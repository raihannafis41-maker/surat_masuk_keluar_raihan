<?php
// ============================================================
// ✅ db_kategori.php — koneksi dan fungsi kategori
// ============================================================

// 1️⃣ Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "surat_masuk_keluar_raihan"; // Ganti sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2️⃣ Fungsi ambil semua kategori
function getAllKategori($conn) {
    $sql = "SELECT * FROM kategori ORDER BY id_kategori ASC";
    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// 3️⃣ Fungsi ambil satu kategori berdasarkan ID
function getKategoriById($conn, $id_kategori) {
    $stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// 4️⃣ Fungsi tambah kategori
function tambahKategori($conn, $nama_kategori, $keterangan) {
    $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori, keterangan) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama_kategori, $keterangan);
    return $stmt->execute();
}

// 5️⃣ Fungsi edit kategori
function updateKategori($conn, $id_kategori, $nama_kategori, $keterangan) {
    $stmt = $conn->prepare("UPDATE kategori SET nama_kategori=?, keterangan=? WHERE id_kategori=?");
    $stmt->bind_param("ssi", $nama_kategori, $keterangan, $id_kategori);
    return $stmt->execute();
}

// 6️⃣ Fungsi hapus kategori
function hapusKategori($conn, $id_kategori) {
    $stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori=?");
    $stmt->bind_param("i", $id_kategori);
    return $stmt->execute();
}
?>
