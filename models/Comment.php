<?php
require_once __DIR__ . '/../config/db.php';

class Comment {
  public static function add(int $userId, int $jobId, string $content): void {
    db_query(
      "INSERT INTO comments (user_id, job_id, content) VALUES (?, ?, ?)",
      [$userId, $jobId, $content]
    );
  }

  public static function getByJob(int $jobId): array {
    return db_fetch_all(
      "SELECT c.*, u.name AS author
       FROM comments c
       JOIN users u ON u.id = c.user_id
       WHERE c.job_id = ?
       ORDER BY c.created_at ASC",
      [$jobId]
    );
  }
}
