
<div class="container my-5">
  <dl class="row">
    <dt class="col-sm-3">Họ và tên:</dt>
    <dd class="col-sm-9"><?= htmlspecialchars($user['name']) ?></dd>

    <dt class="col-sm-3">Email:</dt>
    <dd class="col-sm-9"><?= htmlspecialchars($user['email']) ?></dd>

    <?php if (!empty($app['cover_letter'])): ?>
    <dt class="col-sm-3">Cover Letter:</dt>
    <dd class="col-sm-9"><?= nl2br(htmlspecialchars($app['cover_letter'])) ?></dd>
    <?php endif; ?>

    <dt class="col-sm-3">Ngày ứng tuyển:</dt>
    <dd class="col-sm-9"><?= date('d/m/Y H:i', strtotime($app['applied_at'])) ?></dd>

    <!-- Thêm các trường khác của user nếu có, ví dụ số điện thoại, kinh nghiệm… -->
  </dl>
  <a href="?page=company_applicants" class="btn btn-secondary">← Quay lại</a>
</div>
