<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM penerima");
?>

<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
      <h3 class="card-title mb-0">Daftar Penerima Bantuan</h3>
      <a href="index.php?halaman=tambahpenerima" class="btn btn-light btn-sm">
        <i class="fas fa-plus"></i> Tambah Penerima
      </a>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover text-nowrap">
        <thead class="thead-dark">
          <tr class="text-center">
            <th style="width: 5%">No</th>
            <th>Nama Penerima</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th style="width: 15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($data = mysqli_fetch_assoc($query)) {
            // amankan nilai agar tidak error jika kolom tidak ada
            $nama = isset($data['nama_penerima']) ? htmlspecialchars($data['nama_penerima']) : '-';
            $alamat = isset($data['alamat']) ? htmlspecialchars($data['alamat']) : '-';
            $no_hp = isset($data['no_hp']) ? htmlspecialchars($data['no_hp']) : '-';
          ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= $nama; ?></td>
              <td><?= $alamat; ?></td>
              <td><?= $no_hp; ?></td>
              <td class="text-center">
                <a href="index.php?halaman=editpenerima&id=<?= $data['id_penerima']; ?>" class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="hapus_penerima.php?id=<?= $data['id_penerima']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>