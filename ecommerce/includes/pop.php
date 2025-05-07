<?php if (isset($_SESSION['message'])): ?>
    <div id="popupAlert" class="alert alert-<?= $_SESSION['message'] ?> alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1055; min-width: 300px;">
        <?= $_SESSION['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('popupAlert');
        if (popup) {
            setTimeout(() => {
                // Pakai Bootstrap's dismiss
                const bsAlert = new bootstrap.Alert(popup);
                bsAlert.close();
            }, 4000); // 4000ms = 4 detik
        }
    });
</script>