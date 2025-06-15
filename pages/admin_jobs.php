<?php
require_once __DIR__ . '/../models/Job.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("\u274c Chỉ admin được truy cập.");
}

$jobs = Job::getAll();
?>

<h2>📄 Danh sách việc làm</h2>
<a href="?page=admin_dashboard" class="btn btn-secondary btn-sm mb-3">&larr; Quay về trang Quản trị</a>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tiêu đề</th>
      <th>Công ty</th>
      <th>Địa điểm</th>
      <th>Ngày tạo</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($jobs as $job): ?>
      <tr>
        <td><?= $job['id'] ?></td>
        <td><?= htmlspecialchars($job['title']) ?></td>
        <td><?= htmlspecialchars($job['company']) ?></td>
        <td><?= htmlspecialchars($job['location']) ?></td>
        <td><?= $job['created_at'] ?></td>
        <td>
          <a href="?page=admin_jobs_edit&id=<?= $job['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
          <a href="?page=admin_jobs_delete&id=<?= $job['id'] ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('⚠️ Bạn có chắc chắn muốn xoá công việc này không?');">
            Xoá
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
