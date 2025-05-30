<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';

$auth = authenticate(["user"], true);
if (!$auth || $auth->role !== 'user') {
  header('Location: ../auth/login.php');
  exit;
}

$userId = $auth->id;

$stmt = $pdo->prepare("SELECT od.idorder_details, od.total, pd.amount 
                        FROM order_details od 
                        LEFT JOIN payment_details pd ON od.payment = pd.idpayment_details
                        WHERE od.user = ?
                        ORDER BY od.idorder_details DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="d-grid min-vh-100" style="grid-template-rows: 1fr auto;">
  <div class="px-5">
    <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>
    <?php include_once "includes/user-nav.php"; ?>

    <div class="w-100 mt-4 p-4 bg-white rounded-3 shadow-sm" style="border: 1px solid #ddd;">
      <h4 class="mb-4 text-success fw-bold">Your Orders</h4>

      <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center fs-6" role="alert">
          You have no orders yet.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="px-3 py-2" scope="col">Order No.</th>
                <th class="px-3 py-2" scope="col">Order Status</th>
                <th class="px-3 py-2 text-end" scope="col">Order Total</th>
                <th class="px-3 py-2 text-center" scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
                <tr>
                  <td class="px-3 py-2 text-secondary fw-semibold">#<?= htmlspecialchars($order['idorder_details']) ?></td>
                  <td class="px-3 py-2">
                    <span class="badge bg-success text-uppercase fs-7">Paid</span>
                  </td>
                  <td class="px-3 py-2 text-end fw-semibold">
                    P <?= number_format((float)$order['total'], 2) ?>
                  </td>
                  <td class="px-3 py-2 text-center">
                    <button
                      class="viewButton btn btn-outline-success rounded-pill px-4 fw-semibold"
                      data-order-id="<?= $order['idorder_details'] ?>"
                      data-bs-toggle="modal"
                      data-bs-target="#orderModal"
                      aria-label="View order details #<?= htmlspecialchars($order['idorder_details']) ?>">
                      View
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2 px-3">
          <h5 class="modal-title fs-6" id="orderModalLabel">Order Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3">

          <!-- Loading Spinner -->
          <div id="modalLoader" class="text-center py-3 d-none">
            <div class="spinner-border text-success" role="status" style="width: 2rem; height: 2rem;">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 mb-0 small">Loading order details...</p>
          </div>

          <!-- Order Content -->
          <div id="modalContent">
            <div class="table-responsive">
              <table class="table table-hover table-sm mb-2">
                <thead>
                  <tr>
                    <th class="py-1">Item Name</th>
                    <th class="py-1 text-end">Price</th>
                    <th class="py-1 text-center">Qty</th>
                    <th class="py-1 text-end">Total</th>
                  </tr>
                </thead>
                <tbody id="modalOrderItems">
                  <!-- Filled dynamically -->
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end align-items-center pt-2">
              <strong class="me-3 fs-5 mb-0">TOTAL PRICE:</strong>
              <span id="modalTotalPrice" class="fs-5 mb-0">P 0</span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include_once '../includes/partials/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).on('click', '.viewButton', function() {
      const orderId = $(this).data('order-id');

      $('#orderModalLabel').text(`Order Details - #${orderId}`);
      $('#modalLoader').removeClass('d-none');
      $('#modalContent').addClass('d-none');
      $('#modalOrderItems').html('');
      $('#modalTotalPrice').text('P 0');

      $.ajax({
        url: '../api/user/order.php?order_id=' + orderId,
        type: 'GET',
        success: function(res) {
          let items = res.items || [];
          let total = res.total_price || 0;
          let html = '';

          if (items.length === 0) {
            html = `<tr><td colspan="4" class="text-center small fst-italic text-muted py-2">
                    No items found for this order.
                  </td></tr>`;
          } else {
            items.forEach(item => {
              const name = item.name ?? null;
              const price = item.price ?? null;
              const quantity = item.quantity ?? 0;
              let lineTotal = 0;

              if (name === null || price === null) {
                // Product deleted scenario
                html += `
                <tr>
                  <td class="fst-italic small text-muted">Product/s was deleted from records</td>
                  <td colspan="3" class="text-muted text-center small py-2">N/A</td>
                </tr>
              `;
              } else {
                lineTotal = price * quantity;
                html += `
                <tr>
                  <td class="align-middle small">${name}</td>
                  <td class="align-middle text-end small">P ${parseFloat(price).toFixed(2)}</td>
                  <td class="align-middle text-center small">${quantity}</td>
                  <td class="align-middle text-end small">P ${parseFloat(lineTotal).toFixed(2)}</td>
                </tr>
              `;
              }
            });
          }

          $('#modalOrderItems').html(html);
          $('#modalTotalPrice').text('P ' + parseFloat(total).toFixed(2));
          $('#modalLoader').addClass('d-none');
          $('#modalContent').removeClass('d-none');
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error:", {
            status: status,
            error: error,
            responseText: xhr.responseText
          });
          $('#modalOrderItems').html(`
          <tr>
            <td colspan="4" class="text-center text-danger small py-2">
              Failed to load order details.
            </td>
          </tr>`);
          $('#modalTotalPrice').text('P 0');
          $('#modalLoader').addClass('d-none');
          $('#modalContent').removeClass('d-none');
        }
      });
    });
  </script>


</body>

</html>