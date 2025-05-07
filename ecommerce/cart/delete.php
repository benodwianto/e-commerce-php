<?php
include '../includes/config.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM keranjang WHERE id = '$id'");
header("Location: index.php");
