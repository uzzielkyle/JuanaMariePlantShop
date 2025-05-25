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

// GET all payments for this user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM payment_details WHERE user_id = ?");
    $stmt->execute([$userId]);
    $payments = $stmt->fetchAll();
    respond($payments);
}

// GET payment by id (only if belongs to user)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM payment_details WHERE idpayment_details = ? AND user_id = ?");
    $stmt->execute([$paymentId, $userId]);
    $payment = $stmt->fetch();

    if (!$payment) {
        respond(['error' => 'Payment not found'], 404);
    }

    respond($payment);
}

// POST create new payment record for this user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $required = ['order_id', 'payment_method', 'amount', 'payment_status'];

    foreach ($required as $field) {
        if (!isset($data[$field])) {
            respond(['error' => "Missing field: $field"], 400);
        }
    }

    // Optional: Validate order belongs to user
    $stmtOrder = $pdo->prepare("SELECT * FROM order_details WHERE idorder_details = ? AND user = ?");
    $stmtOrder->execute([$data['order_id'], $userId]);
    if (!$stmtOrder->fetch()) {
        respond(['error' => 'Invalid order ID or unauthorized'], 400);
    }

    $stmt = $pdo->prepare("INSERT INTO payment_details (user_id, order_id, payment_method, amount, payment_status, payment_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $userId,
        $data['order_id'],
        $data['payment_method'],
        $data['amount'],
        $data['payment_status']
    ]);

    $paymentId = $pdo->lastInsertId();
    respond(['message' => 'Payment recorded', 'id' => $paymentId], 201);
}

// PUT update payment record by id (only own)
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    // Check ownership
    $stmtCheck = $pdo->prepare("SELECT * FROM payment_details WHERE idpayment_details = ? AND user_id = ?");
    $stmtCheck->execute([$paymentId, $userId]);
    if (!$stmtCheck->fetch()) {
        respond(['error' => 'Payment not found or unauthorized'], 404);
    }

    $fields = ['payment_method', 'amount', 'payment_status'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
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

// DELETE payment record by id (only own)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $paymentId = $_GET['id'];

    $stmtCheck = $pdo->prepare("SELECT * FROM payment_details WHERE idpayment_details = ? AND user_id = ?");
    $stmtCheck->execute([$paymentId, $userId]);
    if (!$stmtCheck->fetch()) {
        respond(['error' => 'Payment not found or unauthorized'], 404);
    }

    $pdo->prepare("DELETE FROM payment_details WHERE idpayment_details = ?")->execute([$paymentId]);
    respond(['message' => 'Payment deleted']);
}

respond(['error' => 'Method not allowed'], 405);
