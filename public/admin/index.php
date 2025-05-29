<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';

$auth = authenticate(["admin"], true);
if (!$auth || $auth->role !== 'admin') {  // Assuming $auth is an array, adjust if it's an object
  header('Location: ./auth/login.php');
  exit;
}

// Get total cash collected (sum of payment amounts)
$stmt = $pdo->query("SELECT IFNULL(SUM(amount), 0) AS total_cash FROM payment_details");
$totalCash = $stmt->fetch()['total_cash'];

// Get total items sold (sum of all quantities in order_items)
$stmt = $pdo->query("
    SELECT IFNULL(SUM(oi_count), 0) AS total_sold FROM (
        SELECT COUNT(*) AS oi_count FROM order_items
    ) AS subquery
");
$totalItemsSold = $stmt->fetch()['total_sold'];

// Get total customers (count of users)
$stmt = $pdo->query("SELECT COUNT(*) AS total_customers FROM `user`");
$totalCustomers = $stmt->fetch()['total_customers'];

// Get new members this month
$stmt = $pdo->prepare("
    SELECT first_name, last_name, email, created_at 
    FROM `user` 
    WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ORDER BY created_at DESC
");
$stmt->execute();
$newMembers = $stmt->fetchAll();

// Get top items (top 5 products by sold quantity)
$stmt = $pdo->query("
    SELECT p.name, SUM(oi_count) AS items_sold, SUM(oi_count * p.price) AS total_money
    FROM product p
    JOIN (
        SELECT products, COUNT(*) AS oi_count FROM order_items GROUP BY products
    ) oi ON p.idproduct = oi.products
    GROUP BY p.idproduct
    ORDER BY items_sold DESC
    LIMIT 5
");
$topItems = $stmt->fetchAll();
?>

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
                <h1 class="fw-bold">₱ <?php echo number_format($totalCash, 2); ?></h1>
              </div>
            </div>
            <div class="col me-2 p-2 border border-dark">
              <h5 class="fw-light">Total Items Sold</h5>
              <div class="text-center">
                <h1 class="fw-bold"><?php echo number_format($totalItemsSold); ?></h1>
              </div>
            </div>
            <div class="col me-5 p-2 border border-dark">
              <h5 class="fw-light">Total Customers</h5>
              <div class="text-center">
                <h1 class="fw-bold"><?php echo number_format($totalCustomers); ?></h1>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col me-2 ms-5 p-2 border border-dark">
              <h5 class="fw-light">New Members this Month</h5>
              <!-- Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date Joined</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($newMembers as $index => $member): ?>
                    <tr>
                      <th scope="row"><?php echo $index + 1; ?></th>
                      <td><?php echo htmlspecialchars($member['last_name'] . ', ' . $member['first_name']); ?></td>
                      <td><?php echo htmlspecialchars($member['email']); ?></td>
                      <td><?php echo date('Y-m-d', strtotime($member['created_at'])); ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($newMembers)): ?>
                    <tr>
                      <td colspan="4" class="text-center">No new members this month</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <div class="col me-5 p-2 border border-dark">
              <h5 class="fw-light">Top Items</h5>
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
                  <?php foreach ($topItems as $index => $product): ?>
                    <tr>
                      <th scope="row"><?php echo $index + 1; ?></th>
                      <td><?php echo htmlspecialchars($product['name']); ?></td>
                      <td><?php echo number_format($product['items_sold']); ?></td>
                      <td>₱<?php echo number_format($product['total_money'], 2); ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($topItems)): ?>
                    <tr>
                      <td colspan="4" class="text-center">No sales data available</td>
                    </tr>
                  <?php endif; ?>
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
