<?php
// Aktifkan error reporting agar mudah debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
require_once 'koneksi.php';

// Ambil data admin dari database
$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin DESC");
?>

<!-- Default box -->
<div class="card card-solid">
    <div class="col">
        <a href="index.php?halaman=tambah_admin" class="btn btn-primary float-right btn-sm mt-3">
            <i class="fas fa-user-plus"></i> Tambah Admin
        </a>
    </div>

    <div class="card-body pb-0">
        <div class="row">
            <?php
            if (mysqli_num_rows($query) > 0):
                while ($data = mysqli_fetch_assoc($query)):
                    $foto = !empty($data['foto']) ? 'foto/' . htmlspecialchars($data['foto']) : 'dist/img/user2-160x160.jpg';
            ?>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                Administrator
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b><?= htmlspecialchars($data['nama_admin']); ?></b></h2>
                                        <p class="text-muted text-sm"><b>Username: </b> <?= htmlspecialchars($data['username']); ?></p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small">
                                                <span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>
                                                <?= htmlspecialchars($data['email']); ?>
                                            </li>
                                            <li class="small">
                                                <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                <?= htmlspecialchars($data['no_telp']); ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="<?= $foto; ?>" alt="Foto Admin" class="img-circle img-fluid" style="width:100px; height:100px; object-fit:cover;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="index.php?halaman=edit_admin&id=<?= urlencode($data['id_admin']); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapus_admin.php?id=<?= urlencode($data['id_admin']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            else:
                echo '<div class="col-12 text-center"><p class="text-muted">Belum ada data admin.</p></div>';
            endif;
            ?>
        </div>
    </div>

    <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
            </ul>
        </nav>
    </div>
</div>
