<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(['user'], true); // silent = true

if ($auth) {
    if ($auth->role === 'user') {
        header('Location: ../user');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
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
  <?php include_once "../includes/partials/header.php" ?>
  <main class="container p-3 mb-2 mt-5">
    <div class="row">
      <div class="col pb-3 pt-5 px-5 mx-5">
        <h1 class="pb-2">LOGIN</h1>
        <div class="p-3 border border-dark">
          <form id="loginForm">
            <div class="mb-3">
              <label for="loginEmail" class="form-label">
                Email address<span class="text-danger">*</span>
              </label>
              <input
                type="email"
                class="form-control rounded-0 border-dark"
                id="loginEmail"
                name="loginEmail"
                aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
              <label for="loginPassword" class="form-label">
                Password<span class="text-danger">*</span>
              </label>
              <input
                type="password"
                class="form-control rounded-0 border-dark"
                id="loginPassword"
                name="loginPassword">
            </div>

            <div class="text-center mb-3 mt-5">
              <button
                type="submit"
                class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
                style="background-color: #cff3d7"
                id="loginButton">
                LOG IN
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col text-center pb-3 pt-5 px-5 mx-5">
        <h2 class="fw-bold">DON'T HAVE AN ACCOUNT?</h2>
        <p class="mt-3">
          By creating an account on our site, you unlock a personalized
          experience tailored to your needs. As a registered user, you'll also
          be able to save your preferences, track your activity, and receive
          special offers or notifications directly related to your interests.
          Signing up is quick, secure, and completely free—join our community
          today and start enjoying all the benefits we have to offer!
        </p>
        <div class="text-center mb-3 mt-5">
          <button
            type="button"
            class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
            style="background-color: #cff3d7"
            onclick="window.location.href='./register.php';">
            REGISTER
          </button>
        </div>
      </div>
    </div>
  </main>

  <?php include_once '../includes/partials/footer.php'; ?>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

  <script src="./js/validation/login-form.js"></script>
</body>

</html>