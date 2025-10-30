<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// pastikan path koneksi benar meski file di subfolder
include __DIR__ . '/../../koneksi.php';

// pastikan parameter id dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?halaman=kategori');
    exit;
}

$id = intval($_GET['id']);

// cek apakah data dengan id tersebut ada
$cek = mysqli_query($koneksi, "SELECT id_kategori FROM kategori WHERE id_kategori='$id'");
if (mysqli_num_rows($cek) === 0) {
    // jika data tidak ditemukan, langsung balik
    header('Location: index.php?halaman=kategori');
    exit;
}

// hapus data
$hapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");

// setelah selesai hapus, kembali ke halaman kategori
if ($hapus) {
    echo "<script>
            alert('Kategori berhasil dihapus!');
            window.location.href='index.php?halaman=kategori';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus kategori: " . mysqli_error($koneksi) . "');
            window.location.href='index.php?halaman=kategori';
          </script>";
}
exit;
?>
