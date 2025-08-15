<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PoPiCron</title>
    <link rel="stylesheet" href="public/assets/css/site.css" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS (with Bootstrap 5 theme) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.6/dist/select2-bootstrap4.min.css" rel="stylesheet" />
  </head>
  <body>
    <div class="content-wrapper">
      <main class="container py-4">
        <?php include 'view/cron/index.php'; ?>
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
