<?php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cegah SQL Injection
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Ambil data admin dari database
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Jika database masih menggunakan password tanpa hash
        if ($password === $data['password'] || password_verify($password, $data['password'])) {

            // Simpan data ke session
            $_SESSION['login'] = true;
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['user'] = $data['username'];
            $_SESSION['nama'] = $data['nama_admin'];

            // Redirect ke dashboard
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Password salah!');window.location='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');window.location='login.php';</script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
