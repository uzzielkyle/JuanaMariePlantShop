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
  <title>User Management - Juana Marie</title>
  <link rel="icon" href="../assets/logo.svg" type="image/svg+xml" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="m-0">
  <div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>

    <div class="flex-grow-1 p-4" style="height: 100vh; overflow-y: auto;">
      <div class="container-fluid">
        <h1 class="fw-bold">USERS</h1>
        <div class="table-responsive px-3 pt-3">
          <table class="table table-hover align-middle table-striped table-borderless">
            <thead class="table-light">
              <tr class="text-uppercase text-muted small">
                <th colspan="2">Profile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Telephone</th>
                <th colspan="2">Created</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($users)) : ?>
                <tr style="height: 60px;">
                  <td colspan="6" class="text-center text-muted align-middle small">No users found.</td>
                </tr>
              <?php else : ?>
                <?php foreach ($users as $user) :
                  $fullName = $user['first_name'] . ' ' . $user['last_name'];
                  $initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                ?>
                  <tr class="align-middle small" style="height: 60px;">
                    <td colspan="2">
                      <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                          <?= $initials ?>
                        </div>
                        <div>
                          <div class="fw-semibold small"><?= htmlspecialchars($fullName) ?></div>
                          <small class="text-muted">ID: <?= $user['iduser'] ?></small>
                        </div>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?: '<span class="text-muted fst-italic">N/A</span>' ?></td>
                    <td><?= htmlspecialchars($user['telephone']) ?: '<span class="text-muted fst-italic">N/A</span>' ?></td>
                    <td><small class="text-muted"><?= date('M d, Y h:i A', strtotime($user['created_at'])) ?></small></td>
                    <td colspan="2" class="text-center">
                      <button class="btn btn-sm btn-outline-primary btn-view rounded-pill px-3 py-1 fw-semibold"
                        data-id="<?= $user['iduser'] ?>"
                        data-first_name="<?= htmlspecialchars($user['first_name']) ?>"
                        data-last_name="<?= htmlspecialchars($user['last_name']) ?>"
                        data-email="<?= htmlspecialchars($user['email']) ?>"
                        data-address="<?= htmlspecialchars($user['address']) ?>"
                        data-telephone="<?= htmlspecialchars($user['telephone']) ?>">
                        <i class="bi bi-person-lines-fill me-1"></i> View
                      </button>
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