<?php
require_once __DIR__ . '/../config/db.php';

class SavedJob {
  public static function toggle(int $userId, int $jobId): void {
    // nếu chưa có thì xóa, k thì sẽ thêm
    $exists = db_fetch_row(
      "SELECT 1 FROM saved_jobs WHERE user_id = ? AND job_id = ?",
      [$userId, $jobId]
    );
    if ($exists) {
      db_query("DELETE FROM saved_jobs WHERE user_id = ? AND job_id = ?", [$userId, $jobId]);
    } else {
      db_query("INSERT INTO saved_jobs (user_id, job_id) VALUES (?, ?)", [$userId, $jobId]);
    }
  }

  public static function isSaved(int $userId, int $jobId): bool {
    return (bool) db_fetch_row(
      "SELECT 1 FROM saved_jobs WHERE user_id = ? AND job_id = ?",
      [$userId, $jobId]
    );
  }

public static function getByUser(int $userId): array {
        $rows = db_fetch_all(
            "SELECT job_id 
             FROM saved_jobs 
             WHERE user_id = ? 
             ORDER BY saved_at DESC",
            [$userId]
        );
        $savedIds = array_column($rows, 'job_id');
        if (empty($savedIds)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($savedIds), '?'));
        return db_fetch_all(
            "SELECT * FROM jobs 
             WHERE id IN ($placeholders) 
             ORDER BY created_at DESC",
            $savedIds
        );
    }
}

