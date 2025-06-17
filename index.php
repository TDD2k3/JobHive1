<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/core.php';

// Lấy route gốc từ querystring
$pageName = $_GET['page'] ?? 'home';

// Xử lý apply job
if ($pageName === 'job_detail' && isset($_GET['apply']) && isset($_GET['id'])) {
    require_once __DIR__ . '/controllers/JobController.php';
    (new JobController())->apply((int)$_GET['id']);
    // Gợi ý: redirect lại trang chi tiết sau khi apply để tránh apply lại khi reload
    header("Location: index.php?page=job_detail&id=" . (int)$_GET['id']);
    exit;
}

// Xử lý các action cần redirect ngay
if ($pageName === 'login_process') {
    require_once __DIR__ . '/controllers/AuthController.php';
    (new AuthController())->login();
    exit;
}

if ($pageName === 'register_process') {
    require_once __DIR__ . '/controllers/AuthController.php';
    (new AuthController())->register();
    exit;
}

if ($pageName === 'logout') {
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

// Map route tới file view/pages
$pageFile = __DIR__ . "/views/404.php";
if (file_exists(__DIR__ . "/views/{$pageName}.php")) {
    $pageFile = __DIR__ . "/views/{$pageName}.php";
} elseif (file_exists(__DIR__ . "/pages/{$pageName}.php")) {
    $pageFile = __DIR__ . "/pages/{$pageName}.php";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JobHive</title>
  <link rel="stylesheet" href="theme/assets/css/style.css">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Your custom CSS -->
  <link rel="stylesheet" href="theme/assets/css/style.css">
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="theme/assets/css/style.css">
</head>
<body>
    
  <!-- Navbar -->
  <?php
  // edit profile
if ($pageName === 'edit_profile') {
  require_once __DIR__ . '/controllers/ProfileController.php';
  (new ProfileController())->editForm();
  exit;
}
if ($pageName === 'edit_profile_process') {
  require_once __DIR__ . '/controllers/ProfileController.php';
  (new ProfileController())->update();
  exit;
}
// Lưu/xóa save job
if (isset($_GET['action']) && $_GET['action'] === 'toggle_save' && isset($_GET['id'])) {
  require 'controllers/JobExtraController.php';
  (new JobExtraController())->toggleSave((int)$_GET['id']);
  exit;
}

// Thêm bình luận
if (isset($_GET['action']) && $_GET['action'] === 'add_comment' && isset($_GET['id'])) {
  require 'controllers/JobExtraController.php';
  (new JobExtraController())->addComment((int)$_GET['id']);
  exit;
}

if ($pageName === 'company_job_edit' && isset($_GET['id'])) {
    require_once __DIR__ . '/controllers/JobController.php';
    (new JobController())->editCompanyForm((int)$_GET['id']);
    exit;
}
// Lưu / bỏ lưu
if (isset($_GET['action']) && $_GET['action'] === 'toggle_save') {
  require_once __DIR__ . '/controllers/JobExtraController.php';
  (new JobExtraController())->toggleSave((int)($_GET['id'] ?? 0));
  exit;
}

// Xem danh sách đã lưu
if ($pageName === 'saved_jobs') {
  require 'controllers/JobExtraController.php';
  (new JobExtraController())->listSavedJobs();
  exit;
}

// hàm xử lý uoload ảnh
if ($pageName === 'company_logo_upload') {
    require_once 'controllers/ProfileController.php';
    (new ProfileController())->uploadLogo();
    exit;
}
// hàm xử lý chỉnh sửa file, hàm này khác với các hàm update trên là nó cso 1 bước xử lý dữ liệu
if ($pageName === 'company_job_edit_process') {
    require_once __DIR__ . '/controllers/JobController.php';
    (new JobController())->updateCompany((int)($_POST['id'] ?? 0), $_POST);
    exit;
}


  include __DIR__ . '/views/partials/navbar_top.php'; ?>

  <!-- Search bar chỉ trên trang chủ -->
  <?php if ($pageName === 'home'): ?>
    <?php include __DIR__ . '/views/partials/search_bar.php'; ?>
  <?php endif; ?>

  <main class="container my-5">
    <?php
      switch ($pageName) {
        case 'edit_profile':
          require_once __DIR__ . '/controllers/ProfileController.php';
          (new ProfileController())->editForm();
          break;

        case 'job_list':
          require_once 'views/job_list.php';
          break;

        case 'edit_profile_process':
          require_once __DIR__ . '/controllers/ProfileController.php';
          (new ProfileController())->update();
          break;

        case 'company_applicants':
            require_once __DIR__ . '/controllers/JobController.php';
            (new CompanyController())->viewApplicants();
            break;

        case 'applicant_detail':
            require_once __DIR__ . '/controllers/ApplicantController.php';
            (new ApplicantController())->detail();
            break;
        
        case 'job_detail':
            require_once __DIR__ . '/controllers/JobController.php';
            (new JobController())->detail((int)($_GET['id'] ?? 0));
        break;

        case 'saved_jobs':
            require_once __DIR__ . '/controllers/JobExtraController.php';
            (new JobExtraController())->listSavedJobs();
        break;

        default:
            include $pageFile;
      }
    ?>
  </main>

  <!-- Footer -->
  <?php include __DIR__ . '/views/partials/footer.php'; ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
</body>
</html>
