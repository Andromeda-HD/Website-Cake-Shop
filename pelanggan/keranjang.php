<?php
// keranjang.php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login('pelanggan');

$keranjang = $_SESSION['keranjang'] ?? [];
$produk_data = [];
$total = 0;

if (!empty($keranjang)) {
    $ids = implode(',', array_keys($keranjang));
    $query = "SELECT * FROM produk WHERE id IN ($ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['jumlah'] = $keranjang[$row['id']];
        $row['subtotal'] = $row['jumlah'] * $row['harga'];
        $total += $row['subtotal'];
        $produk_data[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keranjang</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <h1>Keranjang Belanja</h1>
    <nav><a href="HalamanUtama.php">Kembali ke Toko</a></nav>
</header>
<main>
<?php if (empty($produk_data)): ?>
    <p>Keranjang kosong.</p>
<?php else: ?>
    <table>
        <thead>
            <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
        <?php foreach ($produk_data as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nama']) ?></td>
                <td>Rp<?= number_format($item['harga']) ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td>Rp<?= number_format($item['subtotal']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p><strong>Total: Rp<?= number_format($total) ?></strong></p>
    <form action="checkout.php" method="post">
        <label>Alamat Pengiriman:</label><br>
        <textarea name="alamat" required></textarea><br><br>
        <button type="submit">Checkout</button>
    </form>
<?php endif; ?>
</main>
</body>
</html>
