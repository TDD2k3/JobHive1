<?php
require_once __DIR__ . '/../models/Job.php';

// Chặn nếu không phải admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("❌ Chỉ admin được phép xoá.");
}

// Lấy ID từ URL
$id = $_GET['id'] ?? 0;
$id = (int) $id;

if ($id > 0) {
    Job::delete($id);
}

// Sau khi xoá xong chuyển hướng về trang danh sách
header("Location: index.php?page=admin_jobs");
exit;
