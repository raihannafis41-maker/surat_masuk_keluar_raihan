<?php
// =============================================================
// ✅ Pengaturan Profil Admin — Versi Final Anti-Error
// =============================================================

// Pastikan session aktif hanya sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

// Cek login
if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Silakan login terlebih dahulu!');window.location='login.php';</script>";
    exit;
}

$id_admin = $_SESSION['id_admin'];

// =============================================================
// 🔍 Ambil Data Admin
// =============================================================
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
$admin = mysqli_fetch_assoc($query);

if (!$admin) {
    echo "<script>alert('Data admin tidak ditemukan!');window.location='logout.php';</script>";
    exit;
}

// =============================================================
// 💾 Proses Update Profil
// =============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = !empty($_POST['password'])
        ? password_hash($_POST['password'], PASSWORD_DEFAULT)
        : $admin['password'];

    // Upload foto baru (jika ada)
    $fotoBaru = $_FILES['foto']['name'] ?? '';
    $fotoLama = $admin['foto'];
    $folder = "uploads";

    if (!empty($fotoBaru)) {
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($fotoBaru, PATHINFO_EXTENSION));
        $size = $_FILES['foto']['size'];

        if (!in_array($ext, $allowed_ext)) {
            echo "<script>alert('❌ Format file tidak valid. Gunakan JPG, JPEG, atau PNG.');</script>";
        } elseif ($size > 2 * 1024 * 1024) {
            echo "<script>alert('❌ Ukuran file maksimal 2MB.');</script>";
        } else {
            // Hapus foto lama jika ada
            if (!empty($fotoLama) && file_exists($folder . $fotoLama)) {
                unlink($folder . $fotoLama);
            }
            // Simpan foto baru
            $namaFileBaru = "admin_" . time() . "." . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $namaFileBaru);
            $foto = $namaFileBaru;
        }
    } else {
        $foto = $fotoLama;
    }

    // Update ke database
    $update = mysqli_query($koneksi, "UPDATE admin SET 
        nama_admin='$nama_admin',
        email='$email',
        username='$username',
        password='$password',
        foto='$foto'
        WHERE id_admin='$id_admin'
    ");

    if ($update) {
        $_SESSION['nama_admin'] = $nama_admin;
        echo "<script>alert('✅ Profil berhasil diperbarui!');window.location='index.php?halaman=profil';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Gagal memperbarui profil.');</script>";
    }
}
?>

<!-- =============================================================
🎨 FORM PENGATURAN PROFIL ADMIN
============================================================= -->
<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-cog"></i> Pengaturan Profil Admin
        </h3>
    </div>

    <form method="POST" enctype="multipart/form-data" id="formProfil">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_admin" class="form-control" required
                       value="<?= htmlspecialchars($admin['nama_admin']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required
                       value="<?= htmlspecialchars($admin['email']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required
                       value="<?= htmlspecialchars($admin['username']); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Kosongkan jika tidak ingin mengganti password">
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <div class="d-flex align-items-center gap-3">
                    <?php
                    $foto = $admin['foto'] ?? '';
                    $fotoPath = "uploads/" . $foto;
                    if (!empty($foto) && file_exists($fotoPath)): ?>
                        <img src="<?= $fotoPath ?>" alt="Foto Profil" class="rounded-circle border" width="70" height="70">
                    <?php else: ?>
                        <img src="uploads/" alt="Foto Default" class="rounded-circle border" width="70" height="70">
                    <?php endif; ?>
                    <input type="file" name="foto" accept="image/*" class="form-control" style="max-width:300px;">
                </div>
                <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB</small>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="index.php?halaman=profil" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<!-- =============================================================
🧠 VALIDASI JAVASCRIPT UNTUK UPLOAD FOTO
============================================================= -->
<script>
document.getElementById('formProfil').addEventListener('submit', function(e) {
    const fileInput = document.querySelector('input[name="foto"]');
    const file = fileInput.files[0];
    if (file) {
        const allowedExtensions = ['jpg', 'jpeg', 'png'];
        const fileSize = file.size / 1024 / 1024; // MB
        const ext = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(ext)) {
            alert('❌ Hanya file JPG, JPEG, atau PNG yang diperbolehkan.');
            e.preventDefault();
            return;
        }

        if (fileSize > 2) {
            alert('❌ Ukuran file tidak boleh lebih dari 2MB.');
            e.preventDefault();
        }
    }
});
</script>
