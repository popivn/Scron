<?php
/**
 * View: Form tạo mới Cron Job
 * File này được gọi từ CronController.php
 * Nó sẽ hiển thị form và các thông báo (nếu có).
 */
?>
<div class="container my-5">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Thêm Cron Job Mới</h2>
        </div>
        <div class="card-body">
            <?php if (isset($message)): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="?page=create" method="post">
                <div class="mb-3">
                    <label for="job_name" class="form-label">Tên Job</label>
                    <input type="text" class="form-control" id="job_name" name="job_name" required placeholder="Ví dụ: Cập nhật tỷ giá">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" class="form-control" id="url" name="url" required placeholder="Ví dụ: https://api.example.com/update-data">
                </div>
                <div class="mb-3">
                    <label for="schedule" class="form-label">Lịch trình (giây)</label>
                    <input type="number" class="form-control" id="schedule" name="schedule" required min="1" value="300" placeholder="Ví dụ: 300 (mỗi 300 giây)">
                </div>
                <button type="submit" class="btn btn-primary w-100">Thêm Job</button>
            </form>
        </div>
    </div>
    <div class="text-center">
        <a href="?page=list" class="btn btn-link mt-3">Quay lại danh sách jobs</a>
    </div>
</div>
