<!-- file này gọn, dễ chỉnh sửa -->
<nav class="d-flex justify-content-between align-items-center px-4 py-2 bg-light border-bottom">
  <!-- Bên trái: Logo và Trang chủ -->
  <div>
    <a href="index.php" class="fw-bold text-dark text-decoration-none fs-4">JobHive</a>
    <a href="?page=home" class="ms-3">Trang chủ</a>

    <!-- chỉ company -->
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'company'): ?>
      <a href="?page=add_job" class="ms-3">➕ Thêm việc làm</a>
    <?php endif; ?>
    <?php if ($_SESSION['user']['role'] === 'company'): ?>
      <a href="?page=company_jobs" class="ms-3">📋 Việc đã đăng</a>
    <?php endif; ?>

  </div>

  <!-- Bên phải: Đăng nhập hoặc Xin chào -->
  <div class="d-flex align-items-center gap-2">
    <?php if (isset($_SESSION['user'])): ?>
      <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <a href="?page=admin_dashboard">🔧 Quản trị</a>
      <?php endif; ?>
    <?php endif; ?>
  <?php if (!isset($_SESSION['user'])): ?>
    <a href="?page=login" class="btn btn-outline-primary btn-sm">🔐 Đăng nhập</a>
    <a href="?page=register" class="btn btn-primary btn-sm">📝 Đăng ký</a>
  <?php else: ?>
    <span>👋 Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></span>
    <a href="?page=logout" class="btn btn-outline-danger btn-sm">Đăng xuất</a>
  <?php endif; ?>
</div>
</nav>
