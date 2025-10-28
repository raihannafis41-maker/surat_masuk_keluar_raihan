<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'koneksi.php'; // <--- sesuaikan path

if (!isset($koneksi) || !$koneksi) {
    die('Koneksi DB tidak ditemukan. Periksa include koneksi.');
}

$query = mysqli_query($koneksi, "SELECT * FROM surat_masuk") or die(mysqli_error($koneksi));
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Surat Masuk</h3>
    </div>

    <div class="card card-solid">
        <div class="col">
            <a href="index.php?halaman=tambah_surat" class="btn btn-primary float-right btn-sm mt-3">
                <i class="fas fa-plus"></i> Tambah Surat
            </a>

         <div class="card-body table-responsive p-3">
    <table class="table table-hover table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>No Surat</th>
          <th>Tanggal Surat</th>
          <th>Tanggal Terima</th>
          <th>Pengirim</th>
          <th>Alamat Pengirim</th>
          <th>Perihal</th>
          <th>Isi</th>
          <th>File</th>
          <th>Status</th>
          <th>Kategori</th>
          <th>Pegawai</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>001</td>
          <td>2025-10-07</td>
          <td>2025-10-07</td>
          <td>Dinas Pendidikan Dan Kebudayaan</td>
          <td>Jl. Ahmad Yani</td>
          <td>Undangan Rapat</td>
          <td>Undangan rapat koordinasi kepala sekolah</td>
          <td><a href="#" class="badge badge-info">Lihat</a></td>
          <td><span class="badge badge-success">Baru</span></td>
          <td>Umum</td>
          <td>Admin</td>
          <td>
            <a href="#" class="btn btn-sm btn-warning mx-1" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a href="#" class="btn btn-sm btn-danger mx-1" title="Hapus">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>