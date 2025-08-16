<?php
// web.php

// Bước 1: Nhận yêu cầu từ người dùng
$request = $_GET['page'] ?? 'list';
// Bước 2: Chuyển hướng yêu cầu đến Controller phù hợp
switch ($request) {
    case 'create':
        require_once __DIR__ . '/controller/CronController.php';
        break;
    case 'list':
    default:
        require_once __DIR__ . '/controller/CronController.php';
        break;
}

// Lưu ý: Cấu trúc này giả định tất cả các route đều được xử lý bởi CronController.
// Trong một ứng dụng lớn hơn, bạn sẽ có các controller khác nhau cho từng chức năng.
