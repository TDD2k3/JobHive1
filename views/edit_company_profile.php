
<?php include __DIR__ . '/partials/navbar_top.php'; ?>

<!-- tách 2 form để 1 form hiển thị file upload, 1 form hiển thị các trường khác -->
<?php
$logo = !empty($profile['logo_path']) ? $profile['logo_path'] : 'theme/assets/img/default-logo.png';
?>

<div class="container mt-5">
  <h1>Profile Công ty</h1>
  <!-- Hiển thị logo công ty hiện tại -->
<?php
$logo = !empty($profile['logo_path']) ? $profile['logo_path'] : 'theme/assets/img/default-logo.png';
?>

<div class="mb-3 text-center">
  <img src="<?= $logo ?>" alt="Logo công ty" style="max-height: 100px;" class="img-thumbnail">
</div>
<form method="POST" enctype="multipart/form-data" action="?page=company_logo_upload" class="mb-5">
  <div class="mb-3">
    <label for="logo" class="form-label">Tải logo công ty mới</label>
    <input type="file" name="logo" id="logo" accept="image/*" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-outline-primary">Tải logo</button>
</form>
  <?php if (!empty($_GET['updated'])): ?>
    <div class="alert alert-success">Cập nhật thành công!</div>
  <?php endif; ?>

  <form method="POST" action="?page=edit_profile_process">
    <div class="mb-3">
      <label class="form-label">Tên công ty</label>
      <input type="text" name="company_name" class="form-control" required
             value="<?= htmlspecialchars($profile['company_name'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Website</label>
      <input type="url" name="website" class="form-control"
             value="<?= htmlspecialchars($profile['website'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Địa chỉ</label>
      <input type="text" name="address" class="form-control"
             value="<?= htmlspecialchars($profile['address'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả công ty</label>
      <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($profile['description'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="?page=home" class="btn btn-secondary ms-2">Hủy</a>
  </form>



</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
