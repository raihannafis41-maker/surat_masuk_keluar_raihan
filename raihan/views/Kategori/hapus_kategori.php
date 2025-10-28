<?php
include 'koneksi.php';
if (!isset($_GET['id'])) {
    header('Location: index.php?halaman=kategori');
    exit;
}
$id = intval($_GET['id']);
mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");
header('Location: index.php?halaman=kategori');
exit;
