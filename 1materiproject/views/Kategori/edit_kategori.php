<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// pastikan path koneksi benar
include __DIR__ . '/../../koneksi.php';

// pastikan parameter id dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?halaman=kategori');
    exit;
}

$id = intval($_GET['id']);

// ambil data kategori
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header('Location: index.php?halaman=kategori');
    exit;
}

// jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_kategori'] ?? '');
    $ket  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

    $update = mysqli_query($koneksi, "
        UPDATE kategori 
        SET nama_kategori = '$nama',
            keterangan = '$ket'
        WHERE id_kategori = '$id'
    ");

    if ($update) {
        // ✅ Redirect otomatis kembali ke halaman kategori setelah berhasil update
        echo "<script>
                alert('Kategori berhasil diperbarui!');
                window.location.href='index.php?halaman=kategori';
              </script>";
        exit;
    } else {
        $errorMsg = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
    }
}
?>

<!-- Tampilan Form Edit -->
<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-edit"></i> Edit Kategori Surat
        </h3>
    </div>

    <div class="card-body">
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori:</label>
                <input type="text" name="nama_kategori" class="form-control"
                       value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Keterangan:</label>
                <textarea name="keterangan" class="form-control" rows="4"><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="index.php?halaman=kategori" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="update" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
