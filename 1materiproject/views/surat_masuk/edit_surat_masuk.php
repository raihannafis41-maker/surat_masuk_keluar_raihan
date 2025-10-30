<?php
require_once __DIR__ . '/../../db/db_surat_masuk.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan');window.location='index.php?halaman=surat_masuk';</script>";
    exit;
}

$id = $_GET['id'];
$data = getSuratMasukById($koneksi, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (updateSuratMasuk($koneksi, $id, $_POST, $_FILES['file_surat'])) {
        echo "<script>alert('Surat masuk berhasil diperbarui!');window.location='index.php?halaman=surat_masuk';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui surat!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-warning">
        <h4>Edit Surat Masuk</h4>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>No Surat</label>
                <input type="text" name="no_surat" value="<?= htmlspecialchars($data['no_surat']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Surat</label>
                <input type="date" name="tgl_surat" value="<?= htmlspecialchars($data['tgl_surat']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Terima</label>
                <input type="date" name="tgl_terima" value="<?= htmlspecialchars($data['tgl_terima']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Pengirim</label>
                <input type="text" name="pengirim" value="<?= htmlspecialchars($data['pengirim']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat Pengirim</label>
                <input type="text" name="alamat_pengirim" value="<?= htmlspecialchars($data['alamat_pengirim']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Perihal</label>
                <input type="text" name="perihal" value="<?= htmlspecialchars($data['perihal']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Isi</label>
                <textarea name="isi" class="form-control" rows="3"><?= htmlspecialchars($data['isi']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="baru" <?= $data['status']=='baru'?'selected':''; ?>>Baru</option>
                    <option value="diproses" <?= $data['status']=='diproses'?'selected':''; ?>>Diproses</option>
                </select>
            </div>
            <div class="form-group">
                <label>File Surat</label><br>
                <?php if(!empty($data['file_surat'])): ?>
                    <img src="uploads/<?= htmlspecialchars($data['file_surat']); ?>" width="120" class="img-thumbnail mb-2"><br>
                <?php endif; ?>
                <input type="file" name="file_surat" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
