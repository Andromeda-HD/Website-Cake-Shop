<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/auth.php";
require_login('admin');

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit;
?>