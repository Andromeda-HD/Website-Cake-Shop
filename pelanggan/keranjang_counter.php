<?php
session_start();
$total = isset($_SESSION['keranjang']) ? array_sum($_SESSION['keranjang']) : 0;
header('Content-Type: application/json');
echo json_encode(['total' => $total]);
