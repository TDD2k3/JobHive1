<!DOCTYPE html>
<html lang="en">
  <?php include __DIR__ . '/../partials/head.php'; ?>
<body>
  <?php include __DIR__ . '/../partials/preloader.php'; ?>
  <?php include __DIR__ . '/../partials/navbar.php'; ?>

  <main class="container my-5">
    <?php echo $content; // đây là vùng nội dung do controller đổ vào ?>
  </main>

  <?php include __DIR__ . '/../partials/footer.php'; ?>
  <?php include __DIR__ . '/../partials/scripts.php'; ?>
</body>
</html>
