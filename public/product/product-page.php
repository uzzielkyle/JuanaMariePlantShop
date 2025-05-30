<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["user"], true); // get user data from JWT

if (!$auth || $auth->role !== 'user') {
  header('Location: ../auth/login.php');
  exit;
}

// Just check if id is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  http_response_code(400);
  echo "Invalid product ID.";
  exit;
}
$productId = (int) $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product Details - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
  <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>

  <section class="container py-5 mt-5">
    <div class="row">
      <div class="col text-center">
        <img id="product-image" src="assets/plant-default.png" alt="Product Image" style="width: 500px; height: auto" />
      </div>
      <div class="col border-bottom border-secondary border-3 pb-3">
        <h3 class="fw-bold" id="product-name">Loading...</h3>
        <h5 class="text-success" id="product-price">P 0.00</h5>

        <div class="row pt-2 pb-3">
          <div class="col-sm-2">
            <input type="number" class="form-control quantity" value="1" min="1" max="99" step="1" />
          </div>
          <div class="col">
            <button type="button" id="addToCartBtn" class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
              style="background-color: #cff3d7">
              <i class="bi bi-cart-fill"></i> Add to cart
            </button>
          </div>
        </div>

        <div class="row pt-4 border-top border-secondary border-2">
          <div class="col">
            <div class="row">
              <div class="col-1">
                <i class="bi bi-sun-fill"></i>
              </div>
              <div class="col-11">
                <h5 class="fw-bold">Sunlight</h5>
              </div>
            </div>
            <p class="ms-4" id="product-sunlight">Loading...</p>
          </div>
          <div class="col">
            <div class="row">
              <div class="col-1">
                <i class="bi bi-droplet-fill"></i>
              </div>
              <div class="col-11">
                <h5 class="fw-bold">Watering Schedule</h5>
              </div>
            </div>
            <p class="ms-4" id="product-watering">Loading...</p>
          </div>
        </div>

        <div class="row pt-4">
          <div class="col">
            <div class="row">
              <div class="col-1">
                <i class="bi bi-caret-right-fill"></i>
              </div>
              <div class="col-11">
                <h5 class="fw-bold">Difficulty</h5>
              </div>
            </div>
            <div class="d-flex align-items-center ps-4 pb-3" id="product-difficulty"></div>
          </div>
        </div>

        <div class="pt-2 border-top border-dark border-2">
          <h3 class="fw-bold">Description</h3>
          <p id="product-description">Loading...</p>

          <h3 class="fw-bold">History</h3>
          <p id="product-history">Loading...</p>

          <h3 class="fw-bold">Care Guide</h3>
          <p id="product-care-guide">Loading...</p>

          <h3 class="fw-bold">Propagation</h3>
          <p id="product-propagation">Loading...</p>
        </div>
      </div>
    </div>
  </section>


  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="cartModalLabel">CART</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          Item has been placed in your cart!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <?php include_once '../includes/partials/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/product-page.js">
  </script>
  <script src="../js/dynamic-nav.js"></script>
  <script>
    $(function() {
      const productId = <?= $productId ?>;
      const apiUrl = `http://localhost/JuanaMariePlantShop/public/api/user/product.php?id=${productId}`;

      $.ajax({
        url: apiUrl,
        method: "GET",
        dataType: "json",
        success: function(product) {
          // If product is an array, take first element
          if (Array.isArray(product)) {
            product = product[0];
          }

          $("#product-name").text(product.name || "No name");
          $("#product-price").text("P " + (parseFloat(product.price).toFixed(2) || "0.00"));
          $("#product-sunlight").text(product.sunlight || "N/A");
          $("#product-watering").text(product.watering_schedule || "N/A");

          // Difficulty as filled circles
          const difficulty = parseInt(product.difficulty) || 0;
          let difficultyHtml = "";
          for (let i = 0; i < difficulty; i++) {
            difficultyHtml += `<i class="bi bi-circle-fill me-1" style="color:#cff3d7;"></i>`;
          }
          $("#product-difficulty").html(difficultyHtml);

          $("#product-description").text(product.description || "No description available.");
          $("#product-history").text(product.history || "No history available.");
          $("#product-care-guide").text(product.care_guide || "No care guide available.");
          $("#product-propagation").text(product.propagation || "No propagation info available.");

          // Optional: Update image src if available
          // $("#product-image").attr("src", product.photo_url || "assets/plant-default.png");
        },
        error: function() {
          alert("Failed to load product data.");
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
</body>

</html>