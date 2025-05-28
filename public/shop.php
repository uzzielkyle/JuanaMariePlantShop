<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JUANA MARIE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
  <?php include_once "./includes/partials/header.php" ?>
  <main>
    <?php
    $categories = [
      "All" => ["Rosemary", "Thyme", "Oregano", "Lavender"],
      "Herbs" => ["Rosemary", "Thyme", "Oregano"],
      "Flowers" => ["Lavender"]
    ];
    ?>

    <section class="container py-5 pt-5 mt-5">
      <h2 class="text-center fw-bold mb-4">PRODUCTS</h2>

      <div class="row mb-4">
        <div class="col-12">
          <?php foreach (array_keys($categories) as $category): ?>
            <button class="btn btn-outline-dark me-2 category-btn" data-category="<?= $category ?>">
              <?= $category ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="row g-4" id="product-list">
        <?php foreach ($categories['All'] as $herb): ?>
          <div class="col-12 col-sm-6 col-lg-3 product-card" data-category="<?= in_array($herb, $categories['Herbs']) ? 'Herbs' : 'Flowers' ?>">
            <a href="product/product-page.php?product=<?= urlencode($herb) ?>" class="text-decoration-none text-dark">
              <div class="card h-100 border border-dark rounded-0 text-center">
                <img src="https://via.placeholder.com/300x200?text=<?= urlencode($herb) ?>" class="card-img-top" alt="<?= $herb ?>">
                <div class="card-body">
                  <h5 class="card-title fw-bold"><?= $herb ?></h5>
                  <h5 class="card-title fw-light">P 500</h5>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.category-btn').on('click', function() {
        var selectedCategory = $(this).data('category');

        $('.product-card').each(function() {
          var cardCategory = $(this).data('category');

          if (selectedCategory === 'All' || cardCategory === selectedCategory) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    });
  </script>
  <footer></footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/dynamic-nav.js"></script>
</body>

</html>