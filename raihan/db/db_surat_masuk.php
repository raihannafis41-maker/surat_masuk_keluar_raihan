<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['id_admin'])) {
    die("Gagal menambah surat: Anda belum login sebagai admin!");
}

$id_admin = $_SESSION['id_admin']; // <-- otomatis ambil dari session
include "../koneksi.php";
session_start();

// Aktifkan error reporting (biar mudah debug)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil parameter proses (tambah, edit, hapus)
$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {

    // Ambil data dari form
    $no_surat        = $_POST['no_surat'] ?? '';
    $tgl_surat       = $_POST['tgl_surat'] ?? '';
    $tgl_terima      = $_POST['tgl_terima'] ?? '';
    $pengirim        = $_POST['pengirim'] ?? '';
    $alamat_pengirim = $_POST['alamat_pengirim'] ?? '';
    $perihal         = $_POST['perihal'] ?? '';
    $isi             = $_POST['isi'] ?? '';
    $status          = $_POST['status'] ?? 'baru';
    $id_kategori     = $_POST['id_kategori'] ?? 1;
    $id_pegawai      = $_POST['id_pegawai'] ?? 1;

    // Ambil id_admin dari session login
    $id_admin = $_SESSION['id_admin'] ?? null;

    // Cek apakah session admin sudah ada
    if ($id_admin === null) {
        die("Gagal menambah surat: Anda belum login sebagai admin!");
    }

    // Upload file surat (jika ada)
    $file_surat = '';
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "../file_surat/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $file_surat = time() . "_" . basename($_FILES["file_surat"]["name"]); // tambahkan timestamp biar unik
        $targetFile = $targetDir . $file_surat;

        if (!move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFile)) {
            die("Gagal mengupload file surat!");
        }
    }

    // Jalankan query insert
    $query = "INSERT INTO surat_masuk (
        no_surat,
        tgl_surat,
        tgl_terima,
        pengirim,
        alamat_pengirim,
        perihal,
        isi,
        file_surat,
        status,
        id_kategori,
        id_admin,
        id_pegawai
    ) VALUES (
        '$no_surat',
        '$tgl_surat',
        '$tgl_terima',
        '$pengirim',
        '$alamat_pengirim',
        '$perihal',
        '$isi',
        '$file_surat',
        '$status',
        '$id_kategori',
        '$id_admin',
        '$id_pegawai'
    )";

    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

} elseif ($proses == 'edit') {

    $id_surat_masuk  = $_POST['id_surat_masuk'] ?? '';
    $no_surat        = $_POST['no_surat'] ?? '';
    $tgl_surat       = $_POST['tgl_surat'] ?? '';
    $tgl_terima      = $_POST['tgl_terima'] ?? '';
    $pengirim        = $_POST['pengirim'] ?? '';
    $alamat_pengirim = $_POST['alamat_pengirim'] ?? '';
    $perihal         = $_POST['perihal'] ?? '';
    $isi             = $_POST['isi'] ?? '';
    $status          = $_POST['status'] ?? 'baru';
    $id_kategori     = $_POST['id_kategori'] ?? 1;
    $id_pegawai      = $_POST['id_pegawai'] ?? 1;
    $id_admin        = $_SESSION['id_admin'] ?? null;

    if ($id_admin === null) {
        die("Gagal mengedit surat: Anda belum login sebagai admin!");
    }

    // Jika upload file baru
    $fileQuery = "";
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "../file_surat/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $file_surat = time() . "_" . basename($_FILES["file_surat"]["name"]);
        $targetFile = $targetDir . $file_surat;

        if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFile)) {
            $fileQuery = ", file_surat='$file_surat'";
        } else {
            die("Gagal mengupload file baru!");
        }
    }

    $query = "UPDATE surat_masuk SET 
        no_surat='$no_surat',
        tgl_surat='$tgl_surat',
        tgl_terima='$tgl_terima',
        pengirim='$pengirim',
        alamat_pengirim='$alamat_pengirim',
        perihal='$perihal',
        isi='$isi',
        status='$status',
        id_kategori='$id_kategori',
        id_admin='$id_admin',
        id_pegawai='$id_pegawai'
        $fileQuery
        WHERE id_surat_masuk='$id_surat_masuk'";

    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

} elseif ($proses == 'hapus') {

    $id_surat_masuk = $_GET['id_surat_masuk'] ?? '';

    // Hapus file jika ada
    $queryFile = mysqli_query($koneksi, "SELECT file_surat FROM surat_masuk WHERE id_surat_masuk='$id_surat_masuk'");
    $dataFile = mysqli_fetch_assoc($queryFile);
    if (!empty($dataFile['file_surat']) && file_exists("../file_surat/" . $dataFile['file_surat'])) {
        unlink("../file_surat/" . $dataFile['file_surat']);
    }

    // Hapus data surat
    if (!mysqli_query($koneksi, "DELETE FROM surat_masuk WHERE id_surat_masuk='$id_surat_masuk'")) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
}

// Redirect kembali ke halaman utama surat masuk
header("Location: ../index.php?halaman=surat_masuk");
exit;
?>
