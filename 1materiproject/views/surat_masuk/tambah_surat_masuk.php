<?php
require_once __DIR__ . '/../../db/db_surat_masuk.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (tambahSuratMasuk($koneksi, $_POST, $_FILES['file_surat'])) {
        echo "<script>alert('Surat masuk berhasil ditambahkan!');window.location='index.php?halaman=surat_masuk';</script>";
    } else {
        echo "<script>alert('Gagal menambah surat!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-success text-white">
        <h4>Tambah Surat Masuk</h4>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>No Surat</label>
                <input type="text" name="no_surat" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Surat</label>
                <input type="date" name="tgl_surat" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Terima</label>
                <input type="date" name="tgl_terima" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Pengirim</label>
                <input type="text" name="pengirim" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat Pengirim</label>
                <input type="text" name="alamat_pengirim" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Perihal</label>
                <input type="text" name="perihal" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Isi</label>
                <textarea name="isi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="baru">Baru</option>
                    <option value="diproses">Diproses</option>
                </select>
            </div>
            <div class="form-group">
                <label>File Surat</label>
                <input type="file" name="file_surat" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
