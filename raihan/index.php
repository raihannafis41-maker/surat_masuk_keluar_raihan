<?php
// Aktifkan error reporting (opsional untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mulai session untuk cek login
session_start();

// Jika belum login, arahkan ke login.php
if (empty($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'pages/header.php'; ?>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">

  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <?php include 'pages/navbar.php'; ?>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include 'pages/sidebar.php'; ?>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <?php
        if (isset($_GET['halaman'])) {
          switch ($_GET['halaman']) {

            /* ============================
               BAGIAN ADMIN
            ============================ */
            case "admin":
              include("views/admin/admin.php");
              break;
            case "tambah_admin":
              include("views/admin/tambah_admin.php");
              break;
            case "edit_admin":
              include("views/admin/edit_admin.php");
              break;
            case "hapus_admin":
              include("views/admin/hapus_admin.php");
              break;

            /* ============================
               BAGIAN PEGAWAI
            ============================ */
            case "pegawai":
              include("views/pegawai/pegawai.php");
              break;
            case "tambah_pegawai":
              include("views/pegawai/tambah_pegawai.php");
              break;
            case "edit_pegawai":
              include("views/pegawai/edit_pegawai.php");
              break;
            case "hapus_pegawai":
              include("views/pegawai/hapus_pegawai.php");
              break;

            /* ============================
               BAGIAN KATEGORI
            ============================ */
            case "kategori":
              include("views/kategori/kategori.php");
              break;
            case "tambah_kategori":
              include("views/kategori/tambah_kategori.php");
              break;
            case "edit_kategori":
              include("views/kategori/edit_kategori.php");
              break;
            case "hapus_kategori":
              include("views/kategori/hapus_kategori.php");
              break;

            /* ============================
               BAGIAN SURAT KELUAR
            ============================ */
            case "surat_keluar":
              include("views/surat_keluar/surat_keluar.php");
              break;
            case "tambah_surat_keluar":
              include("views/surat_keluar/tambah_surat_keluar.php");
              break;
            case "edit_surat_keluar":
              include("views/surat_keluar/edit_surat_keluar.php");
              break;
            case "hapus_surat_keluar":
              include("views/surat_keluar/hapus_surat_keluar.php");
              break;

            /* ============================
               BAGIAN SURAT MASUK
            ============================ */
            case "surat_masuk":
              include("views/surat_masuk/surat_masuk.php");
              break;
            case "tambah_surat_masuk":
              include("views/surat_masuk/tambah_surat_masuk.php");
              break;
            case "edit_surat_masuk":
              include("views/surat_masuk/edit_surat_masuk.php");
              break;
            case "hapus_surat_masuk":
              include("views/surat_masuk/hapus_surat_masuk.php");
              break;

            /* ============================
               BAGIAN DISPOSISI
            ============================ */
            case "disposisi":
              include("views/disposisi/disposisi.php");
              break;
            case "tambah_disposisi":
              include("views/disposisi/tambah_disposisi.php");
              break;
            case "edit_disposisi":
              include("views/disposisi/edit_disposisi.php");
              break;
            case "hapus_disposisi":
              include("views/disposisi/hapus_disposisi.php");
              break;

            /* ============================
               DASHBOARD / DEFAULT
            ============================ */
            case "dashboard":
            case "home":
              include("views/dashboard.php");
              break;

            default:
              include("views/notfound.php");
              break;
          }
        } else {
          include("views/dashboard.php"); // dashboard sebagai default
        }
        ?>
      </section>
    </div>
  </div>

  <!-- REQUIRED SCRIPTS -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/pages/dashboard2.js"></script>

</body>

</html>