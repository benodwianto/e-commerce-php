<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';



// Pastikan hanya admin yang bisa mengakses
redirectIfNotLoggedIn();
redirectIfNotAdmin();


// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Hapus gambar jika ada
    $result = $conn->query("SELECT image FROM products WHERE id=$id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image'])) {
            unlink("../assets/images/products/" . $row['image']);
        }
    }

    // Hapus dari database
    $sql = "DELETE FROM products WHERE id=$id";
    if ($conn->query($sql)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil dihapus'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menghapus produk'];
    }
    header("Location: products.php");
    exit;
}

// Ambil data produk
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

include '../includes/header_admin.php';
?>

<!-- Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="cart-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            Produk berhasil ditambahkan ke keranjang!
        </div>
    </div>
</div>

<div class="container mt-5" style="font-family: 'Poppins', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-uppercase" style="letter-spacing: 1px;">
            <i class="fas fa-boxes me-2 text-primary"></i>Kelola Produk
        </h2>
        <a href="add_product.php" class="btn btn-dark rounded-pill px-4 py-2" style="background-color: #6C4F3D;">
            <i class="fas fa-plus-circle me-1"></i> Tambah Produk
        </a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show">
            <?= $_SESSION['message']['text'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Foto</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($product = $products->fetch_assoc()): ?>
                            <tr class="border-bottom">
                                <td class="ps-4 fw-semibold"><?= $no++ ?></td>
                                <td><?= $product['name'] ?></td>
                                <td class="text-nowrap">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-<?= ($product['stock'] > 0) ? 'success' : 'danger' ?>">
                                        <?= $product['stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?php
                                        switch ($product['category_id']) {
                                            case 1:
                                                echo 'Backpack';
                                                break;
                                            case 2:
                                                echo 'Shoulder Bag';
                                                break;
                                            case 3:
                                                echo 'Tote Bag';
                                                break;
                                            default:
                                                echo 'Lainnya';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <img src="../assets/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50">
                                </td>
                                <td class="text-nowrap pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-primary rounded-pill px-3 me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="products.php?delete=<?= $product['id'] ?>"
                                            class="btn btn-outline-danger rounded-pill px-3"
                                            onclick="return confirm('Yakin hapus produk?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Style -->
<style>
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    /* Khusus kolom pertama jika ingin tetap rata kiri */
    .table th:first-child,
    .table td:first-child {
        text-align: left;
    }

    .table-hover tbody tr:hover {
        background-color: #fef9f5;
        transition: background-color 0.2s;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .table th,
    .table td {
        border-right: 1px solid #e6e6e6;
    }

    /* Hilangkan border kanan di kolom terakhir */
    .table th:last-child,
    .table td:last-child {
        border-right: none;
    }


    .table tbody tr.border-bottom {
        border-bottom: 1px solid #e6e6e6;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
        background-color: #726763;
    }

    .badge {
        min-width: 45px;
        font-size: 0.75rem;
        padding: 6px 10px;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        border-width: 1.5px;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Atur latar belakang dan teks agar sesuai */
    .table thead,
    .table tbody,
    .table tfoot,
    .table th,
    .table td,
    .table tr {
        background-color: #726763 !important;
        color: white !important;
    }

    /* Hover row tetap berbeda agar terlihat */
    .table-hover tbody tr:hover {
        background-color: #8a7d6d !important;
    }

    /* Warna untuk badge juga bisa diatur supaya tidak terlalu gelap */
    .badge.bg-secondary {
        background-color: #a59b91;
        color: white;
    }
</style>

<!-- Google Fonts (Poppins) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


<?php include '../includes/footer.php'; ?>