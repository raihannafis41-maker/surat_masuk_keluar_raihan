<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/../../koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?halaman=pegawai');
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id_pegawai = '$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header('Location: index.php?halaman=pegawai');
    exit;
}
?>

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detail Pegawai</h5>
    </div>

    <div class="card-body bg-dark text-white">
        <div class="row align-items-start text-start">
            <div class="col-md-3 mb-4 text-center">
                <?php
                $fotoPath = "foto/" . ($data['foto'] ?? '');
                if (!empty($data['foto']) && file_exists($fotoPath)): ?>
                    <img src="<?= htmlspecialchars($fotoPath); ?>" 
                         class="rounded-circle border border-light shadow-sm mb-2"
                         width="160" height="160" style="object-fit: cover;">
                <?php else: ?>
                    <img src="assets/img/default-user.png"
                         class="rounded-circle border border-light shadow-sm mb-2"
                         width="160" height="160">
                <?php endif; ?>
                <h5 class="mt-2"><?= htmlspecialchars($data['nama_pegawai']); ?></h5>
                <span class="badge bg-success"><i class="fas fa-user-tie"></i> Pegawai</span>
            </div>

            <div class="col-md-7">
                <h5 class="mb-3 border-bottom pb-2"><i class="fas fa-id-card"></i> Informasi Lengkap</h5>
                <p><strong>NIP:</strong> <?= htmlspecialchars($data['nip']); ?></p>
                <p><strong>Jabatan:</strong> <?= htmlspecialchars($data['jabatan']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>
                <p><strong>No. Telp:</strong> <?= htmlspecialchars($data['no_telp']); ?></p>
                <p><strong>Golongan:</strong> <?= htmlspecialchars($data['golongan']); ?></p>
            </div>

            <div class="col-md-2">
                <h5 class="fw-bold mb-3">Aksi</h5>
                <a href="index.php?halaman=edit_pegawai&id=<?= $data['id_pegawai']; ?>" class="btn btn-info w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="index.php?halaman=pegawai" class="btn btn-danger w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
