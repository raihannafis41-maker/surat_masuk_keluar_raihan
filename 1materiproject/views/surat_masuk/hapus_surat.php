<?php
include "../../koneksi.php";

$id = $_GET['id_surat_masuk'];
$query = mysqli_query($koneksi, "SELECT file_surat FROM surat_masuk WHERE id_surat_masuk='$id'");
$data = mysqli_fetch_assoc($query);

if ($data && !empty($data['file_surat'])) {
    $filePath = "../../file_surat/" . $data['file_surat'];
    if (file_exists($filePath)) unlink($filePath);
}

mysqli_query($koneksi, "DELETE FROM surat_masuk WHERE id_surat_masuk='$id'");
header("Location: ../../index.php?halaman=surat_masuk");
exit;
?>
