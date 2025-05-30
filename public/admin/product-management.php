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
  <meta charset="UTF-8" />
  <title>Manage Products - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body class="m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
      <div class="container-fluid">
        <h1 class="fw-bold">PLANTS</h1>

        <!-- Button to Open Add Plant Modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPlantModal">
          ADD
        </button>

        <!-- Container for cards and loading skeleton -->
        <div class="position-relative">
          <!-- Actual dynamic card container -->
          <div class="row g-3" id="plantCardContainer">
            <!-- Cards will be inserted here dynamically -->
          </div>
        </div>

      </div>

    </div>
  </div>
  </div>

  <!-- Modal for Adding New Plant -->
  <div class="modal fade" id="addPlantModal" tabindex="-1" aria-labelledby="addPlantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="addPlantForm" novalidate>
          <div class="modal-header">
            <h5 class="modal-title" id="addPlantModalLabel">Add New Plant</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="newName" class="form-label">Plant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control border-dark rounded-0" id="newName" name="name" required>
              </div>

              <div class="col mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select border-dark rounded-0" id="newCategory" name="category">
                  <option value="" disabled selected>Select a category</option>
                  <!-- Categories will be populated here -->
                </select>
              </div>

            </div>

            <div class="mb-3">
              <label for="newPhoto" class="form-label">Upload Photo</label>
              <input type="file" class="form-control border-dark rounded-0" id="newPhoto" name="photo" accept="image/*">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newPrice" class="form-label">Price <span class="text-danger">*</span></label>
                <input type="text" class="form-control border-dark rounded-0" id="newPrice" name="price" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="newDifficulty" class="form-label">Difficulty</label>
                <input type="text" class="form-control border-dark rounded-0" id="newDifficulty" name="difficulty">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newSunlight" class="form-label">Sunlight</label>
                <input type="text" class="form-control border-dark rounded-0" id="newSunlight" name="sunlight">
              </div>
              <div class="col-md-6 mb-3">
                <label for="newWatering" class="form-label">Watering Schedule</label>
                <input type="text" class="form-control border-dark rounded-0" id="newWatering" name="watering_schedule">
              </div>
            </div>

            <div class="mb-3">
              <label for="newDescription" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control border-dark rounded-0" id="newDescription" name="description" required></textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="newHistory" class="form-label">History</label>
                <textarea class="form-control border-dark rounded-0" id="newHistory" name="history"></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="newCare" class="form-label">Care Guide</label>
                <textarea class="form-control border-dark rounded-0" id="newCare" name="care_guide"></textarea>
              </div>
            </div>

            <div class="mb-3">
              <label for="newPropagation" class="form-label">Propagation</label>
              <textarea class="form-control border-dark rounded-0" id="newPropagation" name="propagation"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <span class="text-danger me-auto small">* Required fields</span>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add Plant</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Plant Modal -->
  <div class="modal fade" id="plantModal" tabindex="-1" aria-labelledby="plantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="plantForm" novalidate>
          <input type="hidden" id="plantId" name="id">
          <div class="modal-header">
            <h5 class="modal-title" id="plantModalLabel">Edit Plant</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Your input fields same as add form, but with ids:
               name, price, sunlight, watering, difficulty, description, history, care, propagation -->
            <div class="row">
              <div class="col mb-3">
                <label for="name" class="form-label">Plant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-0 border-dark" id="name" name="name" required>
              </div>

              <div class="col mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select border-dark rounded-0" id="category" name="category">
                  <option value="" disabled selected>Select a category</option>
                  <!-- Categories will be populated here -->
                </select>
              </div>


            </div>

            <div class="mb-3">
              <label for="photo" class="form-label">Upload Photo</label>
              <input type="file" class="form-control border-dark rounded-0" id="photo" name="photo" accept="image/*">
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded-0 border-dark" id="price" name="price" required>
            </div>
            <div class="mb-3">
              <label for="sunlight" class="form-label">Sunlight</label>
              <input type="text" class="form-control rounded-0 border-dark" id="sunlight" name="sunlight">
            </div>
            <div class="mb-3">
              <label for="watering" class="form-label">Watering Schedule</label>
              <input type="text" class="form-control rounded-0 border-dark" id="watering" name="watering_schedule">
            </div>
            <div class="mb-3">
              <label for="difficulty" class="form-label">Difficulty</label>
              <input type="text" class="form-control rounded-0 border-dark" id="difficulty" name="difficulty">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control rounded-0 border-dark" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
              <label for="history" class="form-label">History</label>
              <textarea class="form-control rounded-0 border-dark" id="history" name="history"></textarea>
            </div>
            <div class="mb-3">
              <label for="care" class="form-label">Care Guide</label>
              <textarea class="form-control rounded-0 border-dark" id="care" name="care_guide"></textarea>
            </div>
            <div class="mb-3">
              <label for="propagation" class="form-label">Propagation</label>
              <textarea class="form-control rounded-0 border-dark" id="propagation" name="propagation"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this plant?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="./js/product-management.js"></script>

</body>

</html>