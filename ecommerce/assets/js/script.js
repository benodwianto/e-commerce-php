/* Global Styles */
body {
  padding-top: 70px;
  font-family: 'Poppins', sans-serif;
}

.navbar {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Hero Section */
.hero {
  background: linear-gradient(45deg, #2c3e50, #3498db);
  min-height: 600px;
  display: flex;
  align-items: center;
  color: white;
}

/* Product Card */
.product-card {
  transition: transform 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Category Card */
.category-card {
  height: 250px;
  overflow: hidden;
  position: relative;
}

.category-card img {
  height: 100%;
  width: 100%;
  object-fit: cover;
}

.category-card .card-img-overlay {
  background: rgba(0, 0, 0, 0.4);
}

/* Footer */
footer {
  background-color: #343a40;
  color: white;
  padding: 40px 0;
  margin-top: 50px;
}

footer h5 {
  font-weight: bold;
  margin-bottom: 20px;
}

footer a {
  color: white;
  text-decoration: none;
}

footer a:hover {
  text-decoration: underline;
}

/* Buttons */
.btn-primary {
  background-color: #3498db;
  border-color: #3498db;
}

.btn-primary:hover {
  background-color: #2980b9;
  border-color: #2980b9;
}

/* Toast Notification */
.toast-container {
  z-index: 1055;
}

.toast {
  background-color: #28a745;
  color: white;
}

/* Table in Admin Dashboard */
.table th, .table td {
  vertical-align: middle;
}

/* Responsive tweaks */
@media (max-width: 768px) {
  .hero {
    text-align: center;
  }
  .hero img {
    margin-top: 20px;
  }
}
