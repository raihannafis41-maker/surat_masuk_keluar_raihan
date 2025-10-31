<?php
// proses_login.php
session_start();
require_once "koneksi.php"; // pastikan file koneksi kamu sesuai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $next     = $_POST['next'] ?? '';

    // Cek user di database
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' LIMIT 1");

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        // Gunakan password_hash di database, tapi tetap izinkan sementara plain text
        if (password_verify($password, $data['password']) || $password === $data['password']) {
            $_SESSION['login']       = true;
            $_SESSION['id_admin']    = $data['id_admin'];
            $_SESSION['nama_admin']  = $data['nama_admin'];
            $_SESSION['username']    = $data['username'];

            // Redirect ke halaman tujuan (next) jika ada
            if (!empty($next)) {
                header("Location: index.php?halaman=" . urlencode($next));
            } else {
                header("Location: index.php");
            }
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
    header('Location: login.php');
    exit;
}
