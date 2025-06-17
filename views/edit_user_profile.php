<?php include __DIR__ . '/partials/navbar_top.php'; ?>

<div class="container mt-5">
  <h1>Profile Cá nhân</h1>

  <?php if (!empty($_GET['updated'])): ?>
    <div class="alert alert-success">Cập nhật thành công!</div>
  <?php endif; ?>

  <form method="POST" action="?page=edit_profile_process">
  <div class="mb-3">
    <label class="form-label">Họ và tên</label>
    <input type="text" name="name" class="form-control" required
           value="<?= htmlspecialchars($user['name']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required
           value="<?= htmlspecialchars($user['email']) ?>">
  </div>
    <div class="mb-3">
      <label class="form-label">Địa chỉ</label>
      <input type="text" name="address" class="form-control"
             value="<?= htmlspecialchars($profile['address'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Giới thiệu bản thân</label>
      <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Học vấn</label>
      <input type="text" name="education" class="form-control"
             value="<?= htmlspecialchars($profile['education'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Năm sinh</label>
      <input type="text" name="birth_year" class="form-control" placeholder="YYYY"
             value="<?= htmlspecialchars($profile['birth_year'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="?page=home" class="btn btn-secondary ms-2">Hủy</a>
  </form>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
