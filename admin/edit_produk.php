<?php
session_start();

include_once '../includes/db.php';
include_once '../includes/auth.php';
require_login('admin');

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$id = intval($_GET['id']);
$query = "SELECT * FROM produk WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    die("Produk tidak ditemukan.");
}

$produk = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = intval($_POST['harga']);
    $gambar = $produk['gambar']; // default: gambar lama

    // Proses upload gambar baru (jika ada)
    if ($_FILES['gambar']['name']) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($ext), $allowed_ext)) {
            die("Tipe file tidak diperbolehkan.");
        }

        $gambar = time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/$gambar");
    }

    // Update produk
    $update = $conn->prepare("UPDATE produk SET nama = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?");
    $update->bind_param("ssisi", $nama, $deskripsi, $harga, $gambar, $id);

    if ($update->execute()) {
        header("Location: dashboard.php?msg=sukses_update");
        exit;
    } else {
        echo "Gagal mengupdate produk: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Edit Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" value="<?= $produk['harga'] ?>" required><br><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br>
        <small>Gambar saat ini: <?= htmlspecialchars($produk['gambar']) ?></small><br><br>

        <button type="submit">Update</button>
        <a href="dashboard.php">Kembali</a>
    </form>
</body>
</html>
