<?php
// AUTH API - auth.php
require_once '../config/db.php';
require_once '../vendor/autoload.php';
require_once '../includes/load-env.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = getenv("JWT_SECRET_KEY");
$method = $_SERVER['REQUEST_METHOD'];

function respond($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

function generateToken($id, $role)
{
    global $secret_key;
    $payload = [
        'iss' => 'flower_shop_api',
        'iat' => time(),
        'exp' => time() + (60 * 60 * 24), // 1 day expiry
        'id' => $id,
        'role' => $role
    ];
    return JWT::encode($payload, $secret_key, 'HS256');
}

if ($method === 'POST') {
    $action = $_GET['action'] ?? null;
    $data = json_decode(file_get_contents("php://input"));

    if ($action === 'login-user') {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$data->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data->password, $user['password'])) {
            $token = generateToken($user['iduser'], 'user');
            respond(["token" => $token, "user" => $user]);
        } else {
            respond(["error" => "Invalid credentials"], 401);
        }
    } elseif ($action === 'login-admin') {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$data->email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($data->password, $admin['password'])) {
            $token = generateToken($admin['idadmin'], 'admin');
            respond(["token" => $token, "admin" => $admin]);
        } else {
            respond(["error" => "Invalid credentials"], 401);
        }
    } elseif ($action === 'register-user') {
        $stmt = $pdo->prepare("INSERT INTO user (first_name, last_name, email, password, address, telephone, created_at, modified_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([
            $data->first_name,
            $data->last_name,
            $data->email,
            password_hash($data->password, PASSWORD_BCRYPT),
            $data->address,
            $data->telephone
        ]);
        respond(["message" => "User registered successfully"]);
    } elseif ($action === 'register-admin') {
        $stmt = $pdo->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([
            $data->username,
            $data->email,
            password_hash($data->password, PASSWORD_BCRYPT)
        ]);
        respond(["message" => "Admin registered successfully"]);
    } else {
        respond(["error" => "Invalid action"], 400);
    }
} else {
    respond(["error" => "Method not allowed"], 405);
}
