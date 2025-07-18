$(document).ready(function () {
  const apiBase = "../api/admin/product.php";
  const categoryApi = "../api/admin/category.php"; // API endpoint for categories
  const token = localStorage.getItem("token");
  const headers = { Authorization: `Bearer ${token}` };

  function disableAllButtons(clickedBtn) {
    $("button").prop("disabled", true);

    // Save original content so we can restore later
    if (!clickedBtn.data("original-html")) {
      clickedBtn.data("original-html", clickedBtn.html());
    }

    // Add spinner inside the clicked button
    clickedBtn.html(
      `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
    );

    console.log(clickedBtn);
  }

  function enableAllButtons(clickedBtn) {
    $("button").prop("disabled", false);

    // Restore clicked button original content
    if (clickedBtn && clickedBtn.data("original-html")) {
      clickedBtn.html(clickedBtn.data("original-html"));
      clickedBtn.removeData("original-html");
    }
  }

  function showLoading() {
    const container = $("#plantCardContainer");
    container.empty();

    for (let i = 0; i < 6; i++) {
      container.append(`
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card h-100 shadow-sm small placeholder-glow">
                        <div class="card-img-top bg-light placeholder" style="height: 100px; object-fit: cover;"></div>
                        <div class="card-body p-2">
                            <h6 class="card-title placeholder col-7 mb-2 fw-bold d-block">&nbsp;</h6>
                            <p class="card-text placeholder col-4 mb-2 fw-bold d-block">&nbsp;</p>
                            <p class="card-text placeholder col-5 mb-2 d-block">&nbsp;</p>
                            <p class="card-text placeholder col-6 mb-3 d-block">&nbsp;</p>
                            <div class="d-flex justify-content-between">
                                <span class="btn btn-sm btn-warning disabled placeholder col-4"></span>
                                <span class="btn btn-sm btn-danger disabled placeholder col-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
    }
  }

  function hideLoading() {
    $("#loadingOverlay").fadeOut(100);
  }

  // Load all products
  function fetchProducts() {
    showLoading();
    $.ajax({
      url: apiBase,
      method: "GET",
      headers,
      success: function (products) {
        const container = $("#plantCardContainer");
        container.empty();

        products.forEach((product) => {
          let imageUrl;
          if (product.photo) {
            // Convert binary or base64 to proper data URI
            imageUrl = `data:image/jpeg;base64,${product.photo}`;
          } else {
            // Fallback placeholder
            imageUrl = `https://placehold.jp/c0c0c0/ffffff/600x400.png?text=${encodeURIComponent(
              product.name
            )}`;
          }

          const card = `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card h-100 shadow-sm small">
                        <img src="${imageUrl}" class="card-img-top" alt="${
            product.name
          }" style="height: 100px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="card-title text-truncate mb-1 fw-bold">${
                              product.name
                            }</h6>
                            <p class="card-text mb-1"><strong>₱${
                              product.price
                            }</strong></p>
                            <p class="card-text mb-1"><small>☀ ${
                              product.sunlight || "-"
                            }</small></p>
                            <p class="card-text mb-2"><small>💧 ${
                              product.watering_schedule || "-"
                            }</small></p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${
                                  product.idproduct
                                }"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${
                                  product.idproduct
                                }"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
          container.append(card);
        });

        hideLoading();
      },
      error: function () {
        alert("Failed to load products.");
        hideLoading();
      },
    });
  }

  // Fetch categories for dropdowns
  function fetchCategories(selectElement) {
    $.ajax({
      url: categoryApi,
      method: "GET",
      headers,
      success: function (categories) {
        selectElement.empty(); // Clear existing options
        selectElement.append(
          '<option value="" disabled selected>Select a category</option>'
        ); // Default option

        categories.forEach((category) => {
          selectElement.append(
            `<option value="${category.idcategory}">${category.name}</option>`
          );
        });
      },
      error: function () {
        alert("Failed to load categories.");
      },
    });
  }

  // Load categories for add modal
  fetchCategories($("#newCategory"));

  // Edit button click - load data & show modal
  $(document).on("click", ".edit-btn", function () {
    const clickedBtn = $(this);
    const id = clickedBtn.data("id");

    // Disable all buttons and show spinner on this one
    disableAllButtons(clickedBtn);

    $.ajax({
      url: `${apiBase}?id=${id}`,
      method: "GET",
      headers,
      success: function (product) {
        $("#plantId").val(product.idproduct);
        $("#name").val(product.name);
        $("#price").val(product.price);
        $("#sunlight").val(product.sunlight);
        $("#watering").val(product.watering_schedule);
        $("#difficulty").val(product.difficulty);
        $("#description").val(product.description);
        $("#history").val(product.history);
        $("#care").val(product.care_guide);
        $("#propagation").val(product.propagation);

        // Set the selected category
        $("#category").val(product.category_id); // Assuming product.category_id holds the category ID

        // Fetch categories and populate the select element
        fetchCategories($("#category"));

        $("#plantModal").modal("show");
      },
      error: function () {
        alert("Failed to load plant.");
      },
      complete: function () {
        enableAllButtons(clickedBtn);
      },
    });
  });

  let deletePlantId = null; // Store plant id for deletion

  // Initialize validation for Edit form
  $("#plantForm").validate({
    rules: {
      name: { required: true },
      price: { required: true, number: true },
      description: { required: true },
    },
    messages: {
      name: "Please enter the plant name",
      price: {
        required: "Please enter the price",
        number: "Please enter a valid number",
      },
      description: "Please provide a description",
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "div",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".mb-3, .col").append(error);
    },
    highlight: function (element) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
    submitHandler: function (form) {
      const id = $("#plantId").val();
      const token = localStorage.getItem("token");

      const clickedBtn = $(form).find("button[type=submit]");

      disableAllButtons(clickedBtn);

      const productData = {
        name: $("#name").val().trim(),
        price: $("#price").val().trim() || null,
        sunlight: $("#sunlight").val().trim() || null,
        watering_schedule: $("#watering").val().trim() || null,
        difficulty: $("#difficulty").val().trim() || null,
        description: $("#description").val().trim(),
        history: $("#history").val().trim() || null,
        care_guide: $("#care").val().trim() || null,
        propagation: $("#propagation").val().trim() || null,
      };

      const photoFile = $("#photo")[0].files[0];

      if (photoFile) {
        const reader = new FileReader();
        reader.onloadend = function () {
          const base64Photo = reader.result.split(",")[1]; // remove data:image/... prefix
          productData.photo = base64Photo;

          sendUpdateRequest(productData);
        };
        reader.readAsDataURL(photoFile);
      } else {
        sendUpdateRequest(productData);
      }

      function sendUpdateRequest(data) {
        $.ajax({
          url: `${apiBase}?id=${id}`,
          method: "PUT",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
          data: JSON.stringify(data),
          success: function () {
            $("#plantModal").modal("hide");
            fetchProducts();
          },
          error: function (xhr, status, error) {
            console.error("Update error:", status, error);
            console.error("Response text:", xhr.responseText);
            alert("Failed to update plant.");
          },
          complete: function () {
            enableAllButtons(clickedBtn);
          },
        });
      }
    },
  });

  // Delete button click - show modal
  $(document).on("click", ".delete-btn", function () {
    deletePlantId = $(this).data("id");
    $("#deleteModal").modal("show");
  });

  // Confirm delete button
  $("#confirmDeleteBtn").on("click", function () {
    if (!deletePlantId) return;

    const token = localStorage.getItem("token");
    const clickedBtn = $(this);

    disableAllButtons(clickedBtn);

    $.ajax({
      url: `${apiBase}?id=${deletePlantId}`,
      method: "DELETE",
      headers: { Authorization: `Bearer ${token}` },
      success: function () {
        $("#deleteModal").modal("hide");
        fetchProducts();
      },
      error: function () {
        alert("Failed to delete plant.");
      },
      complete: function () {
        deletePlantId = null;
        enableAllButtons(clickedBtn);
      },
    });
  });

  // Add new plant
  $("#addPlantForm").validate({
    rules: {
      name: {
        required: true,
      },
      price: {
        required: true,
        number: true,
      },
      description: {
        required: true,
      },
    },
    messages: {
      name: "Please enter the plant name",
      price: {
        required: "Please enter the price",
        number: "Please enter a valid number",
      },
      description: "Please provide a description",
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "div",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".mb-3, .col").append(error);
    },
    highlight: function (element) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
    submitHandler: function (form) {
      const clickedBtn = $(form).find("button[type=submit]");
      disableAllButtons(clickedBtn);

      const difficultyValue = $("#newDifficulty").val().trim();
      const priceValue = $("#newPrice").val().trim();

      const selectedCategory = $("#newCategory").val();

      const data = {
        name: $("#newName").val().trim(),
        price: priceValue === "" ? null : parseFloat(priceValue),
        sunlight: $("#newSunlight").val().trim() || null,
        watering_schedule: $("#newWatering").val().trim() || null,
        difficulty: difficultyValue === "" ? null : parseInt(difficultyValue),
        description: $("#newDescription").val().trim(),
        history: $("#newHistory").val().trim() || null,
        care_guide: $("#newCare").val().trim() || null,
        propagation: $("#newPropagation").val().trim() || null,
        category: selectedCategory ? parseInt(selectedCategory) : null, // ✅ only one category
      };

      const token = localStorage.getItem("token");
      const photoFile = $("#newPhoto")[0].files[0];

      if (photoFile) {
        const reader = new FileReader();
        reader.onloadend = function () {
          const base64Photo = reader.result.split(",")[1]; // remove data:image/... prefix
          data.photo = base64Photo;

          sendCreateRequest(data);
        };
        reader.readAsDataURL(photoFile);
      } else {
        sendCreateRequest(data);
      }

      function sendCreateRequest(payload) {
        $.ajax({
          url: apiBase,
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
          data: JSON.stringify(payload),
          success: function () {
            $("#addPlantModal").modal("hide");
            $("#addPlantForm")[0].reset();
            $("#addPlantForm input, #addPlantForm textarea").removeClass(
              "is-valid"
            );
            fetchProducts();
          },
          error: function (xhr, status, error) {
            console.error("AJAX error:", status, error);
            console.error("Response text:", xhr.responseText);
            alert("Failed to add plant.");
          },
          complete: function () {
            enableAllButtons(clickedBtn);
          },
        });
      }
    },
  });

  // Initial load
  fetchProducts();
});
