<?php
session_start();
include '../includes/config.php';

// Ambil data feedback beserta informasi user
$result = $conn->query("
    SELECT feedback.*, users.name, users.email
    FROM feedback
    JOIN users ON feedback.user_id = users.id
");

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
        <div class="card-body" style="background-color: #726763;">
            <h1 class="mb-4 h3 fw-semibold text-white">
                <i class="fas fa-comments text-white me-2"></i> Feedback Pengguna
            </h1>
            <div class="table-responsive" style="background-color: #726763;">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-light text-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($feedback = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($feedback['name']) ?></td>
                                    <td><?= htmlspecialchars($feedback['email']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($feedback['message'])) ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($feedback['date'])) ?></td>
                                </tr>
                            <?php endwhile;
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada feedback</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>