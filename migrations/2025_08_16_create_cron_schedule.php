<?php
require_once __DIR__ . '/../db.php'; // file kết nối PDO

try {
    $sql = "
        CREATE TABLE IF NOT EXISTS cron_schedule (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_name VARCHAR(100) NOT NULL,
            url VARCHAR(255) NOT NULL,
            schedule VARCHAR(50) NOT NULL,
            last_run DATETIME NULL,
            status TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";

    $pdo->exec($sql);
    echo "✅ Migration chạy thành công: cron_schedule đã được tạo.\n";
} catch (PDOException $e) {
    echo "❌ Lỗi migration: " . $e->getMessage() . "\n";
}
