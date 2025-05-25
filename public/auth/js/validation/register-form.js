$(document).ready(function () {
  // Custom validation methods
  $.validator.addMethod("gmail", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(value);
  }, "Please enter a valid Gmail address");

  // Initialize validation
  $("#registerForm").validate({
    // Validation rules
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

    // Error messages
    messages: {
      firstInput: {
        required: "First name is required",
        letters: "Only letters allowed"
      },
      // Define similar messages for all other fields
      countrySelect: {
        required: "Please select a country"
      }
    },

    // Bootstrap error styling
    errorClass: "invalid-feedback",
    errorElement: "div",
    highlight: function (element) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element) {
      $(element).removeClass('is-invalid');
    },

    // Error placement
    errorPlacement: function (error, element) {
      if (element.prop("type") === "select-one") {
        error.insertAfter(element.next(".select2-container"));
      } else {
        error.insertAfter(element);
      }
    },

    // Form submission
    submitHandler: function (form) {
      alert("Form submitted successfully!");
      form.submit();
    }
  });

  // Custom letter validation
  $.validator.addMethod("letters", function (value, element) {
    return this.optional(element) || /^[A-Za-z\s]+$/.test(value);
  }, "Only alphabetical characters allowed");

  // Custom password validation
  $.validator.addMethod("strongPassword", function (value, element) {
    return this.optional(element) ||
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(value);
  }, "Must contain uppercase, lowercase, number, and symbol");
});