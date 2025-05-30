<?php
require_once '../../middleware/authMiddleware.php';

$auth = authenticate(['user', 'admin'], true); // silent = true

if ($auth) {
  if ($auth->role === 'admin') {
    header('Location: ../../admin');
    exit;
  } elseif ($auth->role === 'user') {
    header('Location: ../../user');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login - Juana Marie</title>
  <link rel="icon" href="../../assets/logo.svg" type="image/svg+xml" />
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
  <main class="container p-3 mb-2 mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 pb-3 pt-5 px-5">
        <div class="p-3 border border-dark text-center">
      
          <img src="../../assets/logo.svg" alt="Logo" style="width: 80px; height: auto;" class="mb-3">

          <h2 class="text-center pb-3">Admin Login</h2>
          <form id="loginForm">
            <div class="mb-3 text-start">
              <label for="loginIdentifier" class="form-label">
                Email or Username<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="loginIdentifier"
                name="loginIdentifier"
                required>
            </div>

            <div class="mb-3 text-start">
              <label for="loginPassword" class="form-label">
                Password<span class="text-danger">*</span>
              </label>
              <input
                type="password"
                class="form-control rounded-0 border-dark"
                id="loginPassword"
                name="loginPassword"
                required>
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
    </div>
  </main>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstra


</html>