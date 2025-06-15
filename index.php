<?php
session_start();
require_once 'config/db.php';
require_once 'config/core.php';

// Xử lý login_process tách biệt
if (isset($_GET['page']) && $_GET['page'] === 'login_process') {
    require_once 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->login();
    exit;
}

// Đăng xuất
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// Xử lý register_process
if (isset($_GET['page']) && $_GET['page'] === 'register_process') {
    require_once 'controllers/AuthController.php';
    $auth = new AuthController();
    $auth->register();
    exit;
}

// Trang mặc định
$page = 'views/home';

// Các trang đặc biệt nằm trong thư mục pages/
$specialPages = ['login', 'register', 'add_job', 'admin_dashboard','admin_jobs_edit', 'admin_jobs', 'admin_users','admin_jobs_delete','company_jobs', 'company_job_edit'];

// Tìm file trang phù hợp
if (isset($_GET['page'])) {
    $requested = $_GET['page'];
    if (file_exists("views/$requested.php")) {
        $page = "views/$requested";
    } elseif (in_array($requested, $specialPages) && file_exists("pages/$requested.php")) {
        $page = "pages/$requested";
    } else {
        $page = "views/404";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>JobHive</title>
  <link rel="stylesheet" href="theme/assets/css/style.css">
  <!-- SweetAlert2 -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>

  <!-- Navbar trên cùng -->
  <?php include 'views/partials/navbar_top.php'; ?>

  <!-- Thanh tìm kiếm: chỉ hiển thị khi không phải trang login/register -->
  <?php
  $hideSearch = ['pages/login', 'pages/register'];
  if (!in_array($page, $hideSearch)) {
      include 'views/partials/search_bar.php';
  }
  ?>

  <!-- Nội dung chính -->
  <main class="container my-5">
    <?php include "$page.php"; ?>
  </main>

  <!-- Footer -->
  <?php include 'views/partials/footer.php'; ?>
</body>
</html>
