<?php
require_once __DIR__ . '/../../db/db_admin.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='index.php?halaman=admin';</script>";
    exit;
}

$id = $_GET['id'];
$data = getAdminById($koneksi, $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (updateAdmin($koneksi, $id, $_POST, $_FILES['foto'])) {
        echo "<script>alert('Data admin berhasil diperbarui!'); window.location='index.php?halaman=admin';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-warning text-white"><h4>Edit Admin</h4></div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Admin</label>
                <input type="text" name="nama_admin" class="form-control" value="<?= htmlspecialchars($data['nama_admin']); ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($data['password']); ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>">
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input type="text" name="no_telp" class="form-control" value="<?= htmlspecialchars($data['no_telp']); ?>">
            </div>
            <div class="form-group">
                <label>Foto Lama</label><br>
                <?php if ($data['foto']): ?>
                    <img src="uploads/<?= $data['foto']; ?>" width="100" class="img-thumbnail mb-2"><br>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?halaman=admin" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
