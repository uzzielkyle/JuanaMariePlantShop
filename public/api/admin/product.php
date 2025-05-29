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

// GET all products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $stmt = $pdo->query("SELECT idproduct, name, price, quantity, photo, description, history, care_guide, propagation, difficulty, sunlight, watering_schedule FROM product");
    $products = $stmt->fetchAll();

    foreach ($products as &$product) {
        // base64 encode photo blob if present
        if (!empty($product['photo'])) {
            $product['photo'] = base64_encode($product['photo']);
        } else {
            $product['photo'] = null;
        }

        // fetch categories
        $stmtCat = $pdo->prepare("SELECT category_idcategory FROM product_has_category WHERE product_idproduct = ?");
        $stmtCat->execute([$product['idproduct']]);
        $product['categories'] = array_column($stmtCat->fetchAll(), 'category_idcategory');
    }

    respond($products);
}

// GET product by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT idproduct, name, price, quantity, photo, description, history, care_guide, propagation, difficulty, sunlight, watering_schedule FROM product WHERE idproduct = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    if (!$product) {
        respond(['error' => 'Product not found'], 404);
    }

    // base64 encode photo blob if present
    if (!empty($product['photo'])) {
        $product['photo'] = base64_encode($product['photo']);
    } else {
        $product['photo'] = null;
    }

    $stmtCat = $pdo->prepare("SELECT category_idcategory FROM product_has_category WHERE product_idproduct = ?");
    $stmtCat->execute([$product['idproduct']]);
    $product['categories'] = array_column($stmtCat->fetchAll(), 'category_idcategory');

    respond($product);
}

// POST create new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $required = ['name', 'price', 'description'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            respond(['error' => "Missing field: $field"], 400);
        }
    }

    $fields = ['name', 'price', 'quantity', 'photo', 'description', 'history', 'care_guide', 'propagation', 'difficulty', 'sunlight', 'watering_schedule'];
    $placeholders = [];
    $values = [];

    $data['quantity'] = 0; // default

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $placeholders[] = $field;
            if ($field === 'photo') {
                $values[] = base64_decode($data[$field]);
            } else {
                $values[] = $data[$field];
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO product (" . implode(", ", $placeholders) . ") VALUES (" . rtrim(str_repeat('?, ', count($values)), ', ') . ")");
    $stmt->execute($values);

    $productId = $pdo->lastInsertId();

    if (isset($data['categories']) && is_array($data['categories'])) {
        $stmtCat = $pdo->prepare("INSERT INTO product_has_category (product_idproduct, category_idcategory) VALUES (?, ?)");
        foreach ($data['categories'] as $catId) {
            $stmtCat->execute([$productId, $catId]);
        }
    }

    respond(['message' => 'Product created', 'id' => $productId], 201);
}

// PUT update product
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    $fields = ['name', 'price', 'quantity', 'photo', 'description', 'history', 'care_guide', 'propagation', 'difficulty', 'sunlight', 'watering_schedule'];
    $updates = [];
    $values = [];

    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $updates[] = "$field = ?";
            $values[] = $field === 'photo' ? base64_decode($data[$field]) : $data[$field];
        }
    }

    if (!empty($updates)) {
        $values[] = $productId;
        $stmt = $pdo->prepare("UPDATE product SET " . implode(', ', $updates) . " WHERE idproduct = ?");
        $stmt->execute($values);
    }

    if (isset($data['categories']) && is_array($data['categories'])) {
        $pdo->prepare("DELETE FROM product_has_category WHERE product_idproduct = ?")->execute([$productId]);
        $stmtCat = $pdo->prepare("INSERT INTO product_has_category (product_idproduct, category_idcategory) VALUES (?, ?)");
        foreach ($data['categories'] as $catId) {
            $stmtCat->execute([$productId, $catId]);
        }
    }

    respond(['message' => 'Product updated']);
}

// DELETE product
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Check if product exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM product WHERE idproduct = ?");
    $stmt->execute([$productId]);
    if ($stmt->fetchColumn() == 0) {
        respond(['error' => 'Product not found'], 404);
    }

    $pdo->prepare("DELETE FROM product_has_category WHERE product_idproduct = ?")->execute([$productId]);
    $pdo->prepare("DELETE FROM product WHERE idproduct = ?")->execute([$productId]);

    respond(['message' => 'Product deleted']);
}

respond(['error' => 'Method not allowed'], 405);
