<?php
include "../koneksi.php";
session_start();

$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {
    $no_surat        = $_POST['no_surat'];
    $tgl_surat       = $_POST['tgl_surat'];
    $tgl_terima      = $_POST['tgl_terima'];
    $pengirim        = $_POST['pengirim'];
    $alamat_pengirim = $_POST['alamat_pengirim'];
    $perihal         = $_POST['perihal'];
    $isi             = $_POST['isi'];
    $status          = $_POST['status'];
    $id_pegawai      = $_POST['id_pegawai'];

    // Upload file
    $file_surat = '';
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "../file_surat/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $file_surat = time() . "_" . basename($_FILES["file_surat"]["name"]);
        move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetDir . $file_surat);
    }

    mysqli_query($koneksi, "INSERT INTO surat_masuk (no_surat,tgl_surat,tgl_terima,pengirim,alamat_pengirim,perihal,isi,file_surat,status,id_pegawai) 
        VALUES ('$no_surat','$tgl_surat','$tgl_terima','$pengirim','$alamat_pengirim','$perihal','$isi','$file_surat','$status','$id_pegawai')");

    header("Location: ../index.php?halaman=surat_masuk");

} elseif ($proses == 'edit') {
    $id_surat_masuk  = $_POST['id_surat_masuk'];
    $no_surat        = $_POST['no_surat'];
    $tgl_surat       = $_POST['tgl_surat'];
    $tgl_terima      = $_POST['tgl_terima'];
    $pengirim        = $_POST['pengirim'];
    $alamat_pengirim = $_POST['alamat_pengirim'];
    $perihal         = $_POST['perihal'];
    $isi             = $_POST['isi'];
    $status          = $_POST['status'];
    $id_pegawai      = $_POST['id_pegawai'];

    $fileQuery = "";
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "../file_surat/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $file_surat = time() . "_" . basename($_FILES["file_surat"]["name"]);
        move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetDir . $file_surat);
        $fileQuery = ", file_surat='$file_surat'";
    }

    mysqli_query($koneksi, "UPDATE surat_masuk SET 
        no_surat='$no_surat', tgl_surat='$tgl_surat', tgl_terima='$tgl_terima', 
        pengirim='$pengirim', alamat_pengirim='$alamat_pengirim', 
        perihal='$perihal', isi='$isi', status='$status', id_pegawai='$id_pegawai'
        $fileQuery WHERE id_surat_masuk='$id_surat_masuk'");

    header("Location: ../index.php?halaman=surat_masuk");

} elseif ($proses == 'hapus') {
    $id = $_GET['id_surat_masuk'];
    mysqli_query($koneksi, "DELETE FROM surat_masuk WHERE id_surat_masuk='$id'");
    header("Location: ../index.php?halaman=surat_masuk");
}
?>
