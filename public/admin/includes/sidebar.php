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
    <h5 class="mb-4"><a href="#" class="text-white text-decoration-none">JUANA MARIE</a></h5>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Category</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Inventory</a>
      </li>
    </ul>
  </div>

  <a href="<?= $base_url ?>/admin/auth/logout.php" class="btn btn-outline-light mt-3 w-100">Logout</a>
</nav>
