document
  .getElementById("registerForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission
    const errors = [];

    const first = document.getElementById("firstInput").value.trim();
    const last = document.getElementById("lastInput").value.trim();
    const email = document.getElementById("emailInput").value.trim();
    const password = document.getElementById("passwordInput").value;
    const confirm = document.getElementById("confirmInput").value;
    const city = document.getElementById("cityInput").value.trim();
    const zip = document.getElementById("zipCode").value.trim();

    // Only letters allowed for name and city
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(first))
      errors.push("*First name must only contain letters.");
    if (!nameRegex.test(last))
      errors.push("*Last name must only contain letters.");
    if (!nameRegex.test(city)) errors.push("*City must only contain letters.");

    // Gmail email check
    if (!/^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(email)) {
      errors.push("*Email must be a valid Gmail address.");
    }

    // Password rules: 8+ chars, 1 uppercase, 1 lowercase, 1 number, 1 symbol
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if (!passwordRegex.test(password)) {
      errors.push(
        "*Password must be 8+ characters, include uppercase, lowercase, number, and symbol."
      );
    }

    if (confirm !== password) {
      errors.push("*Passwords do not match.");
    }

    // Zip code numbers only
    if (!/^\d+$/.test(zip)) {
      errors.push("*Zip Code must be numeric.");
    }

    // Show errors
    const errorBox = document.getElementById("errorMessages");
    if (errors.length > 0) {
      errorBox.innerHTML = errors.join("<br>");
    } else {
      errorBox.innerHTML = "";
      // This is just for comfirmation, remove this
      alert("Form submitted successfully!");
    }
  });
