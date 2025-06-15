<?php
require_once __DIR__ . '/../controllers/JobController.php';

// Lấy dữ liệu GET
$keyword = $_GET['keyword'] ?? '';
$location = $_GET['location'] ?? '';
$industry = $_GET['industry'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 5; // số job mỗi trang
$offset = ($page - 1) * $limit;

$controller = new JobController();
[$jobs, $total] = $controller->searchWithPagination($keyword, $location, $industry, $limit, $offset);

$totalPages = ceil($total / $limit);
?>

<div class="container mt-5">
  <h4>Kết quả cho: "<?= htmlspecialchars($keyword) ?>"</h4>

  <?php if (empty($jobs)): ?>
    <p>Không có kết quả phù hợp.</p>
  <?php else: ?>
    <?php foreach ($jobs as $job): ?>
      <div class="border p-3 rounded mb-3">
        <a href="?page=job_detail&id=<?= $job['id'] ?>">
          <h5><?= htmlspecialchars($job['title']) ?></h5>
        </a>
        <p><strong><?= htmlspecialchars($job['company']) ?></strong> - <?= htmlspecialchars($job['location']) ?></p>
        <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
      </div>
    <?php endforeach; ?>

    <!-- PHÂN TRANG -->
    <nav>
      <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=search&keyword=<?= urlencode($keyword) ?>&location=<?= urlencode($location) ?>&industry=<?= urlencode($industry) ?>&page=<?= $i ?>">
              <?= $i ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>
