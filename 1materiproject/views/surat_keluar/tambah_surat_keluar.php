<?php 
require_once __DIR__ . '/../../db/db_surat_masuk.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (tambahSuratMasuk($koneksi, $_POST, $_FILES['file_surat'])) {
    echo "<script>
      alert('✅ Surat masuk berhasil ditambahkan');
      window.location='../../index.php?halaman=surat_masuk';
    </script>";
  } else {
    echo "<script>alert('❌ Gagal menambah surat masuk');</script>";
  }
}
?>

<div class="card card-primary shadow-sm">
  <div class="card-header bg-primary text-white">
    <h3 class="card-title mb-0">
      <i class="fas fa-envelope-open-text"></i> Tambah Surat Masuk
    </h3>
  </div>

  <form action="" method="POST" enctype="multipart/form-data">
    <div class="card-body">
      <div class="row g-3">

        <div class="col-md-6">
          <label for="no_surat" class="form-label">No Surat</label>
          <input type="text" name="no_surat" id="no_surat" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label for="tgl_surat" class="form-label">Tanggal Surat</label>
          <input type="date" name="tgl_surat" id="tgl_surat" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label for="pengirim" class="form-label">Pengirim</label>
          <input type="text" name="pengirim" id="pengirim" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label for="perihal" class="form-label">Perihal</label>
          <input type="text" name="perihal" id="perihal" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-select" required>
            <option value="baru" selected>Baru</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
          </select>
        </div>

        <div class="col-12">
          <label for="isi" class="form-label">Isi Surat</label>
          <textarea name="isi" id="isi" rows="4" class="form-control" required></textarea>
        </div>

        <div class="col-12">
          <label for="file_surat" class="form-label">File Surat (PDF/JPG/PNG)</label>
          <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        </div>

      </div>
    </div>

    <div class="card-footer text-end">
      <a href="../../index.php?halaman=surat_masuk" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
      <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Simpan
      </button>
    </div>
  </form>
</div>
