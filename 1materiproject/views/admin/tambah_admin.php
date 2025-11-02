<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// koneksi langsung
require_once __DIR__ . '/../../koneksi.php';
require_once __DIR__ . '/../../db/db_admin.php'; // pastikan file ini ada dan isinya fungsi tambahAdmin()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $berhasil = tambahAdmin($koneksi, $_POST, $_FILES['foto']);

    if ($berhasil) {
        // Redirect pakai meta refresh agar aman dari "headers already sent"
        echo "<meta http-equiv='refresh' content='0;url=index.php?halaman=admin'>";
        exit;
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
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Foto akan disimpan di folder <strong>assets/img/</strong></small>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?halaman=admin" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
