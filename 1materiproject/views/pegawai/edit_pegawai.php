<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

// ============================
// 🔹 Cek ID Pegawai
// ============================
if (!isset($_GET['id'])) {
    echo "<script>alert('ID pegawai tidak ditemukan!');window.location='index.php?halaman=pegawai';</script>";
    exit;
}

$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id_pegawai = '$id'"));
if (!$data) {
    echo "<script>alert('Data pegawai tidak ditemukan!');window.location='index.php?halaman=pegawai';</script>";
    exit;
}

// ============================
// 🔹 PROSES UPDATE
// ============================
if (isset($_POST['update'])) {
    $nip       = $_POST['nip'];
    $nama      = $_POST['nama_pegawai'];
    $jabatan   = $_POST['jabatan'];
    $email     = $_POST['email'];
    $no_telp   = $_POST['no_telp'];
    $golongan  = $_POST['golongan'];
    $foto_lama = $data['foto'];

    // 🔸 Folder penyimpanan disamakan dengan profil.php dan pegawai.php
    $folder = __DIR__ . "/../../assets/img/";
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    // Upload foto baru jika ada
    if (!empty($_FILES['foto']['name'])) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {
            // 🔸 Penamaan file sinkron dengan profil.php
            $newName = "pegawai_" . $id . "_" . time() . "." . $ext;
            $path = $folder . $newName;

            // Hapus foto lama jika ada
            if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
                unlink($folder . $foto_lama);
            }

            move_uploaded_file($_FILES['foto']['tmp_name'], $path);
            $foto = $newName;
        } else {
            $foto = $foto_lama;
        }
    } else {
        $foto = $foto_lama;
    }

    // Update data pegawai
    $update = mysqli_query($koneksi, "UPDATE pegawai SET 
        nip='$nip',
        nama_pegawai='$nama',
        jabatan='$jabatan',
        email='$email',
        no_telp='$no_telp',
        golongan='$golongan',
        foto='$foto'
        WHERE id_pegawai='$id'
    ");

    if ($update) {
        echo "<script>window.location='index.php?halaman=pegawai';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!-- ============================
     💠 STYLE FOTO PREVIEW
============================= -->
<style>
.foto-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
}
.foto-preview img {
    width: 160px;
    height: 180px;
    border-radius: 16px; /* Kotak dengan sudut melengkung */
    object-fit: cover;
    border: 3px solid #e3eaf4;
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}
</style>

<!-- ============================
     💠 FORM EDIT PEGAWAI
============================= -->
<div class='card shadow-lg border-0'>
    <div class='card-header bg-warning text-white'>
        <h3 class='card-title mb-0'>
            <i class='fas fa-user-edit'></i> Edit Data Pegawai
        </h3>
    </div>

    <form method='POST' enctype='multipart/form-data'>
        <div class='card-body'>

            <!-- ✅ Preview Foto -->
            <div class='foto-preview'>
                <?php
                // 🔸 Path foto disamakan dengan profil.php
                $fotoPath = 'assets/img/' . ($data['foto'] ?: 'default.png');
                if (!file_exists(__DIR__ . '/../../' . $fotoPath)) {
                    $fotoPath = 'assets/img/default.png';
                }
                ?>
                <img src='<?= htmlspecialchars($fotoPath); ?>' alt='Foto Pegawai'>
            </div>

            <div class='row'>
                <div class='col-md-6 mb-3'>
                    <label class='form-label'>NIP</label>
                    <input type='text' name='nip' value='<?= htmlspecialchars($data['nip']); ?>' class='form-control'>
                </div>

                <div class='col-md-6 mb-3'>
                    <label class='form-label'>Nama Pegawai</label>
                    <input type='text' name='nama_pegawai' value='<?= htmlspecialchars($data['nama_pegawai']); ?>' class='form-control'>
                </div>

                <div class='col-md-6 mb-3'>
                    <label class='form-label'>Jabatan</label>
                    <input type='text' name='jabatan' value='<?= htmlspecialchars($data['jabatan']); ?>' class='form-control'>
                </div>

                <div class='col-md-6 mb-3'>
                    <label class='form-label'>Email</label>
                    <input type='email' name='email' value='<?= htmlspecialchars($data['email']); ?>' class='form-control'>
                </div>

                <div class='col-md-6 mb-3'>
                    <label class='form-label'>No. Telepon</label>
                    <input type='text' name='no_telp' value='<?= htmlspecialchars($data['no_telp']); ?>' class='form-control'>
                </div>

                <div class='col-md-6 mb-3'>
                    <label class='form-label'>Golongan</label>
                    <input type='text' name='golongan' value='<?= htmlspecialchars($data['golongan']); ?>' class='form-control'>
                </div>

                <div class='col-md-12 mb-3'>
                    <label class='form-label'>Ganti Foto (opsional)</label>
                    <input type='file' name='foto' accept='image/*' class='form-control'>
                </div>
            </div>
        </div>

        <div class='card-footer text-end'>
            <button type='submit' name='update' class='btn btn-success'>
                <i class='fas fa-save'></i> Simpan
            </button>
            <a href='index.php?halaman=pegawai' class='btn btn-secondary'>
                <i class='fas fa-arrow-left'></i> Kembali
            </a>
        </div>
    </form>
</div>
