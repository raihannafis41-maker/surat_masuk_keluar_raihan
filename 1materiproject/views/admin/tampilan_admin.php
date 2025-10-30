<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../../koneksi.php';

// ✅ Hindari error "session already active"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?halaman=admin');
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika tidak ada data
if (!$data) {
    header('Location: index.php?halaman=admin');
    exit;
}

// Format tanggal (jika ada)
$tgl_persetujuan = !empty($data['tanggal_persetujuan'])
    ? date('d M Y H:i', strtotime($data['tanggal_persetujuan']))
    : '-';

// Default value jika kolom kosong
$status = $data['status'] ?? 'Belum Disetujui';
$role   = $data['role'] ?? 'Admin';

// Jika admin login adalah dirinya sendiri, tandai disetujui
if (isset($_SESSION['id_admin']) && $_SESSION['id_admin'] == $data['id_admin']) {
    $status = 'Disetujui';
}

// Label status
$status_label = ($status === 'Disetujui')
    ? '<span class="badge bg-success"><i class="fas fa-check"></i> Disetujui</span>'
    : '<span class="badge bg-danger"><i class="fas fa-times"></i> Belum Disetujui</span>';
?>

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Admin</h5>
    </div>

    <div class="card-body bg-dark text-white">
        <div class="row align-items-start text-start">

            <!-- FOTO -->
            <div class="col-md-3 mb-4 text-center">
                <label class="fw-bold mb-2">Foto:</label><br>
                <?php if (!empty($data['foto']) && file_exists("uploads/" . $data['foto'])): ?>
                    <img src="uploads/<?= htmlspecialchars($data['foto']); ?>" 
                         alt="Foto Admin"
                         class="rounded-circle border border-light shadow-sm mb-2"
                         width="160" height="160" style="object-fit: cover;">
                <?php else: ?>
                    <img src="assets/img/default-user.png"
                         alt="Default Foto"
                         class="rounded-circle border border-light shadow-sm mb-2"
                         width="160" height="160">
                <?php endif; ?>

                <h5 class="mt-2"><?= htmlspecialchars($data['nama_admin']); ?></h5>
                <span class="badge bg-success">
                    <i class="fas fa-user-shield"></i> <?= htmlspecialchars($role); ?>
                </span>
            </div>

            <!-- DETAIL ADMIN -->
            <div class="col-md-7">
                <h5 class="mb-3 border-bottom pb-2">
                    <i class="fas fa-id-card"></i> Detail Admin
                </h5>
                <p><i class="fas fa-user"></i> <strong>Nama:</strong> <?= htmlspecialchars($data['nama_admin']); ?></p>
                <p><i class="fas fa-user-circle"></i> <strong>Username:</strong> <?= htmlspecialchars($data['username']); ?></p>
                <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($data['email']); ?></p>
                <p><i class="fas fa-phone"></i> <strong>No. Telp:</strong> <?= htmlspecialchars($data['no_telp']); ?></p>
                <p><i class="fas fa-lock"></i> <strong>Password:</strong> ********</p>
                <p><i class="fas fa-check-circle"></i> <strong>Status:</strong> <?= $status_label; ?></p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Tanggal Persetujuan:</strong> <?= $tgl_persetujuan; ?></p>
                <p><i class="fas fa-user-tag"></i> <strong>Role:</strong> <?= htmlspecialchars($role); ?></p>
            </div>

            <!-- AKSI -->
            <div class="col-md-2 mt-4 mt-md-0">
                <h5 class="fw-bold mb-3">Aksi</h5>
                <a href="index.php?halaman=edit_admin&id=<?= $data['id_admin']; ?>" 
                   class="btn btn-info w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="index.php?halaman=admin" 
                   class="btn btn-danger w-100">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
