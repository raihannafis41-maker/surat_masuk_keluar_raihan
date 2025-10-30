<?php
// Pastikan koneksi ke database
include 'koneksi.php';

// Ambil data disposisi beserta surat masuk dan pegawai
$query = "
  SELECT d.*, sm.no_surat, sm.pengirim, p.nama_pegawai 
  FROM disposisi d
  JOIN surat_masuk sm ON d.id_surat_masuk = sm.id_surat_masuk
  JOIN pegawai p ON d.id_pegawai = p.id_pegawai
  ORDER BY d.id_disposisi DESC
";

$result = mysqli_query($koneksi, $query);
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Disposisi</h3>
    </div>

    <div class="card-body">
        <a href="index.php?halaman=tambah_disposisi" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Disposisi
        </a>

        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Pengirim</th>
                    <th>Pegawai</th>
                    <th>Tanggal Disposisi</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>

                        <td><?= htmlspecialchars($row['pengirim']) ?></td>
                        <td><?= htmlspecialchars($row['nama_pegawai']) ?></td>
                        <td><?= htmlspecialchars($row['tgl_disposisi']) ?></td>
                        <td>
                            <?php
                            if ($row['status_disposisi'] == 'Belum Dibaca') {
                                echo "<span class='badge badge-secondary'>Belum Dibaca</span>";
                            } elseif ($row['status_disposisi'] == 'Proses') {
                                echo "<span class='badge badge-warning'>Proses</span>";
                            } else {
                                echo "<span class='badge badge-success'>Selesai</span>";
                            }
                            ?>
                        </td>
                        <td><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
                        <td>
                            <?php if (!empty($row['file_disposisi'])): ?>
                                <a href="uploads/<?= $row['file_disposisi'] ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Lihat
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada file</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?halaman=edit_disposisi&id=<?= $row['id_disposisi'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                           <a href="views/disposisi/hapus_disposisi.php?id=<?= $row['id_disposisi']; ?>" class="btn btn-danger btn-sm">Hapus</a>

                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>