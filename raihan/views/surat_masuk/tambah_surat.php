<div class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Surat Masuk</h3>
      </div>

      <form action="db/db_surat_masuk.php?proses=tambah" method="POST" enctype="multipart/form-data">
        <div class="card-body">

          <div class="form-group">
            <label>Nomor Surat</label>
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
            <label>Isi Surat</label>
            <textarea name="isi" class="form-control" rows="3" required></textarea>
          </div>

          <div class="form-group">
            <label>File Surat (PDF/JPG)</label>
            <input type="file" name="file_surat" class="form-control">
          </div>

          <!-- Pilihan status ENUM -->
          <div class="form-group">
            <label>Status Surat</label>
            <select name="status" class="form-control" required>
              <option value="baru" selected>Baru</option>
              <option value="dibaca">Dibaca</option>
              <option value="arsip">Arsip</option>
            </select>
          </div>

          <!-- Field tersembunyi (default kategori, admin, pegawai) -->
          <input type="hidden" name="id_kategori" value="1">
          <input type="hidden" name="id_admin" value="1">
          <input type="hidden" name="id_pegawai" value="1">

        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
