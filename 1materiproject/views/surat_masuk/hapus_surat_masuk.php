<?php
require_once __DIR__ . '/../../db/db_surat_masuk.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    deleteSuratMasuk($koneksi, $id);
}

echo "<script>alert('Surat berhasil dihapus!');window.location='index.php?halaman=surat_masuk';</script>";
?>
