<?php
// =============================================================
// 🧩 Konfigurasi & Validasi Awal
// =============================================================
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// Pastikan parameter id ada
if (!isset($_GET['id'])) {
    echo "<script>alert('ID pegawai tidak ditemukan!');window.location='index.php?halaman=pegawai';</script>";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id_pegawai = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data pegawai tidak ditemukan!');window.location='index.php?halaman=pegawai';</script>";
    exit;
}

// =============================================================
// 🧠 Proses Update Data
// =============================================================
if (isset($_POST['update'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pegawai']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $golongan = mysqli_real_escape_string($koneksi, $_POST['golongan']);
    $foto_lama = $data['foto'];

    // Validasi sederhana
    if (empty($nip) || empty($nama) || empty($jabatan)) {
        echo "<script>alert('NIP, Nama, dan Jabatan wajib diisi!');</script>";
    } else {
        // Proses upload foto
        if (!empty($_FILES['foto']['name'])) {
            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($ext, $allowed)) {
                $newName = 'pegawai_' . time() . '.' . $ext;
                $folder = "foto/";

                // Hapus foto lama jika ada
                if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
                    unlink($folder . $foto_lama);
                }

                // Upload file baru
                move_uploaded_file($tmp, $folder . $newName);
                $foto = $newName;
            } else {
                echo "<script>alert('Format foto tidak valid! Hanya JPG, JPEG, atau PNG.');</script>";
                $foto = $foto_lama;
            }
        } else {
            $foto = $foto_lama; // tetap gunakan foto lama
        }

        // Update ke database
        $update = mysqli_query($koneksi, "UPDATE pegawai SET 
            nip='$nip',
            nama_pegawai='$nama',
            jabatan='$jabatan',
            email='$email',
            no_telp='$no_telp',
            golongan='$golongan',
            foto='$foto'
            WHERE id_pegawai='$id'
        ");

        if ($update) {
            echo "<script>alert('✅ Data pegawai berhasil diperbarui!');window.location='index.php?halaman=pegawai';</script>";
        } else {
            echo "<script>alert('❌ Gagal memperbarui data!');</script>";
        }
    }
}
?>

<!-- =============================================================
💠 Tampilan Form Edit Pegawai (Rapi & Seragam dengan Pengaturan)
============================================================= -->
<div class="card shadow-lg border-0">
    <div class="card-header bg-warning text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-edit"></i> Edit Data Pegawai
        </h3>
    </div>

    <form method="POST" enctype="multipart/form-data" id="formEditPegawai">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" value="<?= htmlspecialchars($data['nip']); ?>" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" value="<?= htmlspecialchars($data['nama_pegawai']); ?>" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" value="<?= htmlspecialchars($data['jabatan']); ?>" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']); ?>" 
                           class="form-control" pattern="[0-9+ ]+" title="Hanya angka atau tanda + diperbolehkan">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Golongan</label>
                    <input type="text" name="golongan" value="<?= htmlspecialchars($data['golongan']); ?>" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Foto Pegawai</label>
                    <div class="d-flex align-items-center gap-3">
                        <?php
                        $foto = $data['foto'] ?? '';
                        $path = "foto/" . $foto;
                        if (!empty($foto) && file_exists($path)): ?>
                            <img src="<?= $path ?>" alt="Foto Pegawai" class="rounded-circle border" width="70" height="70">
                        <?php else: ?>
                            <img src="assets/img/default.png" alt="Default" class="rounded-circle border" width="70" height="70">
                        <?php endif; ?>
                        <input type="file" name="foto" accept="image/*" class="form-control" style="max-width:300px;">
                    </div>
                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks 2MB)</small>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" name="update" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="index.php?halaman=pegawai" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<!-- =============================================================
🧠 Validasi Upload File di Browser
============================================================= -->
<script>
document.getElementById('formEditPegawai').addEventListener('submit', function(e) {
    const fileInput = document.querySelector('input[name="foto"]');
    const file = fileInput.files[0];
    if (file) {
        const allowed = ['jpg', 'jpeg', 'png'];
        const ext = file.name.split('.').pop().toLowerCase();
        const size = file.size / 1024 / 1024;

        if (!allowed.includes(ext)) {
            alert('❌ Hanya file JPG, JPEG, atau PNG yang diperbolehkan.');
            e.preventDefault();
            return;
        }

        if (size > 2) {
            alert('❌ Ukuran file tidak boleh lebih dari 2MB.');
            e.preventDefault();
        }
    }
});
</script>
