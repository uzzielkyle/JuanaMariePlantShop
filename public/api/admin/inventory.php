<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

function respond($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

$auth = authenticate(['admin']);
if (!$auth || $auth->role !== 'admin') {
    respond(['error' => 'Unauthorized'], 403);
}

// GET quantity for all products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("SELECT idproduct, name, quantity FROM product");
    $result = $stmt->fetchAll();
    respond($result);
}

// GET quantity for one product
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT idproduct, name, quantity FROM product WHERE idproduct = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    if (!$product) {
        respond(['error' => 'Product not found'], 404);
    }
    respond($product);
}

// PUT update quantity for product
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['quantity']) || !is_numeric($data['quantity']) || $data['quantity'] < 0) {
        respond(['error' => 'Invalid quantity'], 400);
    }

    $stmt = $pdo->prepare("UPDATE product SET quantity = ? WHERE idproduct = ?");
    $stmt->execute([$data['quantity'], $productId]);

    respond(['message' => 'Quantity updated']);
}

respond(['error' => 'Method not allowed'], 405);
