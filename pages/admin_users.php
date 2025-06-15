<?php
require_once 'models/User.php';
$users = User::getAll();
?>

<h3>👤 Danh sách người dùng</h3>
<table class="table table-bordered">
  <thead>
    <tr><th>ID</th><th>Email</th><th>Tên</th><th>Vai trò</th></tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= $u['role'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
