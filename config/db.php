<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'jobhive_phpmvc';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// tạo, định các hàm helper
// 1. Kết nối PDO
function db_connect() {
    static $pdo = null;
    if ($pdo === null) {
        $host = 'localhost';
        $db   = 'jobhive_phpmvc';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    }
    return $pdo;
}

// 2. Helper lấy tất cả bản ghi
function db_fetch_all(string $sql, array $params = []): array {
    $stmt = db_connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
// 3, định nghĩa thêm hàm lấy roww
function db_fetch_row(string $sql, array $params = []): array|false {
    $stmt = db_connect()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


try {
    // đến MySQL để tạo database nếu chưa có
    $pdoTemp = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdoTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdoTemp->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE ${charset}_general_ci");
    // echo "✅ Đã tạo (hoặc đã tồn tại) database <strong>$db</strong><br>";

    // 2. Kết nối chính vào database vừa tạo
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Đã kết nối tới database <strong>$db</strong><br>";
} catch (PDOException $e) {
    die("❌ Kết nối hoặc tạo DB thất bại: " . $e->getMessage());
}

// Hàm truy vấn
function db_query($sql, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}
// tạo bảng phân quyền
$conn->exec("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    role ENUM('user', 'company', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");


//Tạo bảng jobs nếu chưa có
$conn->exec("
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    company VARCHAR(255),
    location VARCHAR(255),
    salary VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");
// echo "✅ Đã tạo (hoặc tồn tại) bảng <code>jobs</code><br>";
try {
    $result = $conn->query("SHOW COLUMNS FROM jobs LIKE 'industry'");
    if ($result->rowCount() === 0) {
        $conn->exec("ALTER TABLE jobs ADD industry VARCHAR(255) DEFAULT ''");
        // echo "✅ Đã thêm cột <code>industry</code> vào bảng jobs<br>";
    } else {
        // echo "ℹ️ Cột industry đã tồn tại<br>";
    }
} catch (PDOException $e) {
    echo "❌ Lỗi khi thêm cột industry: " . $e->getMessage();
}
//Chèn dữ liệu test nếu bảng đang trống
$count = $conn->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
if ($count == 0) {
    $conn->exec("
        INSERT INTO jobs (title, company, location, salary, description)
        VALUES 
        ('Lập trình viên PHP', 'Công ty ABC', 'Hà Nội', '15 triệu', 'Tham gia phát triển web bằng PHP.'),
        ('Tester Web', 'Công ty XYZ', 'TP.HCM', '12 triệu', 'Kiểm thử hệ thống và viết test case.'),
        ('Frontend Developer', 'Công ty UIUX', 'Đà Nẵng', '18 triệu', 'Thiết kế và phát triển giao diện web.'),
        ('Data Analyst', 'DataCorp', 'Hà Nội', '20 triệu', 'Phân tích dữ liệu kinh doanh.'),
        ('System Admin', 'IT Solutions', 'TP.HCM', '16 triệu', 'Quản trị hệ thống mạng và server.'),
        ('Project Manager', 'PM Group', 'Hà Nội', '25 triệu', 'Quản lý dự án phần mềm.'),
        ('AI Engineer', 'TechAI', 'TP.HCM', '30 triệu', 'Phát triển mô hình AI với Python.'),
        ('Mobile Developer', 'AppDev', 'Hà Nội', '19 triệu', 'Lập trình ứng dụng Android/iOS.'),
        ('Backend Developer', 'WebPlus', 'TP.HCM', '21 triệu', 'Xây dựng API với PHP và NodeJS.'),
        ('QA Engineer', 'QualitySoft', 'Hà Nội', '14 triệu', 'Viết test case và đảm bảo chất lượng phần mềm.'),
        ('Security Specialist', 'CyberSec VN', 'TP.HCM', '28 triệu', 'Kiểm tra bảo mật hệ thống.'),
        ('Fullstack Dev', 'HybridTech', 'Hà Nội', '23 triệu', 'Lập trình cả frontend và backend.'),
        ('Business Analyst', 'BA Corp', 'Đà Nẵng', '22 triệu', 'Phân tích yêu cầu khách hàng.'),
        ('SEO Executive', 'MarketingPro', 'TP.HCM', '13 triệu', 'Tối ưu hóa công cụ tìm kiếm.'),
        ('DevOps Engineer', 'DevOps Inc.', 'Hà Nội', '27 triệu', 'Tự động hóa triển khai hệ thống.'),
        ('Content Writer', 'MediaNow', 'TP.HCM', '11 triệu', 'Viết nội dung chuẩn SEO.'),
        ('Network Engineer', 'NetLink', 'Đà Nẵng', '18 triệu', 'Thiết kế và bảo trì mạng nội bộ.'),
        ('Game Developer', 'GameHouse', 'TP.HCM', '22 triệu', 'Lập trình game Unity và Unreal.'),
        ('HR Manager', 'PeopleFirst', 'Hà Nội', '20 triệu', 'Quản lý tuyển dụng và nhân sự.'),
        ('Support Staff', 'Helpdesk VN', 'TP.HCM', '10 triệu', 'Hỗ trợ người dùng sử dụng phần mềm.'),
        ('UI Designer', 'CreativeLine', 'Hà Nội', '17 triệu', 'Thiết kế giao diện người dùng.')
    ");
    // echo "✅ Đã chèn dữ liệu mẫu vào bảng <code>jobs</code><br>";
} else {
    // echo "ℹ️ Bảng <code>jobs</code> đã có dữ liệu sẵn, không chèn thêm<br>";
}

// Tạo tài khoản nếu chưa tồn tại
$hashed = password_hash("123456", PASSWORD_DEFAULT);

$existing = $conn->query("SELECT COUNT(*) FROM users WHERE email = 'admin@jobhive.com'")->fetchColumn();
if ($existing == 0) {
    $conn->exec("INSERT INTO users (email, password, name, role) VALUES
        ('admin@jobhive.com', '$hashed', 'Admin', 'admin'),
        ('cty@abc.com', '$hashed', 'Công ty ABC', 'company')
    ");
    echo "✅ Đã thêm tài khoản admin và công ty mẫu<br>";
} else {
    // echo "ℹ️ Tài khoản admin đã tồn tại, không thêm lại<br>";
}

// Thêm cột user_id nếu chưa có
try {
    $result = $conn->query("SHOW COLUMNS FROM jobs LIKE 'user_id'");
    if ($result->rowCount() === 0) {
        $conn->exec("ALTER TABLE jobs ADD user_id INT DEFAULT NULL");
        // echo "✅ Đã thêm cột user_id vào bảng jobs<br>";
    } else {
        // echo "ℹ️ Cột user_id đã tồn tại<br>";
    }
} catch (PDOException $e) {
    echo "❌ Lỗi khi thêm cột user_id: " . $e->getMessage();
}
// Tạo bảng ứng tuyển nếu chưa có, bảng này để lưu thông tin nguwofi ứng tuyển
// cái trường unique key để ở dưới để check 1 nguwofi chỉ được apply 1 lần vào 1 job
$conn->exec("
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_application (user_id, job_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
)
");
// Tạo bảng user_profiles nếu chưa có
$conn->exec("
CREATE TABLE IF NOT EXISTS user_profiles (
  user_id    INT PRIMARY KEY,
  address    VARCHAR(255)  NULL,
  bio        TEXT          NULL,
  education  VARCHAR(255)  NULL,
  birth_year YEAR          NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
");

// Tạo bảng company_profiles nếu chưa có
$conn->exec("
CREATE TABLE IF NOT EXISTS company_profiles (
  user_id      INT PRIMARY KEY,
  company_name VARCHAR(255) NOT NULL,
  website      VARCHAR(255) NULL,
  address      VARCHAR(255) NULL,
  description  TEXT         NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
");
// Thêm cột logo_path vào bảng company_profiles nếu chưa có
try {
    $result = $conn->query("SHOW COLUMNS FROM company_profiles LIKE 'logo_path'");
    if ($result->rowCount() === 0) {
        $conn->exec("ALTER TABLE company_profiles ADD logo_path VARCHAR(255) DEFAULT NULL");
        echo "✅ Đã thêm cột logo_path vào bảng company_profiles<br>";
    } else {
        // echo "ℹ️ Cột logo_path đã tồn tại<br>";
    }
} catch (PDOException $e) {
    echo "❌ Lỗi khi thêm cột logo_path: " . $e->getMessage();
}
// tạo bảng savejob
$conn->exec("
CREATE TABLE IF NOT EXISTS saved_jobs (
  user_id INT NOT NULL,
  job_id  INT NOT NULL,
  saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, job_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (job_id)  REFERENCES jobs(id)  ON DELETE CASCADE
)
");
// tạo bảng cmt
$conn->exec("
CREATE TABLE IF NOT EXISTS comments (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  user_id   INT NOT NULL,
  job_id    INT NOT NULL,
  content   TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (job_id)  REFERENCES jobs(id)  ON DELETE CASCADE
)
");

// tạo bảng để đánh giá
$conn->exec("
CREATE TABLE IF NOT EXISTS ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  from_user_id INT NOT NULL,       -- Người đánh giá
  to_user_id   INT DEFAULT NULL,   -- Người được đánh giá (nếu là user)
  to_company_id INT DEFAULT NULL,  -- Công ty được đánh giá (từ bảng users, role = 'company')
  rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (to_company_id) REFERENCES users(id) ON DELETE CASCADE
)
");

// hàm để dùng cho admin CRUD
// Hàm trả về đối tượng PDO để dùng trong models
function db() {
    global $conn;
    return $conn;
}
?>