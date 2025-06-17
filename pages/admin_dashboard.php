<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("❌ Chỉ admin mới có quyền truy cập.");
}
?>

<div class="container my-5">
  <div class="text-center mb-5">
    <h1 class="fw-bold text-dark"><i class="bi bi-shield-lock-fill text-primary"></i> Trang quản trị JobHive</h1>
    <p class="text-muted">Quản lý hệ thống, tài khoản và các công việc.</p>
  </div>

  <div class="row justify-content-center g-4">
    <!-- Quản lý việc làm -->
    <div class="col-md-5">
      <div class="card shadow-sm border-0 h-100 card-hover">

        <div class="card-body text-center">
          <i class="bi bi-folder2-open fs-1 text-warning mb-3"></i>
          <h5 class="card-title fw-bold">Quản lý việc làm</h5>
          <p class="text-muted">Xem, sửa hoặc xoá công việc được đăng trên hệ thống.</p>
          <a href="?page=admin_jobs" class="btn btn-outline-primary mt-2">🗂 Đi tới</a>
        </div>
      </div>
    </div>

    <!-- thêm cho hiejeu ứng dashboard -->
    <style>
    .card-hover {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    </style>

    <!-- Quản lý người dùng -->
    <div class="col-md-5">
      <div class="card shadow-sm border-0 h-100 card-hover">
        <div class="card-body text-center">
          <i class="bi bi-people-fill fs-1 text-success mb-3"></i>
          <h5 class="card-title fw-bold">Quản lý người dùng</h5>
          <p class="text-muted">Quản lý tài khoản của user và công ty.</p>
          <a href="?page=admin_users" class="btn btn-outline-primary mt-2">👥 Đi tới</a>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center mt-5">
    <a href="?page=home" class="btn btn-secondary">
      ← Quay lại trang chủ
    </a>
  </div>
</div>
