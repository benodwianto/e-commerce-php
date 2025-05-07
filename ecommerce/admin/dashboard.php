<?php
session_start();
include '../includes/config.php';

// Cek apakah user adalah admin
// if (isset($_SESSION['role'] != 'admin') {
//   header('Location: ../login.php');
//   exit;
// }

include '../includes/header_admin.php';
?>


<div class="container mt-2 pt-5">
  <h1 class="mb-4 text-dark">📊 Dashboard Admin</h1>
  <div class="row g-4">
    <!-- Produk -->
    <div class="col-md-6">
      <div class="card text-white shadow h-100" style="background-color: #726763;">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-box-seam-fill me-2"></i>Produk</h5>
          <p class="card-text">Kelola produk toko Anda di sini.</p>
          <a href="products.php" class="btn btn-light btn-sm px-4">Lihat Produk</a>
        </div>
      </div>
    </div>
    <!-- Pesanan -->
    <div class="col-md-6">
      <div class="card text-white shadow h-100" style="background-color: #726763;">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-bag-fill me-2"></i>Pesanan</h5>
          <p class="card-text">Pantau pesanan dari pelanggan.</p>
          <a href="orders.php" class="btn btn-light btn-sm px-4">Lihat Pesanan</a>
        </div>
      </div>
    </div>
    <!-- Pengguna -->
    <div class="col-md-6">
      <div class="card text-white shadow h-100" style="background-color: #726763;">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Pengguna</h5>
          <p class="card-text">Kelola akun pengguna.</p>
          <a href="users.php" class="btn btn-light btn-sm px-4">Lihat Pengguna</a>
        </div>
      </div>
    </div>
    <!-- Tambahan -->
    <div class="col-md-6">
      <div class="card text-white shadow h-100" style="background-color: #726763;">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-chat-fill me-2"></i>Feedback User</h5>
          <p class="card-text">Komentar dan saran dari pelanggan</p>
          <a href="feedback.php" class="btn btn-light btn-sm px-4">Pengaturan</a>
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
  body {
    background-color: #f8f9fa;
  }
</style>


<?php include '../includes/footer.php'; ?>