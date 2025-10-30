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

if (isset($_POST['update'])) {
    $no_surat = $_POST['no_surat'];
    $tgl_surat = $_POST['tgl_surat'];
    $tujuan = $_POST['tujuan'];
    $alamat_tujuan = $_POST['alamat_tujuan'];
    $perihal = $_POST['perihal'];
    $isi = $_POST['isi'];
    $file_surat_lama = $data['file_surat'];

    // File baru
    $file_surat = $_FILES['file_surat']['name'];
    if ($file_surat != "") {
        $tmp = $_FILES['file_surat']['tmp_name'];
        $ext = pathinfo($file_surat, PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $ext;
        move_uploaded_file($tmp, "../../uploads/file_surat/" . $newName);
    } else {
        $newName = $file_surat_lama;
    }

    if (updateSuratKeluar($koneksi, $id, $no_surat, $tgl_surat, $tujuan, $alamat_tujuan, $perihal, $isi, $newName)) {
        echo "<script>alert('Data surat berhasil diperbarui!'); window.location='index.php?halaman=surat_keluar';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data surat!');</script>";
    }
}
?>

<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Surat Keluar</h3>
        <a href="index.php?halaman=surat_keluar" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">No Surat</label>
                <input type="text" name="no_surat" value="<?= htmlspecialchars($data['no_surat']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Surat</label>
                <input type="date" name="tgl_surat" value="<?= htmlspecialchars($data['tgl_surat']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tujuan</label>
                <input type="text" name="tujuan" value="<?= htmlspecialchars($data['tujuan']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Tujuan</label>
                <input type="text" name="alamat_tujuan" value="<?= htmlspecialchars($data['alamat_tujuan']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Perihal</label>
                <input type="text" name="perihal" value="<?= htmlspecialchars($data['perihal']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Surat</label>
                <textarea name="isi" rows="4" class="form-control" required><?= htmlspecialchars($data['isi']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">File Surat Saat Ini:</label><br>
                <?php if (!empty($data['file_surat'])): ?>
                    <a href="../../uploads/file_surat/<?= htmlspecialchars($data['file_surat']) ?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-file"></i> Lihat File
                    </a>
                <?php else: ?>
                    <span class="badge bg-secondary">Tidak ada file</span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih File Baru (kosongkan jika tidak diubah)</label>
                <input type="file" name="file_surat" class="form-control">
            </div>

            <div class="text-end">
                <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="index.php?halaman=surat_keluar" class="btn btn-danger"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
