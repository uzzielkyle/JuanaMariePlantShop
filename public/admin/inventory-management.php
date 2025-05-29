<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["admin"], true); // get admin data from JWT

if (!$auth || $auth->role !== 'admin') {
    header('Location: ./auth/login.php');
    exit;
}
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
              <?php
              $products = [
                ['name' => 'Basil', 'quantity' => 29],
                ['name' => 'Mint', 'quantity' => 8],
                ['name' => 'Oregano', 'quantity' => 12],
                ['name' => 'Parsley', 'quantity' => 3],
              ];

              foreach ($products as $product) {
                $status = $product['quantity'] < 10 ? 'Low Stocks' : 'On Stocks';
                $statusClass = $product['quantity'] < 10 ? 'text-danger fw-bold' : 'text-success fw-bold';
                $icon = $product['quantity'] < 10 ?
                  '<i class="bi bi-caret-down-fill"></i>' :
                  '<i class="bi bi-caret-up-fill"></i>';
              ?>
                <tr>
                  <td>
                    <img src="assets/default.jpg" class="img-fluid rounded-circle me-2" style="width: 40px; height: 40px" />
                    <?= htmlspecialchars($product['name']) ?>
                  </td>
                  <td class="<?= $statusClass ?>"><?= $status ?> <?= $icon ?></td>
                  <td>
                    <input type="number" class="form-control w-50 quantity" value="<?= $product['quantity'] ?>" min="0" max="9999" step="1">
                  </td>
                  <td>
                    <button class="btn btn-danger rounded-pill fw-bold border-0">DELETE</button>
                  </td>
                </tr>
              <?php } ?>
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