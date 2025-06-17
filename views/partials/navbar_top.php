<?php
  $page = $page ?? ($_GET['page'] ?? 'home');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
  <div class="container">
    <!-- Logo / Brand -->
    <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="?page=home">
      <!-- Logo -->
      <img src="theme/assets/img/logo1.png" alt="JobHive Logo" width="40" height="40" class="d-inline-block align-middle me-2">
      JobHive
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar" aria-controls="mainNavbar"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?= ($page==='home'?' active':'') ?>" href="?page=home">Trang chủ</a>
        </li>
        <a href="?page=job_list" class="btn btn-primary">Find a Job</a>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role']==='user'): ?>
        <li class="nav-item">
          <a class="nav-link<?= ($page==='saved_jobs'?' active':'') ?> ms-3"
             href="?page=saved_jobs">
            💾 Đã lưu
          </a>
        </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role']==='company'): ?>
        <li class="nav-item">
          <a class="nav-link<?= ($page==='add_job'?' active':'') ?> ms-3"
             href="?page=add_job">➕ Thêm việc làm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= ($page==='company_jobs'?' active':'') ?> ms-3"
             href="?page=company_jobs">📋 Việc đã đăng</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= ($page==='company_applicants'?' active':'') ?> ms-3"
             href="?page=company_applicants">👥 Ứng viên</a>
        </li>
        <?php endif; ?>
      </ul>

      <!-- User menu -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <?php if (empty($_SESSION['user'])): ?>
        <li class="nav-item">
          <a class="btn btn-outline-primary btn-sm me-2" href="?page=login">🔒 Đăng nhập</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary btn-sm" href="?page=register">📝 Đăng ký</a>
        </li>
        <?php else: ?>
          <?php if ($_SESSION['user']['role']==='admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="?page=admin_dashboard">⚙️ Quản trị</a>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['user']['role']==='user'): ?>
          <li class="nav-item">
            <a class="nav-link<?= ($page==='edit_profile'?' active':'') ?>"
               href="?page=edit_profile">📝 Profile</a>
          </li>
          <?php endif; ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              👋 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <?php if ($_SESSION['user']['role'] === 'company'): ?>
                <li><a class="dropdown-item" href="?page=edit_profile"><i class="bi bi-building"></i> Cập nhật hồ sơ</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="?page=logout"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a></li>
            </ul>
          </li>

        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

