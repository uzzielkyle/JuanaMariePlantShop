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
        <div class="container pt-5">
          <div class="row">
            <div class="col me-2 ms-5 p-2 border border-dark ">
              <h5 class="fw-light">Total Cash Collected</h5>
              <div class="text-center">
                <h1 class="fw-bold">P 500,000</h1>
              </div>
            </div>
            <div class="col me-2 p-2 border border-dark">
              <h5 class="fw-light">Total Items Sold</h5>
              <div class="text-center">
                <h1 class="fw-bold">1,412</h1>
              </div>
            </div>
            <div class="col me-5 p-2 border border-dark">
              <h5 class="fw-light">Total Customers</h5>
              <div class="text-center">
                <h1 class="fw-bold">1,091</h1>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col me-2 ms-5 p-2 border border-dark">
              <h5 class="fw-light">New Members this Month</h5>
              <?php
              // Sample data array of people
              $people = [
                ["first" => "Mark", "last" => "Otto", "country" => "USA", "joined" => "2021-03-15"],
                ["first" => "Jacob", "last" => "Thornton", "country" => "Canada", "joined" => "2022-06-20"],
                ["first" => "Larry", "last" => "The Bird", "country" => "UK", "joined" => "2023-01-10"],
              ];
              ?>
              <!-- Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Date Joined</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($people as $index => $person): ?>
                    <tr>
                      <th scope="row"><?php echo $index + 1; ?></th>
                      <td><?php echo $person['last'] . ', ' . $person['first']; ?></td>
                      <td><?php echo $person['country']; ?></td>
                      <td><?php echo $person['joined']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="col me-5 p-2 border border-dark">
              <h5 class="fw-light">Top Items</h5>
              <?php
              // Sample array of herb products
              $products = [
                ["name" => "Basil", "sold" => 150, "total" => 3000.00],
                ["name" => "Mint", "sold" => 200, "total" => 4000.00],
                ["name" => "Oregano", "sold" => 120, "total" => 2400.00],
              ];
              ?>
              <!-- Table of Product Sales -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name of Product</th>
                    <th scope="col">Items Sold</th>
                    <th scope="col">Total Money (₱)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($products as $index => $product): ?>
                    <tr>
                      <th scope="row"><?php echo $index + 1; ?></th>
                      <td><?php echo $product['name']; ?></td>
                      <td><?php echo $product['sold']; ?></td>
                      <td>₱<?php echo number_format($product['total'], 2); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>