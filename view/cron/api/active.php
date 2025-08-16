<?php
header('Content-Type: application/json');

// Bao gồm db.php và cron_handler.php
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../cron_handler.php';

// Đường dẫn đến php_task_scheduler.php
$schedulerScript = __DIR__ . '/../php_task_scheduler.php';

// File để lưu PID của scheduler
$pidFile = '/var/www/html/view/cron/scheduler.pid';

// Kiểm tra xem scheduler đã chạy chưa
if (file_exists($pidFile)) {
    $pid = file_get_contents($pidFile);
    if (shell_exec("ps -p $pid | grep $pid")) {
        echo json_encode([
            'success' => false,
            'message' => 'Scheduler đã chạy với PID: ' . $pid
        ]);
        exit;
    }
}

// Khởi động scheduler trong nền
$command = "php $schedulerScript > /var/www/html/view/cron/scheduler.log 2>&1 & echo $!";
$pid = trim(shell_exec($command));

// Lưu PID vào file
file_put_contents($pidFile, $pid);

echo json_encode([
    'success' => true,
    'message' => 'Scheduler đã được kích hoạt với PID: ' . $pid
]);
?>