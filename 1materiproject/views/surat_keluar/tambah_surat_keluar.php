<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
include __DIR__ . '/../../koneksi.php';
include __DIR__ . '/../../db/db_surat_keluar.php';



if (isset($_POST['simpan'])) {
  $no_surat = $_POST['no_surat'];
  $tgl_surat = $_POST['tgl_surat'];
  $tujuan = $_POST['tujuan'];
  $alamat_tujuan = $_POST['alamat_tujuan'];
  $perihal = $_POST['perihal'];
  $isi = $_POST['isi'];
  $id_pegawai = $_POST['id_pegawai'];

  // Upload file
  $nama_file = $_FILES['file_surat']['name'];
  $tmp_file = $_FILES['file_surat']['tmp_name'];
  $folder = "../../file_surat/";

  if ($nama_file != "") {
    move_uploaded_file($tmp_file, $folder . $nama_file);
  } else {
    $nama_file = null;
  }

  if (tambahSuratKeluar($conn, $no_surat, $tgl_surat, $tujuan, $alamat_tujuan, $perihal, $isi, $nama_file, $id_pegawai)) {
    echo "<script>alert('Surat keluar berhasil ditambahkan'); window.location='surat_keluar.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan surat keluar');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tambah Surat Keluar</title>
  <link rel="stylesheet" href="../../assets/bootstrap.min.css">
</head>

<body class="container mt-5">
  <h3 class="mb-4">Tambah Surat Keluar</h3>

  <form method="POST" enctype="multipart/form-data">
    <div class="form-group mb-3">
      <label>No Surat</label>
      <input type="text" name="no_surat" class="form-control" required>
    </div>
    <div class="form-group mb-3">
      <label>Tanggal Surat</label>
      <input type="date" name="tgl_surat" class="form-control" required>
    </div>
    <div class="form-group mb-3">
      <label>Tujuan</label>
      <input type="text" name="tujuan" class="form-control" required>
    </div>
    <div class="form-group mb-3">
      <label>Alamat Tujuan</label>
      <input type="text" name="alamat_tujuan" class="form-control" required>
    </div>
    <div class="form-group mb-3">
      <label>Perihal</label>
      <input type="text" name="perihal" class="form-control" required>
    </div>
    <div class="form-group mb-3">
      <label>Isi Surat</label>
      <textarea name="isi" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group mb-3">
      <label>File Surat (PDF)</label>
      <input type="file" name="file_surat" accept=".pdf,.docx,.jpg,.png" class="form-control">
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <a href="surat_keluar.php" class="btn btn-secondary">Kembali</a>
  </form>
</body>

</html>