<?php
include '../../../koneksi.php';
include '../../../db/db_surat_keluar.php';


// Fungsi untuk menampilkan semua data surat keluar
function tampilSuratKeluar($conn)
{
    $query = "SELECT * FROM surat_keluar ORDER BY id_surat_keluar DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Fungsi untuk menambah surat keluar
function tambahSuratKeluar($conn, $no_surat, $tgl_surat, $tujuan, $alamat_tujuan, $perihal, $isi, $file_surat, $id_pegawai)
{
    $query = "INSERT INTO surat_keluar (no_surat, tgl_surat, tujuan, alamat_tujuan, perihal, isi, file_surat, id_pegawai)
              VALUES ('$no_surat', '$tgl_surat', '$tujuan', '$alamat_tujuan', '$perihal', '$isi', '$file_surat', '$id_pegawai')";
    return mysqli_query($conn, $query);
}

// Fungsi untuk menghapus surat keluar
function hapusSuratKeluar($conn, $id)
{
    $query = "DELETE FROM surat_keluar WHERE id_surat_keluar = '$id'";
    return mysqli_query($conn, $query);
}

// Fungsi untuk menampilkan surat keluar berdasarkan ID
function getSuratKeluarById($conn, $id)
{
    $query = "SELECT * FROM surat_keluar WHERE id_surat_keluar = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk mengupdate surat keluar
function updateSuratKeluar($conn, $id, $no_surat, $tgl_surat, $tujuan, $alamat_tujuan, $perihal, $isi, $file_surat)
{
    $query = "UPDATE surat_keluar 
              SET no_surat='$no_surat', tgl_surat='$tgl_surat', tujuan='$tujuan', 
                  alamat_tujuan='$alamat_tujuan', perihal='$perihal', isi='$isi', file_surat='$file_surat' 
              WHERE id_surat_keluar='$id'";
    return mysqli_query($conn, $query);
}
