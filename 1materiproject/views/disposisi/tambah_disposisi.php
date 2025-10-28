<?php
// Pastikan session sudah aktif agar tidak muncul warning
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Pastikan koneksi ke database
include 'koneksi.php';

// Ambil data surat masuk dan pegawai untuk dropdown
$suratQuery = mysqli_query($koneksi, "SELECT id_surat_masuk, no_surat, pengirim FROM surat_masuk ORDER BY id_surat_masuk DESC");
$pegawaiQuery = mysqli_query($koneksi, "SELECT id_pegawai, nama_pegawai FROM pegawai ORDER BY nama_pegawai ASC");
?>

<div class="card">
  <div class="card-header bg-primary text-white">
    <h3 class="card-title"><i class="fas fa-plus-circle"></i> Tambah Disposisi</h3>
  </div>

  <form action="db/db_disposisi.php?proses=tambah" method="POST" enctype="multipart/form-data">
    <div class="card-body">
      <div class="form-group">
        <label for="id_surat_masuk">Surat Masuk</label>
        <select name="id_surat_masuk" id="id_surat_masuk" class="form-control" required>
          <option value="">-- Pilih Surat Masuk --</option>
          <?php while ($surat = mysqli_fetch_assoc($suratQuery)) : ?>
            <option value="<?= $surat['id_surat_masuk'] ?>">
              <?= htmlspecialchars($surat['no_surat']) ?> - <?= htmlspecialchars($surat['pengirim']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="id_pegawai">Pegawai Tujuan</label>
        <select name="id_pegawai" id="id_pegawai" class="form-control" required>
          <option value="">-- Pilih Pegawai --</option>
          <?php while ($p = mysqli_fetch_assoc($pegawaiQuery)) : ?>
            <option value="<?= $p['id_pegawai'] ?>"><?= htmlspecialchars($p['nama_pegawai']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="tgl_disposisi">Tanggal Disposisi</label>
        <input type="date" name="tgl_disposisi" id="tgl_disposisi" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="status_disposisi">Status</label>
        <select name="status_disposisi" id="status_disposisi" class="form-control" required>
          <option value="Belum Dibaca">Belum Dibaca</option>
          <option value="Proses">Proses</option>
          <option value="Selesai">Selesai</option>
        </select>
      </div>

      <div class="form-group">
        <label for="catatan">Catatan</label>
        <textarea name="catatan" id="catatan" rows="3" class="form-control" placeholder="Tulis catatan..."></textarea>
      </div>


      <div class="card-footer">
        <button type="submit" class="btn btn-success">
          <i class="fas fa-save"></i> Simpan
        </button>
        <a href="index.php?halaman=disposisi" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>
  </form>
</div>