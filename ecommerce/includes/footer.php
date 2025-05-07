<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    .text-white-50 {
      color: rgba(255, 255, 255, 0.8) !important;
    }

    .hover-text-white:hover {
      color: white !important;
      transition: color 0.3s ease;
    }

    .footer-brand h4 {
      letter-spacing: 1px;
    }

    .social-icons a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      transition: all 0.3s ease;
    }

    .social-icons a:hover {
      background-color: var(--bs-primary);
      transform: translateY(-3px);
    }

    footer a {
      text-decoration: none;
    }

    footer hr {
      opacity: 0.1;
    }
  </style>
</head>

<body>
  <!-- Your main content here -->
  <main class="flex-shrink-0">
    <div class="container py-4">
      <!-- Page content goes here -->
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-light mt-auto">
    <div class="container py-4">
      <div class="row g-4">
        <!-- About Column -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-brand mb-3">
            <h4 class="text-uppercase fw-bold text-white">Les Catino</h4>
            <span class="text-white-50">Official Store</span>
          </div>
          <p class="text-white-50">Toko Online Terpercaya. Menyediakan Berbagai Produk Berkualitas Dengan Harga Terbaik.</p>
          <div class="social-icons mt-3">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>

        <!-- Help Column -->
        <div class="col-lg-2 col-md-6">
          <h5 class="text-uppercase fw-bold mb-4 text-white">Bantuan</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white"><i class="fas fa-chevron-right me-2 small text-white-50"></i>Cara Belanja</a></li>
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white"><i class="fas fa-chevron-right me-2 small text-white-50"></i>Pengembalian</a></li>
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none hover-text-white"><i class="fas fa-chevron-right me-2 small text-white-50"></i>Kontak</a></li>
          </ul>
        </div>

        <!-- Contact Column -->
        <div class="col-lg-3 col-md-6">
          <h5 class="text-uppercase fw-bold mb-4 text-white">Hubungi Kami</h5>
          <ul class="list-unstyled text-white-50">
            <li class="mb-3 d-flex align-items-center">
              <i class="fas fa-phone me-3 text-white"></i>
              <span>+62 043 830 139</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
              <i class="fas fa-envelope me-3 text-white"></i>
              <span>info@lescatinoofficialstore.com</span>
            </li>
          </ul>
        </div>

        <!-- Newsletter Column -->
        <div class="col-lg-3 col-md-6">
          <h5 class="text-uppercase fw-bold mb-4 text-white">Jam Operasional</h5>
          <ul class="list-unstyled text-white-50">
            <li class="mb-2">Senin-Jumat: 09.00-17.00</li>
            <li class="mb-2">Sabtu: 09.00-15.00</li>
            <li>Minggu: Tutup</li>
          </ul>
        </div>
      </div>

      <hr class="my-4 bg-secondary">

      <div class="row">
        <div class="col-md-6 text-center text-md-start">
          <p class="small text-white-50 mb-0">&copy; 2025 Les Catino Official Store. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="#" class="text-white-50 small hover-text-white">Syarat & Ketentuan</a></li>
            <li class="list-inline-item"><span class="text-white-50 mx-2">•</span></li>
            <li class="list-inline-item"><a href="#" class="text-white-50 small hover-text-white">Kebijakan Privasi</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>