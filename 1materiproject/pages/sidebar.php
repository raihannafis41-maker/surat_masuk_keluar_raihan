<?php
// Pastikan koneksi dan session aktif
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include_once 'koneksi.php';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="index.php?halaman=dashboard" class="brand-link text-center">
    <span class="brand-text font-weight-light text-white"><b>Surat</b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Panel User -->
    <div class="user-panel text-center mt-3 pb-3 mb-3 border-bottom">
      <div class="image mb-2">
        <?php
        // ====== AMBIL FOTO USER ======
        $root_path = dirname(__DIR__); // naik satu folder dari /include/
        $web_path  = 'assets/img/';    // path web (untuk <img>)

        $foto = '';

        if (!empty($_SESSION['id_admin'])) {
          $id = $_SESSION['id_admin'];
          $query = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id_admin='$id'");
          $data = mysqli_fetch_assoc($query);
          $foto = $data['foto'] ?? '';
        } elseif (!empty($_SESSION['id_pegawai'])) {
          $id = $_SESSION['id_pegawai'];
          $query = mysqli_query($koneksi, "SELECT foto FROM pegawai WHERE id_pegawai='$id'");
          $data = mysqli_fetch_assoc($query);
          $foto = $data['foto'] ?? '';
        }

        // Cek apakah foto ada di folder assets/img
        $foto_full_path = $root_path . "/assets/img/" . $foto;
        if (!empty($foto) && file_exists($foto_full_path)) {
          $foto_path = $web_path . $foto;
        } else {
          $foto_path = $web_path . "default.png";
        }
        ?>
        <img src="<?= htmlspecialchars($foto_path) ?>"
             alt="User Image"
             style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #007bff;">
      </div>
      <div class="info">
        <a href="index.php?halaman=profil" class="d-block text-white font-weight-bold" style="font-size: 15px;">
          <?= htmlspecialchars($_SESSION['nama_admin'] ?? $_SESSION['nama'] ?? 'Pengguna') ?>
        </a>
        <small class="text-muted d-block" style="font-size: 13px;">
          <?= htmlspecialchars($_SESSION['nip'] ?? $_SESSION['nohp'] ?? '') ?>
        </small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="index.php?halaman=dashboard" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt text-info"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header text-uppercase">Master Data</li>

        <!-- Data Admin -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-shield text-warning"></i>
            <p>Data Admin<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="index.php?halaman=admin" class="nav-link"><i class="far fa-circle nav-icon"></i>Data Admin</a></li>
            <li class="nav-item"><a href="index.php?halaman=tambah_admin" class="nav-link"><i class="far fa-circle nav-icon"></i>Tambah Admin</a></li>
          </ul>
        </li>

        <!-- Data Pegawai -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users text-primary"></i>
            <p>Data Pegawai<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="index.php?halaman=pegawai" class="nav-link"><i class="far fa-circle nav-icon"></i>Data Pegawai</a></li>
            <li class="nav-item"><a href="index.php?halaman=tambah_pegawai" class="nav-link"><i class="far fa-circle nav-icon"></i>Tambah Pegawai</a></li>
          </ul>
        </li>

        <!-- Kategori Surat -->
        <li class="nav-item">
          <a href="index.php?halaman=kategori" class="nav-link">
            <i class="nav-icon fas fa-tags text-success"></i>
            <p>Kategori Surat</p>
          </a>
        </li>

        <li class="nav-header text-uppercase">Manajemen Surat</li>

        <!-- Surat Masuk -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-envelope text-info"></i>
            <p>Surat Masuk<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="index.php?halaman=surat_masuk" class="nav-link"><i class="far fa-circle nav-icon"></i>Data Surat Masuk</a></li>
            <li class="nav-item"><a href="index.php?halaman=tambah_surat_masuk" class="nav-link"><i class="far fa-circle nav-icon"></i>Tambah Surat Masuk</a></li>
          </ul>
        </li>

        <!-- Surat Keluar -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-paper-plane text-success"></i>
            <p>Surat Keluar<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="index.php?halaman=surat_keluar" class="nav-link"><i class="far fa-circle nav-icon"></i>Data Surat Keluar</a></li>
            <li class="nav-item"><a href="index.php?halaman=tambah_surat_keluar" class="nav-link"><i class="far fa-circle nav-icon"></i>Tambah Surat Keluar</a></li>
          </ul>
        </li>

        <!-- Disposisi -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list text-danger"></i>
            <p>Disposisi<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="index.php?halaman=disposisi" class="nav-link"><i class="far fa-circle nav-icon"></i>Data Disposisi</a></li>
            <li class="nav-item"><a href="index.php?halaman=tambah_disposisi" class="nav-link"><i class="far fa-circle nav-icon"></i>Tambah Disposisi</a></li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>

<!-- STYLE TAMBAHAN -->
<style>
  .brand-link {
    background-color: #004085 !important;
  }

  .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #0069d9 !important;
    color: #fff !important;
  }

  .nav-sidebar .nav-link:hover {
    background-color: #004b8d !important;
    color: #fff !important;
    transition: 0.3s ease;
  }

  .nav-header {
    font-size: 0.85rem;
    color: #adb5bd !important;
    padding-left: 15px;
    margin-top: 10px;
  }

  .user-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .user-panel .image img {
    transition: transform 0.3s ease;
  }

  .user-panel .image img:hover {
    transform: scale(1.05);
  }

  .user-panel .info {
    text-align: center;
  }

  @media (max-width: 768px) {
    .user-panel .info a {
      font-size: 14px;
    }
  }
</style>
