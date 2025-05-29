<?php
require_once '../../middleware/authMiddleware.php';

$auth = authenticate(['user', 'admin'], true); // silent = true

if ($auth) {
    if ($auth->role === 'admin') {
        header('Location: ../index.php');
        exit;
    } elseif ($auth->role === 'user') {
        header('Location: ../../user');
        exit;
    }
}

header('Location: login.php');
exit;
?>