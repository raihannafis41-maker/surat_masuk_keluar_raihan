


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
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include 'pages/sidebar.php'; ?>
    </aside>


    

      <!-- Main content -->
      <section class="content">
        <?php

        if (isset($_GET['halaman'])) {
          switch ($_GET['halaman']) {

            // bagian admin
            case "admin";
              include("views/admin/admin.php");
              break;
            case "tambahadmin";
              include("views/admin/tambahadmin.php");
              break;
            case "editadmin";
              include("views/admin/editadmin.php");
              break;

            // bagian penerima
            case "penerima";
              include("views/penerima/penerima.php");
              break;
            case "tambahpenerima";
              include("views/penerima/tambahpenerima.php");
              break;
            case "editpenerima";
              include("views/penerima/editpenerima.php");
              break;

              // bagian bantuan
            case "bantuan";
              include("views/bantuan/bantuan.php");
              break;
            case "tambahbantuan";
              include("views/bantuan/tambahbantuan.php");
              break;
            case "editbantuan";
              include("views/bantuan/editbantuan.php");
              break;


            case "dashboard";
              include("views/dashboard.php");
              break;
            case "home";
              include("views/dashboard.php");
              break;
            case "default";
              include("views/notfound.php");
          }

        } else {
          include("pages/notfound.php");
        }
        ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <?php include 'pages/footer.php'; ?>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>
</body>

</html>