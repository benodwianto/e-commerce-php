<?php
require_once '../includes/auth.php';
include '../includes/config.php';
include '../includes/header_admin.php';

if ($_SESSION['role'] != 'admin') {
  header('Location: ../login.php');
  exit;
}

$result = $conn->query("
  SELECT 
    o.id AS order_id,
    u.name AS customer_name,
    p.name AS product_name,
    o.jumlah,
    o.subtotal,
    o.status,
    o.tanggal_order
  FROM `order` o
  JOIN users u ON o.id_user = u.id
  JOIN products p ON o.id_product = p.id
  ORDER BY o.tanggal_order DESC
");

?>

<style>
  .table-custom thead th {
    background-color: #5a4f4b;
    color: #fff;
    border-color: #fff;
  }

  .table-custom tbody td {
    color: #fff;
    border-color: #fff;
  }

  .table-custom tbody tr:hover {
    background-color: #8a7f7b !important;
  }

  .card-body,
  .card-header {
    border: 1px solid #fff;
  }

  .table thead,
  .table tbody,
  .table tfoot,
  .table th,
  .table td,
  .table tr {
    background-color: #726763 !important;
    color: white !important;
  }
</style>

<div class="container my-5 pt-2">
  <div class="card shadow">
    <div class="card-header text-white" style="background-color: #726763;">
      <h4 class="mb-0">📦 Manajemen Pesanan</h4>
    </div>
    <div class="card-body" style="background-color: #726763;">
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center table-custom">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Total Pesanan</th>
              <th>Status</th>
              <th>Dibuat</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            if (mysqli_num_rows($result) > 0) {
              while ($order = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($order['customer_name']) ?></td>
                  <td><?= htmlspecialchars($order['product_name']) ?></td>
                  <td><?= $order['jumlah'] ?></td>
                  <td>Rp <?= number_format($order['subtotal'], 0, ',', '.') ?></td>
                  <td>
                    <?php
                    $statusClass = match (strtolower($order['status'])) {
                      'pending' => 'badge bg-warning',
                      'proses' => 'badge bg-primary',
                      'selesai' => 'badge bg-success',
                      default => 'badge bg-secondary'
                    };
                    ?>
                    <span class="<?= $statusClass ?>"><?= ucfirst($order['status']) ?></span>
                  </td>
                  <td><?= date('d M Y H:i', strtotime($order['tanggal_order'])) ?></td>
                </tr>
              <?php endwhile;
            } else { ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada pesanan</td>
              </tr>
            <?php } ?>
          </tbody>


        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php' ?>