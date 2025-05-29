const API_URL = "../api/user/profile.php";

$(document).ready(function () {
  // GET user profile
  $.ajax({
    url: API_URL,
    method: "GET",
    dataType: "json",
    success: function (data) {
      $("#firstInput").val(data.first_name);
      $("#lastInput").val(data.last_name);
      $("#emailInput").val(data.email);
      $("#mobileInput").val(data.telephone);

      let [street, city, state, country, zip] = (data.address || "")
        .split(",")
        .map((part) => part.trim());
      $("#streetInput").val(street || "");
      $("#cityInput").val(city || "");
      $("#statesInput").val(state || "");
      $("#countrySelect").val(country || "");
      $("#zipCode").val(zip || "");
    },
    error: function (xhr) {
      alert(
        "Failed to load user profile: " +
          (xhr.responseJSON?.error || "Unknown error")
      );
    },
  });

  // PUT updated profile
  $("#updateButton").on("click", function (e) {
    e.preventDefault();

    const fullAddress = [
      $("#streetInput").val(),
      $("#cityInput").val(),
      $("#statesInput").val(),
      $("#countrySelect").val(),
      $("#zipCode").val(),
    ].join(", ");

    const updatedData = {
      first_name: $("#firstInput").val(),
      last_name: $("#lastInput").val(),
      email: $("#emailInput").val(),
      address: fullAddress,
      telephone: $("#mobileInput").val(),
    };

    const password = $("#passwordInput").val();
    if (password && password.trim() !== "") {
      updatedData.password = password;
    }

    $.ajax({
      url: API_URL,
      method: "PUT",
      contentType: "application/json",
      data: JSON.stringify(updatedData),
      success: function () {
        alert("Profile updated successfully!");
        $("#passwordInput").val("");
      },
      error: function (xhr) {
        alert(
          "Failed to update profile: " +
            (xhr.responseJSON?.error || "Unknown error")
        );
      },
    });
  });
});
