<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';


// Ambil data dari tabel pegawai
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Pegawai</h3>
        <div class="card-tools">
            <a href="index.php?halaman=tambah_pegawai" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Pegawai
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Golongan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($query) > 0):
                    while ($data = mysqli_fetch_assoc($query)):
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['nip'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($data['nama_pegawai'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($data['jabatan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($data['no_telp'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($data['golongan'] ?? '-') ?></td>

                            <td>
                                <?php
                                $foto = $data['foto'] ?? '';
                                $fotoPath = 'foto/' . $foto; // 🔥 Perbaikan di sini — tanpa ../../

                                if (!empty($foto) && file_exists($fotoPath)) {
                                    echo '<img src="' . $fotoPath . '" alt="Foto Pegawai" width="65" height="60" class="rounded-circle border">';
                                } else {
                                    echo '<span class="text-muted">Tidak ada</span>';
                                }
                                ?>
                            </td>


                            <td>
                                <a href="index.php?halaman=edit_pegawai&id=<?= urlencode($data['id_pegawai']) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="hapus_pegawai.php?id=<?= urlencode($data['id_pegawai']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data ini?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    endwhile;
                else:
                    echo '<tr><td colspan="9" class="text-center text-muted">Data pegawai tidak ditemukan.</td></tr>';
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>