<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';

$auth = authenticate(["admin"], true);
if (!$auth || $auth->role !== 'admin') {
  header('Location: ./auth/login.php');
  exit;
}

// Handle Add Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
  $name = trim($_POST['category_name']);
  if (!empty($name)) {
    $stmt = $pdo->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->execute([$name]);
  }
  header("Location: category-management.php");
  exit;
}

// Handle Edit Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
  $id = $_POST['category_id'];
  $name = trim($_POST['category_name']);
  if (!empty($id) && !empty($name)) {
    $stmt = $pdo->prepare("UPDATE category SET name = ? WHERE idcategory = ?");
    $stmt->execute([$name, $id]);
  }
  header("Location: category-management.php");
  exit;
}

// Handle Delete Category
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $pdo->prepare("DELETE FROM category WHERE idcategory = ?");
  $stmt->execute([$id]);
  header("Location: category-management.php");
  exit;
}

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM category ORDER BY idcategory DESC");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Categories - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="fw-bold">Categories</h1>
          <button class="btn btn-success rounded-pill text-white fw-bold border-0" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Add New Category
          </button>
        </div>

        <div class="mb-4 d-flex flex-wrap gap-3">
          <?php foreach ($categories as $category): ?>
            <div class="d-inline-flex align-items-center bg-light border rounded-pill px-4 py-2" style="font-size: 1.25rem;">
              <span class="fw-semibold me-4"><?= htmlspecialchars($category['name']) ?></span>

              <!-- Edit -->
              <button class="btn btn-link p-0 text-warning fs-4" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $category['idcategory'] ?>" aria-label="Edit">
                <i class="bi bi-pencil-fill me-2"></i>
              </button>

              <!-- Delete -->
              <a href="?delete=<?= $category['idcategory'] ?>" class="btn btn-link p-0 text-danger fs-4" aria-label="Delete"
                onclick="return confirm('Are you sure you want to delete this category?')">
                <i class="bi bi-trash-fill"></i>
              </a>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editCategoryModal<?= $category['idcategory'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <form method="POST" class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="category_id" value="<?= $category['idcategory'] ?>">
                    <div class="mb-3">
                      <label class="form-label">Category Name</label>
                      <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="edit_category" class="btn btn-warning rounded-pill fw-bold">Update</button>
                  </div>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_category" class="btn btn-success rounded-pill fw-bold text-white">Add</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>