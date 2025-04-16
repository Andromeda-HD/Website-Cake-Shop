<?php
function require_login($role = null) {
    if (!isset($_SESSION['user'])) {
        header("Location: ../login.php");
        exit;
    }

    if ($role && $_SESSION['user']['role'] !== $role) {
        echo "Akses ditolak!";
        exit;
    }
}
