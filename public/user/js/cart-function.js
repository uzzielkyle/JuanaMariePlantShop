function recalculateSummary() {
  let subtotal = 0;

  $("tr").each(function () {
    const isChecked = $(this).find(".item-check").prop("checked");
    if (isChecked) {
      const quantity = parseInt($(this).find(".quantity").val());
      const price = parseFloat($(this).find(".quantity").data("price"));
      const itemTotal = quantity * price;

      // Update the total for this row
      $(this).find(".item-total").text(itemTotal);

      subtotal += itemTotal;
    } else {
      // if checkbox is not checked, then value will be 0
      $(this).find(".item-total").text("0");
    }
  });

  // Update the subtotal
  $("#subtotal").text(subtotal);

  const shipping = parseFloat($("#shipping").text());

  // Update the final total
  $("#total").text(subtotal + shipping);
}

$(document).ready(function () {
  // It will trigger if an item quantity has changed or if item row is clicked
  $(".quantity, .item-check").on("input change", function () {
    recalculateSummary();
  });
  // if close button is clicked, it will remove the row and recaclulate
  $(document).on("click", ".btn-close", function () {
    $(this).closest("tr").remove();
    recalculateSummary();
  });

  recalculateSummary();
});
