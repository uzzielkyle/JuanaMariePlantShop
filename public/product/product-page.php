<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JUANA MARIE</title>
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
  <section class="container py-5 mt-5">
    <div class="row">
      <div class="col text-center">
        <img
          src="assets/plant-default.png"
          alt="plant"
          style="width: 500px; height: auto" />
      </div>
      <div class="col border-bottom border-secondary border-3 pb-3">
        <h3 class="fw-bold">Product Name</h3>
        <h5 class="text-success">P 500</h5>
        <div class="row pt-2 pb-3">
          <div class="col-sm-2">
            <input
              type="number"
              class="form-control quantity"
              value="1"
              min="1"
              max="99"
              step="1" />
          </div>
          <div class="col">
            <button
              type="button"
              id="addToCartBtn"
              class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
              style="background-color: #cff3d7">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-cart-fill" viewBox="0 0 16 16">
                <path
                  d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
              </svg>
              Add to cart
            </button>
          </div>
        </div>
        <div class="row pt-4 border-top border-secondary border-2">
          <div class="col">
            <div class="row">
              <div class="col-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-sun-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                </svg>
              </div>

              <div class="col-11">
                <h5 class="fw-bold">Sunlight</h5>
              </div>
            </div>
            <p class="ms-4">Full Sun</p>
          </div>
          <div class="col">
            <div class="row">
              <div class="col-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-droplet-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="M8 16a6 6 0 0 0 6-6c0-1.655-1.122-2.904-2.432-4.362C10.254 4.176 8.75 2.503 8 0c0 0-6 5.686-6 10a6 6 0 0 0 6 6M6.646 4.646l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448c.82-1.641 1.717-2.753 2.093-3.13" />
                </svg>
              </div>

              <div class="col-11">
                <h5 class="fw-bold">Watering Schedule</h5>
              </div>
            </div>
            <p class="ms-4">Every 2 days</p>
          </div>
        </div>
        <div class="row pt-4">
          <div class="col">
            <div class="row">
              <div class="col-1">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-caret-right-fill"
                  viewBox="0 0 16 16">
                  <path
                    d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                </svg>
              </div>

              <div class="col-11">
                <h5 class="fw-bold">Difficulty</h5>
              </div>
            </div>
            <?php
            $difficulty = 3; // Change this value depending on the difficulty of plant
            ?>

            <div class="d-flex align-items-center ps-4 pb-3">
              <?php for ($i = 0; $i < $difficulty; $i++): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #cff3d7;" fill="currentColor" class="bi bi-circle-fill me-1" viewBox="0 0 16 16">
                  <circle cx="8" cy="8" r="8" />
                </svg>

              <?php endfor; ?>
            </div>
          </div>
          <div class="col"></div>
        </div>
        <div class="pt-2 border-top border-dark border-2">
          <h3 class="fw-bold">Description</h3>
          <p class="pb-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
            tellus justo, mattis eu risus ut, vehicula fermentum magna. Mauris
            pretium mauris vel leo tincidunt finibus. Ut ornare, lacus a
            ultricies semper, enim risus fringilla sem, eu condimentum augue
            ligula ac turpis. Integer nec congue enim, nec tincidunt sem.
          </p>
          <h3 class="fw-bold">History</h3>
          <p class="pb-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
            tellus justo, mattis eu risus ut, vehicula fermentum magna. Mauris
            pretium mauris vel leo tincidunt finibus. Ut ornare, lacus a
            ultricies semper, enim risus fringilla sem, eu condimentum augue
            ligula ac turpis. Integer nec congue enim, nec tincidunt sem.
          </p>
          <h3 class="fw-bold">Care Guide</h3>
          <p class="pb-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
            tellus justo, mattis eu risus ut, vehicula fermentum magna. Mauris
            pretium mauris vel leo tincidunt finibus. Ut ornare, lacus a
            ultricies semper, enim risus fringilla sem, eu condimentum augue
            ligula ac turpis. Integer nec congue enim, nec tincidunt sem.
          </p>
          <h3 class="fw-bold">Propagation</h3>
          <p class="pb-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
            tellus justo, mattis eu risus ut, vehicula fermentum magna. Mauris
            pretium mauris vel leo tincidunt finibus. Ut ornare, lacus a
            ultricies semper, enim risus fringilla sem, eu condimentum augue
            ligula ac turpis. Integer nec congue enim, nec tincidunt sem.
          </p>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/product-page.js">
  </script>
  <script src="../js/dynamic-nav.js"></script>
</body>

</html>