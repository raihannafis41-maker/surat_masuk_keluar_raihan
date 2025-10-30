<?php
include __DIR__ . '/../koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {
    $id_surat_masuk   = $_POST['id_surat_masuk'];
    $id_pegawai       = $_POST['id_pegawai'];
    $tgl_disposisi    = $_POST['tgl_disposisi'];
    $status_disposisi = $_POST['status_disposisi'];
    $catatan          = $_POST['catatan'];

    // Upload file jika ada
    $nama_file = null;
    if (!empty($_FILES['file_disposisi']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $nama_file = time() . '_' . basename($_FILES['file_disposisi']['name']);
        move_uploaded_file($_FILES['file_disposisi']['tmp_name'], $uploadDir . $nama_file);
    }

    $query = "INSERT INTO disposisi (id_surat_masuk, id_pegawai, tgl_disposisi, status_disposisi, catatan, file_disposisi)
              VALUES ('$id_surat_masuk', '$id_pegawai', '$tgl_disposisi', '$status_disposisi', '$catatan', '$nama_file')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../index.php?halaman=disposisi&status=success");
        exit;
    } else {
        die("Gagal menambah data: " . mysqli_error($koneksi));
    }
}

if ($proses == 'edit') {
    $id               = $_GET['id'] ?? '';
    $id_pegawai       = $_POST['id_pegawai'] ?? '';
    $tgl_disposisi    = $_POST['tgl_disposisi'] ?? '';
    $status_disposisi = $_POST['status_disposisi'] ?? '';
    $catatan          = $_POST['catatan'] ?? '';

    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    // Cek apakah ada file baru
    if (!empty($_FILES['file_disposisi']['name'])) {
        $file_disposisi = time() . "_" . basename($_FILES["file_disposisi"]["name"]);
        move_uploaded_file($_FILES["file_disposisi"]["tmp_name"], $uploadDir . $file_disposisi);

        $query = "UPDATE disposisi SET 
                    id_pegawai='$id_pegawai',
                    tgl_disposisi='$tgl_disposisi',
                    status_disposisi='$status_disposisi',
                    catatan='$catatan',
                    file_disposisi='$file_disposisi'
                  WHERE id_disposisi='$id'";
    } else {
        $query = "UPDATE disposisi SET 
                    id_pegawai='$id_pegawai',
                    tgl_disposisi='$tgl_disposisi',
                    status_disposisi='$status_disposisi',
                    catatan='$catatan'
                  WHERE id_disposisi='$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../index.php?halaman=disposisi&status=updated");
        exit;
    } else {
        die("Gagal update: " . mysqli_error($koneksi));
    }
}

if ($proses == 'hapus') {
    $id = $_GET['id'] ?? '';
    $queryOld = mysqli_query($koneksi, "SELECT file_disposisi FROM disposisi WHERE id_disposisi='$id'");
    $old = mysqli_fetch_assoc($queryOld);

    // hapus file kalau ada
    if (!empty($old['file_disposisi'])) {
        $filePath = __DIR__ . '/../uploads/' . $old['file_disposisi'];
        if (file_exists($filePath)) unlink($filePath);
    }

    mysqli_query($koneksi, "DELETE FROM disposisi WHERE id_disposisi='$id'");
    header("Location: ../index.php?halaman=disposisi&status=deleted");
    exit;
}
