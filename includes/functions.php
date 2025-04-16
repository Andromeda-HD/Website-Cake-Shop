<?php
function is_logged_in() {
    return isset($_SESSION['user']);
}


function is_admin() {
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}

function is_pelanggan() {
    return is_logged_in() && $_SESSION['user']['role'] === 'pelanggan';
}

function is_kurir() {
    return is_logged_in() && $_SESSION['user']['role'] === 'kurir';
}


function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("Location: /sweetbite/login.php");
        exit;
    }
}


function format_rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}


function set_flash($msg) {
    $_SESSION['flash'] = $msg;
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return '';
}
?>
