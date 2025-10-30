<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../koneksi.php';

// Ambil semua data admin
$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin DESC");
?>

<div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h4 class="m-0 text-dark">
            <i class="fas fa-users-cog"></i> Data Admin
        </h4>
        <a href="index.php?halaman=tambah_admin" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Admin
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
                                <?php if (!empty($row['foto']) && file_exists("uploads/" . $row['foto'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['foto']); ?>" 
                                         alt="Foto Admin" 
                                         class="rounded-circle mb-3" 
                                         width="100" height="100"
                                         style="object-fit: cover;">
                                <?php else: ?>
                                    <img src="assets/img/default-user.png" 
                                         alt="Default" 
                                         class="rounded-circle mb-3" 
                                         width="100" height="100">
                                <?php endif; ?>

                                <h5 class="fw-bold"><?= htmlspecialchars($row['nama_admin']); ?></h5>
                                <p class="mb-1">
                                    <i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']); ?>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone"></i> <?= htmlspecialchars($row['no_telp']); ?>
                                </p>

                                <div class="d-flex justify-content-center flex-wrap">
                                    <!-- Tombol Lihat -->
                                    <a href="index.php?halaman=tampilan_admin&id=<?= $row['id_admin']; ?>" 
                                       class="btn btn-info btn-sm mx-1 mb-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="index.php?halaman=edit_admin&id=<?= $row['id_admin']; ?>" 
                                       class="btn btn-warning btn-sm mx-1 mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <a href="index.php?halaman=hapus_admin&id=<?= $row['id_admin']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus admin ini?')"
                                       class="btn btn-danger btn-sm mx-1 mb-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">Belum ada data admin.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
