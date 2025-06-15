<?php
require_once __DIR__ . '/../controllers/JobController.php';
$controller = new JobController();
$data = $controller->index();
$jobs = $data['jobs'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
?>

<section class="section-box pt-50 pb-50">
  <div class="container">
    <h2 class="mb-40">Danh sách việc làm</h2>

    <?php foreach ($jobs as $job): ?>
      <div class="job-card mb-30 p-20 border rounded shadow-sm">
        <a href="?page=job_detail&id=<?= $job['id'] ?>">
          <h3 class="text-brand"><?= htmlspecialchars($job['title']) ?></h3>
        </a>
        <p><strong>Công ty:</strong> <?= htmlspecialchars($job['company']) ?></p>
        <p><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></p>
        <p><strong>Lương:</strong> <?= htmlspecialchars($job['salary']) ?></p>
        <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
      </div>
    <?php endforeach; ?>

    <!-- Phân trang tại inddexx -->
<?php if ($totalPages > 1): ?>
  <nav class="mt-4">
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
          <a class="page-link" href="?page=home&p=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>

    <?php if (count($jobs) === 0): ?>
      <p>Hiện chưa có công việc nào.</p>
    <?php endif; ?>
  </div>
</section>
