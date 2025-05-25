<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JUANA MARIE - Register</title>
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
      <div class="col text-center pb-3 pt-5 px-5 mx-5">
        <h2 class="fw-bold">ALREADY HAVE AN ACCOUNT?</h2>

        <p class="mt-3">
          If you already have an account, simply log in to access your
          personalized dashboard and continue where you left off. As a member,
          you can enjoy all the features and benefits our platform
          offers—whether it's managing your profile, tracking your progress,
          receiving tailored updates, or accessing exclusive content. Stay
          connected and make the most out of your experience with us!
        </p>
        <div class="text-center mb-3 mt-5">
          <button
            type="submit"
            class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
            style="background-color: #cff3d7"
            onclick="window.location.href='./login.php';">
            LOG IN
          </button>
        </div>
      </div>
      <div class="col pb-3 pt-5 px-5 mx-5">
        <h1 class="pb-2">REGISTER</h1>
        <div class="p-3 border border-dark">
          <form id="registerForm">
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label for="firstInput" class="form-label">
                    First Name<span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control rounded-0 border-dark"
                    id="firstInput"
                    name="firstInput"
                    aria-describedby="firstNameHelp">
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="lastInput" class="form-label">
                    Last Name<span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control rounded-0 border-dark"
                    id="lastInput"
                    name="lastInput"
                    aria-describedby="lastNameHelp">
                </div>
              </div>
            </div>

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
              <label for="confirmInput" class="form-label">
                Confirm Password<span class="text-danger">*</span>
              </label>
              <input
                type="password"
                class="form-control rounded-0 border-dark"
                id="confirmInput"
                name="confirmInput"
                aria-describedby="confirmHelp">
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

            <div class="text-center mb-3 mt-5">
              <button
                type="submit"
                class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
                style="background-color: #cff3d7"
                id="registerButton">
                REGISTER
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
  <script src="./js/validation/register-form.js"></script>
</body>

</html>