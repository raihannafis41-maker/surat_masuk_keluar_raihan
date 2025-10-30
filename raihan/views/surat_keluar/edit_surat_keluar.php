<?php
// Pastikan path ke file db benar
require_once(__DIR__ . '/../../db/db_surat_keluar.php');

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID surat tidak ditemukan!'); window.location='index.php?halaman=surat_keluar';</script>";
    exit;
}

$id = $_GET['id'];
$data = getSuratKeluarById($id);

if (!$data) {
    echo "<script>alert('Data surat keluar tidak ditemukan!'); window.location='index.php?halaman=surat_keluar';</script>";
    exit;
}

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    if (updateSuratKeluar($id, $_POST, $_FILES)) {
        echo "<script>
                alert('✅ Data berhasil diperbarui');
                window.location.href = 'index.php?halaman=surat_keluar';
              </script>";
    } else {
        echo "<script>alert('❌ Gagal memperbarui data');</script>";
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Surat Keluar</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Surat Keluar</h3>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group">
                            <label>No Surat</label>
                            <input type="text" name="no_surat" class="form-control" value="<?= htmlspecialchars($data['no_surat']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Surat</label>
                            <input type="date" name="tgl_surat" class="form-control" value="<?= htmlspecialchars($data['tgl_surat']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" value="<?= htmlspecialchars($data['tujuan']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat Tujuan</label>
                            <textarea name="alamat_tujuan" class="form-control" rows="2" required><?= htmlspecialchars($data['alamat_tujuan']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="perihal" class="form-control" value="<?= htmlspecialchars($data['perihal']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Isi Surat</label>
                            <textarea name="isi" class="form-control" rows="3" required><?= htmlspecialchars($data['isi']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>File Surat (PDF / Gambar)</label>
                            <input type="file" name="file_surat" accept=".pdf, .jpg, .jpeg, .png" class="form-control-file">

                            <?php if (!empty($data['file_surat'])): ?>
                                <div class="mt-3">
                                    <label>File Saat Ini:</label><br>

                                    <?php
                                    $filePath = "../../uploads/file_surat/" . $data['file_surat'];
                                    $ext = strtolower(pathinfo($data['file_surat'], PATHINFO_EXTENSION));

                                    if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?= $filePath ?>" alt="Preview Gambar" class="img-thumbnail mt-2" style="max-width: 300px; height: auto;">
                                        <br>
                                        <a href="<?= $filePath ?>" target="_blank" class="btn btn-info btn-sm mt-2">
                                            Lihat Gambar Penuh
                                        </a>
                                    <?php elseif ($ext === 'pdf'): ?>
                                        <embed src="<?= $filePath ?>" type="application/pdf" width="100%" height="400px" class="mt-2">
                                        <br>
                                        <a href="<?= $filePath ?>" target="_blank" class="btn btn-info btn-sm mt-2">
                                            Buka PDF
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted mt-2">Format file tidak didukung untuk preview: <?= htmlspecialchars($data['file_surat']) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mt-2">Belum ada file surat</p>
                            <?php endif; ?>
                        </div>

                        <input type="hidden" name="file_lama" value="<?= htmlspecialchars($data['file_surat']) ?>">
                        <input type="hidden" name="id_pegawai" value="<?= htmlspecialchars($data['id_pegawai']) ?>">
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="index.php?halaman=surat_keluar" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
