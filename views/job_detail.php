
<section class="section-box pt-50">
  <div class="container">
    <!-- Tiêu đề và thông tin cơ bản -->
    <h2><?= htmlspecialchars($job['title']) ?></h2>
    <ul class="list-unstyled mb-3">
      <li><strong>Công ty:</strong> <?= htmlspecialchars($job['company']) ?></li>
      <li><strong>Địa điểm:</strong> <?= htmlspecialchars($job['location']) ?></li>
      <li><strong>Lương:</strong> <?= htmlspecialchars($job['salary']) ?></li>
      <li><strong>Ngày đăng:</strong> <?= date('d/m/Y', strtotime($job['created_at'])) ?></li>
    </ul>

    <!-- Mô tả công việc -->
    <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

    <!-- Nút Save/Unsave -->
    <?php if (isset($_SESSION['user'])): ?>
      <?php $saved = SavedJob::isSaved($_SESSION['user']['id'], $job['id']); ?>
      <a href="?page=job_detail&id=<?= $job['id'] ?>&action=toggle_save"
         class="btn btn-sm <?= $saved ? 'btn-warning' : 'btn-outline-warning' ?> mb-3">
        <?= $saved ? 'Đã lưu' : 'Lưu công việc' ?>
      </a>
    <?php endif; ?>

    <!-- Nút quay lại danh sách, có logic đảm bảo là quay lại thì sẽ về đúng vị trí mà người dùng bấm -->
    <a href="index.php?page=job_list&p=<?= $_GET['p'] ?? 1 ?>#job<?= $job['id'] ?>" class="btn btn-secondary btn-sm mb-3">⬅️ Quay lại danh sách</a>
  </div>
</section>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user'): ?>
  <div class="container mb-4">
    <?php
      // Kiểm tra đã apply chưa
      $userId     = $_SESSION['user']['id'];
      $hasApplied = (bool) db_fetch_row(
        "SELECT 1 FROM applications WHERE user_id = ? AND job_id = ?",
        [$userId, $job['id']]
      );
    ?>

    <?php if (!$hasApplied): ?>
      <form method="POST" action="?page=job_detail&id=<?= $job['id'] ?>&apply=1">
        <button type="submit" class="btn btn-primary">✅ Ứng tuyển ngay</button>
      </form>
    <?php else: ?>
      <p class="text-success">🎉 Bạn đã ứng tuyển vào công việc này.</p>
    <?php endif; ?>
  </div>
<?php endif; ?>

<hr>

<div class="container mb-5">
  <h5>Bình luận</h5>

  <?php
    $comments = Comment::getByJob($job['id']);
    if (empty($comments)):
  ?>
    <p>Chưa có bình luận nào.</p>
  <?php else: foreach ($comments as $c): ?>
    <div class="mb-3 p-3 border rounded">
      <strong><?= htmlspecialchars($c['author']) ?></strong>
      <small class="text-muted"> — <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></small>
      <p class="mt-2"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
    </div>
  <?php endforeach; endif; ?>

  <?php if (isset($_SESSION['user'])): ?>
    <form method="POST" action="?page=job_detail&id=<?= $job['id'] ?>&action=add_comment">
      <div class="mb-3">
        <textarea name="comment" class="form-control" rows="3" placeholder="Viết bình luận..."></textarea>
      </div>
      <button class="btn btn-primary btn-sm">Gửi bình luận</button>
    </form>
  <?php else: ?>
    <p><a href="?page=login">Đăng nhập</a> để bình luận.</p>
  <?php endif; ?>
</div>
