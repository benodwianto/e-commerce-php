<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

redirectIfNotLoggedIn();
// Ambil data produk dari database
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$cart = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = {$_SESSION['user_id']}");
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
            <a class="navbar-brand fw-bold d-flex align-items-center" href="../">
                <i class="fas fa-shopping-bag me-2"></i>
                <span>TokoOnline</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item mx-lg-1">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="../">
                            <i class="fas fa-home me-1 d-lg-none"></i>
                            Beranda
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle">
                                <span class="visually-hidden">Current page</span>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item mx-lg-1">
                        <a class="nav-link px-3 py-2 rounded" href="#">
                            <i class="fas fa-box-open me-1 d-lg-none"></i>
                            Produk
                        </a>
                    </li>
                    <li class="nav-item mx-lg-1 position-relative">
                        <a class="nav-link px-3 py-2 rounded" href="../cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= mysqli_num_rows($cart) ?? 0 ?>
                                <span class="visually-hidden">items in cart</span>
                            </span>
                            <span class="d-lg-none ms-2">Keranjang</span>
                        </a>
                    </li>

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
                                        <a class="dropdown-item py-2" href="admin/dashboard.php">
                                            <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                                            Dashboard Admin
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <!-- <a class="dropdown-item py-2" href="profile.php">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Profil
                                    </a> -->
                                </li>
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
                            <a class="nav-link px-3 py-2 rounded" href="../login.php">
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

    <div class="container">

        <h2 class="mt-5 text-center">Semua Produk</h2> <!-- Menambahkan kelas text-center untuk memusatkan teks -->
        <div class="border p-3 rounded mb-5"> <!-- Bingkai luar untuk semua produk -->
            <div class="row">
                <?php
                // Reset pointer ke awal hasil query
                $products->data_seek(0); // Kembali ke awal hasil query

                while ($product = $products->fetch_assoc()): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 product-card">
                            <img src="../assets/images/products/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text text-danger fw-bold">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                <form action="../cart/add_cart.php" method="post" class="d-flex align-items-start gap-2">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                                    <button class="btn btn-dark add-to-cart rounded-pill flex-grow-1" data-id="<?= $product['id'] ?>">
                                        <i class="fas fa-cart-plus me-2"></i>Keranjang
                                    </button>

                                    <div class="d-flex flex-column" style="width: 88px;">
                                        <div class="input-group">
                                            <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="0" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>