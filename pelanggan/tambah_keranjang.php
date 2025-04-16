<?php
session_start();
require_once '../includes/auth.php';
require_login('pelanggan');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produk_id'])) {
    $produk_id = intval($_POST['produk_id']);

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$produk_id])) {
        $_SESSION['keranjang'][$produk_id]++;
    } else {
        $_SESSION['keranjang'][$produk_id] = 1;
    }

    $total = array_sum($_SESSION['keranjang']);

    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'total' => $total]);
    exit;
}

http_response_code(400);
echo json_encode(['status' => 'error']);
