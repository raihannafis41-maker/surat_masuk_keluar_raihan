<?php
// Debug mode agar terlihat jika ada error
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../db/db_surat_masuk.php';

// Pastikan koneksi aktif
if (!isset($koneksi) || !$koneksi) {
    die("❌ Koneksi database gagal!");
}

$status = null;

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_surat = $_FILES['file_surat'] ?? null;
    $hasil = tambahSuratMasuk($koneksi, $_POST, $file_surat);
    $status = $hasil ? 'sukses' : 'gagal';
}
?>

<div class="card shadow mt-4">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">
            <i class="fas fa-envelope-open-text me-2"></i> Tambah Surat Masuk
        </h4>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">No Surat</label>
                <input type="text" name="no_surat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Surat</label>
                <input type="date" name="tgl_surat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Terima</label>
                <input type="date" name="tgl_terima" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Pengirim</label>
                <input type="text" name="pengirim" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat Pengirim</label>
                <input type="text" name="alamat_pengirim" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Perihal</label>
                <input type="text" name="perihal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Surat</label>
                <textarea name="isi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="baru">Baru</option>
                    <option value="diproses">Diproses</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">File Surat (Opsional)</label>
                <input type="file" name="file_surat" class="form-control" accept=".pdf,.jpg,.png,.doc,.docx">
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Script tambahan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($status): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($status === 'sukses'): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Surat masuk berhasil ditambahkan.',
            showConfirmButton: false,
            timer: 1800
        });
        setTimeout(() => {
            window.location.href = 'index.php?halaman=surat_masuk';
        }, 1800);
    <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menyimpan surat. Silakan coba lagi.'
        });
    <?php endif; ?>
});
</script>
<?php endif; ?>
