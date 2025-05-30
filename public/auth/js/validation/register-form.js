$(document).ready(function () {
  $.validator.addMethod("gmail", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(value);
  }, "Please enter a valid Gmail address");

  $.validator.addMethod("letters", function (value, element) {
    return this.optional(element) || /^[A-Za-z\s]+$/.test(value);
  }, "Only alphabetical characters allowed");

  $.validator.addMethod("strongPassword", function (value, element) {
    return this.optional(element) ||
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(value);
  }, "Must contain uppercase, lowercase, number, and symbol");

  $.validator.addMethod("phoneLoose", function (value, element) {
    return this.optional(element) || /^[\d\s()+\-]+$/.test(value);
  }, "Please enter a valid phone number");


  $("#registerForm").validate({
    rules: {
      firstInput: {
        required: true,
        letters: true
      },
      lastInput: {
        required: true,
        letters: true
      },
      emailInput: {
        required: true,
        gmail: true
      },
      passwordInput: {
        required: true,
        strongPassword: true
      },
      confirmInput: {
        required: true,
        equalTo: "#passwordInput"
      },
      telephoneInput: {
        required: true,
        phoneLoose: true
      },
      streetInput: {
        required: true
      },
      cityInput: {
        required: true,
        letters: true
      },
      statesInput: {
        required: true,
        letters: true
      },
      countrySelect: {
        required: true
      },
      zipCode: {
        required: true,
        digits: true
      }
    },
    messages: {
      firstInput: {
        required: "First name is required",
        letters: "Only letters allowed"
      },
      lastInput: {
        required: "Last name is required",
        letters: "Only letters allowed"
      },
      emailInput: {
        required: "Email is required",
        gmail: "Please enter a valid Gmail address"
      },
      passwordInput: {
        required: "Password is required",
        strongPassword: "Password must contain uppercase, lowercase, number, and symbol"
      },
      confirmInput: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match"
      },
      telephoneInput: {
        required: "Telephone is required",
        phoneLoose: "Please enter a valid telephone number"
      },
      streetInput: {
        required: "Street address is required"
      },
      cityInput: {
        required: "City is required",
        letters: "Only letters allowed"
      },
      statesInput: {
        required: "State is required",
        letters: "Only letters allowed"
      },
      countrySelect: {
        required: "Please select a country"
      },
      zipCode: {
        required: "Zip code is required",
        digits: "Zip code must be numeric"
      }
    },
    errorClass: "invalid-feedback",
    errorElement: "div",
    highlight: function (element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
      $(element).removeClass('is-invalid');
    },
    errorPlacement: function (error, element) {
      if (element.prop("type") === "select-one") {
        error.insertAfter(element.next(".select2-container"));
      } else {
        error.insertAfter(element);
      }
    },

    submitHandler: function (form) {
      const $submitBtn = $('#registerButton');
      $submitBtn.prop('disabled', true).text('Registering...');

      const payload = {
        first_name: $('#firstInput').val().trim(),
        last_name: $('#lastInput').val().trim(),
        email: $('#emailInput').val().trim(),
        password: $('#passwordInput').val(),
        address: `${$('#streetInput').val().trim()}, ${$('#cityInput').val().trim()}, ${$('#statesInput').val().trim()}, ${$('#countrySelect').val()}, ${$('#zipCode').val().trim()}`,
        telephone: $('#telephoneInput').val().trim() || ""
      };

      $.ajax({
        url: '../api/auth.php?action=register-user',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function (response) {
          $.ajax({
            url: '../api/auth.php?action=login-user',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
              email: payload.email,
              password: payload.password
            }),
            success: function (loginResp) {
              localStorage.setItem('token', loginResp.token);
              document.cookie = `token=${loginResp.token}; path=/; SameSite=Lax;`;
              window.location.href = '../user';
            },
            error: function () {
              alert('Registration succeeded but auto-login failed. Please login manually.');
              window.location.href = './login.php';
            }
          });
        },
        error: function (jqXHR) {
          let errMsg = 'Registration failed. Please try again.';
          if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
            errMsg = jqXHR.responseJSON.error;
          }
          alert(errMsg);
          $submitBtn.prop('disabled', false).text('Register');
        }
      });
    }

  });
});
