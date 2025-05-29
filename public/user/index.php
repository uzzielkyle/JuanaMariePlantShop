<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["user"], true); // get user data from JWT

if (!$auth || $auth->role !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Account</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <div class="px-5">
    <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>
    <?php include_once "includes/user-nav.php"; ?>
    <div class="mx-5 border border-dark">
      <div class="p-3 px-5">
        <table class="table">
          <thead>
            <tr>
              <th class="px-5" scope="col">Order No.</th>
              <th class="px-5" scope="col">Delivery Date</th>
              <th class="px-5" scope="col">Order Status</th>
              <th class="px-5" scope="col">Order Price</th>
              <th class="px-5" scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row" class="px-5">1234532</th>
              <td class="px-5">November 11</td>
              <td class="px-5">On the way</td>
              <td class="px-5">P 500</td>
              <td>
                <button
                  type="submit"
                  class="viewButton btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
                  style="background-color: #cff3d7">
                  VIEW
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div
    class="modal fade"
    id="orderModal"
    tabindex="-1"
    aria-labelledby="orderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Item Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody class="table-group-divider">
                <tr>
                  <td>
                    <span class="avatar"><i class="fas fa-user"></i></span>
                    Item Name
                  </td>
                  <td>200</td>
                  <td>1</td>
                  <td>200</td>
                </tr>
                <tr>
                  <td>
                    <span class="avatar"><i class="fas fa-user"></i></span>
                    Item Name
                  </td>
                  <td>100</td>
                  <td>2</td>
                  <td>200</td>
                </tr>
                <tr>
                  <td>
                    <span class="avatar"><i class="fas fa-user"></i></span>
                    Item Name
                  </td>
                  <td>100</td>
                  <td>1</td>
                  <td>100</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <h4 class="mx-3">TOTAL PRICE:</h4>
          </div>
          <div class="col-4">
            <h4 class="mx-3">P 500</h4>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/modal-function.js"> </script>
  <script src="../js/dynamic-nav.js"></script>
</body>

</html>