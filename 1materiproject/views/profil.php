<?php
// =============================================================
// ✅ PROFIL.PHP - Tampilan Profil Admin Modern & Menarik
// =============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../koneksi.php';

// Pastikan user sudah login
if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location='login.php';</script>";
    exit;
}

// Ambil data admin dari database
$id_admin = $_SESSION['id_admin'];
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
$data = mysqli_fetch_assoc($query);

// Foto profil
$foto_admin = !empty($data['foto']) ? $data['foto'] : 'default-avatar.png';
$foto_path = "uploads/" . $foto_admin;

// Jika file foto tidak ada, pakai default
if (!file_exists(__DIR__ . '/../' . $foto_path)) {
    $foto_path = "assets/img/default-avatar.png";
}
?>

<!-- ========================== HALAMAN PROFIL ========================== -->
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-gradient-primary text-white text-center">
            <h3 class="mb-0"><i class="fas fa-user-circle"></i> Profil Administrator</h3>
          </div>

          <div class="card-body text-center p-5">

            <!-- Foto Profil -->
            <div class="position-relative d-inline-block mb-3">
              <img src="<?= htmlspecialchars($foto_path) ?>"
                   alt="Foto Profil"
                   class="img-circle elevation-2 shadow"
                   style="width:130px; height:130px; object-fit:cover; border:3px solid #007bff;">
              <a href="index.php?halaman=pengaturan"
                 class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2"
                 title="Ganti Foto">
                <i class="fas fa-camera"></i>
              </a>
            </div>

            <!-- Nama Admin -->
            <h3 class="mt-3 mb-1 text-primary font-weight-bold">
              <?= htmlspecialchars($data['nama_admin'] ?? '-') ?>
            </h3>
            <p class="text-muted mb-4"><i class="fas fa-user-shield"></i> Administrator</p>

            <!-- Informasi Profil -->
            <div class="card bg-light shadow-sm text-start mb-4">
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user mr-2 text-primary"></i> Username</span>
                    <strong><?= htmlspecialchars($data['username'] ?? '-') ?></strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-envelope mr-2 text-primary"></i> Email</span>
                    <strong><?= htmlspecialchars($data['email'] ?? '-') ?></strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-phone mr-2 text-primary"></i> No. Telepon</span>
                    <strong><?= htmlspecialchars($data['no_telp'] ?? '-') ?></strong>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-center gap-3">
              <a href="index.php?halaman=pengaturan" class="btn btn-primary btn-lg mx-2">
                <i class="fas fa-edit"></i> Ubah Profil
              </a>
              <a href="logout.php" class="btn btn-danger btn-lg mx-2" onclick="return confirm('Yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i> Keluar
              </a>
            </div>

          </div>

          <div class="card-footer bg-light text-center">
            <small class="text-muted">Terakhir login: <?= date("d M Y, H:i") ?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== ANIMASI HALUS (CSS) ==================== -->
<style>
.card {
  transition: all 0.3s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.btn i {
  margin-right: 6px;
}
a.position-absolute:hover {
  background-color: #0056b3 !important;
}
</style>
