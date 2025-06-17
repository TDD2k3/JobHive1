
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ứng viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h1>Danh sách ứng viên ứng tuyển</h1>
   <?php if (empty($applicants)): ?>
    <div class="alert alert-info">Chưa có ai ứng tuyển việc làm của bạn.</div>
  <?php else: ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Job</th>
          <th>Tên ứng viên</th>
          <th>Email</th>
          <th>Ngày Apply</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($applicants as $i => $app): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($app['job_title']) ?></td>
          <!-- chuyển tới để xem chi tiết người đã apply luôn -->
          <td><a href="?page=applicant_detail&id=<?= $app['application_id'] ?>"class="text-decoration-none"><?= htmlspecialchars($app['applicant_name']) ?></a></td> 
          <td><?= htmlspecialchars($app['applicant_email']) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($app['applied_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


