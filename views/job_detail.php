<?php
require_once __DIR__ . '/../config/db.php';

// Kiểm tra ID có tồn tại không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-danger'>⚠️ Không tìm thấy công việc.</p>";
    return;
}

$id = (int) $_GET['id'];
$stmt = db_query("SELECT * FROM jobs WHERE id = ?", [$id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    echo "<p class='text-danger'>❌ Công việc không tồn tại.</p>";
    return;
}
?>

<section class="section-box pt-50">
  <div class="container">
    <h2><?= htmlspecialchars($job['title']) ?></h2>
    <ul class="list-unstyled">
      <li><strong>Công ty:</strong> <?= htmlspecialchars($job['company']) ?></li>
      <li><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></li>
      <li><strong>Lương:</strong> <?= htmlspecialchars($job['salary']) ?></li>
      <li><strong>Ngày đăng:</strong> <?= htmlspecialchars($job['created_at']) ?></li>
    </ul>
    <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

    <a href="./" class="btn btn-secondary mt-3">⬅️ Quay lại danh sách</a>
  </div>
</section>
