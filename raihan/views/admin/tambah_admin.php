<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
include 'koneksi.php';

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $nama_admin = $_POST['nama_admin'] ?? '';
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';
    $email      = $_POST['email'] ?? '';
    $no_telp    = $_POST['no_telp'] ?? '';

    // Enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Upload foto
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "foto/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            die("<script>alert('Gagal mengupload foto admin!'); window.history.back();</script>");
        }
    }

    // Simpan ke database
    $query = "INSERT INTO admin (nama_admin, username, password, email, no_telp, foto)
              VALUES ('$nama_admin', '$username', '$password_hash', '$email', '$no_telp', '$foto')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
            alert('Data admin berhasil disimpan!');
            window.location.href='index.php?halaman=admin';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');
            window.history.back();
        </script>";
    }
}
?>

<!-- Tampilan Form Tambah Admin -->
<style>
    .form-container {
        max-width: 900px;
        margin: 40px auto;
        background: #2d3436;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        color: #fff;
    }

    .form-header {
        background: linear-gradient(90deg, #007bff, #00aaff);
        padding: 15px 25px;
        border-radius: 12px 12px 0 0;
        color: white;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-header i {
        font-size: 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
        color: #a4b0be;
    }

    .form-control {
        background: #3b3b3b;
        border: 1px solid #555;
        color: white;
        border-radius: 10px;
        padding: 10px 15px;
    }

    .form-control:focus {
        border-color: #00aaff;
        box-shadow: 0 0 5px #00aaff;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #006ae6;
    }

    .btn-secondary {
        background-color: #555;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #666;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <i class="fas fa-user-plus"></i> Tambah Admin
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-grid">
            <div>
                <label>Nama Admin</label>
                <input type="text" name="nama_admin" class="form-control" placeholder="Masukkan Nama Admin" required>
            </div>

            <div>
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email Admin">
            </div>

            <div>
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukkan Nomor Telepon">
            </div>

            <div>
                <label>Foto Admin</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="index.php?halaman=admin" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
