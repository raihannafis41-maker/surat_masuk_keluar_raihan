<?php
include 'koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    // Simpan data user ke session
    $_SESSION['user'] = $data['username'];
    $_SESSION['nama'] = $data['nama_admin']; // pastikan kolom di database-nya sesuai
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah!');window.location='login.php';</script>";
}
?>
