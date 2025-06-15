<?php
require_once __DIR__ . '/../controllers/JobController.php';
$controller = new JobController();

// Kiểm tra phân quyền
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'company') {
    die("❌ Chỉ công ty mới có quyền thêm hoặc sửa công việc.");
}


// Nếu submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $controller->addJob($_POST);
        echo "<script>alert('✅ Thêm công việc thành công'); window.location.href='index.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
    }
}
?>

<form method="POST" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Tiêu đề *</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Địa điểm</label>
    <input type="text" name="location" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Lương</label>
    <input type="text" name="salary" class="form-control">
  </div>
  <div class="col-md-12">
    <label class="form-label">Ngành nghề</label>
    <input type="text" name="industry" class="form-control">
  </div>
  <div class="col-md-12">
    <label class="form-label">Mô tả</label>
    <textarea name="description" rows="5" class="form-control"></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Thêm công việc</button>
  </div>
</form>

