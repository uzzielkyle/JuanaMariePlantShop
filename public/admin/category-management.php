<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(["admin"], true); // get admin data from JWT

if (!$auth || $auth->role !== 'admin') {
  header('Location: ./auth/login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="fw-bold">Categories</h1>
          <button class="btn btn-success rounded-pill text-white fw-bold border-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal"> Add New Category
          </button>
        </div>

        <?php
        $categories = ["Herbs", "Flowers"];
        ?>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-5">
          <?php foreach ($categories as $category): ?>
            <div class="col">
              <div class="card h-100 border-dark">
                <div class="card-body text-center">
                  <h5 class="card-title fw-bold"><?= $category ?></h5>
                  <button class="btn btn-sm btn-warning edit-btn rounded-pill text-black fw-bold border-0" data-name="<?= $category ?>">Edit</button>
                  <button class="btn btn-sm btn-danger delete-btn rounded-pill text-white fw-bold border-0" data-name="<?= $category ?>">Delete</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="add-category-form" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="new-category-name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="new-category-name" name="category_name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill text-white fw-bold border-0">Add Category</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      // Add new category
      $('#add-category-form').on('submit', function(e) {
        e.preventDefault();
        const newCategory = $('#new-category-name').val().trim();
        if (newCategory) {
          alert('New category added: ' + newCategory);
          $('#addCategoryModal').modal('hide');
          // Send AJAX request to save category
          location.reload(); // Simulate refresh
        }
      });

      // Edit category
      $('.edit-btn').on('click', function() {
        const oldName = $(this).data('name');
        const newName = prompt('Edit category name:', oldName);
        if (newName && newName !== oldName) {
          alert('Category updated: ' + newName);
        }
      });

      // Delete category
      $('.delete-btn').on('click', function() {
        const name = $(this).data('name');
        if (confirm('Are you sure you want to delete "' + name + '"?')) {
          alert('Category deleted: ' + name);
        }
      });
    });
  </script>

</body>

</html>