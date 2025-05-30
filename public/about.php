<?php
require_once './middleware/authMiddleware.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - Juana Marie</title>
  <link rel="icon" href="./assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body>
  <?php include_once "./includes/partials/header.php" ?>

  <!-- About Us Section -->
  <section class="container mt-5 px-4 py-5 bg-light rounded shadow-sm">
    <div class="text-center mb-5">
      <h1 class="fw-bold text-success">ABOUT US</h1>
      <p class="mt-3 lead text-muted">Your trusted source for fresh, living herbs right in Zamboanga City.</p>
    </div>
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <p class="mb-4">
          Welcome to our herb shop—your go-to place for fresh, living herb plants! We’re all about helping people grow
          their own herbs at home, whether you're a seasoned gardener or just starting out.
        </p>
        <p class="mb-4">
          From kitchen staples like basil, rosemary, and mint to more unique finds like lemon balm or thyme, we offer a
          variety of healthy, vibrant herb plants ready to thrive in your garden, balcony, or windowsill.
        </p>
        <p class="mb-4">
          We believe that growing your own herbs is not only rewarding, but also a great step toward a healthier and
          more sustainable lifestyle. That’s why we focus on offering well-cared-for plants, helpful advice, and a
          welcoming atmosphere for all plant lovers.
        </p>
        <p>
          Thanks for visiting—we hope our little green corner brings some fresh flavor and joy into your life!
        </p>
      </div>
    </div>
  </section>

 <!-- Meet the Team Section -->
  <section class="container py-5">
    <h2 class="text-center fw-bold mb-4 text-success">MEET THE TEAM</h2>
    <div class="row g-4 justify-content-center">
      <!-- Jovan Timosa -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow rounded-4 text-center">
          <img src="./assets/jovtim.png" class="card-img-top rounded-circle mx-auto mt-3"
            alt="Jovan Timosa" style="width: 150px; height: 150px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Jovan Timosa</h5>
            <p class="card-text text-muted">Developer</p>
          </div>
        </div>
      </div>

      <!-- Uzziel Kyle Ynciong -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 border-0 shadow rounded-4 text-center">
          <img src="./assets/uzzielkyle.png" class="card-img-top rounded-circle mx-auto mt-3"
            alt="Uzziel Kyle Ynciong" style="width: 150px; height: 150px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Uzziel Kyle Ynciong</h5>
            <p class="card-text text-muted">Developer</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once './includes/partials/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/dynamic-nav.js"></script>
</body>

</html>
