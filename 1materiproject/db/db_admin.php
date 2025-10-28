<?php
include "../koneksi.php";
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$proses = $_GET['proses'] ?? '';

if ($proses == 'tambah') {
    // Ambil data dari form
    $nama_admin = $_POST['nama_admin'] ?? '';
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';
    $email      = $_POST['email'] ?? '';
    $no_telp    = $_POST['no_telp'] ?? '';

    // Enkripsi password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Upload foto (jika ada)
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "../foto/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $foto;

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
            die("Gagal mengupload foto admin!");
        }
    }

    // Query insert
    $query = "INSERT INTO admin (nama_admin, username, password, email, no_telp, foto)
              VALUES ('$nama_admin', '$username', '$password_hash', '$email', '$no_telp', '$foto')";
    
    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

} elseif ($proses == 'edit') {
    $id_admin   = $_POST['id_admin'] ?? '';
    $nama_admin = $_POST['nama_admin'] ?? '';
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';
    $email      = $_POST['email'] ?? '';
    $no_telp    = $_POST['no_telp'] ?? '';

    // Jika password diubah
    $password_query = '';
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $password_query = ", password='$password_hash'";
    }

    // Upload foto baru (jika ada)
    $foto_query = '';
    if (!empty($_FILES['foto']['name'])) {
        $targetDir = "../foto/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $targetFile = $targetDir . $foto;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
            $foto_query = ", foto='$foto'";
        } else {
            die("Gagal mengupload foto baru!");
        }
    }

    // Query update
    $query = "UPDATE admin SET 
                nama_admin='$nama_admin',
                username='$username',
                email='$email',
                no_telp='$no_telp'
                $password_query
                $foto_query
              WHERE id_admin='$id_admin'";

    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

} elseif ($proses == 'hapus') {
    $id_admin = $_GET['id_admin'] ?? '';

    // Hapus foto jika ada
    $queryFoto = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id_admin='$id_admin'");
    $dataFoto = mysqli_fetch_assoc($queryFoto);
    if (!empty($dataFoto['foto']) && file_exists("../foto/" . $dataFoto['foto'])) {
        unlink("../foto/" . $dataFoto['foto']);
    }

    // Hapus admin
    $query = "DELETE FROM admin WHERE id_admin='$id_admin'";
    if (!mysqli_query($koneksi, $query)) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
}

// Redirect ke halaman admin
header("Location: ../index.php?halaman=admin");
exit;
?>
