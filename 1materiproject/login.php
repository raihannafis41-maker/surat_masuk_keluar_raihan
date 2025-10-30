<?php
// login.php
// Jika sudah login redirect (contoh)
session_start();
if (!empty($_SESSION['user'])) {
  header('Location: index.php');
  exit;
}
?>
<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <title>Login — Sistem Surat</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/css/modern-anim.css">
  <script defer src="https://kit.fontawesome.com/a2d9b5b8f0.js"></script> <!-- optional icons -->
</head>

<body>

  <div class="bg-blobs" aria-hidden="true">
    <div class="blob one"></div>
    <div class="blob two"></div>
  </div>

  <div class="login-wrap">
    <div class="login-card" role="main">
      <!-- left visual -->
      <div class="login-visual">
        <div class="brand">
          <div class="logo">SM</div>
          <div>
            <h2>Surat Modern</h2>
            <p>Masuk untuk mengelola surat masuk & keluar dengan cepat.</p>
          </div>
        </div>

        <div class="envelope-wrap" aria-hidden="true">
          <div class="envelope" id="env1">
            <div class="envelope-count"> <span class="count-to" data-count="27" data-delay="120">0</span> </div>
          </div>
          <div>
            <div style="font-weight:700;color:#dff9ff">Surat Masuk</div>
            <div style="color:var(--muted);font-size:13px">Buka inbox untuk pesan masuk terbaru</div>
          </div>
        </div>

        <div style="margin-top:12px">
          <small style="color:var(--muted)">Tip: tekan Enter setelah mengisi untuk ke halaman selanjutnya </small>
        </div>
      </div>

      <!-- right form -->
      <div class="login-form-wrap">
        <div>
          <div class="form-title">Selamat Datang</div>
          <div class="form-sub">Masukkan username & password untuk masuk</div>
        </div>

        <form class="login-form" action="proses_login.php" method="POST" autocomplete="off">
          <div class="form-group">
            <span class="icon-input"><i class="fa fa-user" aria-hidden="true"></i></span>
            <input class="input" type="text" name="username" placeholder="Username" required>
          </div>

          <div class="form-group">
            <span class="icon-input"><i class="fa fa-lock" aria-hidden="true"></i></span>
            <input class="input" type="password" name="password" placeholder="Password" required>
          </div>

          <div style="display:flex;gap:10px;align-items:center;justify-content:space-between;margin-top:8px">
            <div class="helper">Belum punya akun? hubungi admin.</div>
            <button type="submit" class="btn-submit"><i class="fa fa-sign-in-alt"></i> Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- submit overlay -->
  <div class="submit-overlay" aria-hidden="true">
    <div class="loader-card" role="status" aria-live="polite">
      <div style="display:flex;align-items:center;gap:12px">
        <div style="width:48px;height:48px;border-radius:10px;background:linear-gradient(135deg,#86e3ff,#2f9ef3);display:flex;align-items:center;justify-content:center;color:#012432;font-weight:800">OK</div>
        <div>
          <div style="font-weight:700;color:#e7fbff">Memproses login</div>
          <div style="color:var(--muted);font-size:13px">Sedang memeriksa kredensial & mempersiapkan dashboard...</div>
        </div>
      </div>

      <div class="loader-bar" style="margin-top:12px">
        <div class="loader-progress"></div>
      </div>
    </div>
  </div>

  <script src="assets/js/modern-anim.js" defer></script>
</body>

</html>