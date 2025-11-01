<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Sistem Surat Masuk & Keluar</title>

  <!-- Bootstrap & FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #1e272e, #2f3640);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .register-box {
      width: 420px;
    }
    .card {
      background-color: #2f3640;
      color: #fff;
      border-radius: 10px;
    }
    .card input, .card select {
      background: #353b48;
      border: none;
      color: #fff;
    }
    .card input::placeholder {
      color: #aaa;
    }
    .btn-primary {
      background: #00a8ff;
      border: none;
    }
    .btn-primary:hover {
      background: #0097e6;
    }
    .role-section {
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
<div class="register-box">
  <div class="card">
    <div class="card-body register-card-body">
      <h4 class="text-center mb-4">
        <i class="fas fa-envelope-open-text"></i> <br>
        <b>Registrasi Akun</b>
      </h4>

      <form action="proses_register.php" method="POST" enctype="multipart/form-data" id="formRegister">

        <!-- Pilihan Role -->
        <div class="form-group role-section">
          <label for="role">Daftar Sebagai:</label>
          <select name="role" id="role" class="form-control" required onchange="tampilkanForm()">
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="pegawai">Pegawai</option>
          </select>
        </div>

        <!-- ===================== -->
        <!-- FORM ADMIN -->
        <!-- ===================== -->
        <div id="formAdmin" style="display:none;">
          <div class="form-group">
            <label>Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" placeholder="Nama lengkap admin">
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username admin">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email admin">
          </div>
          <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" placeholder="Nomor telepon admin">
          </div>
          <div class="form-group">
            <label>Foto Profil</label>
            <input type="file" name="foto" accept="image/*" class="form-control">
          </div>

          <!-- Password hanya untuk admin -->
          <div class="form-group password-section">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password">
          </div>
          <div class="form-group password-section">
            <label>Konfirmasi Password</label>
            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password">
          </div>
        </div>

        <!-- ===================== -->
        <!-- FORM PEGAWAI -->
        <!-- ===================== -->
        <div id="formPegawai" style="display:none;">
          <div class="form-group">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai">
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan pegawai">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email pegawai">
          </div>
          <div class="form-group">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" placeholder="Nomor telepon pegawai">
          </div>
          <div class="form-group">
            <label>Golongan</label>
            <input type="text" name="golongan" class="form-control" placeholder="Golongan pegawai">
          </div>
          <div class="form-group">
            <label>Foto Profil</label>
            <input type="file" name="foto" accept="image/*" class="form-control">
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-3">
          <i class="fas fa-user-plus"></i> Daftar Sekarang
        </button>

        <p class="text-center mt-3">
          Sudah punya akun? <a href="before_login.php" class="text-info">Login di sini</a>
        </p>
      </form>
    </div>
  </div>
</div>

<!-- Script -->
<script>
function tampilkanForm() {
  const role = document.getElementById('role').value;
  document.getElementById('formAdmin').style.display = role === 'admin' ? 'block' : 'none';
  document.getElementById('formPegawai').style.display = role === 'pegawai' ? 'block' : 'none';
}
</script>

<!-- JS Bootstrap -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
