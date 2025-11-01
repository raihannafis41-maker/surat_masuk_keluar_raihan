<?php
session_start();
if (!empty($_SESSION['login']) && $_SESSION['login'] === true) {
  header('Location: index.php');
  exit;
}

$next = isset($_GET['next']) ? htmlspecialchars($_GET['next']) : '';
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <title>Login — Sistem Surat</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://kit.fontawesome.com/a2d9b5b8f0.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/modern-anim.css">
  <style>
    body {
      background: radial-gradient(circle at top left, #081229, #05080f);
      font-family: 'Poppins', sans-serif;
      color: #d8e6ff;
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card {
      display: flex;
      flex-wrap: wrap;
      background: rgba(15, 23, 42, 0.8);
      backdrop-filter: blur(16px);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 35px rgba(0, 150, 255, 0.25);
      max-width: 920px;
      width: 90%;
      border: 1px solid rgba(255, 255, 255, 0.06);
      position: relative;
      z-index: 2;
    }

    .login-visual {
      flex: 1 1 45%;
      background: linear-gradient(135deg, #012a4a, #023e7d, #0353a4);
      padding: 40px 32px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #e7f7ff;
      position: relative;
      overflow: hidden;
    }

    .login-visual * {
      pointer-events: none;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 40px;
    }

    .brand .logo {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #38bdf8, #0284c7);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 22px;
      color: #fff;
      box-shadow: 0 0 25px rgba(56, 189, 248, 0.4);
    }

    .login-form-wrap {
      flex: 1 1 55%;
      padding: 50px 45px;
      background: rgba(255, 255, 255, 0.02);
      position: relative;
      z-index: 10;
    }

    .form-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #6ec1ff;
      text-shadow: 0 0 10px rgba(110, 193, 255, 0.4);
      margin-bottom: 6px;
    }

    .form-sub {
      color: #9db3cc;
      font-size: 0.95rem;
      margin-bottom: 28px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .icon-input {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #6ec1ff;
      opacity: 0.8;
    }

    .input {
      width: 100%;
      padding: 10px 12px 10px 42px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 10px;
      color: #ffffff;
      /* teks input jadi putih jelas */
      font-size: 15px;
      transition: all 0.3s ease;
      z-index: 10;
      position: relative;
      appearance: none;
    }

    /* Fokus lebih terang */
    .input:focus {
      outline: none;
      border-color: #38bdf8;
      box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
      background: rgba(255, 255, 255, 0.12);
    }

    /* Dropdown text */
    select.input {
      color: #e8f6ff;
      /* warna teks utama */
      background-color: rgba(10, 25, 45, 0.9);
    }

    /* Warna opsi dalam dropdown */
    select.input option {
      background-color: #0a172c;
      color: #eaf6ff;
      /* teks putih kebiruan */
    }

    /* Saat hover pada opsi */
    select.input option:hover {
      background-color: #1e3a8a;
      color: #ffffff;
    }


    .btn-submit {
      background: linear-gradient(135deg, #00aaff, #0077ff);
      border: none;
      padding: 12px 28px;
      border-radius: 10px;
      color: #3c3939ff;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 15;
      position: relative;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 18px rgba(0, 200, 255, 0.8);
    }

    .btn-outline-info {
      color: #6ec1ff;
      border: 1px solid #6ec1ff;
      border-radius: 8px;
      padding: 6px 14px;
      text-decoration: none;
      transition: all 0.3s;
      z-index: 15;
      position: relative;
    }

    .btn-outline-info:hover {
      background: #6ec1ff;
      color: #012432;
      box-shadow: 0 0 15px rgba(110, 193, 255, 0.6);
    }

    .helper {
      color: #8fa8c6;
      font-size: 13px;
    }

    @media(max-width: 768px) {
      .login-card {
        flex-direction: column;
      }

      .login-visual {
        padding: 30px;
        text-align: center;
      }

      .login-form-wrap {
        padding: 35px 28px;
      }
    }
  </style>
</head>

<body>

  <div class="login-card" role="main">
    <div class="login-visual">
      <div class="brand">
        <div class="logo">SM</div>
        <div>
          <h2>Surat Modern</h2>
          <p>Kelola surat masuk & keluar dengan efisien.</p>
        </div>
      </div>
      <div style="font-weight:700;color:#dff9ff">Surat Masuk</div>
      <div style="color:var(--muted);font-size:13px">Buka inbox untuk pesan masuk terbaru</div>
    </div>

    <div class="login-form-wrap">
      <div class="form-title">Selamat Datang</div>
      <div class="form-sub">Masukkan Username + Password (Admin) atau NIP (Pegawai)</div>

      <form action="proses_login.php" method="POST" autocomplete="off">
        <input type="hidden" name="next" value="<?= $next ?>">

        <!-- Pilihan role -->
        <div class="form-group">
          <label for="role">Login Sebagai:</label>
          <select name="role" id="role" class="input" required onchange="toggleField()">
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="pegawai">Pegawai</option>
          </select>
        </div>

        <!-- Username Admin -->
        <div class="form-group" id="usernameField" style="display:none;">
          <span class="icon-input"><i class="fa fa-user"></i></span>
          <input class="input" type="text" name="username" placeholder="Username Admin">
        </div>

        <!-- NIP Pegawai -->
        <div class="form-group" id="nipField" style="display:none;">
          <span class="icon-input"><i class="fa fa-id-badge"></i></span>
          <input class="input" type="text" name="nip" placeholder="Masukkan NIP Pegawai">
        </div>

        <!-- Password hanya admin -->
        <div class="form-group" id="passwordField" style="display:none;">
          <span class="icon-input"><i class="fa fa-lock"></i></span>
          <input class="input" type="password" name="password" placeholder="Password Admin">
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px;flex-wrap:wrap;gap:8px">
          <div class="helper">Belum punya akun?</div>
          <a href="register.php" class="btn-outline-info">Daftar Akun</a>
        </div>

        <div style="margin-top:20px;text-align:right">
          <button type="submit" class="btn-submit"><i class="fa fa-sign-in-alt"></i> Masuk</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleField() {
      const role = document.getElementById('role').value;
      document.getElementById('usernameField').style.display = (role === 'admin') ? 'block' : 'none';
      document.getElementById('passwordField').style.display = (role === 'admin') ? 'block' : 'none';
      document.getElementById('nipField').style.display = (role === 'pegawai') ? 'block' : 'none';
    }
  </script>

</body>

</html>