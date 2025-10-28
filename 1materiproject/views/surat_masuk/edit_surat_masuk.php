<?php
include "koneksi.php";
$id = $_GET['id_surat_masuk'];
$query = mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE id_surat_masuk='$id_surat_masuk'");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "<script>alert('ID Surat tidak ditemukan!');window.location='index.php?halaman=surat_masuk';</script>";
    exit;
}
?>
<div class="container mt-4">
    <h3>Edit Surat Masuk</h3>
    <form action="db/db_surat_masuk.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_surat_masuk" value="<?= $data['id_surat_masuk']; ?>">
        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="no_surat" class="form-control" value="<?= $data['no_surat']; ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tgl_surat" class="form-control" value="<?= $data['tgl_surat']; ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Terima</label>
            <input type="date" name="tgl_terima" class="form-control" value="<?= $data['tgl_terima']; ?>">
        </div>
        <div class="mb-3">
            <label>Pengirim</label>
            <input type="text" name="pengirim" class="form-control" value="<?= $data['pengirim']; ?>">
        </div>
        <div class="mb-3">
            <label>Alamat Pengirim</label>
            <input type="text" name="alamat_pengirim" class="form-control" value="<?= $data['alamat_pengirim']; ?>">
        </div>
        <div class="mb-3">
            <label>Perihal</label>
            <input type="text" name="perihal" class="form-control" value="<?= $data['perihal']; ?>">
        </div>
        <div class="mb-3">
            <label>Isi Surat</label>
            <textarea name="isi" class="form-control"><?= $data['isi']; ?></textarea>
        </div>
        <div class="mb-3">
            <label>File Surat</label><br>
            <?php if ($data['file_surat']) { ?>
                <a href="file_surat/<?= $data['file_surat']; ?>" target="_blank">Lihat File</a><br>
            <?php } ?>
            <input type="file" name="file_surat" class="form-control mt-2">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="baru" <?= $data['status'] == 'baru' ? 'selected' : ''; ?>>Baru</option>
                <option value="dibaca" <?= $data['status'] == 'dibaca' ? 'selected' : ''; ?>>Dibaca</option>
            </select>
        </div>
        <div class="mb-3">
            <label>ID Pegawai</label>
            <input type="number" name="id_pegawai" class="form-control" value="<?= $data['id_pegawai']; ?>">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">Kembali</a>
    </form>
</div>
