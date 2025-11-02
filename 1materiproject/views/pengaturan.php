<?php
// =============================================================
// ⚙️ pengaturan.php — Versi Final (Pegawai login via NIP saja)
// =============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../koneksi.php';

// ===== CEK LOGIN =====
if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location='login.php';</script>";
    exit;
}

// ===== IDENTIFIKASI ROLE =====
if (!empty($_SESSION['id_admin'])) {
    $id = $_SESSION['id_admin'];
    $table = "admin";
    $id_field = "id_admin";
    $nama_field = "nama_admin";
    $tipe_akun = "Administrator";
    $is_admin = true;
} elseif (!empty($_SESSION['id_pegawai'])) {
    $id = $_SESSION['id_pegawai'];
    $table = "pegawai";
    $id_field = "id_pegawai";
    $nama_field = "nama_pegawai";
    $tipe_akun = "Pegawai";
    $is_admin = false;
} else {
    echo "<script>alert('Sesi tidak valid! Silakan login ulang.');window.location='logout.php';</script>";
    exit;
}

// =============================================================
// 🔒 PROSES: UBAH PASSWORD (khusus admin saja)
// =============================================================
if ($is_admin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_password'])) {
    $pass_lama = mysqli_real_escape_string($koneksi, $_POST['password_lama']);
    $pass_baru = mysqli_real_escape_string($koneksi, $_POST['password_baru']);
    $pass_konfirmasi = mysqli_real_escape_string($koneksi, $_POST['konfirmasi_password']);

    $cek = mysqli_query($koneksi, "SELECT password FROM $table WHERE $id_field='$id'");
    $data = mysqli_fetch_assoc($cek);

    if (!$data || !password_verify($pass_lama, $data['password'])) {
        echo "<script>alert('❌ Password lama salah!');</script>";
    } elseif ($pass_baru !== $pass_konfirmasi) {
        echo "<script>alert('❌ Konfirmasi password tidak cocok!');</script>";
    } else {
        $hash = password_hash($pass_baru, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE $table SET password='$hash' WHERE $id_field='$id'");
        echo "<script>alert('✅ Password berhasil diperbarui!');window.location='index.php?halaman=pengaturan';</script>";
        exit;
    }
}

// =============================================================
// 🎨 PROSES: GANTI TEMA
// =============================================================
if (isset($_POST['ganti_tema'])) {
    $_SESSION['tema'] = ($_SESSION['tema'] ?? 'light') === 'light' ? 'dark' : 'light';
    echo "<script>window.location='index.php?halaman=pengaturan';</script>";
    exit;
}

// =============================================================
// ⚠️ PROSES: RESET DATA PRIBADI
// =============================================================
if (isset($_POST['reset_data'])) {
    mysqli_query($koneksi, "UPDATE $table SET email=NULL, no_telp=NULL, foto=NULL WHERE $id_field='$id'");
    echo "<script>alert('✅ Data pribadi telah direset!');window.location='index.php?halaman=pengaturan';</script>";
    exit;
}

// =============================================================
// 📋 AMBIL DATA & TEMA
// =============================================================
$query = mysqli_query($koneksi, "SELECT * FROM $table WHERE $id_field='$id'");
$data = mysqli_fetch_assoc($query);
$tema = $_SESSION['tema'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="id" data-theme="<?= $tema ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Akun</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>
:root {
  --bg-color-light: #f8f9fa;
  --text-color-light: #212529;
  --card-bg-light: #ffffff;
  --border-light: #dee2e6;

  --bg-color-dark: #1e1e2f;
  --text-color-dark: #f1f1f1;
  --card-bg-dark: #2a2a3d;
  --border-dark: #444;
}

[data-theme="light"] body {
  background-color: var(--bg-color-light);
  color: var(--text-color-light);
}
[data-theme="light"] .card {
  background-color: var(--card-bg-light);
  border-color: var(--border-light);
  color: var(--text-color-light);
}

[data-theme="dark"] body {
  background-color: var(--bg-color-dark);
  color: var(--text-color-dark);
}
[data-theme="dark"] .card {
  background-color: var(--card-bg-dark);
  border-color: var(--border-dark);
  color: var(--text-color-dark);
}
[data-theme="dark"] input, [data-theme="dark"] select, [data-theme="dark"] textarea {
  background-color: #333;
  color: #f1f1f1;
  border-color: #555;
}
[data-theme="dark"] label { color: #ddd; }

.btn i { margin-right: 6px; }
.form-control { border-radius: 8px; padding: 10px 14px; }
.card { border-radius: 16px; transition: 0.3s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
.card-header { border-top-left-radius: 16px; border-top-right-radius: 16px; }
</style>
</head>

<body>
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0"><i class="fas fa-cog"></i> Pengaturan Akun <?= htmlspecialchars($tipe_akun) ?></h3>
          </div>

          <div class="card-body p-4">

            <?php if ($is_admin): ?>
            <!-- === UBAH PASSWORD (Admin saja) === -->
            <h5 class="text-primary"><i class="fas fa-lock"></i> Ubah Password</h5>
            <hr>
            <form method="POST">
              <div class="mb-3">
                <label>Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" class="form-control" required>
              </div>
              <button type="submit" name="ubah_password" class="btn btn-primary w-100 mb-4">
                <i class="fas fa-save"></i> Simpan Password
              </button>
            </form>
            <?php else: ?>
            <!-- === Pegawai tidak punya password === -->
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> Login Anda menggunakan <strong>NIP</strong>. 
              Tidak diperlukan pengaturan password.
            </div>
            <?php endif; ?>

            <!-- === GANTI TEMA === -->
            <h5 class="text-primary"><i class="fas fa-adjust"></i> Ganti Tema</h5>
            <hr>
            <form method="POST" class="text-center mb-4">
              <p>Tema saat ini: <strong><?= ucfirst($tema) ?></strong></p>
              <button type="submit" name="ganti_tema" class="btn btn-warning">
                <i class="fas fa-sync-alt"></i> Ganti ke <?= $tema === 'dark' ? 'Light' : 'Dark' ?> Mode
              </button>
            </form>

            <!-- === RESET DATA PRIBADI === -->
            <h5 class="text-primary"><i class="fas fa-trash-alt"></i> Reset Data Pribadi</h5>
            <hr>
            <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset semua data pribadi?');">
              <button type="submit" name="reset_data" class="btn btn-danger w-100">
                <i class="fas fa-undo"></i> Reset Semua Data
              </button>
            </form>
          </div>

          <div class="card-footer text-center bg-light">
            <a href="index.php?halaman=profil" class="btn btn-secondary mx-2">
              <i class="fas fa-user"></i> Kembali ke Profil
            </a>
            <a href="index.php" class="btn btn-primary mx-2">
              <i class="fas fa-home"></i> Kembali ke Dashboard
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// Efek otomatis ubah tema tanpa reload (bonus)
document.querySelectorAll('form button[name="ganti_tema"]').forEach(btn => {
  btn.addEventListener('click', () => {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
  });
});
</script>

</body>
</html>
