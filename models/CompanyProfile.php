<?php
require_once __DIR__.'/../config/db.php';

class CompanyProfile {
  public static function find(int $userId): array|false {
    return db_fetch_row(
      "SELECT * FROM company_profiles WHERE user_id = ?",
      [$userId]
    );
  }

  public static function upsert(int $userId, array $data): void {
    $sql = "
      INSERT INTO company_profiles
        (user_id, company_name, website, address, description)
      VALUES (?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
        company_name = VALUES(company_name),
        website      = VALUES(website),
        address      = VALUES(address),
        description  = VALUES(description)
    ";
    db_query($sql, [
      $userId, $data['company_name'], $data['website'],
      $data['address'], $data['description']
    ]);
  }
}
