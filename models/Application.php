<?php
require_once __DIR__ . '/../config/db.php';

class Application {
    public static function getApplicantsByCompany(int $companyUserId): array {
        $sql = "
            SELECT
              a.id            AS application_id,
              j.title         AS job_title,
              u.name          AS applicant_name,
              u.email         AS applicant_email,
              a.applied_at    AS applied_at
            FROM applications a
            JOIN users u ON u.id = a.user_id
            JOIN jobs  j ON j.id = a.job_id
            WHERE j.user_id = ?
            ORDER BY a.applied_at DESC
        ";
        return db_fetch_all($sql, [$companyUserId]);
    }
    
    public static function findById(int $appId): ?array {
    return db_fetch_row(
        "SELECT * FROM applications WHERE id = ?",
        [$appId]
    );  // db_fetch_row tương tự db_fetch_all nhưng chỉ fetch 1 row
}

}
