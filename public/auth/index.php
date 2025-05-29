<?php
require_once '../middleware/authMiddleware.php';

$auth = authenticate(['user'], true); // silent = true

if ($auth) {
    if ($auth->role === 'user') {
        header('Location: ../user');
        exit;
    }
}

header('Location: login.php');
exit;
