<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Sistem Surat Masuk & Keluar</title>
  <link rel="stylesheet" href="assets/css/style_login_split.css">
</head>
<body>

  <div class="login-container">
    <!-- Bagian kiri -->
    <div class="left-panel">
      <div class="content">
        <img src="assets/img/logo.png" alt="Logo" class="logo">
        <h1>Sistem Surat Masuk & Keluar</h1>
        <p>Kelola surat masuk dan keluar instansi Anda dengan mudah dan efisien.</p>
      </div>
    </div>

    <!-- Bagian kanan -->
    <div class="right-panel">
      <form id="loginForm" action="proses_login.php" method="POST" class="login-form">
        <h2>Masuk Akun</h2>

        <div class="input-group">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>

        <button type="submit" class="btn-login">Masuk</button>
      </form>
    </div>
  </div>

  <script src="assets/js/login_split.js"></script>
</body>
</html>
