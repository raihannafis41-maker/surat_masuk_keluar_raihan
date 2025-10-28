<?php
include "../koneksi.php";
session_start();

$id_admin = $_GET['id_admin'] ?? '';

if (empty($id_admin)) {
    die("ID admin tidak ditemukan!");
}

// Ambil data admin dari database
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data admin tidak ditemukan!");
}
?>

<!-- Tampilan Edit Admin -->
<div class="container mt-4">
    <h3 class="mb-3">Edit Data Admin</h3>

    <form action="../db/db_admin.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_admin" value="<?= $data['id_admin'] ?>">

        <div class="form-group mb-3">
            <label>Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" value="<?= $data['nama_admin'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
        </div>

        <div class="form-group mb-3">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp'] ?>">
        </div>

        <div class="form-group mb-3">
            <label>Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Foto (kosongkan jika tidak ingin diganti)</label><br>
            <?php if (!empty($data['foto'])): ?>
                <img src="../foto/<?= $data['foto'] ?>" width="100" class="rounded mb-2">
            <?php endif; ?>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="../index.php?halaman=admin" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
