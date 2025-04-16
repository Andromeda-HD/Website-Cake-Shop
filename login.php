<?php
session_start();
require_once "includes/db.php";

$error = '';
$login_attempts = $_SESSION['login_attempts'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($login_attempts >= 3) {
        $error = "Terlalu banyak percobaan login. Silakan coba lagi nanti.";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $error = "Username dan password tidak boleh kosong.";
        } else {

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && $password == $user['password']) {

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $_SESSION['login_attempts'] = 0;


                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($user['role'] === 'pelanggan') {
                    header("Location: pelanggan/HalamanUtama.php");
                } elseif ($user['role'] === 'kurir') {
                    header("Location: kurir/dashboard.php");
                } else {
                    $error = "Role tidak dikenali.";
                }
                exit;
            } else {
                $_SESSION['login_attempts'] = $login_attempts + 1;
                $error = "Username atau password salah.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - SweetBite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
