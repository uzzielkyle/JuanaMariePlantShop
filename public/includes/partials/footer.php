<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$base = "/JuanaMariePlantShop/public";
$base_url = $protocol . $host . $base;
?>

<footer class="bg-dark text-white py-5 mt-5">
  <div class="container">
    <div class="row text-center text-md-start align-items-start">

      <!-- Logo & Description -->
      <div class="col-12 col-md-4 mb-4 mb-md-0">
        <img src="<?= $base_url ?>/assets/logo.svg" alt="Logo" style="height: 40px; filter: brightness(0) invert(1);" class="mb-3">
        <p>JUANA MARIE offers a curated selection of healing herbs, garden plants, and botanical products for everyday wellness and natural living.</p>
      </div>

      <!-- Spacer for significant gap on desktop -->
      <div class="d-none d-md-block col-md-1"></div>

      <!-- Site Navigation -->
      <div class="col-12 col-md-3 mb-4 mb-md-0">
        <h5 class="fw-bold">Navigate</h5>
        <ul class="list-unstyled">
          <li><a href="<?= $base_url ?>/index.php" class="text-white text-decoration-none">Home</a></li>
          <li><a href="<?= $base_url ?>/shop.php" class="text-white text-decoration-none">Shop</a></li>
          <li><a href="<?= $base_url ?>/about.php" class="text-white text-decoration-none">About</a></li>
          <li><a href="<?= $base_url ?>/contacts.php" class="text-white text-decoration-none">Contact</a></li>
        </ul>
      </div>

      <!-- User Links -->
      <div class="col-12 col-md-4">
        <h5 class="fw-bold">Account</h5>
        <ul class="list-unstyled">
          <li><a href="<?= $base_url ?>/auth/login.php" class="text-white text-decoration-none">Login</a></li>
          <li><a href="<?= $base_url ?>/auth/register.php" class="text-white text-decoration-none">Register</a></li>
          <li><a href="<?= $base_url ?>/user/" class="text-white text-decoration-none">User Dashboard</a></li>
          <li><a href="<?= $base_url ?>/admin/" class="text-white text-decoration-none">Admin Panel</a></li>
        </ul>
      </div>

    </div>

    <hr class="border-light my-4">

    <div class="text-center small">
      <p class="mb-1">&copy; <?= date('Y') ?> Juana Marie Plant Shop. All rights reserved.</p>
      <p class="mb-0">
        Developed by 
        <a href="https://github.com/uzzielkyle" target="_blank" class="text-white text-decoration-underline fw-semibold">Uzziel Kyle Ynciong</a> & 
        <a href="https://github.com/JovTim" target="_blank" class="text-white text-decoration-underline fw-semibold">Jovan Timosa</a>
      </p>
    </div>
  </div>
</footer>
