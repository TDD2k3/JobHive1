<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container" style="max-width: 400px; margin-top: 80px;">
    <h3 class="text-center">🔐 Đăng nhập</h3>
    <form method="POST" action="?page=login_process">
      <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
      <h6>Bạn chưa có tài khoản? Hãy <a href="?page=register">đăng ký</a></h6>
    </form>
  </div>
  <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
    <!-- thông báo chúc mừng đăng nhập -->
  <script>
    Swal.fire({
      icon: 'success',
      title: '🎉 Đăng ký thành công!',
      text: 'Bây giờ hãy đăng nhập để bắt đầu sử dụng JobHive.',
      confirmButtonText: 'Đăng nhập ngay'
    });
  </script>
  <?php endif; ?>
</body>
</html>
