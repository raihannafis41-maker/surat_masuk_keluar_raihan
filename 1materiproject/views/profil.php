<?php
// =============================================================
// ✅ PROFIL FINAL FIX — foto sinkron dengan halaman pegawai
// =============================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../koneksi.php";

// ===== CEK LOGIN =====
if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location='login.php';</script>";
    exit;
}

// ===== VARIABEL DASAR =====
$data = [];
$tipe_akun = "";
$foto_path = "assets/img/default.png"; // default
$table = "";
$id_field = "";
$nama_field = "";
$foto_dir = __DIR__ . "/../assets/img/";
$foto_url = "assets/img/";

// ===== DETEKSI ROLE LOGIN =====
if (!empty($_SESSION['id_admin'])) {
    $table = "admin";
    $id_field = "id_admin";
    $nama_field = "nama_admin";
    $tipe_akun = "Administrator";
    $id = $_SESSION['id_admin'];
} elseif (!empty($_SESSION['id_pegawai'])) {
    $table = "pegawai";
    $id_field = "id_pegawai";
    $nama_field = "nama_pegawai";
    $tipe_akun = "Pegawai";
    $id = $_SESSION['id_pegawai'];
} else {
    echo "<script>alert('Sesi tidak valid!');window.location='logout.php';</script>";
    exit;
}

// ===== AMBIL DATA PROFIL =====
$q = mysqli_query($koneksi, "SELECT * FROM $table WHERE $id_field='$id'");
$data = mysqli_fetch_assoc($q);

// Deteksi nama kolom untuk foto & telepon
$kolom_foto = isset($data['foto']) ? 'foto' : (isset($data['foto']) ? 'foto' : (isset($data['gambar']) ? 'gambar' : 'foto'));
$kolom_telp = isset($data['telepon']) ? 'telepon' : (isset($data['no_telp']) ? 'no_telp' : 'telepon');

// ====== PROSES UPDATE PROFIL ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profil'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email   = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $foto_baru = $_FILES['foto']['name'] ?? '';

    $update_foto = "";
    if (!empty($foto_baru)) {
        $ext = pathinfo($foto_baru, PATHINFO_EXTENSION);
        $nama_file = strtolower($table . "_" . $id . "_" . time() . "." . $ext);

        if (!is_dir($foto_dir)) mkdir($foto_dir, 0777, true);
        $tujuan = $foto_dir . $nama_file;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
            // hapus foto lama jika ada
            if (!empty($data[$kolom_foto]) && file_exists($foto_dir . $data[$kolom_foto])) {
                unlink($foto_dir . $data[$kolom_foto]);
            }
            $update_foto = ", $kolom_foto='$nama_file'";
        }
    }

    $update = mysqli_query($koneksi, "
        UPDATE $table SET 
            $nama_field='$nama',
            email='$email',
            $kolom_telp='$telepon'
            $update_foto
        WHERE $id_field='$id'
    ");

    if ($update) {
        echo "<script>alert('✅ Profil berhasil diperbarui!');window.location='index.php?halaman=profil';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Gagal memperbarui profil!');</script>";
    }
}

// ===== CEK FOTO PROFIL =====
if (!empty($data[$kolom_foto]) && file_exists($foto_dir . $data[$kolom_foto])) {
    $foto_path = $foto_url . $data[$kolom_foto];
}
?>

<!-- ============================================================= -->
<!-- ==================== TAMPILAN PROFIL ======================= -->
<!-- ============================================================= -->
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4">
      <div class="col-md-8">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-gradient-primary text-white text-center">
            <h3 class="mb-0"><i class="fas fa-user-circle"></i> Profil <?= htmlspecialchars($tipe_akun) ?></h3>
          </div>

          <div class="card-body text-center p-5">
            <!-- FOTO PROFIL -->
            <div class="position-relative d-inline-block mb-3">
              <img src="<?= htmlspecialchars($foto_path) ?>"
                   alt="Foto Profil"
                   class="img-circle elevation-2 shadow"
                   style="width:130px; height:130px; object-fit:cover; border:3px solid #007bff;">
            </div>

            <h3 class="mt-3 mb-1 text-primary font-weight-bold">
              <?= htmlspecialchars($data[$nama_field] ?? '-') ?>
            </h3>
            <p class="text-muted mb-4"><i class="fas fa-user"></i> <?= htmlspecialchars($tipe_akun) ?></p>

            <!-- FORM UPDATE PROFIL -->
            <form method="POST" enctype="multipart/form-data" class="text-start">
              <div class="form-group mb-3">
                <label><i class="fas fa-id-card text-primary"></i> Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data[$nama_field] ?? '') ?>" required>
              </div>

              <div class="form-group mb-3">
                <label><i class="fas fa-envelope text-primary"></i> Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
              </div>

              <div class="form-group mb-3">
                <label><i class="fas fa-phone text-primary"></i> No. Telepon</label>
                <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($data[$kolom_telp] ?? '') ?>">
              </div>

              <div class="form-group mb-4">
                <label><i class="fas fa-camera text-primary"></i> Ganti Foto</label>
                <input type="file" name="foto" accept="image/*" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
              </div>

              <div class="text-center mt-4">
                <button type="submit" name="update_profil" class="btn btn-primary btn-lg mx-2">
                  <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="index.php" class="btn btn-secondary btn-lg mx-2">
                  <i class="fas fa-home"></i> Dashboard
                </a>
              </div>
            </form>
          </div>

          <div class="card-footer bg-light text-center">
            <small class="text-muted">Terakhir login: <?= date("d M Y, H:i") ?></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.card { transition: all 0.3s ease-in-out; }
.card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
.btn i { margin-right: 6px; }
.form-control { border-radius: 8px; padding: 10px 14px; }
label { font-weight: 600; }
.btn-lg { min-width: 180px; }
</style>
