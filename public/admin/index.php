<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Main Page with Sidebar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">

  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <h1 class="fw-bold">DASHBOARD</h1>
      </div>
    </div>

  </div>
</body>

</html>