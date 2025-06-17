<?php
require_once __DIR__ . '/../models/SavedJob.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Job.php'; 

class JobExtraController {
public function toggleSave(int $jobId) {
    if (empty($_SESSION['user'])) {
        die('Bạn cần đăng nhập để lưu công việc.');
    }
    $userId = $_SESSION['user']['id'];
    SavedJob::toggle($userId, $jobId);

    // redirect về page mà request tới
    $page = $_GET['page'] ?? 'home';
    header("Location: index.php?page=job_detail&id={$jobId}");
    exit;
}

  public function addComment(int $jobId) {
    if (empty($_SESSION['user'])) {
      die('Bạn cần đăng nhập để bình luận.');
    }
    $content = trim($_POST['comment'] ?? '');
    if ($content === '') {
      die('Nội dung bình luận không được để trống.');
    }
    Comment::add($_SESSION['user']['id'], $jobId, $content);
    header("Location: index.php?page=job_detail&id={$jobId}#comments");
    exit;
  }

    public function listSavedJobs() {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            die('Bạn cần đăng nhập để xem công việc đã lưu.');
        }
        $userId = $_SESSION['user']['id'];
        $jobs   = SavedJob::getByUser($userId);
        require __DIR__ . '/../pages/saved_job.php';
    }
}
