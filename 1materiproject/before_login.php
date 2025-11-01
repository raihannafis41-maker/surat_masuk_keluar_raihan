<?php
session_start();
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8fbff;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: linear-gradient(90deg, #023e8a, #07a3f7ff);
      padding: 14px 0;
    }

    .navbar-brand {
      color: #fff !important;
      font-weight: 600;
      font-size: 20px;
    }

    .nav-link {
      color: #fff !important;
      margin-left: 15px;
      font-weight: 500;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #caf0f8 !important;
    }

    .btn-login {
      border: 1px solid #fff;
      border-radius: 30px;
      padding: 5px 15px;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #fff;
      color: #2d2f30ff !important;
    }

    /* ===== HERO SECTION ===== */
    .hero-section {
      background: linear-gradient(rgba(2, 61, 138, 0), rgba(0, 118, 182, 0)), url('dist/img/banner_surat.jpg') center/cover no-repeat;
      color: #fff;
      height: 430px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .hero-content h1 {
      font-weight: 700;
      font-size: 40px;
    }

    .hero-content p {
      font-size: 17px;
      margin-bottom: 25px;
    }

    .btn-main {
      background: #00b4d8;
      color: #fff;
      padding: 12px 28px;
      border-radius: 30px;
      font-weight: 600;
      transition: 0.3s;
      text-decoration: none;
    }

    .btn-main:hover {
      background: #0077b6;
      color: #fff;
    }

    /* ===== FITUR ===== */
    .section-title {
      text-align: center;
      font-weight: 700;
      margin-top: 60px;
      margin-bottom: 30px;
      color: #012a4a;
    }

    .card-feature {
      border: none;
      border-radius: 18px;
      padding: 25px;
      background: #fff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .card-feature:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .card-feature img {
      width: 70px;
      margin-bottom: 15px;
    }

    .card-feature h5 {
      color: #012a4a;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .card-feature p {
      color: #6c757d;
      font-size: 15px;
    }

    /* ===== FOOTER ===== */
    .footer {
      background: #012a4a;
      color: #fff;
      text-align: center;
      padding: 20px 0;
      margin-top: 70px;
      font-size: 14px;
    }

    /* Animasi halus */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-up {
      animation: fadeInUp 0.6s ease forwards;
    }
  </style>
</head>

<body>

  <!-- ======== NAVBAR ======== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">📨 Sistem Surat</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="#tentang" class="nav-link">Tentang</a></li>
          <li class="nav-item"><a href="#fitur" class="nav-link">Fitur</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link btn-login ms-2">Login Admin</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link btn-login ms-2">Login pegawai</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ======== HERO ======== -->
  <section class="hero-section">
    <div class="hero-content animate-up">
      <h1>Sistem Surat Masuk & Keluar</h1>
      <p>Kelola surat dengan cepat, aman, dan efisien dalam satu sistem digital terpadu.</p>
      <a href="login.php" class="btn-main">Masuk ke Dashboard</a>
    </div>
  </section>

  <style>
    /* Hero Section dengan background slider */
    .hero-section {
      position: relative;
      height: 430px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
    }

    .hero-section::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      filter: brightness(0.6);
      animation: slideBackground 15s infinite linear;
      z-index: -1;
    }

    @keyframes slideBackground {
      0% {
        background-image: url('dist/img/fotobareng1.jpg');
      }

      33% {
        background-image: url('dist/img/foto2.jpg');
      }

      66% {
        background-image: url('dist/img/foto3.jpg');
      }

      100% {
        background-image: url('dist/img/fotobareng1.jpg');
      }
    }

    .hero-content h1 {
      font-weight: 700;
      font-size: 40px;
    }

    .hero-content p {
      font-size: 17px;
      margin-bottom: 25px;
    }
  </style>


  <!-- ======== FITUR ======== -->
  <div class="container" id="fitur">
    <h2 class="section-title">Fitur Utama</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 mb-4 animate-up">
        <div class="card-feature text-center">
          <img src="dist/img/icon_inbox.png" alt="Surat Masuk">
          <h5>Surat Masuk</h5>
          <p>Lihat dan kelola semua surat masuk yang diterima instansi dengan mudah dan efisien.</p>
          <a href="login.php?next=surat_masuk" class="btn-main btn-sm">Lihat Surat Masuk</a>
        </div>
      </div>
      <div class="col-md-4 mb-4 animate-up">
        <div class="card-feature text-center">
          <img src="dist/img/icon_outbox.png" alt="Surat Keluar">
          <h5>Surat Keluar</h5>
          <p>Catat, arsipkan, dan cetak surat keluar dengan cepat dan akurat.</p>
          <a href="login.php?next=surat_keluar" class="btn-main btn-sm">Lihat Surat Keluar</a>
        </div>
      </div>
      <div class="col-md-4 mb-4 animate-up">
        <div class="card-feature text-center">
          <img src="dist/img/icon_disposisi.png" alt="Disposisi">
          <h5>Disposisi</h5>
          <p>Distribusikan surat ke pegawai atau unit terkait dengan mudah dan transparan.</p>
          <a href="login.php?next=disposisi" class="btn-main btn-sm">Lihat Disposisi</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ======== TENTANG ======== -->
  <div class="container" id="tentang">
    <h2 class="section-title">Tentang Aplikasi</h2>
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <p class="text-muted">
          <strong>Sistem Surat Masuk & Keluar</strong> membantu instansi dalam mengelola administrasi surat secara digital, cepat, dan aman.
          Semua surat masuk, surat keluar, dan disposisi dapat diakses melalui satu dashboard terpadu.
        </p>
      </div>
    </div>
  </div>

  <!-- ======== FOOTER ======== -->
  <footer class="footer">
    &copy; <?= date('Y') ?> Sistem Surat Masuk & Keluar — All Rights Reserved
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>