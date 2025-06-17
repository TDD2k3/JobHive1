<?php
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    die("❌ Bạn không có quyền.");
}

$userId = $_SESSION['user']['id'];
$jobId = $_POST['job_id'] ?? 0;

// Kiểm tra đã apply chưa
$stmt = db_query("SELECT COUNT(*) FROM applications WHERE user_id = ? AND job_id = ?", [$userId, $jobId]);
if ($stmt->fetchColumn() > 0) {
    echo "⚠️ Bạn đã ứng tuyển công việc này rồi.";
    exit;
}

// Chưa apply => thêm mới
db_query("INSERT INTO applications (user_id, job_id) VALUES (?, ?)", [$userId, $jobId]);

echo "<script>alert('✅ Ứng tuyển thành công!'); window.location.href='index.php?page=job_detail&id=$jobId';</script>";
