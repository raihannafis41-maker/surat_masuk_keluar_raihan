<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "surat_masuk_keluar_raihan"; // ganti sesuai nama database yang benar di phpMyAdmin

// Membuat koneksi
$koneksi = mysqli_connect($server, $user, $pass, $db);

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
