<!-- e chia như này để có thể tái sử dụng, logic -->
<?php
require_once __DIR__ . '/../../controllers/JobController.php';
$jobController = new JobController();
$locationList = $jobController->getAllLocations();
$industryList = $jobController->getAllIndustries();
?>

<form method="GET" action="index.php" class="container mt-4">
  <input type="hidden" name="page" value="search">
  <div class="row g-2 align-items-center">
    <div class="col-md-4">
      <input type="text" name="keyword" class="form-control" placeholder="Từ khóa (VD: PHP, Designer...)" required>
    </div>
    <div class="col-md-3">
      <select class="form-select select2" name="location">
        <option value="">-- Chọn địa điểm --</option>
        <?php foreach ($locationList as $loc): ?>
          <option value="<?= htmlspecialchars($loc) ?>"><?= htmlspecialchars($loc) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select select2" name="industry">
        <option value="">-- Chọn ngành nghề --</option>
        <?php foreach ($industryList as $ind): ?>
          <option value="<?= htmlspecialchars($ind) ?>"><?= htmlspecialchars($ind) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">🔍 Tìm kiếm</button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
