<?php
// ===================================================
// ✅ INDEX.PHP – Sistem Surat Masuk Keluar (Raihan)
// Versi Aman, Dinamis, dan Anti Error Path
// ===================================================

// Aktifkan error reporting (opsional, untuk debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Mulai session untuk autentikasi (tanpa warning)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include 'pages/sidebar.php'; ?>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">

      <!-- Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="?halaman=dashboard">Home</a></li>
                <li class="breadcrumb-item active">
                  <?php echo isset($_GET['halaman']) ? ucfirst($_GET['halaman']) : 'Dashboard'; ?>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <section class="content">
        <?php
        // ===================================================
        // 🔄 ROUTER OTOMATIS (anti error path & mudah dikembangkan)
        // ===================================================

        if (isset($_GET['halaman'])) {
            $halaman = basename($_GET['halaman']); // keamanan: hilangkan karakter aneh
            $found = false;

            // Coba cari di folder views utama
            if (file_exists("views/$halaman.php")) {
                include("views/$halaman.php");
                $found = true;
            } else {
                // Jika tidak ditemukan, coba cari di subfolder berikut
                $folders = [
                    'admin',
                    'pegawai',
                    'kategori',
                    'surat_masuk',
                    'surat_keluar',
                    'disposisi'
                ];

                foreach ($folders as $folder) {
                    $file = "views/$folder/$halaman.php";
                    if (file_exists($file)) {
                        include($file);
                        $found = true;
                        break;
                    }
                }
            }

            // Jika tetap tidak ditemukan
            if (!$found) {
                include("views/notfound.php");
            }
        } else {
            // Default: tampilkan dashboard
            include("views/dashboard.php");
        }
        ?>
      </section>
    </div>
  </div>

  <!-- SCRIPTS -->
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
