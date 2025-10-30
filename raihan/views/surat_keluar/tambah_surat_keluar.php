<?php
// Pastikan file database terhubung dengan path yang benar
require_once(__DIR__ . '/../../db/db_surat_keluar.php');

if (isset($_POST['submit'])) {
    if (tambahSuratKeluar($_POST, $_FILES)) {
        echo "<script>
                alert('✅ Surat keluar berhasil ditambahkan');
                window.location.href = 'index.php?halaman=surat_keluar';
              </script>";
    } else {
        echo "<script>alert('❌ Gagal menambah surat keluar');</script>";
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Surat Keluar</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Surat Keluar</h3>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label>No Surat</label>
                            <input type="text" name="no_surat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Surat</label>
                            <input type="date" name="tgl_surat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat Tujuan</label>
                            <textarea name="alamat_tujuan" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Perihal</label>
                            <input type="text" name="perihal" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Isi Surat</label>
                            <textarea name="isi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>File Surat (PDF)</label>
                            <input type="file" name="file_surat" accept=".pdf" class="form-control-file">
                        </div>

                        <!-- ID Pegawai bisa dinamis kalau kamu tambahkan login -->
                        <input type="hidden" name="id_pegawai" value="1">
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php?halaman=surat_keluar" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
