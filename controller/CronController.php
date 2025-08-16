<?php
// controller/CronController.php

require_once __DIR__ . '/../db.php';

class CronController
{
    private $pdo;
    public $message = null;
    public $error_message = null;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Trang danh sách
    public function list()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM cron_schedule ORDER BY created_at DESC");
            $jobs = $stmt->fetchAll();

            if (empty($jobs)) {
                $this->message = "Chưa có cron job nào được tạo.";
            }
        } catch (PDOException $e) {
            $this->error_message = "❌ Lỗi khi lấy dữ liệu: " . $e->getMessage();
            $jobs = [];
        }

        ob_start();
        require __DIR__ . '/../view/cron/list.php';
        $content = ob_get_clean();

        require __DIR__ . '/../layout.php';
    }

    // Trang tạo mới
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_name'])) {
            $job_name = trim($_POST['job_name']);
            $url = trim($_POST['url']);
            $schedule = (int)$_POST['schedule'];

            if (!empty($job_name) && filter_var($url, FILTER_VALIDATE_URL) && $schedule > 0) {
                $sql = "INSERT INTO cron_schedule (job_name, url, schedule, status) VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                try {
                    $stmt->execute([$job_name, $url, $schedule, 0]);
                    $this->message = "✅ Job '$job_name' đã được thêm thành công!";
                } catch (PDOException $e) {
                    $this->error_message = "❌ Lỗi khi thêm job: " . $e->getMessage();
                }
            } else {
                $this->error_message = "❌ Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.";
            }
        }

        ob_start();
        require __DIR__ . '/../view/cron/create.php';
        $content = ob_get_clean();

        require __DIR__ . '/../layout.php';
    }

    // (Có thể thêm delete, update … sau này)
}
