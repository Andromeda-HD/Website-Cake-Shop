<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/auth.php";
require_login('admin');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $harga = intval($_POST['harga']);

    if ($_FILES['gambar']['error'] === 0) {
        $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            $error = "Format gambar tidak didukung. Gunakan JPG, PNG, atau GIF.";
        } elseif ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
            $error = "Ukuran gambar terlalu besar. Maksimal 2MB.";
        } else {
            $gambar = time() . '_' . uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/$gambar");
        }
    } else {
        $error = "Upload gambar gagal!";
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO produk (nama, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssis", $nama, $deskripsi, $harga, $gambar);
            $stmt->execute();
            header("Location: dashboard.php?msg=berhasil_tambah");
            exit;
        } else {
            $error = "Terjadi kesalahan saat menyimpan produk.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Tambah Produk</h2>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Produk:</label>
        <input type="text" name="nama" placeholder="Nama Produk" required>

        <label>Deskripsi:</label>
        <textarea name="deskripsi" placeholder="Deskripsi Produk" required></textarea>

        <label>Harga:</label>
        <input type="number" name="harga" placeholder="Harga" required>

        <label>Gambar:</label>
        <input type="file" name="gambar" accept="image/*" required>

        <button type="submit">Simpan</button>
        <a href="dashboard.php">Kembali</a>
    </form>
</body>
</html>
