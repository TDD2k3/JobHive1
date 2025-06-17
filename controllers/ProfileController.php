<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserProfile.php';
require_once __DIR__ . '/../models/CompanyProfile.php';

class ProfileController {
  /** Hiển thị form edit (user hoặc company) */
  public function editForm() {
    // 1. Đảm bảo đã login
    if (empty($_SESSION['user'])) {
      header('Location: index.php?page=login');
      exit;
    }

    $uid  = (int)$_SESSION['user']['id'];
    $role = $_SESSION['user']['role'];

    // 2. Lấy thông tin chung từ bảng users
    $user = User::find($uid);
    if (!$user) {
      die('Không tìm thấy người dùng.');
    }

    // 3. Tách view theo role
    if ($role === 'user') {
      $profile = UserProfile::find($uid) ?: [];
      require __DIR__ . '/../views/edit_user_profile.php';
    }
    elseif ($role === 'company') {
      $profile = CompanyProfile::find($uid) ?: [];
      require __DIR__ . '/../views/edit_company_profile.php';
    }
    else {
      die('Bạn không có quyền vào trang này.');
    }
  }

  /** Xử lý submit form edit */
  public function update() {
    if (empty($_SESSION['user'])) {
      header('Location: index.php?page=login');
      exit;
    }

    $uid  = (int)$_SESSION['user']['id'];
    $role = $_SESSION['user']['role'];

    // CHUNG: Lấy và validate các field nếu cần
    if ($role === 'user') {
      // 1) Cập nhật bảng users (name & email)
      $newName  = trim($_POST['name']  ?? '');
      $newEmail = trim($_POST['email'] ?? '');
      if (!$newName || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Vui lòng nhập tên và email hợp lệ.';
        $user    = User::find($uid);
        $profile = UserProfile::find($uid) ?: [];
        require __DIR__ . '/../views/edit_user_profile.php';
        return;
      }
      User::updateBasicInfo($uid, $newName, $newEmail);

      // 2) Cập nhật bảng user_profiles
      $data = [
        'address'    => trim($_POST['address']    ?? ''),
        'bio'        => trim($_POST['bio']        ?? ''),
        'education'  => trim($_POST['education']  ?? ''),
        'birth_year' => trim($_POST['birth_year'] ?? null),
      ];
      if ($data['birth_year'] && !preg_match('/^\d{4}$/', $data['birth_year'])) {
        $error = 'Năm sinh phải là 4 chữ số.';
        $user    = User::find($uid);
        $profile = UserProfile::find($uid) ?: [];
        require __DIR__ . '/../views/edit_user_profile.php';
        return;
      }
      UserProfile::upsert($uid, $data);

      // 3) Cập nhật session
      $_SESSION['user']['name']  = $newName;
      $_SESSION['user']['email'] = $newEmail;

      header('Location: index.php?page=edit_profile&updated=1');
      exit;
    }

    // COMPANY
    if ($role === 'company') {
      // 1) (Nếu cần cập nhật bảng users cho company_name/email riêng)
      //    Có thể update User::updateBasicInfo nếu muốn
      // 2) Cập nhật bảng company_profiles
      $data = [
        'company_name'=> trim($_POST['company_name'] ?? ''),
        'website'     => trim($_POST['website']      ?? ''),
        'address'     => trim($_POST['address']      ?? ''),
        'description' => trim($_POST['description']  ?? ''),
      ];
      if (empty($data['company_name'])) {
        $error = 'Tên công ty không được để trống.';
        $user    = User::find($uid);
        $profile = CompanyProfile::find($uid) ?: [];
        require __DIR__ . '/../views/edit_company_profile.php';
        return;
      }
      CompanyProfile::upsert($uid, $data);

      $_SESSION['user']['name'] = $data['company_name'];  

      header('Location: index.php?page=edit_profile&updated=1');
      exit;
    }

    // Những role khác không hỗ trợ
    die('Role không hợp lệ.');
  }

  // xử lý upload ảnh 
  public function uploadLogo() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
          $userId = $_SESSION['user']['id'];
          $file = $_FILES['logo'];

          if ($file['error'] === UPLOAD_ERR_OK) {
              $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
              $fileName = 'logo_' . time() . "_$userId." . $ext;
              $destination = 'uploads/logos/' . $fileName;

              if (!is_dir('uploads/logos')) {
                  mkdir('uploads/logos', 0755, true);
              }

              move_uploaded_file($file['tmp_name'], $destination);

              // Cập nhật logo_path trong DB
              $stmt = db()->prepare("UPDATE company_profiles SET logo_path = ? WHERE user_id = ?");
              $stmt->execute([$destination, $userId]);

              echo "<script>alert('✅ Tải logo thành công!'); window.location='index.php?page=edit_profile';</script>";
          } else {
              echo "<script>alert('❌ Lỗi khi tải ảnh.');</script>";
          }
      }
  }

}
