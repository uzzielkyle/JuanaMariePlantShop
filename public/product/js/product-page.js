document.getElementById("addToCartBtn").addEventListener("click", function () {
  const productId = new URLSearchParams(window.location.search).get("id");
  const quantity = parseInt(document.querySelector(".quantity").value);

  if (!productId || quantity <= 0) {
    alert("Invalid product or quantity.");
    return;
  }

  fetch("http://localhost/JuanaMariePlantShop/public/api/user/cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    credentials: "include", // <- REQUIRED for cookies like session or JWT
    body: JSON.stringify({
      product: parseInt(productId),
      quantity: quantity,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.error) {
        alert("Error: " + data.error);
      } else {
        // Show success modal
        const myModal = new bootstrap.Modal(
          document.getElementById("cartModal")
        );
        myModal.show();
      }
    })
    .catch((err) => {
      console.error("Failed to add to cart:", err);
      alert("Something went wrong.");
    });
});
