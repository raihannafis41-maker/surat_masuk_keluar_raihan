<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// ================================================
// ✅ PROSES SIMPAN DATA PEGAWAI
// ================================================
if (isset($_POST['simpan'])) {
    $nip           = $_POST['nip'] ?? '';
    $nama_pegawai  = $_POST['nama_pegawai'] ?? '';
    $jabatan       = $_POST['jabatan'] ?? '';
    $email         = $_POST['email'] ?? '';
    $no_telp       = $_POST['no_telp'] ?? '';
    $golongan      = $_POST['golongan'] ?? '';

    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "foto/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "<script>
                alert('Gagal mengupload foto pegawai!');
                window.history.back();
            </script>";
            exit;
        }
    }

    $query = "INSERT INTO pegawai (nip, nama_pegawai, jabatan, email, no_telp, golongan, foto)
              VALUES ('$nip', '$nama_pegawai', '$jabatan', '$email', '$no_telp', '$golongan', '$foto')";
    $result = mysqli_query($koneksi, $query);

    // Jika berhasil simpan → redirect otomatis ke pegawai.php
    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data pegawai berhasil disimpan.',
                showConfirmButton: false,
                timer: 2000
            });
            setTimeout(() => {
                window.location.href = 'index.php?halaman=pegawai';
            }, 2000);
        </script>";
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan: " . addslashes(mysqli_error($koneksi)) . "',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>

<!-- ================================================ -->
<!-- ✅ FORM TAMBAH PEGAWAI -->
<!-- ================================================ -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background: #f5f8fc;
    font-family: 'Poppins', sans-serif;
}
.card-modern {
    background: #ffffff;
    border: none;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.card-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}
.card-header-modern {
    background: linear-gradient(90deg, #1e88e5, #42a5f5);
    color: white;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 15px 25px;
    font-weight: 600;
    font-size: 18px;
    letter-spacing: 0.5px;
}
.form-label {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 6px;
}
.form-control {
    border-radius: 10px;
    border: 1px solid #d0d7e2;
    background-color: #f9fbfd;
    color: #0f172a;
    transition: all 0.2s ease;
}
.form-control::placeholder {
    color: #94a3b8;
}
.form-control:focus {
    border-color: #42a5f5;
    background-color: #ffffff;
    box-shadow: 0 0 0 0.25rem rgba(66,165,245,0.25);
    color: #0f172a;
}
.btn-primary {
    background: linear-gradient(90deg, #1e88e5, #42a5f5);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-primary:hover {
    background: linear-gradient(90deg, #1976d2, #2196f3);
    transform: scale(1.03);
}
.btn-secondary {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}
</style>

<div class="container py-5">
    <div class="card card-modern mx-auto col-md-8">
        <div class="card-header-modern">
            <i class="fas fa-user-plus"></i> Tambah Pegawai
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP Pegawai" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" class="form-control" placeholder="Masukkan Nama Pegawai" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Masukkan Jabatan Pegawai" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email Pegawai">
                </div>

                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="Masukkan Nomor Telepon">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Golongan</label>
                    <input type="text" name="golongan" class="form-control" placeholder="Masukkan Golongan Pegawai">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Foto Pegawai</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="index.php?halaman=pegawai" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
