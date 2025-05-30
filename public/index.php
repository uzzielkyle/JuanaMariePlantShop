<?php
require_once './middleware/authMiddleware.php';
require_once './config/db.php';

try {
    $categoryStmt = $pdo->query("SELECT * FROM category ORDER BY idcategory ASC LIMIT 3");
    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Category query error: " . $e->getMessage());
}
?>

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
        <section id="hero" style="background-image: url('./assets/hero.jpg'); background-size: cover; background-position: center; height: 100vh; display: grid; place-items: center; text-align: center; color: white;">
            <div>
                <h1 class="display-1 fw-bold text-white">JUANA MARIE</h1>
                <h2 class="h1 fw-bold" style="color: #d1e7dd;">HERBAL PLANTS</h2>
                <button class="btn bg-success-subtle rounded-pill mt-3 py-4 px-5 fw-bold">
                    SHOP NOW <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </section>

        <section class="container">
            <?php foreach ($categories as $index => $category): ?>
                <?php
                $stmt = $pdo->prepare("
                                        SELECT p.*
                                        FROM product p
                                        JOIN product_has_category pc ON p.idproduct = pc.product_idproduct
                                        WHERE pc.category_idcategory = ?
                                        ORDER BY p.quantity ASC LIMIT 4
                                    ");
                $stmt->execute([$category['idcategory']]);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $bgClass = $index % 2 === 0 ? 'bg-light' : 'bg-white';
                ?>
                <section class="<?= $bgClass ?> py-5 px-5">
                    <div class="container">
                        <h4 class="text-success fw-bold mb-4 text-center"><?= htmlspecialchars($category['name']) ?></h4>
                        <div class="row g-4">
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $product): ?>
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="card h-100 border-0 shadow-sm text-center transition" style="font-size: 0.85rem;">
                                            <?php
                                            $imgSrc = "https://placehold.jp/c0c0c0/ffffff/600x400.png?text=" . urlencode($product['name']);
                                            if (!empty($product['photo'])) {
                                                $imgData = base64_encode($product['photo']);
                                                $imgSrc = "data:image/jpeg;base64,{$imgData}";
                                            }
                                            ?>
                                            <img src="<?= $imgSrc ?>" class="card-img-top rounded-top-3" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 160px; object-fit: cover;">
                                            <div class="card-body px-3 py-2">
                                                <h6 class="card-title fw-bold mb-1 text-truncate" style="font-size: 0.95rem;"><?= htmlspecialchars($product['name']) ?></h6>
                                                <p class="card-text text-success fw-semibold mb-1">₱<?= number_format($product['price'], 2) ?></p>
                                                <p class="card-text text-muted small text-truncate"><?= htmlspecialchars($product['description']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted text-center">No products found in this category.</p>
                            <?php endif; ?>
                        </div>

                        <!-- View More Button -->
                        <div class=" text-end mt-4">
                            <a href="shop.php" class="btn btn-outline-success rounded-pill px-4">
                                View More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>

        </section>
    </main>

    <?php include_once './includes/partials/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/dynamic-nav.js"></script>
</body>

</html>