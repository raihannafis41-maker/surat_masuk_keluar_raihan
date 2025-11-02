<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../koneksi.php';

// Ambil semua data pegawai
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background-color: #f5f8fc;
    font-family: 'Poppins', sans-serif;
}

/* Kartu Pegawai */
.card-pegawai {
    background: #ffffff;
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-align: center;
    padding-top: 25px;
}

.card-pegawai:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

/* FOTO PEGAWAI - KOTAK MELENGKUNG */
.card-pegawai .foto-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.card-pegawai img {
    width: 150px;
    height: 180px;
    border-radius: 16px; /* melengkung, tapi tetap kotak */
    border: 4px solid #e3eaf4;
    object-fit: cover;
    object-position: center;
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

/* Tombol */
.btn-action {
    border-radius: 8px;
    font-weight: 600;
    transition: 0.2s;
}
.btn-action i {
    margin-right: 5px;
}
.btn-info {
    background: linear-gradient(90deg, #00b4d8, #48cae4);
    border: none;
}
.btn-warning {
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
    border: none;
    color: #fff;
}
.btn-danger {
    background: linear-gradient(90deg, #ef4444, #f87171);
    border: none;
}
.btn-info:hover,
.btn-warning:hover,
.btn-danger:hover {
    transform: scale(1.05);
}

/* Header */
.card-header-modern {
    background: linear-gradient(90deg, #1e88e5, #42a5f5);
    color: #fff;
    padding: 15px 25px;
    border-radius: 15px;
    font-weight: 600;
}
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="card-header-modern">
            <i class="fas fa-user-tie"></i> Data Pegawai
        </div>
        <a href="index.php?halaman=tambah_pegawai" class="btn btn-primary btn-action">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>

    <div class="row">
        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <?php
                // --- FIX: Semua foto sekarang diambil dari /assets/img/
                $fotoFile = htmlspecialchars($row['foto'] ?? '');
                $fotoPath = 'assets/img/default.png'; // default jika kosong

                if (!empty($fotoFile)) {
                    $path = __DIR__ . '/../../assets/img/' . $fotoFile;
                    if (file_exists($path)) {
                        $fotoPath = 'assets/img/' . $fotoFile;
                    }
                }
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-pegawai p-3">
                        <div class="foto-wrapper">
                            <img src="<?= $fotoPath ?>" alt="Foto Pegawai">
                        </div>
                        <h5 class="fw-bold mt-2 mb-1"><?= htmlspecialchars($row['nama_pegawai']); ?></h5>
                        <p class="text-muted mb-1"><i class="fas fa-id-card"></i> <?= htmlspecialchars($row['nip'] ?? '-'); ?></p>
                        <p class="mb-1"><i class="fas fa-briefcase"></i> <?= htmlspecialchars($row['jabatan'] ?? '-'); ?></p>
                        <p class="mb-1"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email'] ?? '-'); ?></p>
                        <p class="mb-2"><i class="fas fa-phone"></i> <?= htmlspecialchars($row['no_telp'] ?? '-'); ?></p>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="index.php?halaman=tampilan_pegawai&id=<?= $row['id_pegawai']; ?>" class="btn btn-info btn-sm btn-action mx-1">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="index.php?halaman=edit_pegawai&id=<?= $row['id_pegawai']; ?>" class="btn btn-warning btn-sm btn-action mx-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="index.php?halaman=hapus_pegawai&id=<?= $row['id_pegawai']; ?>"
                               onclick="return confirm('Yakin ingin menghapus pegawai ini?')"
                               class="btn btn-danger btn-sm btn-action mx-1">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-info py-4 mt-3 rounded-3 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> Belum ada data pegawai.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
