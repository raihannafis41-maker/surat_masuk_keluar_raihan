<?php
// ==== DEBUG & ERROR HANDLING ====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==== KONEKSI DATABASE ====
require_once(__DIR__ . '/../../koneksi.php'); // pastikan path ini sesuai

if (!isset($koneksi) || !$koneksi) {
  die('❌ Koneksi ke database gagal. Periksa file koneksi.php');
}

// ==== QUERY DATA ====
$query = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY id_surat_keluar DESC")
  or die(mysqli_error($koneksi));

// ==== URL BASE UNTUK FILE ====
$base_url = '/raihan/11pertemuan29/raihan/uploads/file_surat/';
?>

<div class="card">
  <div class="card-header bg-primary text-white">
    <h3 class="card-title mb-0">📤 Data Surat Keluar</h3>
  </div>

  <div class="card-body">
    <a href="index.php?halaman=tambah_surat_keluar" class="btn btn-success btn-sm mb-3">
      <i class="fas fa-plus"></i> Tambah Surat Keluar
    </a>

    <div class="table-responsive">
      <table id="tabelSuratKeluar" class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>No Surat</th>
            <th>Tanggal Surat</th>
            <th>Tujuan</th>
            <th>Alamat Tujuan</th>
            <th>Perihal</th>
            <th>Isi</th>
            <th>File Surat</th>
            <th>ID Pegawai</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
          if (mysqli_num_rows($query) > 0) :
            while ($data = mysqli_fetch_assoc($query)) :
              $fileName = htmlspecialchars($data['file_surat']);
              $filePath = $base_url . $fileName;
              $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
          ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data['no_surat']) ?></td>
                <td><?= htmlspecialchars($data['tgl_surat']) ?></td>
                <td><?= htmlspecialchars($data['tujuan']) ?></td>
                <td><?= htmlspecialchars($data['alamat_tujuan']) ?></td>
                <td><?= htmlspecialchars($data['perihal']) ?></td>
                <td class="text-start"><?= htmlspecialchars($data['isi']) ?></td>

                <td>
                  <?php if (!empty($fileName)) : ?>
                    <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png'])) : ?>
                      <img src="<?= $filePath ?>" alt="Gambar Surat" class="img-thumbnail mb-2" style="max-width: 120px;">
                      <br>
                      <a href="<?= $filePath ?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fas fa-image"></i> Lihat Gambar
                      </a>
                    <?php elseif ($fileExt === 'pdf') : ?>
                      <a href="<?= $filePath ?>" target="_blank" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Lihat PDF
                      </a>
                    <?php else : ?>
                      <span class="text-muted">Format tidak dikenali</span>
                    <?php endif; ?>
                  <?php else : ?>
                    <span class="text-muted">Tidak ada file</span>
                  <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($data['id_pegawai'] ?? '-') ?></td>

                <td>
                  <a href="index.php?halaman=edit_surat_keluar&id=<?= urlencode($data['id_surat_keluar']) ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>

                  <a href="views/surat_keluar/hapus_surat_keluar.php?id=<?= urlencode($data['id_surat_keluar']) ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
          <?php
            endwhile;
          else :
            echo '<tr><td colspan="10" class="text-center text-muted">Belum ada data surat keluar.</td></tr>';
          endif;
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DataTables -->
<script>
  $(function() {
    $('#tabelSuratKeluar').DataTable({
      scrollX: true,
      autoWidth: false,
      ordering: false
    });
  });
</script>
