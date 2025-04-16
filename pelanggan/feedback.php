<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$feedback_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $isi = trim($_POST['isi']);
    $rating = intval($_POST['rating']);

    if (!empty($isi) && $rating >= 1 && $rating <= 5) {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, isi, rating, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("isi", $user_id, $isi, $rating);
        $stmt->execute();

        $feedback_msg = "Terima kasih atas ulasannya!";
    } else {
        $feedback_msg = "Isi feedback dan rating wajib diisi (1–5).";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Pengguna</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Feedback & Ulasan</h2>
    <?php if (!empty($feedback_msg)): ?>
        <p><?= htmlspecialchars($feedback_msg) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Ulasan Anda:</label><br>
        <textarea name="isi" placeholder="Tulis pendapatmu tentang produk atau situs ini..." required></textarea><br><br>

        <label>Rating (1–5):</label><br>
        <input type="number" name="rating" min="1" max="5" required><br><br>

        <button type="submit">Kirim Feedback</button>
    </form>

    <hr>
    <h3>Ulasan Lainnya</h3>
    <?php
    $result = $conn->query("SELECT f.isi, f.rating, f.created_at, u.username FROM feedback f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC");

    while ($row = $result->fetch_assoc()):
    ?>
        <div class="feedback-box">
            <strong><?= htmlspecialchars($row['username']) ?></strong> (<?= $row['rating'] ?>/5)<br>
            <small><?= $row['created_at'] ?></small>
            <p><?= htmlspecialchars($row['isi']) ?></p>
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?= $i <= $row['rating'] ? '⭐' : '☆' ?>
                <?php endfor; ?>
            </div>
        </div>
        <hr>
    <?php endwhile; ?>
    <a href="HalamanUtama.php" style="display:inline-block; margin-top:20px;" class="back-to-home">← Kembali ke Halaman Utama</a>
</body>
</html>
