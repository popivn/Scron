<?php
// Đặt múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Gọi file db.php và cron_handler.php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/cron_handler.php';

class PhpTaskScheduler {
    private $cronHandler;
    private $pdo;
    private $checkInterval = 10; // Kiểm tra mỗi 10 giây

    public function __construct() {
        $this->cronHandler = new CronHandler();

        // Kết nối cơ sở dữ liệu sử dụng PDO
        global $pdo;
        if ($pdo instanceof PDO) {
            $this->pdo = $pdo;
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Kết nối cơ sở dữ liệu thành công\n";
        } else {
            die("Lỗi kết nối cơ sở dữ liệu: Không thể khởi tạo PDO");
        }
    }

    public function run() {
        echo "PHP Task Scheduler đang chạy. Nhấn Ctrl+C để dừng.\n";
        echo "Múi giờ PHP: " . date_default_timezone_get() . "\n";

        while (true) {
            try {
                // Lấy danh sách cron jobs có status = 1
                $stmt = $this->pdo->query("SELECT * FROM cron_schedule WHERE status = 1");
                $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "Số job với status = 1: " . count($jobs) . "\n";
                
                if (count($jobs) === 0) {
                    echo "Không tìm thấy job nào với status = 1\n";
                }

                $currentTime = time();
                echo "Thời gian hiện tại (Unix timestamp): $currentTime (" . date('Y-m-d H:i:s', $currentTime) . ")\n";

                foreach ($jobs as $job) {
                    $jobId = $job['id'];
                    $url = $job['url'];
                    $schedule = (int)$job['schedule'];
                    $lastRunRaw = $job['last_run'];
                    $lastRun = $lastRunRaw ? strtotime($lastRunRaw) : null;

                    echo "Kiểm tra job $jobId (URL: $url, Schedule: $schedule giây, Last Run Raw: " . 
                         ($lastRunRaw ? $lastRunRaw : 'NULL') . ", Last Run Timestamp: " . 
                         ($lastRun ? date('Y-m-d H:i:s', $lastRun) . " ($lastRun)" : 'NULL') . ")\n";

                    // Kiểm tra schedule hợp lệ
                    if ($schedule <= 0) {
                        echo "Job $jobId: Schedule không hợp lệ ($schedule giây)\n";
                        continue;
                    }

                    // Kiểm tra last_run hợp lệ
                    if ($lastRunRaw && $lastRun === false) {
                        echo "Job $jobId: last_run không hợp lệ ($lastRunRaw)\n";
                        continue;
                    }

                    // Kiểm tra xem có cần chạy job không
                    $shouldRun = false;
                    if ($lastRun === null) {
                        $shouldRun = true;
                        echo "Job $jobId: last_run là NULL, sẽ chạy ngay.\n";
                    } else {
                        $diff = $currentTime - $lastRun;
                        echo "Job $jobId: ($currentTime - $lastRun) = $diff giây >= $schedule giây : " . 
                             ($diff >= $schedule ? 'true' : 'false') . "\n";
                        if ($diff >= $schedule) {
                            $shouldRun = true;
                            echo "Job $jobId: Đã đủ $schedule giây kể từ last_run, sẽ chạy.\n";
                        } else {
                            echo "Job $jobId: Chưa đủ thời gian ($diff < $schedule giây).\n";
                        }
                    }

                    if ($shouldRun) {
                        // Gọi URL
                        echo "Đang gọi URL: $url cho job $jobId tại " . date('Y-m-d H:i:s') . "\n";
                        $response = $this->cronHandler->callUrl($url);
                        echo "Kết quả gọi URL $url: " . ($response ? $response : "Không có phản hồi") . "\n";

                        // Cập nhật last_run
                        $stmt = $this->pdo->prepare("UPDATE cron_schedule SET last_run = FROM_UNIXTIME(?) WHERE id = ?");
                        $stmt->execute([$currentTime, $jobId]);
                        echo "Cập nhật last_run cho job $jobId thành công.\n";
                    }
                }
                
                echo "Đã kiểm tra cron jobs tại: " . date('Y-m-d H:i:s') . "\n";
            } catch (Exception $e) {
                $error = "Lỗi trong PhpTaskScheduler: " . $e->getMessage();
                echo $error . "\n";
                error_log($error);
            }
            
            // Ngủ để tiết kiệm tài nguyên
            sleep($this->checkInterval);
        }
    }
}

// Khởi động scheduler
$scheduler = new PhpTaskScheduler();
$scheduler->run();
?>