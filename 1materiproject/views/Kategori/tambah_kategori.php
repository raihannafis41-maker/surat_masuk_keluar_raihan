<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// pastikan koneksi bisa diakses walau file di subfolder
include __DIR__ . '/../../koneksi.php';

// proses simpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama_kategori'] ?? ''));
    $ket  = trim(mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? ''));

    if ($nama !== '') {
        $simpan = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama', '$ket')");
        if ($simpan) {
            // langsung kembali ke halaman kategori setelah berhasil simpan
            header('Location: index.php?halaman=kategori');
            exit;
        } else {
            $errorMsg = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    } else {
        $errorMsg = "Nama kategori tidak boleh kosong!";
    }
}
?>

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-plus-circle"></i> Tambah Kategori Surat</h3>
    </div>

    <div class="card-body">
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group mb-3">
                <label for="nama_kategori" class="fw-bold">Nama Kategori:</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Masukkan nama kategori" required>
            </div>

            <div class="form-group mb-3">
                <label for="keterangan" class="fw-bold">Keterangan:</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Tulis keterangan (opsional)"></textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="index.php?halaman=kategori" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" name="simpan" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
