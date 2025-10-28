<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// koneksi database
require_once 'koneksi.php'; // sesuaikan path dengan struktur kamu

if (!isset($koneksi) || !$koneksi) {
  die('Koneksi DB tidak ditemukan. Periksa include koneksi.');
}

// ambil data dari tabel surat_keluar
$query = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY id_surat_keluar DESC") or die(mysqli_error($koneksi));
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Surat Keluar</h3>
    </div>

    <div class="card card-solid">
        <div class="col">
           <a href="index.php?halaman=tambah_surat_keluar" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Surat Keluar
            </a>

         <div class="card-body table-responsive p-3">
      <table class="table table-hover table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th style="width:50px;">No</th>
            <th>ID Surat</th>
            <th>No Surat</th>
            <th style="width:130px;">Tanggal Surat</th>
            <th>Tujuan</th>
            <th style="width:200px;">Alamat Tujuan</th>
            <th style="width:200px;">Perihal</th>
            <th style="width:250px;">Isi</th>
            <th>File Surat</th>
            <th>ID Kategori</th>
            <th>ID Admin</th>
            <th>ID Pegawai</th>
            <th style="width:110px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
                   <?php
          $no = 1;
          if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
              $id = urlencode($data['id_surat_keluar'] ?? '');
              echo '<tr>';
              echo '<td>' . $no++ . '</td>';
              echo '<td>' . htmlspecialchars($data['id_surat_keluar'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['no_surat'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['tgl_surat'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['tujuan'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['alamat_tujuan'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['perihal'] ?? '') . '</td>';
              echo '<td class="text-start">' . htmlspecialchars($data['isi'] ?? '') . '</td>';

              echo '<td>';
              if (!empty($data['file_surat'])) {
                echo '<a href="files/' . htmlspecialchars($data['file_surat']) . '" target="_blank">Lihat</a>';
              } else {
                echo '-';
              }
              echo '</td>';

              echo '<td>' . htmlspecialchars($data['id_kategori'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['id_admin'] ?? '') . '</td>';
              echo '<td>' . htmlspecialchars($data['id_pegawai'] ?? '') . '</td>';

              echo '<td>
                      <a href="index.php?halaman=edit_surat_keluar&id=' . $id . '" class="btn btn-warning btn-sm me-1">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="views/surat_keluar/hapus_surat_keluar.php?id=' . $id . '" 
                         class="btn btn-danger btn-sm"
                         onclick="return confirm(\'Yakin ingin menghapus data ini?\')">
                         <i class="fas fa-trash"></i>
                      </a>
                    </td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="13" class="text-center">Data surat keluar tidak ditemukan</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Optional: aktifkan DataTables agar tabel bisa scroll, search, sort -->
<script>
  $(function () {
    $('#example1').DataTable({
      scrollX: true,
      autoWidth: false
    });
  });
</script>

