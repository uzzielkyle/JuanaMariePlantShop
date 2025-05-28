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
  $users = [
    [
      'id' => 1,
      'first_name' => 'Juan',
      'last_name' => 'Dela Cruz',
      'email' => 'juan@gmail.com',
      'telephone' => '09177185912',
      'password' => 'Juan_1234',
      'city' => 'Puerto Princesa City',
      'street' => 'Rizal St.',
      'region' => 'MIMAROPA',
      'country' => 'Philippines',
      'zip' => '5300',
      'created_at' => '2023-11-11',
      'modified_at' => '2023-11-11',
    ],
    [
      'id' => 2,
      'first_name' => 'Maria',
      'last_name' => 'Santos',
      'email' => 'maria@gmail.com',
      'telephone' => '09181234567',
      'password' => 'Maria_1231',
      'city' => 'Manila',
      'street' => 'España Blvd.',
      'region' => 'NCR',
      'country' => 'Philippines',
      'zip' => '1008',
      'created_at' => '2023-10-05',
      'modified_at' => '2023-12-01',
    ]
  ];
  ?>
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <h1 class="fw-bold">USERS</h1>
        <div class="table-responsive px-5">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Telephone No.</th>
                <th>Created At</th>
                <th>Modified At</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td>
                    <img src="assets/default.jpg" class="img-fluid rounded-circle me-2" style="width: 40px; height: 40px" />
                    <?= $user['last_name'] . ', ' . $user['first_name'] ?>
                  </td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['city']) ?></td>
                  <td><?= htmlspecialchars($user['telephone']) ?></td>
                  <td><?= htmlspecialchars($user['created_at']) ?></td>
                  <td><?= htmlspecialchars($user['modified_at']) ?></td>
                  <td>
                    <button
                      class="btn btn-primary btn-view rounded-pill text-white fw-bold border-0"
                      data-id="<?= $user['id'] ?>"
                      data-first="<?= htmlspecialchars($user['first_name']) ?>"
                      data-last="<?= htmlspecialchars($user['last_name']) ?>"
                      data-email="<?= htmlspecialchars($user['email']) ?>"
                      data-telephone="<?= htmlspecialchars($user['telephone']) ?>"
                      data-password="<?= htmlspecialchars($user['password']) ?>"
                      data-city="<?= htmlspecialchars($user['city']) ?>"
                      data-street="<?= htmlspecialchars($user['street']) ?>"
                      data-region="<?= htmlspecialchars($user['region']) ?>"
                      data-country="<?= htmlspecialchars($user['country']) ?>"
                      data-zip="<?= htmlspecialchars($user['zip']) ?>">VIEW</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="userForm">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">Full User Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="userId" name="id">

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control rounded-0 border-dark" id="firstName" name="first_name">
              </div>

              <div class="col-md-6">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control rounded-0 border-dark" id="lastName" name="last_name">
              </div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control rounded-0 border-dark" id="email" name="email">
            </div>

            <div class="mb-3">
              <label for="telephone" class="form-label">Telephone</label>
              <input type="text" class="form-control rounded-0 border-dark" id="telephone" name="telephone">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control rounded-0 border-dark" id="password" name="password">
            </div>

            <div class="mb-3">
              <label for="street" class="form-label">Street</label>
              <input type="text" class="form-control rounded-0 border-dark" id="street" name="street">
            </div>

            <div class="mb-3">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control rounded-0 border-dark" id="city" name="city">
            </div>

            <div class="mb-3">
              <label for="region" class="form-label">Region</label>
              <input type="text" class="form-control rounded-0 border-dark" id="region" name="region">
            </div>

            <div class="row mb">
              <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control rounded-0 border-dark" id="country" name="country">
              </div>
              <div class="col-md-6">
                <label for="zip" class="form-label">ZIP Code</label>
                <input type="text" class="form-control rounded-0 border-dark" id="zip" name="zip">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger px-4 rounded-pill text-black fw-bold border-0 text-white" id="deleteUser">Delete</button>
            <button type="submit" class="btn px-4 rounded-pill text-black fw-bold border-0" style=" background-color: #cff3d7">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.btn-view').on('click', function() {
        const user = $(this).data();
        $('#userId').val(user.id);
        $('#firstName').val(user.first);
        $('#lastName').val(user.last);
        $('#email').val(user.email);
        $('#telephone').val(user.telephone);
        $('#password').val(user.password);
        $('#street').val(user.street);
        $('#city').val(user.city);
        $('#region').val(user.region);
        $('#country').val(user.country);
        $('#zip').val(user.zip);
        $('#userModal').modal('show');
      });

      $('#userForm').on('submit', function(e) {
        e.preventDefault();
        // USE AJAX HERE TO UPDATE FORM, AND REMOVE THE ALERT
        alert('User updated (simulate saving).');
        $('#userModal').modal('hide');
      });

      $('#deleteUser').on('click', function() {
        const id = $('#userId').val();
        if (confirm('Are you sure you want to delete this user?')) {
          // REMOVE THE ALERT
          alert('User deleted with ID: ' + id);
          $('#userModal').modal('hide');
        }
      });
    });
  </script>
</body>

</html>