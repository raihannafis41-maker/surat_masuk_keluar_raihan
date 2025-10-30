<?php
include '../../db/db_surat_keluar.php';

$id = $_GET['id'];
if (hapusSuratKeluar($id)) {
    echo "<script>alert('Data surat keluar berhasil dihapus'); window.location='surat_keluar.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data'); window.location='surat_keluar.php';</script>";
}
?>
