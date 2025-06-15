<?php
require_once __DIR__ . '/../config/db.php';

class Job {
    public static function getAll() {
        $stmt = db_query("SELECT * FROM jobs ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// 
    //xóa bản ghi
    public static function delete($id) {
    $stmt = db()->prepare("DELETE FROM jobs WHERE id = ?");
    return $stmt->execute([$id]);
    }
// 
    // Hàm find và update để edit bản ghi trong admin
    public static function find($id) {
        return db_query("SELECT * FROM jobs WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $title, $company, $location, $salary, $description, $industry) {
        $sql = "UPDATE jobs SET title=?, company=?, location=?, salary=?, description=?, industry=? WHERE id=?";
        db_query($sql, [$title, $company, $location, $salary, $description, $industry, $id]);
    }

    // hàm thêm job của công ty
    public static function create($data) {
    // Lấy thông tin từ session
    $companyName = $_SESSION['user']['name'];
    $userId = $_SESSION['user']['id'];

    $sql = "INSERT INTO jobs (title, company, location, salary, description, industry, user_id)
            VALUES (:title, :company, :location, :salary, :description, :industry, :user_id)";
    return db_query($sql, [
        ':title' => $data['title'],
        ':company' => $companyName,
        ':location' => $data['location'],
        ':salary' => $data['salary'],
        ':description' => $data['description'],
        ':industry' => $data['industry'],
        ':user_id' => $userId
    ]);
    }
    // phụ trách edit trong phân quyền company
    public static function updateById($id, $data) {
    $sql = "UPDATE jobs SET 
                title = :title, 
                company = :company, 
                location = :location, 
                salary = :salary, 
                description = :description, 
                industry = :industry 
            WHERE id = :id";

    return db_query($sql, [
        ':title' => $data['title'],
        ':company' => $data['company'],
        ':location' => $data['location'],
        ':salary' => $data['salary'],
        ':description' => $data['description'],
        ':industry' => $data['industry'],
        ':id' => $id
    ]);
}


}

