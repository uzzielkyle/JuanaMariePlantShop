<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

$auth = authenticate(["user"]); // get user data from JWT

if (!$auth || $auth->role !== 'user') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $auth->id;

// GET all cart items for the logged-in user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->prepare("
        SELECT c.idcart, c.user, c.product AS product_id, p.name, p.price, c.quantity
        FROM cart c
        INNER JOIN `user` u ON u.iduser = c.user
        INNER JOIN product p ON p.idproduct = c.product
        WHERE c.user = ?
    ");
    $stmt->execute([$userId]);
    echo json_encode($stmt->fetchAll());
    exit;
}

// GET specific cart item by ID (must belong to user)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE idcart = ? AND `user` = ?");
    $stmt->execute([$_GET['id'], $userId]);
    $cart = $stmt->fetch();
    if ($cart) {
        echo json_encode($cart);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Cart not found']);
    }
    exit;
}

// POST: Add new cart item (automatically assigned to logged-in user)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['product'], $data['quantity'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing fields']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO cart (`user`, product, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $data['product'], $data['quantity']]);
    echo json_encode(['message' => 'Cart item added', 'id' => $pdo->lastInsertId()]);
    exit;
}

// PUT: Update quantity of a cart item (must belong to user)
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['quantity'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Quantity required']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE idcart = ? AND `user` = ?");
    $stmt->execute([$data['quantity'], $_GET['id'], $userId]);
    echo json_encode(['message' => 'Cart updated']);
    exit;
}

// DELETE: Remove a cart item (must belong to user)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE idcart = ? AND `user` = ?");
    $stmt->execute([$_GET['id'], $userId]);
    echo json_encode(['message' => 'Cart item deleted']);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
