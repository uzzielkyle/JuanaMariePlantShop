$(document).ready(function () {
  // Custom method for email validation
  $.validator.addMethod(
    "customEmail",
    function (value, element) {
      return (
        this.optional(element) ||
        /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
      );
    },
    "Please enter a valid email address"
  );

  function setTokenCookie(token) {
    const days = 7; // valid for 7 days
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `token=${encodeURIComponent(
      token
    )}; path=/; SameSite=Lax`;
  }

  $("#loginForm").validate({
    rules: {
      loginEmail: {
        required: true,
        customEmail: true,
      },
      loginPassword: {
        required: true,
        minlength: 6,
      },
    },
    messages: {
      loginEmail: {
        required: "Please enter your email address",
      },
      loginPassword: {
        required: "Please enter your password",
        minlength: "Password must be at least 6 characters long",
      },
    },
    errorElement: "div",
    errorClass: "text-danger mt-1",
    highlight: function (element) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid");
    },
    errorPlacement: function (error, element) {
      error.insertAfter(element);
    },
    submitHandler: function () {
      const email = $("#loginEmail").val().trim();
      const password = $("#loginPassword").val().trim();

      const $loginBtn = $("#loginButton");

      $loginBtn.prop("disabled", true).html(`
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Logging in...
            `);

      $.ajax({
        url: "../api/auth.php?action=login-user",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ email, password }),
        success: function (response) {
          localStorage.setItem("token", response.token);
          setTokenCookie(response.token);
          window.location.href = "../user";
        },
        error: function () {
          alert("Invalid email or password.");

          $loginBtn.prop("disabled", false).html("LOG IN");
        },
      });
    },
  });
});
