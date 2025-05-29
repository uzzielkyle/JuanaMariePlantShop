<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["user"], true); // get user data from JWT

if (!$auth || $auth->role !== 'user') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Account</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <div class="px-5 pb-5">
    <?php include_once __DIR__ . "/../includes/partials/header.php"; ?>
    <?php include_once "includes/user-nav.php"; ?>
    <div class="mx-5 p-4 border border-dark">
      <div class="row pb-4">
        <div class="col-10">
          <h2>Account Settings</h2>
        </div>
        <div class="col-2">
          <button
            type="submit"
            class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
            style="background-color: #cff3d7"
            id="updateButton">
            UPDATE
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-3 d-flex justify-content-center align-items-center">
          <div class="d-flex flex-column align-items-center">
            <img
              src="http://placebeard.it/250/250"
              alt="Profile"
              class="rounded-circle mb-3" />
            <button
              type="submit"
              class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
              style="background-color: #cff3d7"
              id="registerButton">
              Change
            </button>
          </div>
        </div>

        <form class="d-flex col-9 row">
          <div class="col-6">
            <div class="mb-3">
              <label for="streetInput" class="form-label">
                First Name<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="firstInput"
                name="firstInput"
                aria-describedby="firstHelp" />
            </div>

            <div class="mb-3">
              <label for="streetInput" class="form-label">
                Last Name<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="lastInput"
                name="lastInput"
                aria-describedby="lastHelp" />
            </div>
          </div>

          <div class="col-6">
            <div class="mb-3">
              <label for="emailInput" class="form-label">
                Email address<span class="text-danger">*</span>
              </label>
              <input
                type="email"
                class="form-control rounded-0 border-dark"
                id="emailInput"
                name="emailInput"
                aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
              <label for="passwordInput" class="form-label">
                Password<span class="text-danger">*</span>
              </label>
              <input
                type="password"
                class="form-control rounded-0 border-dark"
                id="passwordInput"
                name="passwordInput"
                aria-describedby="passwordHelp">
            </div>

            <div class="mb-3">
              <label for="streetInput" class="form-label">
                Street Address<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="streetInput"
                name="streetInput"
                aria-describedby="streetHelp">
            </div>

            <div class="mb-3">
              <label for="cityInput" class="form-label">
                City<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="cityInput"
                name="cityInput"
                aria-describedby="cityHelp">
            </div>

            <div class="mb-3">
              <label for="statesInput" class="form-label">
                State/Province/Region<span class="text-danger">*</span>
              </label>
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="statesInput"
                name="statesInput"
                aria-describedby="stateHelp">
            </div>

            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="countrySelect" class="form-label">
                    Country<span class="text-danger">*</span>
                  </label>
                  <select
                    class="form-select rounded-0 border-dark"
                    id="countrySelect"
                    name="countrySelect"
                    aria-describedby="countryHelp">
                    <option value="">Select a country</option>
                    <option value="us">United States</option>
                    <option value="ca">Canada</option>
                    <option value="uk">United Kingdom</option>
                    <!-- Add more countries as needed -->
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="zipCode" class="form-label">
                    Zip Code<span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control rounded-0 border-dark"
                    id="zipCode"
                    name="zipCode"
                    aria-describedby="zipHelp">
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/dynamic-nav.js"></script>
</body>

</html>