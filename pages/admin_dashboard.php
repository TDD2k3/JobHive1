<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("❌ Chỉ admin mới có quyền truy cập.");
}
?>

<h2>🧩 Quản trị JobHive</h2>
<ul>
  <li><a href="?page=admin_jobs">🗂 Quản lý việc làm</a></li>
  <li><a href="?page=admin_users">👥 Quản lý người dùng</a></li>
</ul>
<!-- Đùng Jv để tạo nút qauy lại cho thuận tiện -->
<button onclick="window.history.back()" class="btn btn-secondary mb-3">
  ← Quay lại
</button>