<?php
include __DIR__ . '/../koneksi.php';

// === READ ALL SURAT ===
function getAllSuratKeluar($conn) {
    $sql = "SELECT * FROM surat_keluar ORDER BY tgl_surat DESC";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// === GET BY ID ===
function getSuratKeluarById($conn, $id) {
    $sql = "SELECT * FROM surat_keluar WHERE id_surat_keluar = $id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// === INSERT ===
function tambahSuratKeluar($conn, $data, $file) {
    $no_surat = mysqli_real_escape_string($conn, $data['no_surat']);
    $tgl_surat = mysqli_real_escape_string($conn, $data['tgl_surat']);
    $tujuan = mysqli_real_escape_string($conn, $data['tujuan']);
    $alamat_tujuan = mysqli_real_escape_string($conn, $data['alamat_tujuan']);
    $perihal = mysqli_real_escape_string($conn, $data['perihal']);
    $isi = mysqli_real_escape_string($conn, $data['isi']);

    $fileName = null;
    if ($file && !empty($file['name'])) {
        $uploadDir = __DIR__ . '/../../uploads/file_surat/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadDir . $fileName);
    }

    $sql = "INSERT INTO surat_keluar (no_surat, tgl_surat, tujuan, alamat_tujuan, perihal, isi, file_surat)
            VALUES ('$no_surat', '$tgl_surat', '$tujuan', '$alamat_tujuan', '$perihal', '$isi', '$fileName')";
    return mysqli_query($conn, $sql);
}

// === UPDATE ===
function updateSuratKeluar($conn, $id, $no_surat, $tgl_surat, $tujuan, $alamat_tujuan, $perihal, $isi, $file_surat) {
    $id = (int)$id;
    $no_surat = mysqli_real_escape_string($conn, $no_surat);
    $tgl_surat = mysqli_real_escape_string($conn, $tgl_surat);
    $tujuan = mysqli_real_escape_string($conn, $tujuan);
    $alamat_tujuan = mysqli_real_escape_string($conn, $alamat_tujuan);
    $perihal = mysqli_real_escape_string($conn, $perihal);
    $isi = mysqli_real_escape_string($conn, $isi);
    $file_surat = mysqli_real_escape_string($conn, $file_surat);

    $sql = "UPDATE surat_keluar SET 
                no_surat = '$no_surat',
                tgl_surat = '$tgl_surat',
                tujuan = '$tujuan',
                alamat_tujuan = '$alamat_tujuan',
                perihal = '$perihal',
                isi = '$isi',
                file_surat = '$file_surat'
            WHERE id_surat_keluar = $id";

    return mysqli_query($conn, $sql);
}

// === DELETE ===
function deleteSuratKeluar($conn, $id) {
    $id = (int)$id;
    $sql = "DELETE FROM surat_keluar WHERE id_surat_keluar = $id";
    return mysqli_query($conn, $sql);
}
?>
