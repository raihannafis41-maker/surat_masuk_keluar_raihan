<?php
require_once __DIR__ . '/../../koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='index.php?halaman=pegawai';</script>";
    exit;
}

$id = intval($_GET['id']);

// 🔹 Cek data pegawai terlebih dahulu
$cek = mysqli_query($koneksi, "SELECT foto FROM pegawai WHERE id_pegawai='$id'");
if ($cek && mysqli_num_rows($cek) > 0) {
    $data = mysqli_fetch_assoc($cek);
    $fotoFile = $data['foto'];

    // 🔹 Path folder foto disesuaikan dengan struktur terbaru
    $fotoPath = __DIR__ . '/../../assets/img/' . $fotoFile;

    // 🔹 Hapus file foto jika ada
    if (!empty($fotoFile) && file_exists($fotoPath)) {
        unlink($fotoPath);
    }

    // 🔹 Hapus data pegawai dari database
    $hapus = mysqli_query($koneksi, "DELETE FROM pegawai WHERE id_pegawai='$id'");

    if ($hapus) {
        echo "<script>
            alert('✅ Data pegawai dan fotonya berhasil dihapus!');
            window.location.href='index.php?halaman=pegawai';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menghapus data pegawai dari database!');
            window.location.href='index.php?halaman=pegawai';
        </script>";
    }
} else {
    echo "<script>
        alert('❌ Data pegawai tidak ditemukan!');
        window.location.href='index.php?halaman=pegawai';
    </script>";
}
exit;
?>
