<?php
// before_login.php — Halaman publik sebelum login
session_start();

// Jika sudah login langsung ke dashboard
if (!empty($_SESSION['login']) && $_SESSION['login'] === true) {
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Surat Masuk & Keluar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fc;
    }
    .navbar {
      background-color: #012a4a !important;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 500;
    }
    .hero-section {
      position: relative;
      background: url('dist/img/banner_surat.jpg') center/cover no-repeat;
      height: 320px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
    }
    .hero-section::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.55);
    }
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .hero-content h1 {
      font-weight: 700;
      font-size: 36px;
      color: #e9f6ff;
    }
    .hero-content p {
      font-size: 16px;
      color: #dceefc;
      margin-bottom: 20px;
    }
    .btn-main {
      background-color: #2f9ef3;
      color: #fff;
      padding: 10px 22px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
      text-decoration: none;
    }
    .btn-main:hover {
      background-color: #0077cc;
      color: #fff;
    }
    .section-title {
      text-align: center;
      margin-top: 40px;
      margin-bottom: 20px;
      font-weight: 700;
      color: #012a4a;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .footer {
      margin-top: 60px;
      background: #012a4a;
      color: #fff;
      text-align: center;
      padding: 16px 0;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- ======== NAVBAR ======== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">📨 Sistem Surat</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="#tentang" class="nav-link">Tentang</a></li>
          <li class="nav-item"><a href="#fitur" class="nav-link">Fitur</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link btn btn-sm btn-outline-light ms-2">Login Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ======== HERO SECTION ======== -->
  <section class="hero-section">
    <div class="hero-content">
      <h1>Sistem Surat Masuk & Keluar</h1>
      <p>Kelola surat dengan cepat, aman, dan efisien dalam satu sistem terpadu.</p>
      <a href="login.php" class="btn-main">Masuk ke Dashboard</a>
    </div>
  </section>

  <!-- ======== FITUR ======== -->
  <div class="container">
    <h2 class="section-title" id="fitur">Fitur Utama</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_inbox.png" width="60" alt="Surat Masuk">
            <h5 class="card-title mt-3">Surat Masuk</h5>
            <p class="card-text text-muted">Lihat dan kelola semua surat masuk yang diterima instansi dengan mudah.</p>
            <a href="login.php?next=surat_masuk" class="btn btn-main">Lihat Surat Masuk</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_outbox.png" width="60" alt="Surat Keluar">
            <h5 class="card-title mt-3">Surat Keluar</h5>
            <p class="card-text text-muted">Catat, arsipkan, dan cetak surat keluar dengan cepat dan akurat.</p>
            <a href="login.php?next=surat_keluar" class="btn btn-main">Lihat Surat Keluar</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_disposisi.png" width="60" alt="Disposisi">
            <h5 class="card-title mt-3">Disposisi</h5>
            <p class="card-text text-muted">Distribusikan surat ke pegawai atau unit terkait dengan mudah.</p>
            <a href="login.php?next=disposisi" class="btn btn-main">Lihat Disposisi</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======== TENTANG ======== -->
  <div class="container">
    <h2 class="section-title" id="tentang">Tentang Aplikasi</h2>
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <p class="text-muted">
          Aplikasi <strong>Sistem Surat Masuk & Keluar</strong> dikembangkan untuk membantu instansi dalam mengelola administrasi surat dengan efisien.
          Semua surat masuk, surat keluar, dan disposisi dapat diakses dengan aman dan cepat dalam satu dashboard.
        </p>
      </div>
    </div>
  </div>

  <!-- ======== FOOTER ======== -->
  <div class="footer">
    &copy; <?= date('Y') ?> Sistem Surat Masuk & Keluar — All Rights Reserved
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// before_login.php — Halaman publik sebelum login
session_start();

// Jika sudah login langsung ke dashboard
if (!empty($_SESSION['login']) && $_SESSION['login'] === true) {
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Surat Masuk & Keluar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fc;
    }
    .navbar {
      background-color: #012a4a !important;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 500;
    }
    .hero-section {
      position: relative;
      background: url('dist/img/banner_surat.jpg') center/cover no-repeat;
      height: 320px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
    }
    .hero-section::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.55);
    }
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .hero-content h1 {
      font-weight: 700;
      font-size: 36px;
      color: #e9f6ff;
    }
    .hero-content p {
      font-size: 16px;
      color: #dceefc;
      margin-bottom: 20px;
    }
    .btn-main {
      background-color: #2f9ef3;
      color: #fff;
      padding: 10px 22px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
      text-decoration: none;
    }
    .btn-main:hover {
      background-color: #0077cc;
      color: #fff;
    }
    .section-title {
      text-align: center;
      margin-top: 40px;
      margin-bottom: 20px;
      font-weight: 700;
      color: #012a4a;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .footer {
      margin-top: 60px;
      background: #012a4a;
      color: #fff;
      text-align: center;
      padding: 16px 0;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- ======== NAVBAR ======== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">📨 Sistem Surat</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="#tentang" class="nav-link">Tentang</a></li>
          <li class="nav-item"><a href="#fitur" class="nav-link">Fitur</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link btn btn-sm btn-outline-light ms-2">Login Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ======== HERO SECTION ======== -->
  <section class="hero-section">
    <div class="hero-content">
      <h1>Sistem Surat Masuk & Keluar</h1>
      <p>Kelola surat dengan cepat, aman, dan efisien dalam satu sistem terpadu.</p>
      <a href="login.php" class="btn-main">Masuk ke Dashboard</a>
    </div>
  </section>

  <!-- ======== FITUR ======== -->
  <div class="container">
    <h2 class="section-title" id="fitur">Fitur Utama</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_inbox.png" width="60" alt="Surat Masuk">
            <h5 class="card-title mt-3">Surat Masuk</h5>
            <p class="card-text text-muted">Lihat dan kelola semua surat masuk yang diterima instansi dengan mudah.</p>
            <a href="login.php?next=surat_masuk" class="btn btn-main">Lihat Surat Masuk</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_outbox.png" width="60" alt="Surat Keluar">
            <h5 class="card-title mt-3">Surat Keluar</h5>
            <p class="card-text text-muted">Catat, arsipkan, dan cetak surat keluar dengan cepat dan akurat.</p>
            <a href="login.php?next=surat_keluar" class="btn btn-main">Lihat Surat Keluar</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center p-3">
          <div class="card-body">
            <img src="dist/img/icon_disposisi.png" width="60" alt="Disposisi">
            <h5 class="card-title mt-3">Disposisi</h5>
            <p class="card-text text-muted">Distribusikan surat ke pegawai atau unit terkait dengan mudah.</p>
            <a href="login.php?next=disposisi" class="btn btn-main">Lihat Disposisi</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======== TENTANG ======== -->
  <div class="container">
    <h2 class="section-title" id="tentang">Tentang Aplikasi</h2>
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <p class="text-muted">
          Aplikasi <strong>Sistem Surat Masuk & Keluar</strong> dikembangkan untuk membantu instansi dalam mengelola administrasi surat dengan efisien.
          Semua surat masuk, surat keluar, dan disposisi dapat diakses dengan aman dan cepat dalam satu dashboard.
        </p>
      </div>
    </div>
  </div>

  <!-- ======== FOOTER ======== -->
  <div class="footer">
    &copy; <?= date('Y') ?> Sistem Surat Masuk & Keluar — All Rights Reserved
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
