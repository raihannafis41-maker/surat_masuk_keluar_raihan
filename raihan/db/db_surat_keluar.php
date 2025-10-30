<?php
require_once(__DIR__ . '/../koneksi.php');

if (!isset($koneksi) || !$koneksi) {
    die("❌ Koneksi ke database gagal. Periksa file koneksi.php");
}

// === CREATE ===
function tambahSuratKeluar($data, $file)
{
    global $koneksi;

    $no_surat      = mysqli_real_escape_string($koneksi, $data['no_surat']);
    $tgl_surat     = mysqli_real_escape_string($koneksi, $data['tgl_surat']);
    $tujuan        = mysqli_real_escape_string($koneksi, $data['tujuan']);
    $alamat_tujuan = mysqli_real_escape_string($koneksi, $data['alamat_tujuan']);
    $perihal       = mysqli_real_escape_string($koneksi, $data['perihal']);
    $isi           = mysqli_real_escape_string($koneksi, $data['isi']);
    $id_pegawai    = mysqli_real_escape_string($koneksi, $data['id_pegawai']);

    $namaFile = null;
    if (!empty($file['file_surat']['name'])) {
        // ✅ Gunakan path absolut dari root proyek
        $uploadDir = __DIR__ . '/../uploads/file_surat/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $namaFile = time() . '_' . basename($file['file_surat']['name']);
        $target = $uploadDir . $namaFile;

        // Pindahkan file upload
        if (!move_uploaded_file($file['file_surat']['tmp_name'], $target)) {
            die("❌ Gagal upload file surat!");
        }
    }

    $query = "INSERT INTO surat_keluar 
              (no_surat, tgl_surat, tujuan, alamat_tujuan, perihal, isi, file_surat, id_pegawai)
              VALUES ('$no_surat', '$tgl_surat', '$tujuan', '$alamat_tujuan', '$perihal', '$isi', '$namaFile', '$id_pegawai')";
    return mysqli_query($koneksi, $query);
}

// === READ ===
function getAllSuratKeluar()
{
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY id_surat_keluar DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getSuratKeluarById($id)
{
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM surat_keluar WHERE id_surat_keluar='$id'");
    return mysqli_fetch_assoc($result);
}

// === UPDATE ===
function updateSuratKeluar($id, $data, $file)
{
    global $koneksi;

    $no_surat      = mysqli_real_escape_string($koneksi, $data['no_surat']);
    $tgl_surat     = mysqli_real_escape_string($koneksi, $data['tgl_surat']);
    $tujuan        = mysqli_real_escape_string($koneksi, $data['tujuan']);
    $alamat_tujuan = mysqli_real_escape_string($koneksi, $data['alamat_tujuan']);
    $perihal       = mysqli_real_escape_string($koneksi, $data['perihal']);
    $isi           = mysqli_real_escape_string($koneksi, $data['isi']);
    $id_pegawai    = mysqli_real_escape_string($koneksi, $data['id_pegawai']);

    $namaFile = $data['file_lama'] ?? null;
    $uploadDir = __DIR__ . '/../../uploads/file_surat/';

    if (!empty($file['file_surat']['name'])) {
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $namaFileBaru = time() . '_' . basename($file['file_surat']['name']);
        $target = $uploadDir . $namaFileBaru;

        if (move_uploaded_file($file['file_surat']['tmp_name'], $target)) {
            // hapus file lama
            if (!empty($data['file_lama'])) {
                $oldFile = $uploadDir . $data['file_lama'];
                if (file_exists($oldFile)) unlink($oldFile);
            }
            $namaFile = $namaFileBaru;
        } else {
            echo "<script>alert('❌ Gagal upload file baru!');</script>";
        }
    }

    $query = "UPDATE surat_keluar SET 
                no_surat='$no_surat',
                tgl_surat='$tgl_surat',
                tujuan='$tujuan',
                alamat_tujuan='$alamat_tujuan',
                perihal='$perihal',
                isi='$isi',
                file_surat='$namaFile',
                id_pegawai='$id_pegawai'
              WHERE id_surat_keluar='$id'";
    return mysqli_query($koneksi, $query);
}

// === DELETE ===
function hapusSuratKeluar($id)
{
    global $koneksi;
    $data = getSuratKeluarById($id);
    if ($data && !empty($data['file_surat'])) {
        $filePath = __DIR__ . '/../uploads/file_surat/' . $data['file_surat'];
        if (file_exists($filePath)) unlink($filePath);
    }
    return mysqli_query($koneksi, "DELETE FROM surat_keluar WHERE id_surat_keluar='$id'");
}
