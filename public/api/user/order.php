<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

function respond($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

$auth = authenticate(['user']);
if (!$auth) {
    respond(['error' => 'Unauthorized'], 403);
}

$userId = $auth->id;

// GET all user's orders with items and products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM order_details WHERE user = ?");
    $stmt->execute([$userId]);
    $orders = $stmt->fetchAll();

    foreach ($orders as &$order) {
        $stmtItems = $pdo->prepare("
            SELECT oi.idorder_items, oi.products AS product_id, p.name, p.price 
            FROM order_items oi 
            JOIN product p ON oi.products = p.idproduct 
            WHERE oi.`order` = ?
        ");
        $stmtItems->execute([$order['idorder_details']]);
        $order['items'] = $stmtItems->fetchAll();
    }
    respond($orders);
}

// GET specific user's order by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ? AND user = ?");
    $stmt->execute([$orderId, $userId]);
    $order = $stmt->fetch();

    if (!$order) {
        respond(['error' => 'Order not found'], 404);
    }

    $stmtItems = $pdo->prepare("
        SELECT oi.idorder_items, oi.products AS product_id, p.name, p.price 
        FROM order_items oi 
        JOIN product p ON oi.products = p.idproduct 
        WHERE oi.`order` = ?
    ");
    $stmtItems->execute([$orderId]);
    $order['items'] = $stmtItems->fetchAll();

    respond($order);
}

// POST create new order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
        respond(['error' => 'Order items required'], 400);
    }

    // Calculate total price from products and quantities
    $total = 0;
    foreach ($data['items'] as $item) {
        if (!isset($item['product_id'])) {
            respond(['error' => 'Product ID missing in order items'], 400);
        }
        $stmt = $pdo->prepare("SELECT price FROM product WHERE idproduct = ?");
        $stmt->execute([$item['product_id']]);
        $product = $stmt->fetch();
        if (!$product) {
            respond(['error' => 'Invalid product ID: ' . $item['product_id']], 400);
        }
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
        $total += $product['price'] * $quantity;
    }

    // Insert order_details
    $stmtOrder = $pdo->prepare("INSERT INTO order_details (`user`, total) VALUES (?, ?)");
    $stmtOrder->execute([$userId, $total]);
    $orderId = $pdo->lastInsertId();

    // Insert order_items (note: here quantity is not saved since your order_items table doesn’t have it)
    $stmtItem = $pdo->prepare("INSERT INTO order_items (products, `order`) VALUES (?, ?)");
    foreach ($data['items'] as $item) {
        $stmtItem->execute([$item['product_id'], $orderId]);
    }

    respond(['message' => 'Order created', 'order_id' => $orderId], 201);
}

// DELETE cancel user's order
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Check ownership
    $stmtCheck = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ? AND user = ?");
    $stmtCheck->execute([$orderId, $userId]);
    if (!$stmtCheck->fetch()) {
        respond(['error' => 'Order not found or unauthorized'], 404);
    }

    // Delete order items and order
    $pdo->prepare("DELETE FROM order_items WHERE `order` = ?")->execute([$orderId]);
    $pdo->prepare("DELETE FROM order_details WHERE idorder_details = ?")->execute([$orderId]);

    respond(['message' => 'Order cancelled']);
}

respond(['error' => 'Method not allowed'], 405);
