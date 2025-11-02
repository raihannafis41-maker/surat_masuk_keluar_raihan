<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// ================================================
// ✅ PROSES SIMPAN DATA PEGAWAI
// ================================================
if (isset($_POST['simpan'])) {
    $nip           = trim($_POST['nip'] ?? '');
    $nama_pegawai  = trim($_POST['nama_pegawai'] ?? '');
    $jabatan       = trim($_POST['jabatan'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $no_telp       = trim($_POST['no_telp'] ?? '');
    $golongan      = trim($_POST['golongan'] ?? '');

    // ===============================
    // 🔍 CEK DUPLIKAT NIP
    // ===============================
    $cek_nip = mysqli_query($koneksi, "SELECT nip FROM pegawai WHERE nip = '$nip' LIMIT 1");
    if (mysqli_num_rows($cek_nip) > 0) {
        echo "<script>alert('NIP sudah terdaftar! Silakan gunakan NIP lain.');window.history.back();</script>";
        exit;
    }

    // ===============================
    // 🖼️ PROSES UPLOAD FOTO
    // ===============================
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        // Folder upload disamakan dengan profil.php & edit_pegawai.php
        $target_dir = __DIR__ . "/../../assets/img/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {
            $foto = "pegawai_" . time() . "." . $ext;
            $target_file = $target_dir . $foto;

            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "<script>alert('Gagal mengupload foto pegawai!');window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto tidak valid! Gunakan JPG, JPEG, atau PNG.');window.history.back();</script>";
            exit;
        }
    }

    // ===============================
    // 💾 SIMPAN DATA PEGAWAI
    // ===============================
    $query = "INSERT INTO pegawai (nip, nama_pegawai, jabatan, email, no_telp, golongan, foto)
              VALUES ('$nip', '$nama_pegawai', '$jabatan', '$email', '$no_telp', '$golongan', '$foto')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href = 'index.php?halaman=pegawai';</script>";
        exit;
    } else {
        echo "<script>alert('Terjadi kesalahan: " . addslashes(mysqli_error($koneksi)) . "');</script>";
    }
}
?>

<div class='container py-5'>
    <div class='card card-modern mx-auto col-md-8'>
        <div class='card-header-modern'>
            <i class='fas fa-user-plus'></i> Tambah Pegawai
        </div>

        <form action='' method='POST' enctype='multipart/form-data' class='p-4'>
            <div class='row g-3'>
                <div class='col-md-6'>
                    <label class='form-label'>NIP</label>
                    <input type='text' name='nip' class='form-control' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Nama Pegawai</label>
                    <input type='text' name='nama_pegawai' class='form-control' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Jabatan</label>
                    <input type='text' name='jabatan' class='form-control' required>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Email</label>
                    <input type='email' name='email' class='form-control'>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>No. Telepon</label>
                    <input type='text' name='no_telp' class='form-control'>
                </div>
                <div class='col-md-6'>
                    <label class='form-label'>Golongan</label>
                    <input type='text' name='golongan' class='form-control'>
                </div>
                <div class='col-md-12'>
                    <label class='form-label'>Foto Pegawai</label>
                    <input type='file' name='foto' class='form-control' accept='image/*'>
                </div>
            </div>

            <div class='text-end mt-4'>
                <button type='submit' name='simpan' class='btn btn-primary'>
                    <i class='fas fa-save me-1'></i> Simpan
                </button>
                <a href='index.php?halaman=pegawai' class='btn btn-secondary'>
                    <i class='fas fa-arrow-left me-1'></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
