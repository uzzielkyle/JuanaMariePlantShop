<?php
// Dynamically get the protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Dynamically get the host and the base path
$host = $_SERVER['HTTP_HOST'];

// Project base folder name
$base = "/JuanaMariePlantShop/public"; // Change if your root folder name differs

// Final base URL
$base_url = $protocol . $host . $base;
?>

<nav class="bg-dark text-white p-3 vh-100 d-flex flex-column justify-content-between" style="min-width: 250px;">
  <div>
    <h5 class="mb-4 d-flex align-items-center gap-3">
      <a href="<?= $base_url ?>/admin/" class="text-white text-decoration-none d-flex align-items-center gap-2">
        <img src="<?= $base_url ?>/assets/logo.svg" alt="Juana Marie Logo" style="height: 30px; filter: brightness(0) invert(1);">
        <span>JUANA MARIE</span>
      </a>
    </h5>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $base_url ?>/admin/">
          <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $base_url ?>/admin/product-management.php">
          <i class="bi bi-box-seam me-2"></i>Products
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $base_url ?>/admin/category-management.php">
          <i class="bi bi-tags me-2"></i>Category
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $base_url ?>/admin/user-management.php">
          <i class="bi bi-people me-2"></i>Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $base_url ?>/admin/inventory-management.php">
          <i class="bi bi-stack me-2"></i>Inventory
        </a>
      </li>
    </ul>
  </div>

  <a href="<?= $base_url ?>/admin/auth/logout.php" class="btn btn-outline-light mt-3 w-100">
    <i class="bi bi-box-arrow-right me-2"></i>Logout
  </a>
</nav>