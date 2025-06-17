<?php
if (isset($_GET['updated'])): ?>
  <div class="alert alert-success">✅ Sửa việc thành công!</div>
<?php endif; ?>

<h2>Chỉnh sửa công việc</h2>
<form method="POST" action="?page=company_job_edit_process">
  <input type="hidden" name="id" value="<?= $job['id'] ?>">
  
  <div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control"
           value="<?= htmlspecialchars($job['title']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Địa điểm</label>
    <input type="text" name="location" class="form-control"
           value="<?= htmlspecialchars($job['location']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Lương</label>
    <input type="text" name="salary" class="form-control"
           value="<?= htmlspecialchars($job['salary']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Ngành nghề</label>
    <input type="text" name="industry" class="form-control"
           value="<?= htmlspecialchars($job['industry']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($job['description']) ?></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
  <a href="?page=company_jobs" class="btn btn-secondary ms-2">Hủy</a>
</form>