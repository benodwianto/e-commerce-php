<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);
    $image = '';

    // Handle upload gambar
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/products/$image");
    }

    $sql = "INSERT INTO products (name, price, description, stock, category_id, image) 
            VALUES ('$name', $price, '$description', $stock, $category_id, '$image')";

    if ($conn->query($sql)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Produk berhasil ditambahkan'];
        header("Location: products.php");
        exit;
    } else {
        $error = "Gagal menambahkan produk: " . $conn->error;
    }
}

include '../includes/header_admin.php';
?>

<div class="container py-4">
    <div class="card shadow-lg border-0" style="background-color: #726763 !important;">
        <div class="card-header border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0"><i class="fas fa-plus-circle text-white me-2"></i>Tambah Produk Baru</h2>
                <a href="products.php" class="btn btn-warning text-white">
                    <i class="fas fa-arrow-left me-1 text-white"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="row g-3">
                <!-- Product Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold text-white">Nama Produk <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama produk" required>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold text-white">Harga <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" id="price" name="price" class="form-control"
                            min="0" step="100" placeholder="Masukkan harga" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-white">Deskripsi <span class="text-danger">*</span></label>
                    <textarea id="description" name="description" class="form-control"
                        rows="4" placeholder="Masukkan deskripsi produk" required></textarea>
                </div>

                <!-- Stock -->
                <div class="col-md-6">
                    <label for="stock" class="form-label fw-semibold text-white">Stok <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                        <input type="number" id="stock" name="stock" class="form-control"
                            min="0" placeholder="Masukkan jumlah stok" required>
                    </div>
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-semibold text-white">Kategori <span class="text-danger">*</span></label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="1">Backpack</option>
                        <option value="2">Shoulder Bag</option>
                        <option value="3">Tote Bag</option>
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="col-12">
                    <label for="image" class="form-label fw-semibold text-white">Gambar Produk</label>
                    <div class="file-upload-area">
                        <div class="file-upload-wrapper">
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <div class="file-upload-meta">
                                <small class="text-muted">Format: JPG, PNG, JPEG (Maks. 2MB)</small>
                            </div>
                        </div>
                        <div class="preview-area mt-3 d-none">
                            <img id="image-preview" class="img-thumbnail" width="150">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-danger text-white">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }

    .form-control,
    .form-select {
        background-color: #fefefe;
        color: #212529;
    }

    .container {
        max-width: 960px;
    }

    .card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        background-color: #726763;
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



<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const previewArea = document.querySelector('.preview-area');
        const previewImage = document.getElementById('image-preview');

        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewArea.classList.remove('d-none');
            }

            reader.readAsDataURL(this.files[0]);
        } else {
            previewArea.classList.add('d-none');
        }
    });
</script>

<?php include '../includes/footer.php'; ?>