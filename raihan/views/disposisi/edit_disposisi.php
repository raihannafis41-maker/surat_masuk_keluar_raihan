<?php
include 'koneksi.php';

// Pastikan ada ID di URL
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID Disposisi tidak ditemukan!</div>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data disposisi dan relasinya (pegawai & surat masuk)
$query = "
    SELECT d.*, sm.pengirim, p.nama_pegawai
    FROM disposisi d
    JOIN surat_masuk sm ON d.id_surat_masuk = sm.id_surat_masuk
    JOIN pegawai p ON d.id_pegawai = p.id_pegawai
    WHERE d.id_disposisi = '$id'
";
$data = mysqli_query($koneksi, $query);
$d = mysqli_fetch_assoc($data);

if (!$d) {
    echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $tgl = $_POST['tgl_disposisi'];
    $status = $_POST['status_disposisi'];
    $catatan = $_POST['catatan'];

    // Upload file baru jika ada
    $file_name = $d['file_disposisi'];
    if (!empty($_FILES['file_disposisi']['name'])) {
        $file_tmp = $_FILES['file_disposisi']['tmp_name'];
        $file_new = time() . "_" . basename($_FILES['file_disposisi']['name']);
        move_uploaded_file($file_tmp, "uploads/" . $file_new);
        $file_name = $file_new;
    }

    // Update ke database
    $update = "
        UPDATE disposisi SET 
            id_pegawai = '$id_pegawai',
            tgl_disposisi = '$tgl',
            status_disposisi = '$status',
            catatan = '$catatan',
            file_disposisi = '$file_name'
        WHERE id_disposisi = '$id'
    ";

    if (mysqli_query($koneksi, $update)) {
        echo "<script>alert('Data berhasil diperbarui');window.location='index.php?halaman=disposisi';</script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<div class="content-wrapper p-3">
    <section class="content-header mb-3">
        <h3>Edit Disposisi</h3>
    </section>

    <section class="content">
        <div class="card shadow">
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data">

                    <!-- Pengirim -->
                    <div class="form-group mb-2">
                        <label>Pengirim</label>
                        <input type="text" class="form-control" 
                               value="<?= htmlspecialchars($d['pengirim'] ?? '') ?>" 
                               readonly>
                    </div>

                    <!-- Pegawai -->
                    <div class="form-group mb-2">
                        <label>Pegawai Tujuan</label>
                        <select name="id_pegawai" class="form-control" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <?php
                            $pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
                            while ($p = mysqli_fetch_assoc($pegawai)) :
                            ?>
                                <option value="<?= $p['id_pegawai'] ?>"
                                    <?= ($p['id_pegawai'] == $d['id_pegawai']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['nama_pegawai']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Tanggal Disposisi -->
                    <div class="form-group mb-2">
                        <label>Tanggal Disposisi</label>
                        <input type="date" name="tgl_disposisi" class="form-control"
                               value="<?= htmlspecialchars($d['tgl_disposisi'] ?? '') ?>" required>
                    </div>

                    <!-- Status Disposisi -->
                    <div class="form-group mb-2">
                        <label>Status Disposisi</label>
                        <select name="status_disposisi" class="form-control" required>
                            <option value="Belum Dibaca" <?= ($d['status_disposisi'] == 'Belum Dibaca') ? 'selected' : '' ?>>Belum Dibaca</option>
                            <option value="Proses" <?= ($d['status_disposisi'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                            <option value="Selesai" <?= ($d['status_disposisi'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div class="form-group mb-2">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3"><?= htmlspecialchars($d['catatan'] ?? '') ?></textarea>
                    </div>

                    <!-- File Disposisi -->
                    <div class="form-group mb-2">
                        <label>File Disposisi (Opsional)</label><br>
                        <?php if (!empty($d['file_disposisi'])): ?>
                            <a href="uploads/<?= htmlspecialchars($d['file_disposisi']) ?>" target="_blank" class="btn btn-sm btn-info mb-2">
                                <i class="fas fa-file"></i> Lihat File Lama
                            </a><br>
                        <?php endif; ?>
                        <input type="file" name="file_disposisi" class="form-control">
                    </div>

                    <div class="mt-3">
                        <button type="submit" name="update" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="index.php?halaman=disposisi" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
