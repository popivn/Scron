<?php
// controller/CronController.php

// Kết nối database
require_once __DIR__ . '/../db.php';

// Khởi tạo các biến để truyền cho View
$message = null;
$error_message = null;
$jobs = [];

// Lấy tham số 'page' từ URL để xác định hành động
$page = $_GET['page'] ?? 'list';

// Xử lý các hành động
if ($page === 'create') {
    // Nếu là trang tạo mới, xử lý dữ liệu POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_name'])) {
        $job_name = trim($_POST['job_name']);
        $url = trim($_POST['url']);
        $schedule = (int)$_POST['schedule'];

        if (!empty($job_name) && filter_var($url, FILTER_VALIDATE_URL) && $schedule > 0) {
            $sql = "INSERT INTO cron_schedule (job_name, url, schedule, status) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([$job_name, $url, $schedule, 0]);
                $message = "✅ Job '$job_name' đã được thêm thành công!";
            } catch (PDOException $e) {
                $error_message = "❌ Lỗi khi thêm job: " . $e->getMessage();
            }
        } else {
            $error_message = "❌ Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.";
        }
    }
    // Gán biến để hiển thị form tạo mới
    $viewFile = __DIR__ . '/../view/cron/create.php';
} else {
    // Mặc định là trang danh sách, lấy dữ liệu từ database
    try {
        $stmt = $pdo->query("SELECT * FROM cron_schedule ORDER BY created_at DESC");
        $jobs = $stmt->fetchAll();
        // Kiểm tra nếu không có dữ liệu
        if (empty($jobs)) {
            $message = "Chưa có cron job nào được tạo.";
        }
    } catch (PDOException $e) {
        $error_message = "❌ Lỗi khi lấy dữ liệu: " . $e->getMessage();
    }
    // Gán biến để hiển thị danh sách
    $viewFile = __DIR__ . '/../view/cron/list.php';
}

// Gọi file View
require_once $viewFile;
