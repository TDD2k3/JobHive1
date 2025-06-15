<?php
require_once __DIR__ . '/../models/Job.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("❌ Chỉ admin mới có quyền.");
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("❌ Thiếu ID công việc.");
}

$job = Job::find($id);
if (!$job) {
    die("❌ Không tìm thấy công việc.");
}

// Nếu form gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $industry = $_POST['industry'];

    Job::update($id, $title, $company, $location, $salary, $description, $industry);
    header("Location: index.php?page=admin_jobs");
    exit;
}
?>

<h2>📝 Sửa công việc</h2>
<a href="?page=admin_jobs" class="btn btn-secondary btn-sm mb-3">&larr; Quay lại danh sách</a>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($job['title']) ?>" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Công ty</label>
    <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($job['company']) ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Địa điểm</label>
    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($job['location']) ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Lương</label>
    <input type="text" name="salary" class="form-control" value="<?= htmlspecialchars($job['salary']) ?>">
  </div>
  <div class="col-md-6">
    <label class="form-label">Ngành nghề</label>
    <input type="text" name="industry" class="form-control" value="<?= htmlspecialchars($job['industry']) ?>">
  </div>
  <div class="col-12">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($job['description']) ?></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
  </div>
</form>
