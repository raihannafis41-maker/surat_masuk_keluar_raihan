<?php
// Aktifkan error reporting untuk debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../koneksi.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    die('ID disposisi tidak ditemukan.');
}

// Cek file lama
$cek = mysqli_query($koneksi, "SELECT file_disposisi FROM disposisi WHERE id_disposisi='$id'");
$data = mysqli_fetch_assoc($cek);

if ($data && !empty($data['file_disposisi'])) {
    $filePath = "../../uploads/" . $data['file_disposisi'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Hapus data dari database
mysqli_query($koneksi, "DELETE FROM disposisi WHERE id_disposisi='$id'");

// Redirect kembali ke halaman disposisi utama
header("Location: ../../index.php?halaman=disposisi");
exit();
?>
