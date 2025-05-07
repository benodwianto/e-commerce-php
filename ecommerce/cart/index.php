<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id_user_terlogin = $_SESSION['user_id'] ?? 1;

// Ambil semua item keranjang pengguna dan gabungkan dengan informasi produk
$query_keranjang = "SELECT k.id, k.id_product, k.jumlah, p.name AS nama_produk, p.price AS harga, p.image AS gambar
                    FROM keranjang k
                    JOIN products p ON k.id_product = p.id
                    WHERE k.user_id = ?";
$stmt_keranjang = mysqli_prepare($conn, $query_keranjang);
mysqli_stmt_bind_param($stmt_keranjang, "i", $id_user_terlogin);
mysqli_stmt_execute($stmt_keranjang);
$result_keranjang = mysqli_stmt_get_result($stmt_keranjang);
$items_keranjang = []; // simpan data keranjang
while ($row = mysqli_fetch_assoc($result_keranjang)) {
    $items_keranjang[] = $row;
}
$total_harga = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }

        .navbar {
            padding: 0.5rem 0;
            background: linear-gradient(135deg, #343a40 0%, #212529 100%);
        }

        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.rounded {
            border-radius: 50px !important;
        }

        .dropdown-menu {
            border-radius: 10px;
            margin-top: 8px;
        }

        .dropdown-item {
            border-radius: 5px;
            margin: 0 5px;
            width: auto;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .navbar-brand i {
            font-size: 1.5rem;
        }

        @media (min-width: 992px) {
            .navbar-nav {
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../index.php">
                <i class="fas fa-shopping-bag me-2"></i>
                <span>TokoOnline</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item mx-lg-1">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="../index.php">
                            <i class="fas fa-home me-1 d-lg-none"></i>
                            Beranda
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle">
                                <span class="visually-hidden">Current page</span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item mx-lg-1">
                        <a class="nav-link px-3 py-2 rounded" href="../pages/products.php">
                            <i class="fas fa-box-open me-1 d-lg-none"></i>
                            Produk
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] != 'admin') :
                        $query = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = {$_SESSION['user_id']}");
                    ?>
                        <li class="nav-item mx-lg-1 position-relative">
                            <a class="nav-link px-3 py-2 rounded" href="#">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cart-count" class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= mysqli_num_rows($query) ?? 0 ?>
                                    <span class="visually-hidden">items in cart</span>
                                </span>
                                <span class="d-lg-none ms-2">Keranjang</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown mx-lg-1">
                            <a class="nav-link dropdown-toggle px-3 py-2 rounded d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="me-2 d-none d-lg-inline-flex align-items-center justify-content-center bg-primary rounded-circle" style="width: 30px; height: 30px;">
                                    <span class="text-white"><?= substr($_SESSION['name'], 0, 1) ?></span>
                                </div>
                                <span class="d-lg-none">
                                    <i class="fas fa-user-circle me-1"></i>
                                </span>
                                <?= $_SESSION['name'] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item py-2" href="dashboard.php">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                            Dashboard Admin
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <!-- <li>
                                    <a class="dropdown-item py-2" href="profile.php">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Profil
                                    </a>
                                </li> -->
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 text-danger" href="../logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item mx-lg-1">
                            <a class="nav-link px-3 py-2 rounded" href="login.php">
                                <i class="fas fa-sign-in-alt me-1 d-lg-none"></i>
                                Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cart-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                Produk berhasil ditambahkan ke keranjang!
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="card shadow border-0">
            <div class="card-header text-white" style="background-color: #726763;">
                <h4 class="mb-0">🛒 Keranjang Belanja Anda</h4>
            </div>
            <div class="card-body" style="background-color: #726763; color: #f8f9fa;">
                <?php if (mysqli_num_rows($result_keranjang) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-white">
                            <thead style="background-color: #8a7f78;" class="text-light">
                                <tr>
                                    <th class="border-1">Foto</th>
                                    <th class="border-1">Nama Produk</th>
                                    <th class="border-1">Harga Satuan</th>
                                    <th class="border-1">Jumlah</th>
                                    <th class="border-1">Subtotal</th>
                                    <th class="border-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_harga = 0;
                                foreach ($items_keranjang as $keranjang) :
                                    $harga = (int)$keranjang['harga'];
                                    $jumlah = (int)$keranjang['jumlah'];
                                    $subtotal = $harga * $jumlah;
                                    $total_harga += $subtotal;
                                ?>
                                    <tr>
                                        <td class="border-1"><img src="../assets/images/products/<?= $keranjang['gambar'] ?>" alt="<?= $keranjang['nama_produk'] ?>" width="60" class="rounded"></td>
                                        <td class="border-1"><?= $keranjang['nama_produk'] ?></td>
                                        <td class="border-1">Rp <?= number_format($harga, 0, ',', '.') ?></td>
                                        <td class="border-1"><?= $keranjang['jumlah'] ?></td>
                                        <td class="border-1">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                        <td>
                                            <a href="delete.php?id=<?= $keranjang['id'] ?>" class="btn btn-sm btn-outline-dark btn-danger" onclick="return confirm('Yakin hapus produk?')">🗑 Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <h4>Total Harga: <span class="text-warning">Rp <?= number_format($total_harga, 0, ',', '.') ?></span></h4>
                        <form action="../cart/order.php" method="POST">
                            <input type="hidden" name="total_harga" value="<?= $total_harga ?>">
                            <button type="submit" class="btn btn-lg" style="background-color: #5cb85c; color: white;">
                                🚚 Checkout Sekarang
                            </button>
                        </form>
                    </div>

                <?php else : ?>
                    <div class="alert alert-light text-center text-dark">
                        Keranjang belanja Anda masih kosong.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>