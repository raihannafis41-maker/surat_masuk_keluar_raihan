<?php
require_once __DIR__ . '/../../db/db_admin.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID admin tidak ditemukan!'); window.location='index.php?halaman=admin';</script>";
    exit;
}

$id = $_GET['id'];

if (deleteAdmin($koneksi, $id)) {
    echo "<script>alert('Admin berhasil dihapus!'); window.location='index.php?halaman=admin';</script>";
} else {
    echo "<script>alert('Gagal menghapus admin!'); window.location='index.php?halaman=admin';</script>";
}
?>
