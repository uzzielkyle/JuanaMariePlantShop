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

// Authenticate admin
$auth = authenticate(['admin']);
if (!$auth) {
    respond(['error' => 'Unauthorized'], 403);
}

// GET all users
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("SELECT iduser, first_name, last_name, email, address, telephone, created_at, modified_at FROM user");
    respond($stmt->fetchAll());
}

// GET user by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT iduser, first_name, last_name, email, address, telephone, created_at, modified_at FROM user WHERE iduser = ?");
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch();
    if ($user) {
        respond($user);
    } else {
        respond(['error' => 'User not found'], 404);
    }
}

// POST create user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['address'], $data['telephone'])) {
        respond(['error' => 'Missing required fields'], 400);
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO user (first_name, last_name, email, password, address, telephone, created_at, modified_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $hashedPassword,
        $data['address'],
        $data['telephone']
    ]);

    respond(['message' => 'User created', 'id' => $pdo->lastInsertId()]);
}

// PUT update user
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['iduser'])) {
        respond(['error' => 'Missing user ID'], 400);
    }

    $fields = ['first_name', 'last_name', 'email', 'address', 'telephone'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $updates[] = "$field = ?";
            $values[] = $data[$field];
        }
    }

    if (isset($data['password']) && !empty($data['password'])) {
        $updates[] = "password = ?";
        $values[] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    if (empty($updates)) {
        respond(['error' => 'No fields to update'], 400);
    }

    $updates[] = "modified_at = NOW()";
    $values[] = $data['iduser']; // bind at the end

    $sql = "UPDATE user SET " . implode(', ', $updates) . " WHERE iduser = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    respond(['message' => 'User updated']);
}

// DELETE user
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id'])) {
        respond(['error' => 'ID required'], 400);
    }

    $stmt = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
    $stmt->execute([$data['id']]);
    respond(['message' => 'User deleted']);
}

respond(['error' => 'Method not allowed'], 405);
