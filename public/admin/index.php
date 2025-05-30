<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';

$auth = authenticate(["admin"], true);
if (!$auth || $auth->role !== 'admin') {
  header('Location: ./auth/login.php');
  exit;
}

// Total cash collected
$stmt = $pdo->query("SELECT IFNULL(SUM(amount), 0) AS total_cash FROM payment_details");
$totalCash = $stmt->fetch()['total_cash'];

// Total items sold (simplified)
$stmt = $pdo->query("SELECT COUNT(*) AS total_sold FROM order_items");
$totalItemsSold = $stmt->fetch()['total_sold'];

// Total customers
$stmt = $pdo->query("SELECT COUNT(*) AS total_customers FROM `user`");
$totalCustomers = $stmt->fetch()['total_customers'];

// New members this month
$stmt = $pdo->prepare("
    SELECT first_name, last_name, email, created_at 
    FROM `user` 
    WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())
    ORDER BY created_at DESC
");
$stmt->execute();
$newMembers = $stmt->fetchAll();

// Top items
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
  <meta charset="UTF-8" />
  <title>Admin - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body class="bg-light m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <main class="flex-grow-1 p-3" style="height: 100vh; overflow-y: auto;">
      <div class="container-fluid">
        <h1 class="fw-bold mb-3">Dashboard</h1>

        <div class="row g-2 mb-4">
          <div class="col-md-4">
            <div class="card shadow-sm border-0 text-success">
              <div class="card-body position-relative py-2">
                <i class="bi bi-cash-stack fs-2 text-success" style="position: absolute; top: 0.5rem; right: 1rem; opacity: 0.25;"></i>
                <h6 class="text-uppercase fw-semibold mb-1">Total Cash Collected</h6>
                <h3 class="fw-bold">₱ <?php echo number_format($totalCash, 2); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm border-0 text-primary">
              <div class="card-body position-relative py-2">
                <i class="bi bi-basket fs-2 text-primary" style="position: absolute; top: 0.5rem; right: 1rem; opacity: 0.25;"></i>
                <h6 class="text-uppercase fw-semibold mb-1">Total Items Sold</h6>
                <h3 class="fw-bold"><?php echo number_format($totalItemsSold); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow-sm border-0 text-info">
              <div class="card-body position-relative py-2">
                <i class="bi bi-people fs-2 text-info" style="position: absolute; top: 0.5rem; right: 1rem; opacity: 0.25;"></i>
                <h6 class="text-uppercase fw-semibold mb-1">Total Customers</h6>
                <h3 class="fw-bold"><?php echo number_format($totalCustomers); ?></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-lg-6">
            <div class="card shadow-sm border-0">
              <div class="card-body p-3">
                <h5 class="fw-bold mb-3">New Members This Month</h5>
                <div class="table-responsive overflow-auto" style="max-height: 280px;">
                  <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light sticky-top">
                      <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 35%;">Full Name</th>
                        <th scope="col" style="width: 40%;">Email</th>
                        <th scope="col" style="width: 20%;">Date Joined</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($newMembers)) : ?>
                        <tr>
                          <td colspan="4" class="text-center text-muted py-3">No new members this month</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($newMembers as $index => $member): ?>
                          <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td><?php echo htmlspecialchars($member['last_name'] . ', ' . $member['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($member['created_at'])); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card shadow-sm border-0">
              <div class="card-body p-3">
                <h5 class="fw-bold mb-3">Top Items</h5>
                <div class="table-responsive overflow-auto" style="max-height: 280px;">
                  <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light sticky-top">
                      <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 45%;">Product Name</th>
                        <th scope="col" style="width: 20%;">Items Sold</th>
                        <th scope="col" style="width: 30%;">Total Money (₱)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (empty($topItems)) : ?>
                        <tr>
                          <td colspan="4" class="text-center text-muted py-3">No sales data available</td>
                        </tr>
                      <?php else: ?>
                        <?php foreach ($topItems as $index => $product): ?>
                          <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['items_sold']); ?></td>
                            <td>₱<?php echo number_format($product['total_money'], 2); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>