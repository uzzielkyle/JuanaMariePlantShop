<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Cart</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body>
  <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>
  <section class="px-5 py-5 my-5">
    <div class="row px-5">
      <div class="col-8">
        <?php
        $items = [["Rosemary", 100, 1], ["Basil", 200, 1], ["Dil", 100, 4], ["Mint", 300, 1], ["Chives", 50, 6]];
        ?>
        <h2 class="fw-bold">My Cart</h2>
        <div class="table-responsive">
          <table class="table table table-hover">
            <thead>
              <tr>
                <th class="" scope="col"></th>
                <th class="" scope="col">Item Name</th>
                <th class="" scope="col">Price</th>
                <th class="" scope="col">Quantity</th>
                <th class="" scope="col">Total</th>
                <th class="" scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php for ($x = 0; $x < count($items); $x++): ?>
                <tr>
                  <td class="text-center">
                    <input type="checkbox" class="item-check" checked style="transform: scale(1.5);">
                  </td>
                  <th><?= $items[$x][0] ?></th>
                  <td><?= $items[$x][1] ?></td>
                  <td>
                    <div class="col-sm-3">
                      <input type="number" class="form-control quantity" value="<?= $items[$x][2] ?>" min="1" max="99" step="1" data-price="<?= $items[$x][1] ?>">
                    </div>
                  </td>
                  <td class="item-total"><?= $items[$x][1] * $items[$x][2] ?></td>
                  <td>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-4">
        <h2 class="fw-bold">Summary</h2>
        <div class="border border-dark p-2">
          <div class="border-bottom border-secondary border-4 pb-3">
            <div class="row px-2">
              <div class="col-8">
                <h5 class="fw-bold text-secondary">Subtotal Price</h5>
              </div>
              <div class="col-4">
                <h5 class="fw-bold" id="subtotal"></h5>
              </div>
            </div>
            <div class="row px-2">
              <div class="col-8">
                <h5 class="fw-bold text-secondary">Shipping Fee</h5>
              </div>
              <div class="col-4">
                <h5 class="fw-bold" id="shipping">100</h5>
              </div>
            </div>
          </div>

          <div class="border-bottom border-secondary border-4">
            <div class="row px-2">
              <div class="col-8">
                <h5 class="fw-bold text-secondary">TOTAL PRICE</h5>
              </div>
              <div class="col-4">
                <h5 class="fw-bold" id="total"></h5>
              </div>
            </div>
          </div>

          <div class="pt-2">
            <div class="row px-2">
              <div class="col-8">
                <h5 class="fw-bold text-secondary">Payment Method</h5>
              </div>
              <div class="col-4">
                <select
                  class="form-select rounded-0 border-dark border-2"
                  id="paymentSelect"
                  name="paymentSelect"
                  aria-describedby="paymentHelp">
                  <option value="us">COD</option>
                  <option value="ca">Gcash</option>
                </select>
              </div>
            </div>
            <div class="row px-2">
              <div class="col-8">
                <h5 class="fw-bold text-secondary">Delivery Date</h5>
              </div>
              <div class="col-4">
                <h5 class="fw-bold">November</h5>
              </div>
            </div>

            <div class="text-center py-5">
              <button
                type="submit"
                class="viewButton btn btn-primary px-5 rounded-pill text-black fw-bold border-0"
                style="background-color: #cff3d7">
                CHECKOUT
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="js/cart-function.js"></script>
  <script src="../js/dynamic-nav.js"></script>
</body>

</html>