<?php
require_once __DIR__ . '/../controllers/JobController.php';

$controller = new JobController();

// Gọi danh sách jobs có phân trang
$data = $controller->index();
$jobs = $data['jobs'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];

// Gọi top 3 job lương cao nhất để hiển thị bên phải Highlight
$highlightJobs = $controller->getTopJobsBySalary(3);
?>


<section class="section-box pt-60 pb-60">
  <div class="container">
    <!-- Bộ lọc -->
    <form method="get" class="mb-4">
      <input type="hidden" name="page" value="job_list">
      <div class="row g-2 align-items-center">
        <div class="col-md-4">
          <select class="form-select" name="category">
            <option value="">Tất cả ngành nghề</option>
            <option value="IT" <?= ($_GET['category'] ?? '') === 'IT' ? 'selected' : '' ?>>IT</option>
            <option value="Marketing" <?= ($_GET['category'] ?? '') === 'Marketing' ? 'selected' : '' ?>>Marketing</option>
            <!-- thêm các ngành khác -->
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-select" name="sort">
            <option value="">Sắp xếp</option>
            <option value="high_salary" <?= ($_GET['sort'] ?? '') === 'high_salary' ? 'selected' : '' ?>>Lương cao nhất</option>
            <option value="recent" <?= ($_GET['sort'] ?? '') === 'recent' ? 'selected' : '' ?>>Mới nhất</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
      </div>
    </form>

    <!-- Bố cục chia 2 cột -->
    <div class="row">
      <!-- Cột trái: Danh sách công việc -->
      <div class="col-lg-8">
        <?php foreach ($jobs as $job): ?>
          <div id="job<?= $job['id'] ?>" class="card mb-3 p-3 job-card-hover">
            <div class="d-flex">
              <?php
                    $logo = !empty($job['logo_path']) ? $job['logo_path'] : 'theme/assets/img/default-logo.png';
                ?>
            <img src="<?= $logo ?>" alt="Logo công ty" width="60" class="me-3 rounded">
              <div>
                <h5 class="mb-1 text-brand">
                  <a href="index.php?page=job_detail&id=<?= $job['id'] ?>&p=<?= $currentPage ?>">
                    <?= htmlspecialchars($job['title']) ?>
                  </a>
                </h5>
                <p class="mb-1"><strong><?= $job['company'] ?></strong> - <?= $job['location'] ?></p>
                <p class="mb-2 text-muted small"><?= substr($job['description'], 0, 100) ?>...</p>
                <div>
                  <?php foreach (explode(',', $job['skills'] ?? '') as $tag): ?>
                    <span class="badge bg-light text-dark border"><?= trim($tag) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if ($totalPages > 1): ?>
            <nav class="mt-4 d-flex justify-content-center">
                <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="index.php?page=job_list&p=<?= $i ?>&category=<?= urlencode($_GET['category'] ?? '') ?>&sort=<?= urlencode($_GET['sort'] ?? '') ?>">
                        <?= $i ?>
                    </a>
                    </li>
                <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
      </div>

      <!-- Cột phải: Highlight -->
      <div class="col-lg-4">
        <h5 class="mb-3">Highlight Jobs</h5>
        <?php foreach ($highlightJobs as $hj): ?>
          <div class="card mb-3 p-3 border-start border-warning border-3">
            <div class="d-flex align-items-center">
                <?php 
                $logo = (!empty($hj['logo_path']) && file_exists($hj['logo_path'])) ? $hj['logo_path'] : 'theme/assets/img/default-logo.png';?>
              <img src="<?= htmlspecialchars($logo) ?>" style="width: 50px; height: 50px;" class="me-3" alt="Logo công ty">
                <div>
                    <a href="index.php?page=job_detail&id=<?= $hj['id'] ?>" class="text-decoration-none fw-bold text-dark"><?= htmlspecialchars($hj['title']) ?></a>
                    <p class="mb-0 small"><?= $hj['company'] ?> - <?= $hj['salary'] ?></p>
                </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

