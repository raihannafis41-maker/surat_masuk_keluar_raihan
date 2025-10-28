<?php
include "../koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {
    $id_surat_masuk   = $_POST['id_surat_masuk'] ?? '';
    $id_pegawai       = $_POST['id_pegawai'] ?? '';
    $tgl_disposisi    = $_POST['tgl_disposisi'] ?? '';
    $status_disposisi = $_POST['status_disposisi'] ?? 'Belum Dibaca';
    $catatan          = $_POST['catatan'] ?? '';

    // Upload file (jika ada)
    $file_disposisi = '';
    if (!empty($_FILES['file_disposisi']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $file_disposisi = time() . "_" . basename($_FILES["file_disposisi"]["name"]);
        $targetFile = $targetDir . $file_disposisi;

        if (!move_uploaded_file($_FILES["file_disposisi"]["tmp_name"], $targetFile)) {
            die("Gagal mengupload file disposisi!");
        }
    }

    // Query insert
    $query = "INSERT INTO disposisi (id_surat_masuk, id_pegawai, tgl_disposisi, status_disposisi, catatan, file_disposisi)
              VALUES ('$id_surat_masuk', '$id_pegawai', '$tgl_disposisi', '$status_disposisi', '$catatan', '$file_disposisi')";
    
    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=disposisi");
    exit;
}
?>
<?php
include "../koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {
    $id_surat_masuk   = $_POST['id_surat_masuk'] ?? '';
    $id_pegawai       = $_POST['id_pegawai'] ?? '';
    $tgl_disposisi    = $_POST['tgl_disposisi'] ?? '';
    $status_disposisi = $_POST['status_disposisi'] ?? 'Belum Dibaca';
    $catatan          = $_POST['catatan'] ?? '';

    // Upload file (jika ada)
    $file_disposisi = '';
    if (!empty($_FILES['file_disposisi']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $file_disposisi = time() . "_" . basename($_FILES["file_disposisi"]["name"]);
        $targetFile = $targetDir . $file_disposisi;

        if (!move_uploaded_file($_FILES["file_disposisi"]["tmp_name"], $targetFile)) {
            die("Gagal mengupload file disposisi!");
        }
    }

    // Query insert
    $query = "INSERT INTO disposisi (id_surat_masuk, id_pegawai, tgl_disposisi, status_disposisi, catatan, file_disposisi)
              VALUES ('$id_surat_masuk', '$id_pegawai', '$tgl_disposisi', '$status_disposisi', '$catatan', '$file_disposisi')";
    
    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=disposisi");
    exit;
}
?>
