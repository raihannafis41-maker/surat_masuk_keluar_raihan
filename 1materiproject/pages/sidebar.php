<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="index.php?halaman=dashboard" class="brand-link text-center">
    <img src="dist/img/hanjay.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .9">
    <span class="brand-text font-weight-bold text-light ml-1">Surat</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">



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

        <!-- Kategori -->
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
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<style>
  .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #0069d9 !important;
    color: #fff !important;
  }

  .nav-sidebar .nav-link:hover {
    background-color: #004b8d !important;
    color: #fff !important;
    transition: 0.3s ease;
  }

  .brand-link {
    background-color: #004085 !important;
  }

  .user-panel .image img {
    border: 2px solid #007bff;
  }

  .nav-header {
    font-size: 0.85rem;
    color: #adb5bd !important;
    padding-left: 15px;
    margin-top: 10px;
  }
</style>