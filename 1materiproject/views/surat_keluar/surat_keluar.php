<?php
// ==== DEBUG & ERROR HANDLING ====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==== KONEKSI DATABASE ====
require_once(__DIR__ . '/../../koneksi.php'); // pastikan path benar!

if (!isset($koneksi) || !$koneksi) {
  die('<div class="alert alert-danger text-center mt-5">❌ Gagal: koneksi database tidak tersedia. Periksa koneksi.php.</div>');
}

// ==== QUERY DATA ====
$query = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY id_surat_keluar DESC") 
  or die(mysqli_error($koneksi));

// ==== BASE URL UNTUK FILE SURAT ====
$base_url = '/raihan/11pertemuan29/raihan/uploads/file_surat/';
?>

<!-- ====== HALAMAN DATA SURAT KELUAR ====== -->
<section class="content">
  <div class="container-fluid">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
          <i class="fas fa-paper-plane"></i> Data Surat Keluar
        </h3>
        <a href="index.php?halaman=tambah_surat_keluar" class="btn btn-success btn-sm">
          <i class="fas fa-plus"></i> Tambah Surat
        </a>
      </div>

      <div class="card-body">
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
                    <td class="text-start"><?= nl2br(htmlspecialchars($data['isi'])) ?></td>

                    <td>
                      <?php if (!empty($fileName)) : ?>
                        <?php if (in_array($fileExt, ['jpg', 'jpeg', 'png'])) : ?>
                          <img src="<?= $filePath ?>" alt="File Surat" class="img-thumbnail mb-1" style="max-width: 100px;">
                          <div><a href="<?= $filePath ?>" target="_blank" class="btn btn-info btn-sm mt-1">
                            <i class="fas fa-eye"></i> Lihat
                          </a></div>
                        <?php elseif ($fileExt === 'pdf') : ?>
                          <a href="<?= $filePath ?>" target="_blank" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> Lihat PDF
                          </a>
                        <?php else : ?>
                          <span class="badge bg-secondary">Format tidak dikenali</span>
                        <?php endif; ?>
                      <?php else : ?>
                        <span class="text-muted">Tidak ada file</span>
                      <?php endif; ?>
                    </td>

                    <td>
                      <a href="index.php?halaman=edit_surat_keluar&id=<?= urlencode($data['id_surat_keluar']) ?>"
                         class="btn btn-warning btn-sm me-1" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>

                      <a href="views/surat_keluar/hapus_surat_keluar.php?id=<?= urlencode($data['id_surat_keluar']) ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Yakin ingin menghapus data ini?')"
                         title="Hapus">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
              <?php
                endwhile;
              else :
                echo '<tr><td colspan="9" class="text-center text-muted">Belum ada data surat keluar.</td></tr>';
              endif;
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==== DataTables ==== -->
<script>
  $(function() {
    $('#tabelSuratKeluar').DataTable({
      scrollX: true,
      autoWidth: false,
      ordering: false,
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data",
        zeroRecords: "Data tidak ditemukan",
      }
    });
  });
</script>
