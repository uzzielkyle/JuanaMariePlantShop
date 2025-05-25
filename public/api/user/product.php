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

function respond($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

// GET all products with categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("
        SELECT 
            p.*, 
            GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
        FROM product p
        LEFT JOIN product_has_category pc ON p.idproduct = pc.product_idproduct
        LEFT JOIN category c ON pc.category_idcategory = c.idcategory
        GROUP BY p.idproduct
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    respond($products);
}

// GET product by id with categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("
        SELECT 
            p.*, 
            GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
        FROM product p
        LEFT JOIN product_has_category pc ON p.idproduct = pc.product_idproduct
        LEFT JOIN category c ON pc.category_idcategory = c.idcategory
        WHERE p.idproduct = ?
        GROUP BY p.idproduct
    ");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();

    if ($product) {
        respond($product);
    } else {
        respond(['error' => 'Product not found'], 404);
    }
}

respond(['error' => 'Method not allowed'], 405);
