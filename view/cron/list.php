<?php
/**
 * View: Danh sách Cron Jobs
 * File này được gọi từ CronController.php
 * Nó sẽ hiển thị danh sách job và các thông báo.
 */
?>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Danh sách Cron Jobs</h2>
            <!-- Nút chuyển hướng đến trang tạo mới -->
            <a href="?page=create" class="btn btn-success btn-sm">Tạo job mới</a>
        </div>
        <div class="card-body">
            <?php if (isset($message)): ?>
                <div class="alert alert-info" role="alert">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($jobs)): ?>
                <p class="text-muted">Chưa có cron job nào được tạo.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Job</th>
                                <th>URL</th>
                                <th>Lịch trình</th>
                                <th>Chạy lần cuối</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?= htmlspecialchars($job['id']) ?></td>
                                    <td><?= htmlspecialchars($job['job_name']) ?></td>
                                    <td><?= htmlspecialchars($job['url']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($job['schedule']) ?>s</span></td>
                                    <td><?= htmlspecialchars($job['last_run'] ?? 'Chưa bao giờ') ?></td>
                                    <td>
                                        <?php if ($job['status'] === 1): ?>
                                            <span class="badge bg-success">Thành công</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Thất bại</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
