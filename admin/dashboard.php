<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$query = "SELECT * FROM produk ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$produk = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
        <nav>
            <ul>
                <li><a href="tambah_produk.php">Tambah Produk</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Daftar Produk</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nama']) ?></td>
                        <td><?= htmlspecialchars($p['deskripsi']) ?></td>
                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td><img src="../uploads/<?= htmlspecialchars($p['gambar']) ?>" width="100" alt="<?= htmlspecialchars($p['nama']) ?>"></td>
                        <td>
                            <a href="edit_produk.php?id=<?= $p['id'] ?>">Edit</a> |
                            <a href="hapus_produk.php?id=<?= $p['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
