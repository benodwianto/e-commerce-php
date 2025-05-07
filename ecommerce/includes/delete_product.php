<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
checkAdminRole();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 1. Ambil info gambar sebelum hapus
    $sql = "SELECT image FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    // 2. Hapus gambar dari folder jika ada
    if (!empty($row['image'])) {
        $image_path = "../assets/images/products/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Hapus file
        }
    }
    
    // 3. Hapus data dari database
    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil dihapus'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menghapus produk'];
    }
}

// Redirect kembali ke halaman produk
header("Location: products.php");
exit;
?>