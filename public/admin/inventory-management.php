<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';  // Add your DB connection

$auth = authenticate(["admin"], true); // get admin data from JWT
if (!$auth || $auth->role !== 'admin') {
    header('Location: ./auth/login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $productId = intval($_POST['product_id']);
        $newQty = intval($_POST['quantity']);
        $stmt = $pdo->prepare("UPDATE product SET quantity = :quantity WHERE idproduct = :id");
        $stmt->execute(['quantity' => $newQty, 'id' => $productId]);
        header("Location: " . $_SERVER['PHP_SELF']); // redirect to avoid form resubmission
        exit;
    }

    if (isset($_POST['delete_product'])) {
        $productId = intval($_POST['product_id']);
        $stmt = $pdo->prepare("DELETE FROM product WHERE idproduct = :id");
        $stmt->execute(['id' => $productId]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch products from DB
$stmt = $pdo->query("SELECT idproduct, name, quantity FROM product ORDER BY name");
$products = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Inventory - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <h1 class="fw-bold">PRODUCTS</h1>
        <div class="table-responsive ps-5 ms-5">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Status</th>
                <th>Quantity</th>
                <th></th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php foreach ($products as $product):
                $status = $product['quantity'] < 10 ? 'Low Stocks' : 'On Stocks';
                $statusClass = $product['quantity'] < 10 ? 'text-danger fw-bold' : 'text-success fw-bold';
                $icon = $product['quantity'] < 10
                  ? '<i class="bi bi-caret-down-fill"></i>'
                  : '<i class="bi bi-caret-up-fill"></i>';
              ?>
                <tr>
                  <td>
                    <img src="assets/default.jpg" class="img-fluid rounded-circle me-2" style="width: 40px; height: 40px" />
                    <?= htmlspecialchars($product['name']) ?>
                  </td>
                  <td class="<?= $statusClass ?>"><?= $status ?> <?= $icon ?></td>
                  <td>
                    <form method="post" class="d-flex align-items-center gap-2">
                      <input type="hidden" name="product_id" value="<?= $product['idproduct'] ?>">
                      <input
                        type="number"
                        name="quantity"
                        class="form-control w-50 quantity"
                        value="<?= $product['quantity'] ?>"
                        min="0"
                        max="9999"
                        step="1"
                      />
                      <button type="submit" name="update_quantity" class="btn btn-primary btn-sm rounded-pill">UPDATE</button>
                    </form>
                  </td>
                  <td>
                    <form method="post" onsubmit="return confirm('Are you sure to delete this product?');">
                      <input type="hidden" name="product_id" value="<?= $product['idproduct'] ?>">
                      <button type="submit" name="delete_product" class="btn btn-danger rounded-pill fw-bold border-0">DELETE</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($products)): ?>
                <tr>
                  <td colspan="4" class="text-center">No products found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('.quantity').on('input', function() {
        var quantity = $(this).val();
        var statusCell = $(this).closest('tr').find('td:nth-child(2)');

        if (quantity < 10) {
          statusCell.html('Low Stocks <i class="bi bi-caret-down-fill"></i>').removeClass('text-success').addClass('text-danger fw-bold');
        } else {
          statusCell.html('On Stocks <i class="bi bi-caret-up-fill"></i>').removeClass('text-danger').addClass('text-success fw-bold');
        }
      });
    });
  </script>
</body>

</html>
