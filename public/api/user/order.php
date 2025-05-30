<?php
header("Content-Type: application/json");
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';

$auth = authenticate(["user"]);
$user_id = $auth->id;

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['items']) || !is_array($data['items']) || !isset($data['total_amount'])) {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input."]);
        exit();
    }

    $items = $data['items']; // array of [product_id => quantity]
    $total_amount = $data['total_amount'];

    try {
        $pdo->beginTransaction();

        // 1. Insert into order_details
        $stmt = $pdo->prepare("INSERT INTO order_details (`user`, total) VALUES (?, ?)");
        $stmt->execute([$user_id, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // 2. Insert into order_items
        $stmtItem = $pdo->prepare("INSERT INTO order_items (products, `order`) VALUES (?, ?)");
        foreach ($items as $product_id => $qty) {
            for ($i = 0; $i < $qty; $i++) {
                $stmtItem->execute([$product_id, $order_id]);
            }

            // 3. Decrease product quantity
            $pdo->prepare("UPDATE product SET quantity = quantity - ? WHERE idproduct = ?")
                ->execute([$qty, $product_id]);

            // 4. Remove from cart
            $pdo->prepare("DELETE FROM cart WHERE user = ? AND product = ?")
                ->execute([$user_id, $product_id]);
        }

        // 5. Insert into payment_details
        $stmtPay = $pdo->prepare("INSERT INTO payment_details (`order`, amount) VALUES (?, ?)");
        $stmtPay->execute([$order_id, $total_amount]);
        $payment_id = $pdo->lastInsertId();

        // 6. Update order_details with payment ID
        $pdo->prepare("UPDATE order_details SET payment = ? WHERE idorder_details = ?")
            ->execute([$payment_id, $order_id]);

        $pdo->commit();

        echo json_encode([
            "message" => "Checkout successful.",
            "order_id" => $order_id,
            "payment_id" => $payment_id
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(["message" => "Checkout failed.", "error" => $e->getMessage()]);
    }
} elseif ($method === 'GET') {
    // Fetch orders for a user
    if (!isset($_GET['user_id'])) {
        http_response_code(400);
        echo json_encode(["message" => "Missing user_id."]);
        exit();
    }

    $user_id = $_GET['user_id'];

    try {
        $stmt = $pdo->prepare("
            SELECT 
                od.idorder_details AS order_id,
                od.total,
                pd.amount AS payment_amount,
                GROUP_CONCAT(p.name SEPARATOR ', ') AS products
            FROM order_details od
            LEFT JOIN order_items oi ON oi.`order` = od.idorder_details
            LEFT JOIN product p ON p.idproduct = oi.products
            LEFT JOIN payment_details pd ON pd.`order` = od.idorder_details
            WHERE od.user = ?
            GROUP BY od.idorder_details
            ORDER BY od.idorder_details DESC
        ");
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "message" => "Orders fetched successfully.",
            "orders" => $orders
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Failed to fetch orders.", "error" => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
