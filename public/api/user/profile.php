<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

// Response helper
function respond($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

// Authenticate user
$auth = authenticate(["user"]);
if (!$auth || $auth->role !== 'user') {
    respond(['error' => 'Unauthorized'], 403);
}

$userid = $auth->iduser;  // assuming 'iduser' is in JWT

// GET own profile
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT iduser, first_name, last_name, email, address, telephone, created_at, modified_at FROM user WHERE iduser = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch();
    if ($user) {
        respond($user);
    } else {
        respond(['error' => 'User not found'], 404);
    }
}

// PUT update own profile
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $fields = ['first_name', 'last_name', 'email', 'address', 'telephone'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $updates[] = "$field = ?";
            $values[] = $data[$field];
        }
    }

    if (isset($data['password'])) {
        $updates[] = "password = ?";
        $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    if (empty($updates)) {
        respond(['error' => 'No fields to update'], 400);
    }

    $values[] = $userid;
    $sql = "UPDATE user SET " . implode(', ', $updates) . ", modified_at = NOW() WHERE iduser = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    respond(['message' => 'Profile updated']);
}

// DELETE own account
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $stmt = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
    $stmt->execute([$userid]);
    respond(['message' => 'Account deleted']);
}

respond(['error' => 'Method not allowed'], 405);
