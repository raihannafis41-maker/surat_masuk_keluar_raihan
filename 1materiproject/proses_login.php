<?php
session_start();
require_once "koneksi.php"; // pastikan koneksi sesuai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $nip      = trim($_POST['nip'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $next     = $_POST['next'] ?? '';

    // ===========================================================
    // LOGIN ADMIN
    // ===========================================================
    if ($role === 'admin') {
        if (empty($username) || empty($password)) {
            echo "<script>alert('Username dan password wajib diisi!');window.location='login.php';</script>";
            exit;
        }

        $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' LIMIT 1");

        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);

            // validasi password (hash / plain text fallback)
            if (password_verify($password, $data['password']) || $password === $data['password']) {
                $_SESSION['login']      = true;
                $_SESSION['role']       = 'admin';
                $_SESSION['id_admin']   = $data['id_admin'];
                $_SESSION['nama_admin'] = $data['nama_admin'];
                $_SESSION['username']   = $data['username'];
                $_SESSION['foto']       = $data['foto'] ?? 'default.png';

                header("Location: " . (!empty($next) ? "index.php?halaman=" . urlencode($next) : "index.php"));
                exit;
            } else {
                echo "<script>alert('Password salah!');window.location='login.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Username admin tidak ditemukan!');window.location='login.php';</script>";
            exit;
        }

    // ===========================================================
    // LOGIN PEGAWAI
    // ===========================================================
    } elseif ($role === 'pegawai') {
        if (empty($nip)) {
            echo "<script>alert('NIP wajib diisi!');window.location='login.php';</script>";
            exit;
        }

        $query = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE nip='$nip' LIMIT 1");

        if ($query && mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);

            // Pegawai tidak perlu password
            $_SESSION['login']      = true;
            $_SESSION['role']       = 'pegawai';
            $_SESSION['id_pegawai'] = $data['id_pegawai'];
            $_SESSION['nip']        = $data['nip'];
            $_SESSION['nama']       = $data['nama'] ?? $data['nip'];
            $_SESSION['jabatan']    = $data['jabatan'] ?? '';
            $_SESSION['foto']       = $data['foto'] ?? 'default.png';

            header("Location: " . (!empty($next) ? "index.php?halaman=" . urlencode($next) : "index.php"));
            exit;
        } else {
            echo "<script>alert('NIP pegawai tidak ditemukan!');window.location='login.php';</script>";
            exit;
        }

    // ===========================================================
    // ROLE INVALID
    // ===========================================================
    } else {
        echo "<script>alert('Silakan pilih role terlebih dahulu!');window.location='login.php';</script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
