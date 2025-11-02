<?php
// ============================================================
// ✅ NAVBAR FINAL FIX — Foto Kotak & Tampilan Rapi
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$root_path = dirname(__DIR__);
require_once $root_path . "/koneksi.php";

// ===== Default value =====
$nama_user = "Pengguna";
$email_user = "-";
$foto_path = "assets/img/default.png"; // fallback
$foto_full_path = $root_path . "/assets/img/default.png";

// ===== Deteksi role login =====
if (!empty($_SESSION['id_admin'])) {
    $id = $_SESSION['id_admin'];
    $query = mysqli_query($koneksi, "SELECT nama_admin AS nama, email, foto FROM admin WHERE id_admin='$id'");
} elseif (!empty($_SESSION['id_pegawai'])) {
    $id = $_SESSION['id_pegawai'];
    $query = mysqli_query($koneksi, "SELECT nama_pegawai AS nama, email, foto FROM pegawai WHERE id_pegawai='$id'");
}

if (!empty($query) && $data = mysqli_fetch_assoc($query)) {
    $nama_user = $data['nama'] ?? $nama_user;
    $email_user = $data['email'] ?? $email_user;

    if (!empty($data['foto'])) {
        $foto_full_path = $root_path . "/assets/img/" . $data['foto'];
        if (file_exists($foto_full_path)) {
            $foto_path = "assets/img/" . $data['foto'];
        }
    }
}

// ===== Fallback =====
if (!file_exists($foto_full_path)) {
    $foto_path = "assets/img/default.png";
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

  <!-- 👤 Profil -->
  <li class="nav-item dropdown user-menu ml-3">
    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
      <img src="<?= htmlspecialchars($foto_path) ?>" 
           class="user-image elevation-2"
           alt="User Image"
           style="object-fit: cover; width: 35px; height: 35px; border-radius: 6px;">
      <span class="d-none d-md-inline ml-2 text-white font-weight-bold">
        <?= htmlspecialchars($nama_user) ?>
      </span>
    </a>

    <!-- Dropdown Menu -->
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

      <!-- Header -->
      <li class="user-header bg-primary d-flex flex-column align-items-center">
        <img src="<?= htmlspecialchars($foto_path) ?>"
             alt="User Image"
             style="object-fit: cover; width: 100px; height: 100px; border-radius: 10px; border: 2px solid #fff;">
        <p class="mt-2 mb-0 font-weight-bold"><?= htmlspecialchars($nama_user) ?></p>
        <small><?= htmlspecialchars($email_user) ?></small>
      </li>

      <!-- Body -->
      <li class="user-body text-center py-2">
        <a href="index.php?halaman=profil" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-user"></i> Profil Saya
        </a>
      </li>

      <!-- Footer -->
      <li class="user-footer d-flex justify-content-between">
        <a href="index.php?halaman=pengaturan" class="btn btn-default btn-flat">
          <i class="fas fa-cog"></i> Pengaturan
        </a>
        <a href="logout.php" class="btn btn-danger btn-flat"
           onclick="return confirm('Yakin ingin logout?')">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </a>
      </li>
    </ul>
  </li>
</ul>

<!-- ========================== STYLE TAMBAHAN ========================== -->
<style>
  /* Membuat foto user kotak dan rapi */
  .user-menu .user-image {
    border: 2px solid #007bff;
    transition: transform 0.3s ease;
  }

  .user-menu .user-image:hover {
    transform: scale(1.08);
  }

  .user-header img {
    transition: transform 0.3s ease;
  }

  .user-header img:hover {
    transform: scale(1.05);
  }

  .user-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 10px;
  }

  .user-footer .btn {
    font-size: 0.9rem;
  }

  .navbar-nav .nav-link {
    color: white !important;
  }

  .navbar-nav .nav-link:hover {
    color: #ffc107 !important;
  }
</style>
