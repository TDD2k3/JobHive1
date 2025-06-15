<?php
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../config/db.php'; 

// Hàm kiểm tra quyền truy cập
function requireRole($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        die("❌ Bạn không có quyền truy cập chức năng này.");
    }
}

class JobController {
    // Hiển thị tất cả công việc có phân trang với mỗi trang mình cho là 10
    public function index() {
        global $conn;

        $perPage = 10;// số bản ghi mỗi trang
        $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $offset = ($page - 1) * $perPage;

        // Đếm tổng số dòng
        $total = $conn->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
        $totalPages = ceil($total / $perPage);

        // Lấy dữ liệu giới hạn theo phân trang
        $stmt = $conn->prepare("SELECT * FROM jobs ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Trả về cả dữ liệu và thông tin phân trang
        return [
            'jobs' => $jobs,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
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

}
