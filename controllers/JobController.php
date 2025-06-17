<?php
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../config/db.php'; 
require_once __DIR__ . '/../models/Application.php';
require_once __DIR__ . '/../models/SavedJob.php';
require_once __DIR__ . '/../models/Comment.php';

// Hàm kiểm tra quyền truy cập
function requireRole($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        die("❌ Bạn không có quyền truy cập chức năng này.");
    }
}

class JobController {
    // Hiển thị tất cả công việc có phân trang với mỗi trang mình cho là 12
public function index() {
    global $conn;

    $perPage = 12; // số bản ghi mỗi trang
    $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
    $offset = ($page - 1) * $perPage;

    // Đếm tổng số dòng
    $total = $conn->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
    $totalPages = ceil($total / $perPage);

    // Lấy dữ liệu có JOIN với bảng company_profiles để lấy logo_path
    $stmt = $conn->prepare("
        SELECT j.*, cp.logo_path 
        FROM jobs j
        LEFT JOIN company_profiles cp ON j.user_id = cp.user_id
        ORDER BY j.created_at DESC
        LIMIT $perPage OFFSET $offset
    ");
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'jobs' => $jobs,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}

    // hàm xử lý hiển thị 3 job hightlgiht  dựa theo mức lương cao
            // Chuyển '50 triệu' => 50, '120 triệu' => 120
        // vì mình lớp nhập kiểu của salary bằng varchar rồi,nên chúng ta sẽ
        // xử  lý bằng cách là ép người dùng luôn nhập "triệu"ở dằng
        // sau và dùng các hàm trong SQL là (REGEXP_REPLACE) để giữ laji số
        // và dùng CASt ... as unsigned để sắp xếpđúng theo số
    public function getTopJobsBySalary($limit = 3) {
        $sql = "
            SELECT j.*, cp.logo_path
            FROM jobs j
            LEFT JOIN company_profiles cp ON cp.user_id = j.user_id
            ORDER BY 
                CAST(REPLACE(REPLACE(j.salary, ' triệu', ''), '.', '') AS UNSIGNED) DESC
            LIMIT :limit
        ";
        $stmt = db_connect()->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Tìm kiếm nâng cao (không phân trang)
    public function advancedSearch($keyword, $location, $industry) {
        $sql = "SELECT * FROM jobs WHERE 1";
        $params = [];

        if ($keyword) {
            $sql .= " AND (title LIKE :kw OR company LIKE :kw OR description LIKE :kw)";
            $params[':kw'] = "%$keyword%";
        }

        if ($location) {
            $sql .= " AND location = :loc";
            $params[':loc'] = $location;
        }

        if ($industry) {
            $sql .= " AND industry LIKE :ind";
            $params[':ind'] = "%$industry%";
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = db_query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm có phân trang
    public function searchWithPagination($keyword, $location, $industry, $limit, $offset) {
        $sql = "SELECT * FROM jobs WHERE 1";
        $params = [];

        if ($keyword) {
            $sql .= " AND (title LIKE :kw OR company LIKE :kw OR description LIKE :kw)";
            $params[':kw'] = "%$keyword%";
        }

        if ($location) {
            $sql .= " AND location = :loc";
            $params[':loc'] = $location;
        }

        if ($industry) {
            $sql .= " AND industry LIKE :ind";
            $params[':ind'] = "%$industry%";
        }

        // Đếm tổng số kết quả
        $countSql = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
        $countStmt = db_query($countSql, $params);
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Lấy dữ liệu phân trang
        $sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $stmt = db_query($sql, $params);
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$jobs, $total];
    }
    public function editCompanyForm(int $jobId) {
        requireRole('company');
        // Lấy job
        $job = Job::find($jobId);
        if (!$job || $job['user_id'] !== $_SESSION['user']['id']) {
        die('<p class="text-danger">✖ Bạn không có quyền sửa việc này.</p>');
        }
        // Render form
        require __DIR__ . '/../pages/company_job_edit.php';
    }
  /**
   * Xử lý submit form sửa job
   */
    public function updateCompany(int $jobId, array $post) {
        requireRole('company');
        require_once __DIR__ . '/../models/CompanyProfile.php';

        $profile = CompanyProfile::find($_SESSION['user']['id']);
        $companyName = $profile['company_name'] ?? 'Không rõ';

        $job = Job::find($jobId);
        if (!$job || $job['user_id'] !== $_SESSION['user']['id']) {
            die('<p class="text-danger">✖ Không có quyền.</p>');
        }

        $data = [
            'title'       => trim($post['title']      ?? ''),
            'company'     => $companyName,
            'location'    => trim($post['location']   ?? ''),
            'salary'      => trim($post['salary']     ?? ''),
            'description' => trim($post['description']?? ''),
            'industry'    => trim($post['industry']   ?? ''),
        ];

        Job::updateById($jobId, $data);

        // Redirect về danh sách việc của công ty
        header('Location: index.php?page=company_jobs&updated=1');
        exit;
    }

    // Lấy danh sách location để dùng cho select
    public function getAllLocations() {
        $stmt = db_query("SELECT DISTINCT location FROM jobs WHERE location IS NOT NULL AND location != '' ORDER BY location");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Lấy danh sách industry để dùng cho select
    public function getAllIndustries() {
        $stmt = db_query("SELECT DISTINCT industry FROM jobs WHERE industry IS NOT NULL AND industry != '' ORDER BY industry");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Hàm thêm mới công việc — chỉ cho phép 'company'
    public function addJob($data) {
    requireRole('company'); // Kiểm tra quyền
    Job::create($data);     // Gọi model thay vì viết lại SQL
    }

    // gọi hàm chỉnh sửa của company ở models
    public function editJob($id, $data) {
    requireRole('company'); // Chỉ cho company sửa

    Job::updateById($id, $data); // Gọi model để xử lý
    }

    // hàm này là để company xem ai đã apply vào job của mình 
    public function getApplicants($jobId) {
    $sql = "SELECT u.name, u.email, a.applied_at
            FROM applications a
            JOIN users u ON a.user_id = u.id
            WHERE a.job_id = ?";
    return db_query($sql, [$jobId])->fetchAll(PDO::FETCH_ASSOC);
    }

    // method xử lý bấm apply
    public function apply($jobId) {
    requireRole('user');
    $userId = $_SESSION['user']['id'];

    // Check đã apply chưa
    $count = db_query("SELECT COUNT(*) FROM applications WHERE user_id = ? AND job_id = ?", [$userId, $jobId])->fetchColumn();
    if ($count > 0) {
        echo "<script>alert('⚠️ Bạn đã ứng tuyển vào công việc này rồi.');</script>";
    } else {
        db_query("INSERT INTO applications (user_id, job_id) VALUES (?, ?)", [$userId, $jobId]);
        echo "<script>alert('✅ Ứng tuyển thành công!'); window.location.reload();</script>";
        exit;
    }
    }
  public function detail(int $jobId) {
    // 1) Lấy job
    $job = Job::find($jobId);
    if (!$job) {
      echo "<p class='text-danger'>❌ Công việc không tồn tại.</p>";
      return;
    }

    // 2) Pass qua view
    require __DIR__ . '/../views/job_detail.php';
  }
}

class CompanyController {
    public function viewApplicants() {
    if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'company') {
        echo "Bạn chưa đăng nhập công ty.";
        return;
    }

    // Dùng id của user đang login
    $companyUserId = $_SESSION['user']['id'];
    $applicants    = Application::getApplicantsByCompany($companyUserId);

    require __DIR__ . '/../views/company_applicants.php';
}
}