<?php
require_once './middleware/authMiddleware.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JUANA MARIE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="d-grid min-vh-100" style="grid-template-rows: 1fr auto;">
  <?php include_once "./includes/partials/header.php" ?>

  <main>
    <section class="container py-5 pt-5 mt-5">
      <h2 class="text-center fw-bold mb-4">PRODUCTS</h2>

      <!-- Category Filter Buttons -->
      <div class="row mb-4">
        <div class="col-12" id="category-buttons">
          <!-- Buttons will be added dynamically -->
        </div>
      </div>

      <!-- Product Grid -->
      <div class="row g-4" id="product-list">
        <!-- Products will be injected here dynamically -->
      </div>
    </section>
  </main>

  <?php include_once './includes/partials/footer.php'; ?>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      const productList = $('#product-list');
      const categoryButtons = $('#category-buttons');
      const categorySet = new Set();

      $.ajax({
        url: './api/user/product.php',
        method: 'GET',
        success: function(products) {
          productList.empty();
          categorySet.clear(); // Clear previous categories if needed

          products.forEach(product => {
            const categories = (product.categories || 'Uncategorized').split(',').map(c => c.trim());

            categories.forEach(cat => {
              if (cat) categorySet.add(cat);
            });

            const firstCategory = categories[0] || 'Uncategorized';

            let imageUrl = '';
            if (product.photo && product.photo.trim() !== '') {
              const base64Image = product.photo;
              const imageMimeType = "image/jpeg";
              imageUrl = `data:${imageMimeType};base64,${base64Image}`;
            } else {
              imageUrl = `https://placehold.jp/c0c0c0/ffffff/600x400.png?text=${encodeURIComponent(product.name)}`;
            }

            const productCard = `
                                <div class="col-12 col-sm-6 col-lg-3 product-card" data-category="${firstCategory}">
                                  <a href="product/product-page.php?id=${product.idproduct}" class="text-decoration-none text-dark">
                                    <div class="card h-100 border border-dark rounded-0 text-center">
                                      <img src="${imageUrl}" class="card-img-top" alt="${product.name}">
                                      <div class="card-body">
                                        <h5 class="card-title fw-bold">${product.name}</h5>
                                        <h5 class="card-title fw-light">P ${parseFloat(product.price).toFixed(2)}</h5>
                                      </div>
                                    </div>
                                  </a>
                                </div>
                              `;
            productList.append(productCard);
          });

          // Build dynamic category buttons
          categoryButtons.empty(); // Clear old buttons if needed
          categoryButtons.append(`<button class="btn btn-outline-dark me-2 category-btn" data-category="All">All</button>`);
          [...categorySet].sort().forEach(category => {
            categoryButtons.append(`
                                    <button class="btn btn-outline-dark me-2 category-btn" data-category="${category}">
                                      ${category}
                                    </button>
                                  `);
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('XHR object:', jqXHR); // Logs the full XHR object
          console.error('Status:', textStatus);
          console.error('Error thrown:', errorThrown);

          productList.html('<p class="text-danger">Failed to load products. Please try again later.</p>');
        }
      });

      // Filtering Logic
      $(document).on('click', '.category-btn', function() {
        const selectedCategory = $(this).data('category');

        $('.product-card').each(function() {
          const cardCategory = $(this).data('category');

          if (selectedCategory === 'All' || cardCategory === selectedCategory) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    });
  </script>

  <script src="js/dynamic-nav.js"></script>
</body>

</html>