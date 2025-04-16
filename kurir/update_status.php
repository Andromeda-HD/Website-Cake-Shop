<?php
session_start();
require_once('../includes/db.php');


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'kurir') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];


    $allowed_status = ['Dikirim', 'Diterima'];
    if (!in_array($status, $allowed_status)) {
        die("Status tidak valid.");
    }

    $stmt = $conn->prepare("UPDATE pesanan SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?update=success");
        exit;
    } else {
        die("Gagal update status.");
    }
} else {
    header("Location: dashboard.php");
    exit;
}
