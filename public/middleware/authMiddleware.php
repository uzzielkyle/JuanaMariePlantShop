<?php
// authMiddleware.php

require_once __DIR__ . "/../vendor/autoload.php";
include_once __DIR__ . "/../includes/load-env.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = getenv("JWT_SECRET_KEY");

/**
 * Extract Bearer token from Authorization header or fallback to cookie
 * @return string|null
 */
function getBearerToken()
{
    $headers = null;

    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(
            array_map('ucwords', array_keys($requestHeaders)),
            array_values($requestHeaders)
        );
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }

    // Check Authorization: Bearer <token>
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }

    // Fallback: check token cookie
    if (!empty($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }

    return null;
}

/**
 * Authenticate JWT token and enforce role-based access control.
 * @param array $allowed_roles List of allowed roles. Empty = any valid token
 * @param bool $silent If true, don't exit on failure, just return null
 * @return object|null Decoded JWT payload or null if silent failure
 */
function authenticate(array $allowed_roles = [], bool $silent = false)
{
    global $secret_key;
    $token = getBearerToken();

    if (!$token) {
        if ($silent) return null;
        http_response_code(401);
        echo json_encode(["error" => "Access token not provided"]);
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));

        if (!empty($allowed_roles) && (!isset($decoded->role) || !in_array($decoded->role, $allowed_roles))) {
            if ($silent) return null;
            http_response_code(403);
            echo json_encode(["error" => "Access forbidden: insufficient permissions"]);
            exit;
        }

        return $decoded;
    } catch (Exception $e) {
        if ($silent) return null;
        http_response_code(401);
        echo json_encode(["error" => "Invalid token: " . $e->getMessage()]);
        exit;
    }
}
