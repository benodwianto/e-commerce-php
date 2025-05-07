<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['product_id'], $_POST['jumlah'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = intval($_SESSION['user_id']);
    $jumlah = intval($_POST['jumlah']);

    // Cek apakah produk sudah ada di keranjang
    $check = $conn->query("SELECT * FROM keranjang WHERE user_id = $user_id AND id_product = $product_id");
    if ($check->num_rows > 0) {
        // Jika sudah ada, update jumlahnya
        $sql = "UPDATE keranjang SET jumlah = jumlah + $jumlah WHERE user_id = $user_id AND id_product = $product_id";
    } else {
        // Jika belum, insert baru
        $sql = "INSERT INTO keranjang (user_id, id_product, jumlah) VALUES ($user_id, $product_id, $jumlah)";
    }

    if ($conn->query($sql)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil ditambahkan ke keranjang'];
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menambahkan produk'];
        header("Location: ../index.php");
        exit;
    }
}
