<?php
require_once __DIR__ . '/../../koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='index.php?halaman=pegawai';</script>";
    exit;
}

$id = intval($_GET['id']);

// Cek data pegawai
$cek = mysqli_query($koneksi, "SELECT foto FROM pegawai WHERE id_pegawai='$id'");
if ($cek && mysqli_num_rows($cek) > 0) {
    $data = mysqli_fetch_assoc($cek);
    $fotoPath = __DIR__ . '/../../uploads/' . $data['foto'];

    // Hapus file foto
    if (!empty($data['foto']) && file_exists($fotoPath)) {
        unlink($fotoPath);
    }
}

// Hapus dari DB
$hapus = mysqli_query($koneksi, "DELETE FROM pegawai WHERE id_pegawai='$id'");

if ($hapus) {
    echo "<script>
        alert('✅ Data pegawai berhasil dihapus!');
        window.location.href='index.php?halaman=pegawai';
    </script>";
} else {
    echo "<script>
        alert('❌ Gagal menghapus data pegawai!');
        window.location.href='index.php?halaman=pegawai';
    </script>";
}
exit;
?>
