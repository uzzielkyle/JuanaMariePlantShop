<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../middleware/authMiddleware.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

function respond($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

function cleanAndEncodeProducts($products) {
    return array_map(function($product) {
        $cleaned = [];
        foreach ($product as $key => $value) {
            $key = trim($key);
            if ($key === 'photo' && !empty($value)) {
                $value = base64_encode($value);
            }
            $cleaned[$key] = $value;
        }
        return $cleaned;
    }, $products);
}

function cleanAndEncodeProduct($product) {
    $cleaned = [];
    foreach ($product as $key => $value) {
        $key = trim($key);
        if ($key === 'photo' && !empty($value)) {
            $value = base64_encode($value);
        }
        $cleaned[$key] = $value;
    }
    return $cleaned;
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
    $products = cleanAndEncodeProducts($products);
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
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $product = cleanAndEncodeProduct($product);
        respond($product);
    } else {
        respond(['error' => 'Product not found'], 404);
    }
}

respond(['error' => 'Method not allowed'], 405);
