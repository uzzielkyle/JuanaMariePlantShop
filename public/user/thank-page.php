<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["user"], true); // get user data from JWT

if (!$auth || $auth->role !== 'user') {
  header('Location: ../auth/login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank You - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>
  <section class="container pb-3 px-5 pt-5 mt-5">
    <div class="text-center mx-5 px-5">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="200"
        height="200"
        fill="currentColor"
        class="bi bi-truck"
        viewBox="0 0 16 16">
        <path
          d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
      </svg>
      <h1 class="text-center fw-bold mb-4">Thank you for your order</h1>
      <p>
        Your order has been placed and is being processed. You will receive a
        notification with your order details
      </p>

      <a href="../shop.php" class="text-success fw-bold text-decoration-underline">
        Go back to shopping
      </a>
    </div>
  </section>

  <?php include_once '../includes/partials/footer.php'; ?>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/dynamic-nav.js"></script>
</body>

</html>