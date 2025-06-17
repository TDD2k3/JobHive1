<?php
include __DIR__ . '/../views/partials/navbar_top.php';
?>
<h2>Việc làm đã lưu</h2>

<?php if (empty($jobs)): ?>
  <div class="alert alert-info">Bạn chưa lưu công việc nào.</div>
<?php else: ?>
  <div class="row gy-3">
    <?php foreach ($jobs as $job): ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <a href="?page=job_detail&id=<?= $job['id'] ?>">
                <?= htmlspecialchars($job['title']) ?>
              </a>
            </h5>
            <p class="mb-1"><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></p>
            <p class="mb-2"><strong>Lương:</strong> <?= htmlspecialchars($job['salary']) ?></p>
            <a
              href="?page=saved_jobs&action=toggle_save&id=<?= $job['id'] ?>"
              class="btn btn-sm btn-warning"
            >
              Bỏ lưu
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include __DIR__ . '/../views/partials/footer.php'; ?>