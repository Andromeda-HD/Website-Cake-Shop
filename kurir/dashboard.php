<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'kurir') {
    header("Location: ../login.php");
    exit;
}

$query = "
    SELECT p.id, u.username AS nama_user, p.alamat, p.status, p.created_at
    FROM pesanan p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
";
$result = mysqli_query($conn, $query);

$pesanan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['id'];
    $detail_result = mysqli_query($conn, "
        SELECT pd.jumlah, pr.nama
        FROM pesanan_detail pd
        JOIN produk pr ON pd.produk_id = pr.id
        WHERE pd.order_id = $order_id
    ");
    
    $detail = [];
    while ($d = mysqli_fetch_assoc($detail_result)) {
        $detail[] = $d;
    }

    $row['detail'] = $detail;
    $pesanan[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h2>Dashboard Kurir</h2>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </header>

    <div class="container">

        <?php foreach ($pesanan as $p): ?>
            <div class="order-box">
                <h3>Pesanan #<?= $p['id'] ?></h3>
                <p><strong>Pemesan:</strong> <?= htmlspecialchars($p['nama_user']) ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($p['alamat']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($p['status']) ?></p>
                <p><strong>Waktu Pesan:</strong> <?= $p['created_at'] ?></p>
                <p><strong>Produk:</strong></p>
                <ul>
                    <?php foreach ($p['detail'] as $d): ?>
                        <li><?= $d['nama'] ?> (<?= $d['jumlah'] ?>)</li>
                    <?php endforeach; ?>
                </ul>

                <form method="POST" action="update_status.php">
                    <input type="hidden" name="order_id" value="<?= $p['id'] ?>">
                    <select name="status" required>
                        <option value="">-- Ubah Status --</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Diterima">Diterima</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</body>
</html>
