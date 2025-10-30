<?php
require_once __DIR__ . '/../../db/db_surat_keluar.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID surat tidak ditemukan!'); window.location='index.php?halaman=surat_keluar';</script>";
    exit;
}

$id = $_GET['id'];
$data = getSuratKeluarById($koneksi, $id);

if (!$data) {
    echo "<script>alert('Data surat tidak ditemukan!'); window.location='index.php?halaman=surat_keluar';</script>";
    exit;
}

if (isset($_POST['hapus'])) {
    if (!empty($data['file_surat']) && file_exists("../../uploads/file_surat/" . $data['file_surat'])) {
        unlink("../../uploads/file_surat/" . $data['file_surat']);
    }

    if (deleteSuratKeluar($koneksi, $id)) {
        echo "<script>alert('Data surat berhasil dihapus!'); window.location='index.php?halaman=surat_keluar';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data surat!');</script>";
    }
}
?>

<div class="card shadow-sm border-danger">
    <div class="card-header bg-danger text-white">
        <h3 class="card-title"><i class="fas fa-trash"></i> Hapus Surat Keluar</h3>
    </div>

    <div class="card-body">
        <p>Apakah Anda yakin ingin menghapus surat berikut?</p>
        <ul>
            <li><strong>No Surat:</strong> <?= htmlspecialchars($data['no_surat']) ?></li>
            <li><strong>Tujuan:</strong> <?= htmlspecialchars($data['tujuan']) ?></li>
            <li><strong>Perihal:</strong> <?= htmlspecialchars($data['perihal']) ?></li>
        </ul>

        <form method="POST" class="mt-3 text-end">
            <a href="index.php?halaman=surat_keluar" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
            <button type="submit" name="hapus" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Hapus
            </button>
        </form>
    </div>
</div>
