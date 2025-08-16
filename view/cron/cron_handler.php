<?php
class CronHandler {
    private $db_file = 'cron_jobs.json';

    /**
     * Chuyển đổi trạng thái cron job
     */
    public function toggleCronJob($job_id) {
        $jobs = $this->loadJobs();
        
        foreach ($jobs as &$job) {
            if ($job['id'] == $job_id) {
                $job['status'] = $job['status'] === 1 ? 0 : 1;
                
                // Nếu bật job, cập nhật thời gian bắt đầu
                if ($job['status'] === 1) {
                    $job['next_run'] = time() + $job['schedule'];
                }
                
                $this->saveJobs($jobs);
                return [
                    'success' => true,
                    'message' => $job['status'] === 1 ? 'Cron job đã được bật' : 'Cron job đã được tắt',
                    'status' => $job['status']
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => 'Không tìm thấy cron job'
        ];
    }

    /**
     * Thực thi các cron job đang chạy
     */
    public function executeCronJobs() {
        $jobs = $this->loadJobs();
        $current_time = time();
        
        foreach ($jobs as &$job) {
            if ($job['status'] === 1 && isset($job['next_run']) && $current_time >= $job['next_run']) {
                // Gọi URL
                $this->callUrl($job['url']);
                
                // Cập nhật thời gian chạy lần cuối và lần chạy tiếp theo
                $job['last_run'] = date('Y-m-d H:i:s', $current_time);
                $job['next_run'] = $current_time + $job['schedule'];
            }
        }
        
        $this->saveJobs($jobs);
    }

    /**
     * Gọi URL bằng cURL
      */
      public function callUrl($url) {
        // Kiểm tra URL hợp lệ
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            error_log("URL không hợp lệ: $url");
            return false;
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bỏ qua kiểm tra SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Theo dõi redirect
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // Giới hạn số lần redirect
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Lấy HTTP status code
    
        if (curl_errno($ch)) {
            $error = "cURL error for URL $url: " . curl_error($ch);
            error_log($error);
            echo $error . "\n";
            curl_close($ch);
            return false;
        }
    
        // Kiểm tra HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            echo "Response from $url (HTTP $httpCode):\n$response\n";
            error_log("Gọi URL $url thành công (HTTP $httpCode)");
        } else {
            $error = "Gọi URL $url thất bại (HTTP $httpCode): $response";
            echo $error . "\n";
            error_log($error);
            $response = false;
        }
    
        curl_close($ch);
        return $response;
    }

    /**
     * Đọc danh sách jobs từ file
     */
    private function loadJobs() {
        if (file_exists($this->db_file)) {
            $content = file_get_contents($this->db_file);
            return json_decode($content, true) ?: [];
        }
        return [];
    }

    /**
     * Lưu danh sách jobs vào file
     */
    private function saveJobs($jobs) {
        file_put_contents($this->db_file, json_encode($jobs, JSON_PRETTY_PRINT));
    }
}

// Xử lý request bật/tắt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle' && isset($_POST['job_id'])) {
    $cronHandler = new CronHandler();
    $result = $cronHandler->toggleCronJob($_POST['job_id']);
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}

// Xử lý thực thi cron jobs
$cronHandler = new CronHandler();
$cronHandler->executeCronJobs();
?>