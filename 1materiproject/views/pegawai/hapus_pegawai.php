<?php
include '../koneksi.php'; // karena file ini di dalam folder 'views', jadi butuh naik 1 level

if (!isset($_GET['id'])) {
    header('Location: ../index.php?halaman=pegawai');
    exit;
}

$id = intval($_GET['id']);
mysqli_query($koneksi, "DELETE FROM pegawai WHERE id_pegawai='$id'");
header('Location: ../index.php?halaman=pegawai');
exit;
?>
