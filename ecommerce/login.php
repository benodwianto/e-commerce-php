<?php
require 'includes/auth.php';
require 'includes/config.php';
require 'includes/pop.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/products.php");
            } else {
                header("Location: index.php");
                exit;
            }
            exit;
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Email tidak ditemukan";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light" style="font-family: 'Poppins', sans-serif;">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 d-none d-lg-block">
                <img src="assets/images/products/homee.jpeg" alt="Fashion Bags" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4 text-uppercase" style="letter-spacing: 1px;">Welcome Back</h3>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control rounded-3" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control rounded-3" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2" style="background-color: #6C4F3D;">Login</button>
                        </form>
                        <p class="mt-4 text-center">Don't have an account? <a href="register.php" class="text-decoration-none" style="color: #6C4F3D;">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Google Fonts -->
    <link href="https://fonts.googleapis.com/css2


</html>