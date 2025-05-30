<?php
require_once './middleware/authMiddleware.php';

?>

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
    <div class="mx-2 px-2">
      <h1 class="text-center fw-bold mb-5 pb-5">CONTACT US</h1>
      <div class="row">
        <div class="col-6 ">
          <form id="registerForm">
            <div class="mb-3">
              <div class="mb-3">
                <input
                  type="text"
                  class="form-control rounded-0 border-dark"
                  id="nameInput"
                  name="nameInput"
                  aria-describedby="nameHelp"
                  placeholder="FULL NAME">
              </div>

              <input
                type="email"
                class="form-control rounded-0 border-dark"
                id="emailInput"
                name="emailInput"
                aria-describedby="emailHelp"
                placeholder="EMAIL ADDRESS">
            </div>

            <div class="mb-3">
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="phoneInput"
                name="phoneInput"
                aria-describedby="phoneHelp"
                placeholder="PHONE NO.">
            </div>

            <div class="mb-3">
              <input
                type="text"
                class="form-control rounded-0 border-dark"
                id="subjectInput"
                name="subjectInput"
                aria-describedby="subjectHelp"
                placeholder="SUBJECT">
            </div>

            <div class="mb-3">
              <textarea class="form-control rounded-0 border-dark" id="commentText" rows="3" placeholder="YOUR MESSAGE"></textarea>
            </div>

            <div class="text-center mb-3 mt-5">
              <button
                type="submit"
                class="btn btn-primary px-4 rounded-pill text-black fw-bold border-0"
                style="background-color: #cff3d7"
                id="sendButton">
                SEND
              </button>
            </div>
          </form>
        </div>
        <div class="col-6 ps-5">
          <div class="row">
            <div class="col-2 d-flex justify-content-center align-items-center" style="height: 100px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                class="bi bi-house" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 
        8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 
        0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 
        7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
              </svg>
            </div>
            <div class="col-10">
              <h2 class="fw-bold">LOCATIONS</h2>
              <p>Lorem ipsum dolor sit amet</p>
              <p>Lorem ipsum dolor sit amet</p>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
          </div>
          <div class="row">
            <div class="col-2 d-flex justify-content-center align-items-center" style="height: 100px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z" />
                <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
              </svg>
            </div>
            <div class="col-10">
              <h2 class="fw-bold">EMAIL</h2>
              <p>Lorem ipsum dolor sit amet</p>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
          </div>
          <div class="row">
            <div class="col-2 d-flex justify-content-center align-items-center" style="height: 100px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-telephone-inbound" viewBox="0 0 16 16">
                <path d="M15.854.146a.5.5 0 0 1 0 .708L11.707 5H14.5a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 1 0v2.793L15.146.146a.5.5 0 0 1 .708 0m-12.2 1.182a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
              </svg>
            </div>
            <div class="col-10">
              <h2 class="fw-bold">PHONE</h2>
              <p>Lorem ipsum dolor sit amet</p>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once './includes/partials/footer.php'; ?>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/dynamic-nav.js"></script>
</body>

</html>