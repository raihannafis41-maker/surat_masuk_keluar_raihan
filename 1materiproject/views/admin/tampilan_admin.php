<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?halaman=admin');
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header('Location: index.php?halaman=admin');
    exit;
}

$tgl_persetujuan = !empty($data['tanggal_persetujuan'])
    ? date('d M Y H:i', strtotime($data['tanggal_persetujuan']))
    : '-';
$status = $data['status'] ?? 'Belum Disetujui';
$role   = $data['role'] ?? 'Admin';
$status_label = ($status === 'Disetujui')
    ? '<span class="badge bg-success"><i class="fas fa-check"></i> Disetujui</span>'
    : '<span class="badge bg-danger"><i class="fas fa-times"></i> Belum Disetujui</span>';
?>

<style>
.card-body {
    background-color: #1e293b;
    color: #fff;
}
.foto-admin {
    width: 150px;
    height: 180px;
    border-radius: 16px;
    border: 4px solid #e3eaf4;
    object-fit: cover;
    object-position: center;
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}
</style>

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detail Admin</h5>
    </div>

    <div class="card-body">
        <div class="row align-items-start text-start">
            <div class="col-md-3 mb-4 text-center">
                <?php
                $fotoPath = "assets/img/" . ($data['foto'] ?? '');
                if (!empty($data['foto']) && file_exists(__DIR__ . '/../../' . $fotoPath)): ?>
                    <img src="<?= htmlspecialchars($fotoPath); ?>" alt="Foto Admin" class="foto-admin mb-2">
                <?php else: ?>
                    <img src="assets/img/default-user.png" alt="Default Foto" class="foto-admin mb-2">
                <?php endif; ?>

                <h5 class="mt-3"><?= htmlspecialchars($data['nama_admin']); ?></h5>
                <span class="badge bg-success">
                    <i class="fas fa-user-shield"></i> <?= htmlspecialchars($role); ?>
                </span>
            </div>

            <div class="col-md-7">
                <h5 class="mb-3 border-bottom pb-2"><i class="fas fa-id-card"></i> Detail Admin</h5>
                <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_admin']); ?></p>
                <p><strong>Username:</strong> <?= htmlspecialchars($data['username']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>
                <p><strong>No. Telp:</strong> <?= htmlspecialchars($data['no_telp']); ?></p>
                <p><strong>Status:</strong> <?= $status_label; ?></p>
                <p><strong>Tanggal Persetujuan:</strong> <?= $tgl_persetujuan; ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($role); ?></p>
            </div>

            <div class="col-md-2">
                <h5 class="fw-bold mb-3">Aksi</h5>
                <a href="index.php?halaman=edit_admin&id=<?= $data['id_admin']; ?>" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="index.php?halaman=admin" class="btn btn-danger w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
