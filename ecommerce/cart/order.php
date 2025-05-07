<?php
session_start();
require '../includes/config.php';

// Ambil total harga dari POST
$total_harga = (int)$_POST['total_harga'];
$tanggal_order = date('Y-m-d H:i:s');
$id_user = $_SESSION['user_id'] ?? null; // jika ada sistem login

// Ambil data dari keranjang dan join dengan produk
$query = "SELECT k.id_product, k.jumlah, p.name AS nama_produk, p.price AS harga 
          FROM keranjang k
          JOIN products p ON k.id_product = p.id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Keranjang kosong.";
    exit;
}

// Simpan tiap item ke tabel `order`
while ($row = mysqli_fetch_assoc($result)) {
    $id_product = $row['id_product'];
    $nama_produk = mysqli_real_escape_string($conn, $row['nama_produk']);
    $harga = (int)$row['harga'];
    $jumlah = (int)$row['jumlah'];
    $subtotal = $harga * $jumlah;

    mysqli_query($conn, "INSERT INTO `order` 
        (`id_product`, `nama_produk`, `harga`, `jumlah`, `subtotal`, `tanggal_order`, `id_user`) 
        VALUES 
        ($id_product, '$nama_produk', $harga, $jumlah, $subtotal, '$tanggal_order', " . ($id_user ? $id_user : "NULL") . ")
    ");
}

$_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil dipesan'];
header("Location: ../index.php");
exit;
