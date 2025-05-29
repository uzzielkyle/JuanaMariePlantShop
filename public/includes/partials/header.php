<?php
// Dynamically get the protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Dynamically get the host and the base path
$host = $_SERVER['HTTP_HOST'];

// Project base folder name
$base = "/JuanaMariePlantShop/public"; // Change if your root folder name differs

// Final base URL
$base_url = $protocol . $host . $base;

$auth = authenticate(['user', 'admin'], true); // silent = true
?>


<header class="navbar navbar-expand-lg bg-white px-4 py-2 border-bottom fixed-top">
  <a class="navbar-brand d-flex align-items-center me-5" href="<?= $base_url ?>/index.php">
    <img src="<?= $base_url ?>/assets/logo.svg" alt="Logo" style="height: 40px;">
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNavbar">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link px-4 mx-2" href="<?= $base_url ?>/">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-4 mx-2" href="<?= $base_url ?>/shop.php">SHOP</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-4 mx-2" href="<?= $base_url ?>/about.php">ABOUT US</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-4 mx-2" href="<?= $base_url ?>/contacts.php">CONTACT US</a>
      </li>
    </ul>

    <div class="d-flex align-items-center gap-3">
      <?php if ($auth): ?>
        <a href="<?= $base_url ?>/user/cart.php" class="text-dark fs-5">
          <i class="bi bi-cart"></i>
        </a>

        <a href="<?= $base_url ?>/user/user-account.php">
          <img src="http://placebeard.it/250/250" alt="Profile" class="rounded-circle" style="height: 32px; width: 32px;">
        </a>

        <a href="<?= $base_url ?>/auth/logout.php" class="btn btn-outline-danger active rounded-pill">
          Logout
        </a>
      <?php else: ?>
        <a href="<?= $base_url ?>/auth/login.php" class="btn border-1 border-success fw-bold bg-success-subtle rounded-pill">
          Login
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>