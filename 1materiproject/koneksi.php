<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "db_surat";

// Membuat koneksi
$koneksi = mysqli_connect("localhost", "root", "", "surat_masuk_keluar_raihan");

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// else {
//     echo "Koneksi berhasil!";
// }
?>
