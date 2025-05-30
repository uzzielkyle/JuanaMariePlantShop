function recalculateSummary() {
  let subtotal = 0;

  $("#cart-table-body tr").each(function () {
    const checkbox = $(this).find(".item-check");
    const quantityInput = $(this).find(".quantity");
    const itemTotalCell = $(this).find(".item-total");

    const isChecked = checkbox.prop("checked");
    const quantity = parseInt(quantityInput.val());
    const price = parseFloat(quantityInput.data("price"));
    const itemTotal = quantity * price;

    // If checked, include in subtotal
    if (isChecked) {
      subtotal += itemTotal;
      itemTotalCell.text(itemTotal.toFixed(2));
    } else {
      itemTotalCell.text("0.00");
    }
  });

  const shipping = parseFloat($("#shipping").text()) || 0;
  $("#subtotal").text(subtotal.toFixed(2));
  $("#total").text((subtotal + shipping).toFixed(2));
}

function bindCartEvents() {
  // When checkbox changes
  $(".item-check")
    .off("change")
    .on("change", function () {
      recalculateSummary();
    });

  // When quantity input changes, update DB with debounce to reduce calls
  let quantityUpdateTimeout = null;
  $(".quantity")
    .off("input")
    .on("input", function () {
      const input = $(this);
      const newQuantity = parseInt(input.val());
      const cartId = input.data("id");

      if (isNaN(newQuantity) || newQuantity < 1) return; // Validate minimum quantity

      // Recalculate totals immediately for UI feedback
      recalculateSummary();

      // Debounce the AJAX update call by 500ms
      clearTimeout(quantityUpdateTimeout);
      quantityUpdateTimeout = setTimeout(() => {
        $.ajax({
          url: `../api/user/cart.php?id=${cartId}`,
          method: "PUT",
          contentType: "application/json",
          data: JSON.stringify({ quantity: newQuantity }),
          success: function () {
            // Optionally show success or just silently update
            // fetchCartItems(); // Uncomment if you want to refresh entire cart after update
          },
          error: function () {
            alert("Failed to update quantity.");
          },
        });
      }, 500);
    });

  // When remove button is clicked
  $(".btn-close")
    .off("click")
    .on("click", function () {
      const cartId = $(this).data("id");
      $.ajax({
        url: `../api/user/cart.php?id=${cartId}`,
        method: "DELETE",
        success: function () {
          fetchCartItems();
        },
        error: function () {
          alert("Failed to remove item.");
        },
      });
    });
}

function fetchCartItems() {
  $.ajax({
    url: "../api/user/cart.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      renderCart(data);
    },
    error: function (xhr) {
      console.error("Error fetching cart items:", xhr.responseText);
      $("#cart-table-body").html(
        '<tr><td colspan="6" class="text-center">Failed to load cart.</td></tr>'
      );
    },
  });
}

function renderCart(items) {
  const tbody = $("#cart-table-body");
  tbody.empty();

  if (!items.length) {
    tbody.append(
      '<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>'
    );
    $("#subtotal").text("0.00");
    $("#total").text("0.00");
    return;
  }

  let subtotal = 0;

  items.forEach((item) => {
    const price = parseFloat(item.price);
    const total = item.quantity * price;
    subtotal += total;

    const row = `
      <tr data-product-id=${item.product_id}>
        <td class="text-center">
          <input type="checkbox" class="item-check" checked style="transform: scale(1.5);">
        </td>
        <th>${item.name || "Product " + item.product}</th>
        <td>${price.toFixed(2)}</td>
        <td>
          <div class="col-sm-4">
            <input type="number" class="form-control quantity" value="${item.quantity
      }" min="1" max="99" step="1" data-price="${price}" data-id="${item.idcart
      }">
          </div>
        </td>
        <td class="item-total">${total.toFixed(2)}</td>
        <td>
          <button type="button" class="btn-close delete-btn" data-id="${item.idcart
      }" aria-label="Close"></button>
        </td>
      </tr>
    `;
    tbody.append(row);
  });

  $("#shipping").text("100.00");
  $("#subtotal").text(subtotal.toFixed(2));
  $("#total").text((subtotal + 100).toFixed(2));

  bindCartEvents(); // Rebind events for newly added elements
  recalculateSummary(); // Initial calculation
}

$(document).ready(function () {
  fetchCartItems();
});

$("#checkoutBtn").on("click", function () {
  const $btn = $(this);
  const $spinner = $("#checkoutSpinner");
  const $text = $("#checkoutText");

  const selectedItems = {};
  let subtotal = 0;

  $("#cart-table-body tr").each(function () {
    const checkbox = $(this).find(".item-check");
    if (checkbox.prop("checked")) {
      const quantityInput = $(this).find(".quantity");
      const productId = $(this).data("product-id");
      const quantity = parseInt(quantityInput.val());
      const price = parseFloat(quantityInput.data("price"));

      selectedItems[productId] = quantity;
      subtotal += quantity * price;
    }
  });

  if (Object.keys(selectedItems).length === 0) {
    alert("Please select at least one item to checkout.");
    return;
  }

  const shipping = parseFloat($("#shipping").text()) || 0;
  const total = subtotal + shipping;

  console.log(selectedItems)

  // Show spinner
  $btn.prop("disabled", true);
  $spinner.removeClass("d-none");
  $text.text("Processing...");

  $.ajax({
    url: "../api/user/order.php",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      items: selectedItems,
      total_amount: total
    }),
    success: function () {
      alert("Checkout successful!");
      setTimeout(function () {
        window.location.href = "thank-page.php";
      }, 500);
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      alert("Checkout failed.");
    },
    complete: function () {
      // Hide spinner and restore button
      $btn.prop("disabled", false);
      $spinner.addClass("d-none");
      $text.text("CHECKOUT");
    }
  });
});

