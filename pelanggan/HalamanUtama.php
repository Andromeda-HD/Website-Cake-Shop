<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_login('pelanggan');

$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY created_at DESC");
$produk = [];
while ($row = mysqli_fetch_assoc($result)) {
    $produk[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBite - Toko Kue</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>SweetBite</h1>
        <nav>
        <a href="../logout.php" class="logout-btn">Logout</a>
        </nav>
        <div class="cart-icon">
            <a href="keranjang.php">🛒 <span id="cart-count">0</span></a>
        </div>
    </header>

    <main class="container">
        <h2>Daftar Produk</h2>
        <div class="produk-list">
            <?php foreach ($produk as $p): ?>
                <div class="produk-card">
                    <img src="../uploads/<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>">
                    <h3><?= htmlspecialchars($p['nama']) ?></h3>
                    <p><?= htmlspecialchars($p['deskripsi']) ?></p>
                    <p><strong>Rp <?= number_format($p['harga'], 0, ',', '.') ?></strong></p>
                    <button onclick="tambahKeKeranjang(<?= $p['id'] ?>)">Pesan</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function tambahKeKeranjang(produkId) {
            fetch('tambah_keranjang.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'produk_id=' + produkId
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.total;
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            fetch('keranjang_counter.php')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.total;
                });
        });
    </script>
</body>
</html>
