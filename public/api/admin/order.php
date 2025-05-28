<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

function respond($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

$auth = authenticate(['admin']);
if (!$auth || $auth->role !== 'admin') {
    respond(['error' => 'Unauthorized'], 403);
}

// GET all orders with items and products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("SELECT * FROM order_details");
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

// GET order by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ?");
    $stmt->execute([$orderId]);
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

// POST create new order (admin can create for any user)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user']) || !isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
        respond(['error' => 'User ID and order items are required'], 400);
    }

    // Validate user exists
    $stmtUser = $pdo->prepare("SELECT * FROM user WHERE iduser = ?");
    $stmtUser->execute([$data['user']]);
    if (!$stmtUser->fetch()) {
        respond(['error' => 'Invalid user ID'], 400);
    }

    // Calculate total
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
    $stmtOrder->execute([$data['user'], $total]);
    $orderId = $pdo->lastInsertId();

    // Insert order_items
    $stmtItem = $pdo->prepare("INSERT INTO order_items (products, `order`) VALUES (?, ?)");
    foreach ($data['items'] as $item) {
        $stmtItem->execute([$item['product_id'], $orderId]);
    }

    respond(['message' => 'Order created', 'order_id' => $orderId], 201);
}

// PUT update order by id
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    // Allow updating total or user (if needed), but better to recalc total based on items ideally
    $fields = ['total', 'user'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            // Validate user if updating user
            if ($field === 'user') {
                $stmtUser = $pdo->prepare("SELECT * FROM user WHERE iduser = ?");
                $stmtUser->execute([$data[$field]]);
                if (!$stmtUser->fetch()) {
                    respond(['error' => 'Invalid user ID'], 400);
                }
            }
            $updates[] = "$field = ?";
            $values[] = $data[$field];
        }
    }

    if (!empty($updates)) {
        $values[] = $orderId;
        $stmt = $pdo->prepare("UPDATE order_details SET " . implode(', ', $updates) . " WHERE idorder_details = ?");
        $stmt->execute($values);
    }

    // Optionally update order_items if items array is provided
    if (isset($data['items']) && is_array($data['items'])) {
        // Delete existing order items
        $pdo->prepare("DELETE FROM order_items WHERE `order` = ?")->execute([$orderId]);

        $stmtItem = $pdo->prepare("INSERT INTO order_items (products, `order`) VALUES (?, ?)");
        foreach ($data['items'] as $item) {
            if (!isset($item['product_id'])) {
                respond(['error' => 'Product ID missing in order items'], 400);
            }
            $stmtItem->execute([$item['product_id'], $orderId]);
        }
    }

    respond(['message' => 'Order updated']);
}

// DELETE order by id
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $orderId = $_GET['id'];

    $stmtCheck = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ?");
    $stmtCheck->execute([$orderId]);
    if (!$stmtCheck->fetch()) {
        respond(['error' => 'Order not found'], 404);
    }

    $pdo->prepare("DELETE FROM order_items WHERE `order` = ?")->execute([$orderId]);
    $pdo->prepare("DELETE FROM order_details WHERE idorder_details = ?")->execute([$orderId]);

    respond(['message' => 'Order deleted']);
}

respond(['error' => 'Method not allowed'], 405);
