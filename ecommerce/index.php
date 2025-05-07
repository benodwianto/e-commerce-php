<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';

?>

<style>
  .hero-section {
    min-height: 600px;
    align-items: center;
    overflow: hidden;
  }

  .hero-background {
    top: 0;
    left: 0;
    z-index: 1;
  }

  .product-showcase {
    position: relative;
    animation: float 3s ease-in-out infinite;
  }

  @keyframes float {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-15px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  .feature-card {
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    /* Make cards take full height of row */
    border: none;
    display: flex;
    /* Added for equal height */
    flex-direction: column;
    /* Added for equal height */
  }

  .feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }

  .feature-card .card-body {
    padding: 1.5rem;
    flex-grow: 1;
    /* Added for equal height */
    display: flex;
    /* Added for equal height */
    flex-direction: column;
    /* Added for equal height */
  }

  .feature-card .icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    margin-left: auto;
    margin-right: auto;
  }

  .feature-card h3 {
    margin-bottom: 1rem;
  }

  .feature-card p {
    margin-bottom: 0;
  }

  /* Equal height row */
  .row.equal-height {
    display: flex;
    flex-wrap: wrap;
  }

  .row.equal-height>[class*='col-'] {
    display: flex;
  }
</style>

<!-- Hero Section -->
<section class="hero-section position-relative py-5">
  <!-- Background Image with Overlay -->
  <div class="hero-background position-absolute w-100 h-100">
    <img src="assets/images/products/homee.jpeg" class="img-fluid w-100 h-100" alt="Background" style="object-fit: cover;">
    <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.4; top: 0; left: 0;"></div>
  </div>

  <!-- Content -->
  <div class="container position-relative d-flex align-items-center justify-content-center vh-100" style="z-index: 2;">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-12 text-center">
        <h1 class="display-4 fw-bold text-white mb-4">Selamat Datang Di Official Store Les Catino</h1>
        <p class="lead text-white mb-4">Upgrade Gayamu Tanpa Bikin Kantong Bolong! Cek Koleksi Terbaru Kami Sekarang!</p>
        <a href="pages/products.php" class="btn btn-light btn-lg px-4 py-2">
          <i class="fas fa-shopping-bag me-2"></i> Belanja Sekarang
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5" style="background-color: #726763;">
  <div class="container">
    <div class="row equal-height g-4"> <!-- Added equal-height class -->
      <!-- Card 1: Bahan Baku Premium -->
      <div class="col-md-4">
        <div class="card feature-card shadow-sm h-100">
          <div class="card-body text-center">
            <div class="icon-wrapper bg-primary text-white">
              <i class="fas fa-star"></i>
            </div>
            <h3 class="h4">Bahan Baku Premium</h3>
            <p class="text-muted">Kami hanya menggunakan bahan baku pilihan terbaik dari tim profesional untuk kualitas terjamin</p>
          </div>
        </div>
      </div>

      <!-- Card 2: Produk Asli Jepara -->
      <div class="col-md-4">
        <div class="card feature-card shadow-sm h-100">
          <div class="card-body text-center">
            <div class="icon-wrapper bg-success text-white">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3 class="h4">Produk Asli Indonesia</h3>
            <p class="text-muted">Produksi langsung dari pabrik alat Indonesia di Padang Sumatra Barat</p>
          </div>
        </div>
      </div>

      <!-- Card 3: Bergaransi Resmi -->
      <div class="col-md-4">
        <div class="card feature-card shadow-sm h-100">
          <div class="card-body text-center">
            <div class="icon-wrapper bg-warning text-white">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="h4">Bergaransi Resmi</h3>
            <p class="text-muted">Setiap produk kami memiliki garansi resmi untuk bahan baku kayu dan bagian lainnya</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Featured Products -->

<?php include 'includes/pop.php'; ?>

<section class="featured-products py-5" style="background-color: #726763;">
  <div class="container">
    <h2 class="text-center mb-5 text-white">Produk Unggulan</h2>
    <div class="row">
      <?php
      $data = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
      $products = $data->fetch_all(MYSQLI_ASSOC);

      foreach ($products as $product) {
      ?>
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100 product-card border-0 shadow-sm hover-shadow">
            <!-- Product Image Container -->
            <div class="position-relative overflow-hidden" style="height: 280px;">
              <img src="assets/images/products/<?= $product['image'] ?>"
                class="card-img-top h-100 object-fit-cover p-3"
                alt="<?= $product['name'] ?>">
              <!-- Quick View Button (appears on hover) -->
              <div class="quick-view position-absolute bottom-0 start-0 end-0 text-center p-2 bg-white opacity-0 transition-all">
                <button class="btn btn-sm btn-outline-dark rounded-pill quick-view-btn" data-id="<?= $product['id'] ?>">
                  <i class="fas fa-eye me-1"></i> Lihat Detail
                </button>
              </div>
            </div>

            <!-- Product Details -->
            <div class="card-body text-center pt-0 pb-3">
              <!-- Product Name -->
              <h5 class="card-title mb-1 text-truncate" title="<?= $product['name'] ?>">
                <?= $product['name'] ?>
              </h5>

              <!-- Price -->
              <p class="card-text text-danger fw-bold mb-2">
                Rp <?= number_format($product['price'], 0, ',', '.') ?>
              </p>

              <!-- Add to Cart Button -->
              <form action="cart/add_cart.php" method="post" class="d-flex align-items-start gap-2">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <button class="btn btn-dark add-to-cart rounded-pill flex-grow-1" data-id="<?= $product['id'] ?>">
                  <i class="fas fa-cart-plus me-2"></i>Keranjang
                </button>

                <div class="d-flex flex-column" style="width: 88px;">
                  <div class="input-group">
                    <input type="number" id="jumlah" name="jumlah" class="form-control" min="0" placeholder="0" required>
                  </div>
                </div>
              </form>


              <!-- Additional Actions (appear on hover) -->
              <div class="d-flex justify-content-center mt-2 additional-actions opacity-0 transition-all">
                <button class="btn btn-sm btn-outline-secondary me-1 rounded-circle" title="Wishlist">
                  <i class="far fa-heart"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-circle" title="Bandingkan">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      <?php } ?>
    </div>
  </div>
  <!-- <div class="text-center mt-2">
    <a href="#" class="btn btn-secondary px-4 py-2">View All Products</a>
  </div> -->
</section>

<!-- Counter Section with Logos -->
<section class="py-5" style="background-color: #726763;">
  <div class="container">
    <div class="row text-center">
      <!-- Products Counter -->
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="counter-box p-4">
          <div class="icon-wrapper bg-warning bg-opacity-10 text-white rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-box-open fa-2x"></i>
          </div>
          <h2 class="display-4 fw-bold text-white" data-count="1237">0</h2>
          <p class="fw-medium text-white">Produk Tersedia</p>
        </div>
      </div>

      <!-- Customers Counter -->
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="counter-box p-4">
          <div class="icon-wrapper bg-warning bg-opacity-10 text-success rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-users fa-2x text-white"></i>
          </div>
          <h2 class="display-4 fw-bold text-white " data-count="1324">0</h2>
          <p class="text-white fw-medium ">Pelanggan</p>
        </div>
      </div>

      <!-- Portfolio Counter -->
      <div class="col-md-3 mb-4 mb-md-0">
        <div class="counter-box p-4">
          <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-briefcase fa-2x text-white"></i>
          </div>
          <h2 class="display-4 fw-bold text-white" data-count="1469">0</h2>
          <p class="text-white fw-medium">Portfolio</p>
        </div>
      </div>

      <!-- Categories Counter -->
      <div class="col-md-3">
        <div class="counter-box p-4">
          <div class="icon-wrapper bg-warning bg-opacity-10 text-danger rounded-circle mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-tags fa-2x text-white"></i>
          </div>
          <h2 class="display-4 fw-bold text-danger text-white" data-count="3">0</h2>
          <p class="text-white fw-medium">Kategori Produk</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Categories Section -->
<section class="categories py-5" id="categories" style="background-color:  #726763;">
  <div class="container">
    <h2 class="text-center mb-5 display-4 fw-bold text-white">Popular Categories</h2>
    <p class="text-center mb-5 lead text-white">Discover our most sought-after collections</p>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card category-card shadow-sm border-0 overflow-hidden">
          <img src="assets/images/products/Backpack.jpeg" class="card-img" alt="Backpack">
          <div class="card-img-overlay d-flex align-items-center justify-content-center">
            <div class="text-center">
              <h3 class="text-white fw-bold mb-3">Backpack</h3>
              <a href="#" class="btn btn-outline-light btn-sm stretched-link">Shop Now</a>
            </div>
          </div>
          <div class="category-hover-overlay"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card category-card shadow-sm border-0 overflow-hidden">
          <img src="assets/images/products/Shoulder Bag.jpeg" class="card-img" alt="Shoulder Bag">
          <div class="card-img-overlay d-flex align-items-center justify-content-center">
            <div class="text-center">
              <h3 class="text-white fw-bold mb-3">Shoulder Bag</h3>
              <a href="#" class="btn btn-outline-light btn-sm stretched-link">Shop Now</a>
            </div>
          </div>
          <div class="category-hover-overlay"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card category-card shadow-sm border-0 overflow-hidden">
          <img src="assets/images/products/Tote Bag.jpeg" class="card-img" alt="Tote Bag">
          <div class="card-img-overlay d-flex align-items-center justify-content-center">
            <div class="text-center">
              <h3 class="text-white fw-bold mb-3">Tote Bag</h3>
              <a href="#" class="btn btn-outline-light btn-sm stretched-link">Shop Now</a>
            </div>
          </div>
          <div class="category-hover-overlay"></div>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="#categories" class="btn btn-dark px-4 py-2">Categories</a>
    </div>
  </div>

  <section class="feedback py-5 mt-4" style="background-color:#726763;">
    <div class="container">
      <div class="text-center text-white mb-4">
        <h2>📝 Feedback Pengguna</h2>
        <p>Kami menghargai masukan Anda untuk meningkatkan layanan kami.</p>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow border-0">
            <div class="card-body">
              <form action="submit_feedback.php" method="POST">
                <div class="mb-3">
                  <label for="message" class="form-label">Pesan</label>
                  <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary px-4">Kirim Feedback</button>
              </form>
            </div>
            <div class="card-body" style="background-color: #726763; color: #fff;">
              <h5 class="card-title mb-3">💬 Feedback Terbaru</h5>
              <ul class="list-group list-group-flush">
                <?php
                $sql = "SELECT feedback.message, users.name 
            FROM feedback 
            JOIN users ON feedback.user_id = users.id 
            ORDER BY feedback.date DESC 
            LIMIT 5";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                  while ($row = $result->fetch_assoc()):
                ?>
                    <li class="list-group-item" style="background-color: #8a7f75; color: white;">
                      <strong><?= htmlspecialchars($row['name']) ?>:</strong> <?= htmlspecialchars($row['message']) ?>
                    </li>
                  <?php
                  endwhile;
                else:
                  ?>
                  <li class="list-group-item" style="background-color: #8a7f75; color: white;">
                    Belum ada feedback.
                  </li>
                <?php endif; ?>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>


  </style>
  <?php include 'includes/footer.php'; ?>

  <!-- CSS Tambahan -->
  <style>
    .counter-box {
      transition: all 0.3s ease;
      border-radius: 10px;
    }

    .counter-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .product-card {
      transition: all 0.3s ease;
      border-radius: 10px !important;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .product-card .quick-view {
      transform: translateY(100%);
    }

    .product-card:hover .quick-view {
      opacity: 1;
      transform: translateY(0);
    }

    .product-card:hover .additional-actions {
      opacity: 1;
    }

    .hover-shadow {
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .hover-shadow:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .transition-all {
      transition: all 0.3s ease;
    }

    .category-card {
      height: 300px;
      border-radius: 12px !important;
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .category-card img {
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .category-card:hover img {
      transform: scale(1.05);
    }

    .category-card .card-img-overlay {
      background: rgba(0, 0, 0, 0.3);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .category-card:hover .card-img-overlay {
      opacity: 1;
    }

    .category-hover-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .category-card:hover .category-hover-overlay {
      opacity: 1;
    }

    .hero {
      background: linear-gradient(45deg, #F5E8E4, #E4DCCF, #D3D3D3);
      min-height: 600px;
      display: flex;
      align-items: center;
    }

    .product-card {
      transition: transform 0.3s;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .category-card {
      height: 250px;
      overflow: hidden;
      position: relative;
    }

    .category-card img {
      height: 100%;
      object-fit: cover;
    }
  </style>

  <script>
    // Counter animation script
    document.addEventListener('DOMContentLoaded', function() {
      const counters = document.querySelectorAll('[data-count]');
      const speed = 200;

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            startCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.5
      });

      counters.forEach(counter => {
        observer.observe(counter);
      });

      function startCounter(counter) {
        const target = +counter.getAttribute('data-count');
        const count = +counter.innerText;
        const increment = target / speed;

        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(() => updateCount(counter, target), 1);
        } else {
          counter.innerText = target;
        }
      }

      function updateCount(counter, target) {
        const count = +counter.innerText;
        const increment = target / speed;

        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(() => updateCount(counter, target), 1);
        } else {
          counter.innerText = target;
        }
      }
    });

    // Add to Cart Script
    document.querySelectorAll('.add-to-cart').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.dataset.id;
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              product_id: productId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const cartCount = document.getElementById('cart-count');
              cartCount.textContent = data.cart_count;
              new bootstrap.Toast(document.getElementById('cart-toast')).show();
            }
          });
      });
    });
  </script>