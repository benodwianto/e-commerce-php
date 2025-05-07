<?php
session_start();
include '../includes/config.php';


$result = $conn->query("SELECT * FROM users");
include '../includes/header_admin.php';
?>
<style>
  .table td,
  .table th {
    vertical-align: middle;
  }

  .badge {
    font-size: 0.875rem;
    padding: 0.5em 0.75em;
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

<div class="container mt-5 pt-5">
  <div class="card shadow-sm border-0 rounded">
    <div class="card-body" style="background-color: #726763; color: #f8f9fa;">
      <h1 class="mb-4 h3 fw-semibold">
        <i class="fas fa-users-cog text-white me-2"></i> Manajemen Pengguna
      </h1>
      <div class="table-responsive" style="background-color: #726763;">
        <table class="table table-bordered table-hover table-striped align-middle">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Terdaftar</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while ($user = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                  <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge bg-danger">Admin</span>
                  <?php elseif ($user['role'] === 'staff'): ?>
                    <span class="badge bg-warning text-dark">Staff</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">User</span>
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y, H:i', strtotime($user['created_at'])) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>