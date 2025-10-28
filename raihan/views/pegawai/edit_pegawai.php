<?php
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

// Jika tombol simpan ditekan
if (isset($_POST['update'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pegawai']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $golongan = mysqli_real_escape_string($koneksi, $_POST['golongan']);
    $foto_lama = $data['foto'];

    // Proses upload foto (jika ada)
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = "foto/";

        // Hapus foto lama jika ada
        if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
            unlink($folder . $foto_lama);
        }

        // Upload foto baru
        move_uploaded_file($tmp, $folder . $foto);
    } else {
        $foto = $foto_lama; // tetap pakai foto lama
    }

    // Update data
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
        echo "<script>alert('Data pegawai berhasil diperbarui!');window.location='index.php?halaman=pegawai';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-warning text-white">
        <h3 class="card-title">Edit Data Pegawai</h3>
    </div>

    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" value="<?= htmlspecialchars($data['nip']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Pegawai</label>
                <input type="text" name="nama_pegawai" value="<?= htmlspecialchars($data['nama_pegawai']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" value="<?= htmlspecialchars($data['jabatan']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>No. Telp</label>
                <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Golongan</label>
                <input type="text" name="golongan" value="<?= htmlspecialchars($data['golongan']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Foto Pegawai</label><br>
                <?php if (!empty($data['foto']) && file_exists('foto/' . $data['foto'])): ?>
                    <img src="foto/<?= $data['foto'] ?>" width="80" class="mb-2 rounded-circle border">
                <?php else: ?>
                    <p class="text-muted">Belum ada foto</p>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <button type="submit" name="update" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="index.php?halaman=pegawai" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
