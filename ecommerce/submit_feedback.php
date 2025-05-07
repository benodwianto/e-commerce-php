<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Login Dahulu'];
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO feedback (user_id, message, date) VALUES ($user_id, '$message', '$date')";
    $conn->query($sql);

    $_SESSION['message'] = ['type' => 'success', 'text' => 'Feedback berhasil dikirim'];
    header('Location: index.php');
    exit;
}
