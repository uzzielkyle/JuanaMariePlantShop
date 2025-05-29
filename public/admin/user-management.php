<?php
require_once '../middleware/authMiddleware.php';
require_once '../config/db.php';

$auth = authenticate(["admin"], true);
if (!$auth || $auth->role !== 'admin') {
  header('Location: ./auth/login.php');
  exit;
}

// Fetch users
$stmt = $pdo->query("SELECT * FROM user ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>User Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4">
      <div class="container-fluid">
        <h1 class="fw-bold">USERS</h1>
        <div class="table-responsive px-5">
          <table class="table table-hover align-middle">
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
              <?php if (empty($users)) : ?>
                <tr>
                  <td colspan="7" class="text-center">No users found</td>
                </tr>
              <?php else : ?>
                <?php foreach ($users as $user) : ?>
                  <tr>
                    <td>
                      <?= htmlspecialchars($user['last_name'] . ', ' . $user['first_name']) ?>
                    </td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?></td>
                    <td><?= htmlspecialchars($user['telephone']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><?= htmlspecialchars($user['modified_at']) ?></td>
                    <td>
                      <button
                        class="btn btn-primary btn-view rounded-pill text-white fw-bold border-0"
                        data-id="<?= $user['iduser'] ?>"
                        data-first_name="<?= htmlspecialchars($user['first_name']) ?>"
                        data-last_name="<?= htmlspecialchars($user['last_name']) ?>"
                        data-email="<?= htmlspecialchars($user['email']) ?>"
                        data-address="<?= htmlspecialchars($user['address']) ?>"
                        data-telephone="<?= htmlspecialchars($user['telephone']) ?>">VIEW</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- User Modal -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="userForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 px-4">
          <input type="hidden" id="userId" name="iduser" />
          <div class="col-md-6">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" id="firstName" name="first_name" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" id="lastName" name="last_name" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label for="telephone" class="form-label">Telephone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" required />
          </div>
          <div class="col-md-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" name="address" class="form-control" />
          </div>
          <div class="col-md-6">
            <label class="form-label">Created At</label>
            <input type="text" id="createdAt" class="form-control" readonly />
          </div>
          <div class="col-md-6">
            <label class="form-label">Modified At</label>
            <input type="text" id="modifiedAt" class="form-control" readonly />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="deleteUser">Delete</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/user-management.js"></script>
</body>

</html>