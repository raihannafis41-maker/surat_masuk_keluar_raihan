<?php
include '../../koneksi.php';

$id = $_GET['id'];
$cek = mysqli_query($koneksi, "SELECT file_disposisi FROM disposisi WHERE id_disposisi='$id'");
$data = mysqli_fetch_assoc($cek);

if ($data['file_disposisi'] && file_exists("../../uploads/" . $data['file_disposisi'])) {
    unlink("../../uploads/" . $data['file_disposisi']);
}

mysqli_query($koneksi, "DELETE FROM disposisi WHERE id_disposisi='$id'");
header("Location: disposisi.php");
exit();
?>
