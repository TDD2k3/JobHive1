<?php
require_once __DIR__.'/../config/db.php';

class UserProfile {
  public static function find(int $userId): array|false {
    return db_fetch_row(
      "SELECT * FROM user_profiles WHERE user_id = ?",
      [$userId]
    );
  }

  public static function upsert(int $userId, array $data): void {
    // Dùng INSERT ... ON DUPLICATE KEY UPDATE
    $sql = "
      INSERT INTO user_profiles
        (user_id, address, bio, education, birth_year)
      VALUES (?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
        address    = VALUES(address),
        bio        = VALUES(bio),
        education  = VALUES(education),
        birth_year = VALUES(birth_year)
    ";
    db_query($sql, [
      $userId, $data['address'], $data['bio'],
      $data['education'], $data['birth_year']
    ]);
  }
}
