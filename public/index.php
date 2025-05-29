<?php
require_once './middleware/authMiddleware.php';

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
        <section id="hero" style="
                background-image: url('./assets/hero.jpg');
                background-size: cover;
                background-position: center;
                height: 100vh;
                display: grid;
                place-items: center;
                text-align: center;
                color: white;
            ">
            <div>
                <h1 class="display-1 fw-bold text-white">JUANA MARIE</h1>
                <h2 class="h1 fw-bold" style="color: #d1e7dd;">HERBAL PLANTS</h2>
                <button class="btn bg-success-subtle rounded-pill mt-3 py-4 px-5 fw-bold">
                    SHOP NOW <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </section>

        <?php
        $indoorHerbs = ["Basil", "Mint", "Parsley", "Chives"];
        $gardenHerbs = ["Rosemary", "Thyme", "Oregano", "Lavender"];
        ?>

        <section class="container py-5 bg-light">
            <h2 class="text-center fw-bold mb-4">Indoor Herbs</h2>
            <div class="row g-4">
                <?php foreach ($indoorHerbs as $herb): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100 border border-dark rounded-0 text-center">
                            <img src="https://via.placeholder.com/300x200?text=<?= urlencode($herb) ?>" class="card-img-top" alt="<?= $herb ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= $herb ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="container py-5">
            <h2 class="text-center fw-bold mb-4">Garden Herbs</h2>
            <div class="row g-4">
                <?php foreach ($gardenHerbs as $herb): ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100 border border-dark rounded-0  text-center">
                            <img src="https://via.placeholder.com/300x200?text=<?= urlencode($herb) ?>" class="card-img-top" alt="<?= $herb ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?= $herb ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>
    <footer></footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/dynamic-nav.js"></script>
</body>

</html>