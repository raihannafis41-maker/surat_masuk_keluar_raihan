<?php
// ============================================================
// ✅ NAVBAR FINAL: Menampilkan Foto Profil Admin yang Login
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "koneksi.php";

// Ambil data admin dari session
$id_admin = $_SESSION['id_admin'] ?? null;
$nama_admin = "Administrator";
$email_admin = "-";
$foto = "default.png"; // default foto

if ($id_admin) {
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
    if ($data = mysqli_fetch_assoc($query)) {
        $nama_admin = $data['nama_admin'];
        $email_admin = $data['email'];
        $foto = !empty($data['foto']) ? $data['foto'] : "default.png";
    }
}

// Path folder upload foto
$upload_dir = "uploads/";
$foto_path = $upload_dir . $foto;

// Jika file foto tidak ada, gunakan default
if (!file_exists($foto_path)) {
    $foto_path = "uploads/default.png";
}
?>

<!-- ========================== NAVBAR ========================== -->
<ul class="navbar-nav ml-auto align-items-center">

  <!-- 🔍 Search -->
  <li class="nav-item">
    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
      <i class="fas fa-search"></i>
    </a>
  </li>

  <!-- 🔔 Notifikasi -->
  <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge">3</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">3 Notifikasi</span>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 1 pesan baru
        <span class="float-right text-muted text-sm">3 menit</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 2 user baru
        <span class="float-right text-muted text-sm">12 jam</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="index.php?halaman=notifikasi" class="dropdown-item dropdown-footer">Lihat Semua</a>
    </div>
  </li>

  <!-- 👤 Profil Admin -->
  <li class="nav-item dropdown user-menu ml-3">
    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
      <img src="<?= htmlspecialchars($foto_path) ?>" 
           class="user-image img-circle elevation-2"
           alt="User Image"
           style="object-fit: cover; width: 35px; height: 35px;">
      <span class="d-none d-md-inline ml-2 text-white">
        <?= htmlspecialchars($nama_admin) ?>
      </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <!-- Header -->
      <li class="user-header bg-primary">
        <img src="<?= htmlspecialchars($foto_path) ?>"
             class="img-circle elevation-2"
             alt="User Image"
             style="object-fit: cover; width: 100px; height: 100px;">
        <p>
          <?= htmlspecialchars($nama_admin) ?><br>
          <small><?= htmlspecialchars($email_admin) ?></small>
        </p>
      </li>

      <!-- Body -->
      <li class="user-body text-center">
        <a href="index.php?halaman=profil" class="btn btn-sm btn-outline-light">
          <i class="fas fa-user"></i> Profil Saya
        </a>
      </li>

      <!-- Footer -->
      <li class="user-footer">
        <a href="index.php?halaman=pengaturan" class="btn btn-default btn-flat">
          <i class="fas fa-cog"></i> Pengaturan
        </a>
        <a href="logout.php" class="btn btn-danger btn-flat float-right"
           onclick="return confirm('Yakin ingin logout?')">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
      </li>
    </ul>
  </li>
</ul>
