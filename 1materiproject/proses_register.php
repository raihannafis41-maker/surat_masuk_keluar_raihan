<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data umum
  $role = $_POST['role'] ?? '';
  $password = $_POST['password'] ?? '';
  $konfirmasi = $_POST['konfirmasi_password'] ?? '';

  // Folder upload foto
  $upload_dir = "uploads/";
  if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

  // Proses upload foto (jika ada)
  $foto_nama = "default.png";
  if (!empty($_FILES['foto']['name'])) {
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_nama = time() . '_' . basename($_FILES['foto']['name']);
    move_uploaded_file($foto_tmp, $upload_dir . $foto_nama);
  }

  // ============================================================
  // 🧩 ROLE: ADMIN (dengan password)
  // ============================================================
  if ($role === 'admin') {

    // Cek konfirmasi password
    if ($password !== $konfirmasi) {
      echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
      exit;
    }

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Ambil data
    $nama = trim($_POST['nama_admin'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');

    // Cek username unik
    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
      echo "<script>alert('Username sudah digunakan oleh admin lain!'); window.history.back();</script>";
      exit;
    }

    // Simpan ke tabel admin
    $query = "INSERT INTO admin (nama_admin, username, email, no_telp, password, foto)
              VALUES ('$nama', '$username', '$email', '$no_telp', '$hashed_password', '$foto_nama')";

    if (mysqli_query($koneksi, $query)) {
      echo "<script>alert('Pendaftaran Admin berhasil! Silakan login.'); window.location='before_login.php';</script>";
    } else {
      echo "<script>alert('Terjadi kesalahan saat menyimpan data Admin.'); window.history.back();</script>";
    }

  // ============================================================
  // 🧩 ROLE: PEGAWAI (tanpa password)
  // ============================================================
  } elseif ($role === 'pegawai') {
    $nip = trim($_POST['nip'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_telp = trim($_POST['no_telp'] ?? '');
    $golongan = trim($_POST['golongan'] ?? '');

    // Cek NIP unik
    $cek = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE nip='$nip'");
    if (mysqli_num_rows($cek) > 0) {
      echo "<script>alert('NIP sudah digunakan oleh pegawai lain!'); window.history.back();</script>";
      exit;
    }

    // Simpan ke tabel pegawai (tanpa kolom password)
    $query = "INSERT INTO pegawai (nip, jabatan, email, no_telp, golongan, foto)
              VALUES ('$nip', '$jabatan', '$email', '$no_telp', '$golongan', '$foto_nama')";

    if (mysqli_query($koneksi, $query)) {
      echo "<script>alert('Pendaftaran Pegawai berhasil! Silakan login.'); window.location='before_login.php';</script>";
    } else {
      echo "<script>alert('Terjadi kesalahan saat menyimpan data Pegawai.'); window.history.back();</script>";
    }

  // ============================================================
  // ROLE INVALID
  // ============================================================
  } else {
    echo "<script>alert('Role tidak valid!'); window.history.back();</script>";
  }

} else {
  header("Location: register.php");
  exit;
}
?>
