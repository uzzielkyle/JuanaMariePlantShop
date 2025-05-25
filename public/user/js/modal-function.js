document.addEventListener("DOMContentLoaded", function () {
  const modal = new bootstrap.Modal(document.getElementById("orderModal"));
  document.querySelectorAll(".viewButton").forEach(function (button) {
    button.addEventListener("click", function () {
      modal.show();
    });
  });
});
