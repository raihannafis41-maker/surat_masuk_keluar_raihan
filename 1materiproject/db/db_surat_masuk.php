<?php
require_once __DIR__ . '/../koneksi.php';

/* =========================================================
   FUNGSI CRUD SURAT MASUK (FINAL SESUAI STRUKTUR PROJECT)
   ========================================================= */

// === READ ALL ===
function getAllSuratMasuk($koneksi) {
    $sql = "SELECT * FROM surat_masuk ORDER BY id_surat_masuk DESC";
    $result = mysqli_query($koneksi, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// === GET BY ID ===
function getSuratMasukById($koneksi, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM surat_masuk WHERE id_surat_masuk = $id";
    $result = mysqli_query($koneksi, $sql);
    return mysqli_fetch_assoc($result);
}

// === INSERT ===
function tambahSuratMasuk($koneksi, $data, $file) {
    $no_surat   = mysqli_real_escape_string($koneksi, $data['no_surat']);
    $tgl_surat  = mysqli_real_escape_string($koneksi, $data['tgl_surat']);
    $tgl_terima = mysqli_real_escape_string($koneksi, $data['tgl_terima']);
    $pengirim   = mysqli_real_escape_string($koneksi, $data['pengirim']);
    $alamat_pengirim = mysqli_real_escape_string($koneksi, $data['alamat_pengirim']);
    $perihal    = mysqli_real_escape_string($koneksi, $data['perihal']);
    $isi        = mysqli_real_escape_string($koneksi, $data['isi']);
    $status     = mysqli_real_escape_string($koneksi, $data['status']);

    $fileName = null;
    if ($file && !empty($file['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadDir . $fileName);
    }

    $sql = "INSERT INTO surat_masuk (no_surat, tgl_surat, tgl_terima, pengirim, alamat_pengirim, perihal, isi, file_surat, status)
            VALUES ('$no_surat', '$tgl_surat', '$tgl_terima', '$pengirim', '$alamat_pengirim', '$perihal', '$isi', '$fileName', '$status')";
    return mysqli_query($koneksi, $sql);
}

// === UPDATE ===
function updateSuratMasuk($koneksi, $id, $data, $file) {
    $id = (int)$id;
    $lama = getSuratMasukById($koneksi, $id);
    $fileLama = $lama['file_surat'];

    $no_surat   = mysqli_real_escape_string($koneksi, $data['no_surat']);
    $tgl_surat  = mysqli_real_escape_string($koneksi, $data['tgl_surat']);
    $tgl_terima = mysqli_real_escape_string($koneksi, $data['tgl_terima']);
    $pengirim   = mysqli_real_escape_string($koneksi, $data['pengirim']);
    $alamat_pengirim = mysqli_real_escape_string($koneksi, $data['alamat_pengirim']);
    $perihal    = mysqli_real_escape_string($koneksi, $data['perihal']);
    $isi        = mysqli_real_escape_string($koneksi, $data['isi']);
    $status     = mysqli_real_escape_string($koneksi, $data['status']);

    if ($file && !empty($file['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileBaru = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadDir . $fileBaru);

        if ($fileLama && file_exists($uploadDir . $fileLama)) unlink($uploadDir . $fileLama);
        $fileLama = $fileBaru;
    }

    $sql = "UPDATE surat_masuk SET 
                no_surat='$no_surat',
                tgl_surat='$tgl_surat',
                tgl_terima='$tgl_terima',
                pengirim='$pengirim',
                alamat_pengirim='$alamat_pengirim',
                perihal='$perihal',
                isi='$isi',
                status='$status',
                file_surat='$fileLama'
            WHERE id_surat_masuk=$id";
    return mysqli_query($koneksi, $sql);
}

// === DELETE ===
function deleteSuratMasuk($koneksi, $id) {
    $id = (int)$id;
    $data = getSuratMasukById($koneksi, $id);
    $file = $data['file_surat'];

    if ($file && file_exists(__DIR__ . '/../uploads/' . $file)) {
        unlink(__DIR__ . '/../uploads/' . $file);
    }

    $sql = "DELETE FROM surat_masuk WHERE id_surat_masuk = $id";
    return mysqli_query($koneksi, $sql);
}
?>
