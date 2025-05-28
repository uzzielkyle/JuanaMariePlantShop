<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
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
  <?php include_once "./includes/partials/header.php" ?>
  <section class="container pb-3 px-5 pt-5 mt-5">
    <div class="text-center mx-5 px-5">
      <h1 class="text-center fw-bold mb-4">ABOUT US</h1>
      <p>
        Welcome to our herb shop—your go-to place for fresh, living herb
        plants! We’re all about helping people grow their own herbs at home,
        whether you're a seasoned gardener or just starting out. From kitchen
        staples like basil, rosemary, and mint to more unique finds like lemon
        balm or thyme, we offer a variety of healthy, vibrant herb plants
        ready to thrive in your garden, balcony, or windowsill. Nothing beats
        the satisfaction of picking fresh herbs straight from your own plant!
      </p>

      <p>
        We believe that growing your own herbs is not only rewarding, but also
        a great step toward a healthier and more sustainable lifestyle. That’s
        why we focus on offering well-cared-for plants, helpful advice, and a
        welcoming atmosphere for all plant lovers. Whether you're here to
        start your first herb pot or expand your green collection, we’re
        always happy to help you choose the right plants and share tips for
        keeping them happy and flourishing. Thanks for visiting—we hope our
        little green corner brings some fresh flavor and joy into your life!
      </p>
    </div>
  </section>

  <?php
  $developerTeam = ["Jovan Timosa", "Uzziel Kyle Ynciong"];
  ?>

  <section class="container py-5">
    <h1 class="text-center fw-bold mb-4">MEET THE TEAM</h1>
    <div class="row g-4 d-flex justify-content-center">
      <?php foreach ($developerTeam as $team): ?>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card h-100 border border-dark rounded-0 text-center">
            <img src="https://via.placeholder.com/300x200?text=<?= urlencode($team) ?>" class="card-img-top" alt="<?= $team ?>">
            <div class="card-body">
              <h5 class="card-title fw-bold"><?= $team ?></h5>
              <h5 class="card-body fw-light">Developer</h5>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</body>

</html>