<?php
require_once __DIR__ . '/../config/db.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = db_query("SELECT * FROM users WHERE email = ?", [$email])->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'name' => $user['name']
                ];
                header("Location: index.php");
                exit;
            } else {
                echo "<p style='color:red'>Sai email hoặc mật khẩu!</p>";
            }
        }
    }
    // hàm xử lý resgister
    public function register() {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? 'user'; // mặc định là user

    if (!$email || !$password || !$name) {
        echo "Thiếu thông tin!";
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = db_query("INSERT INTO users (email, password, name, role) VALUES (?, ?, ?, ?)", [
        $email, $hashed, $name, $role
    ]);
    // thêm 1 tham số
    header("Location: index.php?page=login&registered=1");
    exit;
}
}


