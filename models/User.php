<?php
require_once __DIR__ . '/../config/db.php';

class User {
    /**
     * Lấy tất cả người dùng
     * @return array
     */
    public static function getAll(): array {
        // db_query trả về PDOStatement
        return db_query("SELECT * FROM users ORDER BY created_at DESC")
               ->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Lấy thông tin một user theo ID
     * @return array|false mảng dữ liệu hoặc false nếu không tìm thấy
     */
    public static function find(int $userId): array|false {
        return db_fetch_row(
            "SELECT * FROM users WHERE id = ?",
            [$userId]
        );
    }

    /**
     * Cập nhật tên và email cho user
     */
    public static function updateBasicInfo(int $id, string $name, string $email): void {
        db_query(
            "UPDATE users SET name = ?, email = ? WHERE id = ?",
            [$name, $email, $id]
        );
    }
}
