<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Application.php';

class ApplicantController {
    public function detail() {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'company') {
            die("Bạn không có quyền xem trang này.");
        }

        //Lấy application_id từ query
        $appId = (int)($_GET['id'] ?? 0);
        if (!$appId) {
            die("ID ứng viên không hợp lệ.");
        }

        //Lấy bản ghi ứng tuyển
        $app = Application::findById($appId);
        if (!$app) {
            die("Không tìm thấy thông tin ứng viên.");
        }

        //Lấy thông tin user
        $user = User::find($app['user_id']);
        if (!$user) {
            die("Không tìm thấy profile người dùng.");
        }

        //trả về view
        require __DIR__ . '/../views/applicant_detail.php';
    }
}
