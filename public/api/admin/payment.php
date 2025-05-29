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

// GET all payments
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("SELECT * FROM payment_details");
    $payments = $stmt->fetchAll();
    respond($payments);
}

// GET payment by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM payment_details WHERE idpayment_details = ?");
    $stmt->execute([$paymentId]);
    $payment = $stmt->fetch();

    if (!$payment) {
        respond(['error' => 'Payment not found'], 404);
    }

    respond($payment);
}

// POST create new payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $required = ['user_id', 'order_id', 'payment_method', 'amount', 'payment_status'];

    foreach ($required as $field) {
        if (!isset($data[$field])) {
            respond(['error' => "Missing field: $field"], 400);
        }
    }

    // Validate user
    $stmtUser = $pdo->prepare("SELECT * FROM user WHERE iduser = ?");
    $stmtUser->execute([$data['user_id']]);
    if (!$stmtUser->fetch()) {
        respond(['error' => 'Invalid user ID'], 400);
    }

    // Validate order
    $stmtOrder = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ?");
    $stmtOrder->execute([$data['order_id']]);
    if (!$stmtOrder->fetch()) {
        respond(['error' => 'Invalid order ID'], 400);
    }

    $stmt = $pdo->prepare("INSERT INTO payment_details (user_id, order_id, payment_method, amount, payment_status, payment_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $data['user_id'],
        $data['order_id'],
        $data['payment_method'],
        $data['amount'],
        $data['payment_status']
    ]);

    $paymentId = $pdo->lastInsertId();
    respond(['message' => 'Payment created', 'id' => $paymentId], 201);
}

// PUT update payment by id
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    $fields = ['user_id', 'order_id', 'payment_method', 'amount', 'payment_status'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            // Validate user if updating user_id
            if ($field === 'user_id') {
                $stmtUser = $pdo->prepare("SELECT * FROM user WHERE iduser = ?");
                $stmtUser->execute([$data[$field]]);
                if (!$stmtUser->fetch()) {
                    respond(['error' => 'Invalid user ID'], 400);
                }
            }
            // Validate order if updating order_id
            if ($field === 'order_id') {
                $stmtOrder = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ?");
                $stmtOrder->execute([$data[$field]]);
                if (!$stmtOrder->fetch()) {
                    respond(['error' => 'Invalid order ID'], 400);
                }
            }
            $updates[] = "$field = ?";
            $values[] = $data[$field];
        }
    }

    if (!empty($updates)) {
        $values[] = $paymentId;
        $stmt = $pdo->prepare("UPDATE payment_details SET " . implode(', ', $updates) . " WHERE idpayment_details = ?");
        $stmt->execute($values);
        respond(['message' => 'Payment updated']);
    } else {
        respond(['error' => 'No valid fields to update'], 400);
    }
}

// DELETE payment by id
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];

    $stmtCheck = $pdo->prepare("SELECT * FROM payment_details WHERE idpayment_details = ?");
    $stmtCheck->execute([$paymentId]);
    if (!$stmtCheck->fetch()) {
        respond(['error' => 'Payment not found'], 404);
    }

    $pdo->prepare("DELETE FROM payment_details WHERE idpayment_details = ?")->execute([$paymentId]);
    respond(['message' => 'Payment deleted']);
}

respond(['error' => 'Method not allowed'], 405);
