<?php
include '../koneksi.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?halaman=admin');
    exit;
}

$id = intval($_GET['id']);
mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin='$id'");
header('Location: index.php?halaman=admin');
exit;
?>
