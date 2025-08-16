<?php
// layout.php
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PoPiCron</title>
    <link rel="stylesheet" href="public/assets/css/site.css" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.6/dist/select2-bootstrap4.min.css" rel="stylesheet" />
  </head>
  <body>
    <!-- Header -->
    <header class="bg-primary text-white shadow-sm">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
          <a class="navbar-brand fw-bold" href="?page=list">
            <img src="public/assets/img/logo.png" alt="PoPiCron" style="height:32px;margin-right:8px;vertical-align:middle;" onerror="this.style.display='none'">
            PoPiCron
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link<?php if(($_GET['page'] ?? 'list') === 'list') echo ' active'; ?>" href="?page=list">Danh sách Jobs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link<?php if(($_GET['page'] ?? '') === 'create') echo ' active'; ?>" href="?page=create">Tạo Job mới</a>
              </li>
              <!-- Có thể thêm các mục khác ở đây -->
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- End Header -->

    <div class="content-wrapper">
      <main class="container py-4">
        <?php 
          // chèn nội dung view ở đây
          echo $content ?? '';
        ?>
      </main>
    </div>
    <footer>
      <div style="text-align:center;padding:16px 0;opacity:.6">&copy; PoPiCron</div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#exampleSelect').select2({
          theme: 'bootstrap4',
          width: '100%'
        });
      });
    </script>
    <script src="public/assets/js/site.js" defer></script>
  </body>
</html>
