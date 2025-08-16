document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-cron').forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.getAttribute('data-id');
            fetch('cron_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=toggle&job_id=${jobId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi khi xử lý yêu cầu');
            });
        });
    });
});