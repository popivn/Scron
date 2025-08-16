<?php
header('Content-Type: application/json');

// Đường dẫn đến file PID
$pidFile = '/var/www/html/view/cron/scheduler.pid';

if (!file_exists($pidFile)) {
    echo json_encode([
        'success' => false,
        'message' => 'Scheduler không chạy'
    ]);
    exit;
}

$pid = file_get_contents($pidFile);

if (shell_exec("ps -p $pid | grep $pid")) {
    shell_exec("kill $pid");
    unlink($pidFile);
    echo json_encode([
        'success' => true,
        'message' => 'Scheduler đã dừng'
    ]);
} else {
    unlink($pidFile);
    echo json_encode([
        'success' => false,
        'message' => 'Scheduler không chạy hoặc đã dừng trước đó'
    ]);
}
?>