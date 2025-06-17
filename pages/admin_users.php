<?php
require_once 'models/User.php';
$users = User::getAll();
?>

<div class="container mt-5">
  <h2 class="mb-4"><i class="bi bi-person-lines-fill me-2"></i>Danh sách người dùng</h2>

  <div class="table-responsive shadow-sm rounded-3">
    <table class="table table-hover align-middle border table-bordered">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Tên</th>
          <th>Vai trò</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td>
              <?php if ($u['role'] === 'admin'): ?>
                <span class="badge bg-danger text-uppercase">Admin</span>
              <?php elseif ($u['role'] === 'company'): ?>
                <span class="badge bg-primary text-uppercase">Company</span>
              <?php else: ?>
                <span class="badge bg-secondary text-uppercase">User</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    <a href="?page=admin_dashboard" class="btn btn-dark">← Quay lại trang quản trị</a>
  </div>
</div>
