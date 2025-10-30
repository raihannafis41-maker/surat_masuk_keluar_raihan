<?php
require_once __DIR__ . '/../../db/db_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (tambahAdmin($koneksi, $_POST, $_FILES['foto'])) {
        echo "<script>alert('Admin berhasil ditambahkan!'); window.location='index.php?halaman=admin';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan admin!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-success text-white"><h4>Tambah Admin</h4></div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Admin</label>
                <input type="text" name="nama_admin" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input type="text" name="no_telp" class="form-control">
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?halaman=admin" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
