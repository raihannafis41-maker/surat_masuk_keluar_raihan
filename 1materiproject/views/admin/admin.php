<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../koneksi.php';

// Ambil semua data admin
$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin DESC");
?>

<style>
.card-admin {
    background-color: #2f3542;
    color: #fff;
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: 0.3s ease;
}
.card-admin:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

/* ✅ Foto di tengah */
.foto-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.foto-admin {
    width: 150px;
    height: 180px;
    border-radius: 16px;
    object-fit: cover;
    object-position: center;
    border: 4px solid #e3eaf4;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>

<div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h4 class="m-0 text-light">
            <i class="fas fa-users-cog"></i> Data Admin
        </h4>
        <a href="index.php?halaman=tambah_admin" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Admin
        </a>
    </div>
</div>

<section class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <?php
                    $fotoFile = htmlspecialchars($row['foto'] ?? '');
                    $fotoPath = 'assets/img/default-user.png';
                    $pathCheck = __DIR__ . '/../../assets/img/' . $fotoFile;
                    if (!empty($fotoFile) && file_exists($pathCheck)) {
                        $fotoPath = 'assets/img/' . $fotoFile;
                    }
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-admin text-center p-3">
                            <div class="foto-wrapper">
                                <img src="<?= $fotoPath ?>" alt="Foto Admin" class="foto-admin">
                            </div>

                            <h5 class="fw-bold"><?= htmlspecialchars($row['nama_admin']); ?></h5>
                            <p class="mb-1"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']); ?></p>
                            <p class="mb-2"><i class="fas fa-phone"></i> <?= htmlspecialchars($row['no_telp']); ?></p>

                            <div class="d-flex justify-content-center flex-wrap">
                                <a href="index.php?halaman=tampilan_admin&id=<?= $row['id_admin']; ?>" class="btn btn-info btn-sm mx-1 mb-1">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="index.php?halaman=edit_admin&id=<?= $row['id_admin']; ?>" class="btn btn-warning btn-sm mx-1 mb-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="index.php?halaman=hapus_admin&id=<?= $row['id_admin']; ?>" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="btn btn-danger btn-sm mx-1 mb-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info py-3 mt-3 rounded-3 shadow-sm">
                        <i class="fas fa-info-circle"></i> Belum ada data admin.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
