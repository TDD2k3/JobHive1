<?php
require_once __DIR__ . '/../models/Job.php';

// Kiểm tra phân quyền
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'company') {
    die("❌ Chỉ công ty mới xem được danh sách việc đã đăng.");
}

$userId = $_SESSION['user']['id'];
$jobs = db_query("SELECT * FROM jobs WHERE user_id = ?", [$userId])->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
  <h2>Các công việc bạn đã đăng</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tiêu đề</th>
        <th>Địa điểm</th>
        <th>Lương</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($jobs as $job): ?>
        <tr>
          <td><?= htmlspecialchars($job['title']) ?></td>
          <td><?= htmlspecialchars($job['location']) ?></td>
          <td><?= htmlspecialchars($job['salary']) ?></td>
          <td>
            <a href="?page=company_job_edit&id=<?= $job['id'] ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
