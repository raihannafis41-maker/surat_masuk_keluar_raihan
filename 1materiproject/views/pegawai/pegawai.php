<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../koneksi.php';

// Ambil semua data pegawai
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>

<div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h4 class="m-0 text-dark">
            <i class="fas fa-user-tie"></i> Data Pegawai
        </h4>
        <a href="index.php?halaman=tambah_pegawai" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card shadow-sm text-center border-0" style="background-color: #2f3542; color: #fff;">
                            <div class="card-body">
                                <?php
                                $fotoPath = "foto/" . ($row['foto'] ?? '');
                                if (!empty($row['foto']) && file_exists($fotoPath)): ?>
                                    <img src="<?= htmlspecialchars($fotoPath); ?>" 
                                         alt="Foto Pegawai" 
                                         class="rounded-circle mb-3" 
                                         width="100" height="100"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <img src="assets/img/default-user.png" 
                                         alt="Default" 
                                         class="rounded-circle mb-3" 
                                         width="100" height="100">
                                <?php endif; ?>

                                <h5 class="fw-bold"><?= htmlspecialchars($row['nama_pegawai']); ?></h5>
                                <p class="mb-1"><i class="fas fa-id-card"></i> <?= htmlspecialchars($row['nip'] ?? '-'); ?></p>
                                <p class="mb-1"><i class="fas fa-briefcase"></i> <?= htmlspecialchars($row['jabatan'] ?? '-'); ?></p>
                                <p class="mb-1"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email'] ?? '-'); ?></p>
                                <p class="mb-2"><i class="fas fa-phone"></i> <?= htmlspecialchars($row['no_telp'] ?? '-'); ?></p>

                                <div class="d-flex justify-content-center">
                                    <a href="index.php?halaman=tampilan_pegawai&id=<?= $row['id_pegawai']; ?>" 
                                       class="btn btn-info btn-sm mx-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="index.php?halaman=edit_pegawai&id=<?= $row['id_pegawai']; ?>" 
                                       class="btn btn-warning btn-sm mx-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="index.php?halaman=hapus_pegawai&id=<?= $row['id_pegawai']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus pegawai ini?')"
                                       class="btn btn-danger btn-sm mx-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">Belum ada data pegawai.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
