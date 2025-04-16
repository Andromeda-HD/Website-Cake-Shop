<?php
$host = "sql308.infinityfree.com";
$user = "if0_38759814";
$pass = "bEl9BX2OTalCe";
$db_name = "if0_38759814_sweetbite";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
