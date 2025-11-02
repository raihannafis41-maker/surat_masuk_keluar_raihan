<?php
require_once __DIR__ . '/../koneksi.php';

/* =====================================================
   FUNGSI CRUD UNTUK DATA ADMIN
   (FINAL - FOTO DISIMPAN & DIGUNAKAN DARI assets/img/)
   ===================================================== */

// === READ ALL ADMIN ===
function getAllAdmin($koneksi) {
    $sql = "SELECT * FROM admin ORDER BY id_admin ASC";
    $result = mysqli_query($koneksi, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// === GET ADMIN BY ID ===
function getAdminById($koneksi, $id) {
    $sql = "SELECT * FROM admin WHERE id_admin = $id";
    $result = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($result);
}

// === TAMBAH ADMIN ===
function tambahAdmin($koneksi, $data, $file) {
    $nama_admin = mysqli_real_escape_string($koneksi, $data['nama_admin']);
    $username   = mysqli_real_escape_string($koneksi, $data['username']);
    $password   = mysqli_real_escape_string($koneksi, $data['password']);
    $email      = mysqli_real_escape_string($koneksi, $data['email']);
    $no_telp    = mysqli_real_escape_string($koneksi, $data['no_telp']);

    $fileName = null;
    if ($file && !empty($file['name'])) {
        // Lokasi penyimpanan: assets/img/
        $uploadDir = realpath(__DIR__ . '/../assets/img/') . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = 'admin_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            $fileName = null; // fallback jika gagal upload
        }
    }

    $sql = "INSERT INTO admin (nama_admin, username, password, email, no_telp, foto)
            VALUES ('$nama_admin', '$username', '$password', '$email', '$no_telp', '$fileName')";
    return mysqli_query($koneksi, $sql);
}

// === UPDATE ADMIN ===
function updateAdmin($koneksi, $id, $data, $file) {
    $id = (int)$id;
    $lama = getAdminById($koneksi, $id);
    $fotoLama = $lama['foto'];

    $nama_admin = mysqli_real_escape_string($koneksi, $data['nama_admin']);
    $username   = mysqli_real_escape_string($koneksi, $data['username']);
    $password   = mysqli_real_escape_string($koneksi, $data['password']);
    $email      = mysqli_real_escape_string($koneksi, $data['email']);
    $no_telp    = mysqli_real_escape_string($koneksi, $data['no_telp']);

    // Proses upload foto baru (jika ada)
    if ($file && !empty($file['name'])) {
        $uploadDir = realpath(__DIR__ . '/../assets/img/') . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileBaru = 'admin_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $fileBaru;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Hapus foto lama jika ada
            if ($fotoLama && file_exists($uploadDir . $fotoLama)) {
                unlink($uploadDir . $fotoLama);
            }
            $fotoLama = $fileBaru;
        }
    }

    $sql = "UPDATE admin SET 
                nama_admin='$nama_admin',
                username='$username',
                password='$password',
                email='$email',
                no_telp='$no_telp',
                foto='$fotoLama'
            WHERE id_admin=$id";
    return mysqli_query($koneksi, $sql);
}

// === HAPUS ADMIN ===
function deleteAdmin($koneksi, $id) {
    $id = (int)$id;
    $data = getAdminById($koneksi, $id);
    $foto = $data['foto'];

    $uploadDir = realpath(__DIR__ . '/../assets/img/') . '/';
    if ($foto && file_exists($uploadDir . $foto)) {
        unlink($uploadDir . $foto);
    }

    $sql = "DELETE FROM admin WHERE id_admin = $id";
    return mysqli_query($koneksi, $sql);
}
?>
