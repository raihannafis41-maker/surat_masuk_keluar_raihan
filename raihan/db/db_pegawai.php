<?php
// Aktifkan error reporting untuk debugging (nonaktifkan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
include 'koneksi.php';

// Query data pegawai
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-users"></i> Data Pegawai
        </h3>
        <a href="index.php?halaman=tambah_pegawai" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
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
                            $foto = $data['foto'] ?? '';
                            $fotoPath = 'foto/' . $foto; // 🔥 Pastikan sesuai folder penyimpanan
                    ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['nip'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['nama_pegawai'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['jabatan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['no_telp'] ?? '-') ?></td>
                                <td class="text-center"><?= htmlspecialchars($data['golongan'] ?? '-') ?></td>
                                <td class="text-center">
                                    <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                                        <img src="<?= $fotoPath ?>" alt="Foto Pegawai" width="60" height="60" class="rounded-circle border">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?halaman=edit_pegawai&id=<?= urlencode($data['id_pegawai']) ?>" 
                                       class="btn btn-warning btn-sm" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="hapus_pegawai.php?id=<?= urlencode($data['id_pegawai']) ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?');"
                                       title="Hapus Data">
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
</div>
