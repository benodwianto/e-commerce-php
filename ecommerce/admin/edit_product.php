<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';


if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Produk tidak ditemukan'];
    header("Location: products.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // Handle upload gambar baru
    $image = $product['image'];
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Hapus gambar lama jika ada
        if (!empty($image)) {
            unlink("../assets/images/products/$image");
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/products/$image");
    }

    $sql = "UPDATE products SET 
            name='$name', 
            price=$price, 
            description='$description', 
            stock=$stock, 
            category_id=$category_id, 
            image='$image' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil diperbarui'];
        header("Location: products.php");
        exit;
    } else {
        $error = "Gagal memperbarui produk: " . $conn->error;
    }
}

include '../includes/header_admin.php';
?>
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 960px;
    }

    .card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card-header {
        background-color: #726763;
        color: #fff;
        padding: 20px 24px;
        border-bottom: none;
    }

    .card-header h2 {
        color: #fff;
        font-weight: 600;
    }

    .btn-outline-secondary {
        border-color: #fff;
        color: #fff;
        transition: 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
    }

    label.form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        border: 1px solid #ced4da;
        background-color: #fff;
        transition: 0.2s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0a58ca;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .input-group-text {
        background-color: #e9f1ff;
        border: 1px solid #ced4da;
        color: #0a58ca;
        border-right: none;
        padding: 10px 14px;
    }

    .input-group .form-control {
        border-left: none;
    }

    .file-upload-area {
        border: 2px dashed #b6d4fe;
        border-radius: 12px;
        padding: 20px;
        background-color: #f0f8ff;
        text-align: center;
        transition: 0.3s;
    }

    .file-upload-area:hover {
        border-color: #0a58ca;
        background-color: #e9f3ff;
    }

    .file-upload-meta small {
        color: #6c757d;
    }

    .preview-area img {
        margin-top: 10px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .btn {
        padding: 10px 20px;
        font-size: 0.95rem;
        border-radius: 10px;
        transition: 0.2s ease-in-out;
    }

    .btn-primary {
        background-color: #0a58ca;
        border: none;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .btn-primary:hover {
        background-color: #084298;
    }

    .alert {
        border-radius: 12px;
        font-size: 0.9rem;
        background-color: #ffe5e5;
        color: #b02a37;
        border: none;
    }

    .btn-close {
        background: none;
        border: none;
    }
</style>
<div class="container py-4">
    <div class="card shadow-lg border-0" style="background-color: #726763 !important;">
        <div class="card-header border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0"><i class="fas fa-edit text-white me-2"></i>Edit Produk</h2>
                <a href="products.php" class="btn btn-warning text-white">
                    <i class="fas fa-arrow-left me-1 text-white"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="row g-3">
                <!-- Product Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold text-white">Nama Produk</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        <input type="text" id="name" name="name" class="form-control"
                            value="<?= $product['name'] ?>" required>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold text-white">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" id="price" name="price" class="form-control"
                            min="0" step="100" value="<?= $product['price'] ?>" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-white">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="4" required><?= $product['description'] ?></textarea>
                </div>

                <!-- Stock -->
                <div class="col-md-6">
                    <label for="stock" class="form-label fw-semibold text-white">Stok</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                        <input type="number" id="stock" name="stock" class="form-control"
                            min="0" value="<?= $product['stock'] ?>" required>
                    </div>
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold text-white">Kategori</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="1" <?= $product['category_id'] == 1 ? 'selected' : '' ?>>Backpack</option>
                        <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Shoulder Bag</option>
                        <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Tote Bag</option>
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-white">Gambar Produk</label>
                    <?php if (!empty($product['image'])): ?>
                        <div class="mb-3">
                            <img src="../assets/images/products/<?= $product['image'] ?>"
                                class="img-thumbnail" width="150">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                <label class="form-check-label text-white" for="remove_image">
                                    Hapus gambar saat ini
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="file-upload">
                        <input type="file" name="image" id="image" class="form-control mb-2">
                        <div><small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small></div>
                    </div>
                </div>


                <!-- Form Actions -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-danger text-white">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary text-white">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>