<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'pelanggan') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
    header("Location: index.php");
    exit;
}

$alamat = $_POST['alamat'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $alamat) {

    $stmt = $conn->prepare("INSERT INTO pesanan (user_id, alamat, status, created_at) VALUES (?, ?, 'Menunggu Konfirmasi', NOW())");
    $stmt->bind_param("is", $user_id, $alamat);
    $stmt->execute();
    $order_id = $stmt->insert_id;


    $stmt_detail = $conn->prepare("INSERT INTO pesanan_detail (order_id, produk_id, jumlah) VALUES (?, ?, ?)");
    foreach ($keranjang as $produk_id => $jumlah) {
        $stmt_detail->bind_param("iii", $order_id, $produk_id, $jumlah);
        $stmt_detail->execute();
    }

    unset($_SESSION['keranjang']);
    header("Location: feedback.php?pesan=sukses");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Checkout</h2>
    <form method="POST">
        <label>Alamat Pengiriman:</label><br>
        <textarea name="alamat" required></textarea><br><br>
        <button type="submit">Konfirmasi Pesanan</button>
        <a href="keranjang.php">Kembali ke Keranjang</a>
    </form>
</body>
</html>
