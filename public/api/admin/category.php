<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

$auth = authenticate(["admin"]); // get user data from JWT

if (!$auth || $auth->role !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// GET all categories
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM category");
    echo json_encode($stmt->fetchAll());
    exit;
}

// GET category by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM category WHERE idcategory = ?");
    $stmt->execute([$_GET['id']]);
    $cat = $stmt->fetch();
    if ($cat) {
        echo json_encode($cat);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Category not found']);
    }
    exit;
}

// POST create category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name required']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->execute([$data['name']]);
    echo json_encode(['message' => 'Category created', 'id' => $pdo->lastInsertId()]);
    exit;
}

// PUT update category
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name required']);
        exit;
    }
    $stmt = $pdo->prepare("UPDATE category SET name = ? WHERE idcategory = ?");
    $stmt->execute([$data['name'], $_GET['id']]);
    echo json_encode(['message' => 'Category updated']);
    exit;
}

// DELETE category
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM category WHERE idcategory = ?");
    $stmt->execute([$_GET['id']]);
    echo json_encode(['message' => 'Category deleted']);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
