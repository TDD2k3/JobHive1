<?php
include 'partials/navbar_top.php';

// Chỉ hiển thị search bar nếu KHÔNG phải trang login/register
$page = $_GET['page'] ?? 'home';
if (!in_array($page, ['login', 'register'])) {
  include 'partials/search_bar.php';
}
?>
