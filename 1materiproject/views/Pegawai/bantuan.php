
<?php
// Query join bantuan dengan kategori
$query = mysqli_query($koneksi, "
  SELECT a.idbantuan, a.namabantuan, a.kondisi, a.posisi, a.tanggalpembelian, k.namakategori
  FROM bantuan a
  LEFT JOIN kategori k ON a.idkategori = k.idkategori
");
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data bantuan</h3>
  </div>

  <div class="card-body">
    <div class="col">
      <a href="index.php?halaman=tambahbantuan" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-plus"></i> Tambah bantuan
      </a>
    </div>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama bantuan</th>
          <th>Kategori</th>
          <th>Kondisi</th>
          <th>Posisi</th>
          <th>Tanggal Pembelian</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) :
        ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['namabantuan']); ?></td>
            <td><?= htmlspecialchars($data['namakategori']); ?></td>
            <td><?= htmlspecialchars($data['kondisi']); ?></td>
            <td><?= htmlspecialchars($data['posisi']); ?></td>
            <td><?= htmlspecialchars($data['tanggalpembelian']); ?></td>
            <td>
              <a href="index.php?halaman=editbantuan&id=<?= $data['idbantuan']; ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <a href="hapus_bantuan.php?id=<?= $data['idbantuan']; ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Yakin ingin menghapus data ini?');">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
