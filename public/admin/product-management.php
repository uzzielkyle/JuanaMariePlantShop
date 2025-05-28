<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Main Page with Sidebar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">
  <?php
  $plants = [
    [
      'name' => 'Basil',
      'price' => 500,
      'sunlight' => 'Full Sun',
      'watering_schedule' => 'Every 2 days',
      'difficulty' => 3,
      'description' => 'A fragrant herb used in cooking.',
      'history' => 'Originated in tropical regions.',
      'care_guide' => 'Keep soil moist and provide plenty of sunlight.',
      'propagation' => 'Can be propagated from cuttings.',
    ],
    [
      'name' => 'Dill',
      'price' => 100,
      'sunlight' => 'Partial Sun',
      'watering_schedule' => 'Once a week',
      'difficulty' => 2,
      'description' => 'An herb with a distinct flavor.',
      'history' => 'Used since ancient times.',
      'care_guide' => 'Water regularly and ensure good drainage.',
      'propagation' => 'Seeds can be sown directly in soil.',
    ]
  ];
  ?>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <h1 class="fw-bold">PLANTS</h1>

        <!-- Button to Open Add Plant Modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPlantModal">
          ADD
        </button>

        <div class="table-responsive px-5">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Plant Name</th>
                <th>Price</th>
                <th>Sunlight</th>
                <th>Watering Schedule</th>
                <th>Difficulty</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($plants as $plant): ?>
                <tr>
                  <td>
                    <img src="assets/default.jpg" class="img-fluid rounded-circle me-2" style="width: 40px; height: 40px" />
                    <?= htmlspecialchars($plant['name']) ?>
                  </td>
                  <td><?= htmlspecialchars($plant['price']) ?></td>
                  <td><?= htmlspecialchars($plant['sunlight']) ?></td>
                  <td><?= htmlspecialchars($plant['watering_schedule']) ?></td>
                  <td><?= htmlspecialchars($plant['difficulty']) ?></td>
                  <td>
                    <button
                      class="btn btn-primary btn-view rounded-pill text-white fw-bold border-0"
                      data-name="<?= htmlspecialchars($plant['name']) ?>"
                      data-price="<?= htmlspecialchars($plant['price']) ?>"
                      data-sunlight="<?= htmlspecialchars($plant['sunlight']) ?>"
                      data-watering="<?= htmlspecialchars($plant['watering_schedule']) ?>"
                      data-difficulty="<?= htmlspecialchars($plant['difficulty']) ?>"
                      data-description="<?= htmlspecialchars($plant['description']) ?>"
                      data-history="<?= htmlspecialchars($plant['history']) ?>"
                      data-care="<?= htmlspecialchars($plant['care_guide']) ?>"
                      data-propagation="<?= htmlspecialchars($plant['propagation']) ?>">VIEW</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Adding New Plant -->
  <div class="modal fade" id="addPlantModal" tabindex="-1" aria-labelledby="addPlantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="addPlantForm">
          <div class="modal-header">
            <h5 class="modal-title" id="addPlantModalLabel">Add New Plant</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="newName" class="form-label">Plant Name</label>
              <input type="text" class="form-control rounded-0 border-dark" id="newName" name="name" required>
            </div>

            <div class="row">
              <div class="col mb-3">
                <label for="newPrice" class="form-label">Price</label>
                <input type="text" class="form-control rounded-0 border-dark" id="newPrice" name="price" required>
              </div>

              <div class="col mb-3">
                <label for="newSunlight" class="form-label">Sunlight</label>
                <input type="text" class="form-control rounded-0 border-dark" id="newSunlight" name="sunlight" required>
              </div>
            </div>

            <div class="row">
              <div class="col mb-3">
                <label for="newWatering" class="form-label">Watering Schedule</label>
                <input type="text" class="form-control rounded-0 border-dark" id="newWatering" name="watering_schedule" required>
              </div>

              <div class="col mb-3">
                <label for="newDifficulty" class="form-label">Difficulty</label>
                <input type="text" class="form-control rounded-0 border-dark" id="newDifficulty" name="difficulty" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="newDescription" class="form-label">Description</label>
              <textarea class="form-control rounded-0 border-dark" id="newDescription" name="description" required></textarea>
            </div>

            <div class="mb-3">
              <label for="newHistory" class="form-label">History</label>
              <textarea class="form-control rounded-0 border-dark" id="newHistory" name="history" required></textarea>
            </div>

            <div class="mb-3">
              <label for="newCare" class="form-label">Care Guide</label>
              <textarea class="form-control rounded-0 border-dark" id="newCare" name="care_guide" required></textarea>
            </div>

            <div class="mb-3">
              <label for="newPropagation" class="form-label">Propagation</label>
              <textarea class="form-control rounded-0 border-dark" id="newPropagation" name="propagation" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add Plant</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.btn-view').on('click', function() {
        const plant = $(this).data();
        $('#plantId').val(plant.id);
        $('#name').val(plant.name);
        $('#price').val(plant.price);
        $('#sunlight').val(plant.sunlight);
        $('#watering').val(plant.watering);
        $('#difficulty').val(plant.difficulty);
        $('#description').val(plant.description);
        $('#history').val(plant.history);
        $('#care').val(plant.care);
        $('#propagation').val(plant.propagation);
        $('#plantModal').modal('show');
      });

      $('#plantForm').on('submit', function(e) {
        e.preventDefault();
        // USE AJAX HERE TO UPDATE FORM, AND REMOVE THE ALERT
        alert('Plant updated (simulate saving).');
        $('#plantModal').modal('hide');
      });

      $('#deletePlant').on('click', function() {
        const id = $('#plantId').val();
        if (confirm('Are you sure you want to delete this plant?')) {
          // REMOVE THE ALERT
          alert('Plant deleted with ID: ' + id);
          $('#plantModal').modal('hide');
        }
      });

      // for adding new plant
      $('#addPlantForm').on('submit', function(e) {
        e.preventDefault();
        // REMOVE THIS ALERT
        alert('New plant added (simulate saving).');
        $('#addPlantModal').modal('hide');
      });
    });
  </script>
</body>

</html>