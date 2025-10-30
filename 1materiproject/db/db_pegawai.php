<?php
// =============================================================
// 🔧 SETUP & KONEKSI
// =============================================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

// =============================================================
// 🧱 FUNGSI: TAMBAH PEGAWAI
// =============================================================
function tambahPegawai($koneksi, $data, $file)
{
    $nip = mysqli_real_escape_string($koneksi, $data['nip'] ?? '');
    $nama = mysqli_real_escape_string($koneksi, $data['nama_pegawai'] ?? '');
    $jabatan = mysqli_real_escape_string($koneksi, $data['jabatan'] ?? '');
    $golongan = mysqli_real_escape_string($koneksi, $data['golongan'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $data['email'] ?? '');
    $telepon = mysqli_real_escape_string($koneksi, $data['telepon'] ?? '');

    // Cegah duplikasi NIP
    $cek = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE nip='$nip'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('❌ NIP sudah terdaftar!');</script>";
        return false;
    }

    // Upload foto jika ada
    $foto = null;
    if (!empty($file['name'])) {
        $namaFile = $file['name'];
        $tmpFile = $file['tmp_name'];
        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $namaBaru = 'pegawai_' . time() . '.' . $ext;
        $folderTujuan = '../assets/img/';

        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0777, true);
        }

        if (move_uploaded_file($tmpFile, $folderTujuan . $namaBaru)) {
            $foto = $namaBaru;
        }
    }

    // Simpan data pegawai
    $sql = "INSERT INTO pegawai (nip, nama_pegawai, jabatan, golongan, email, telepon, foto)
            VALUES ('$nip', '$nama', '$jabatan', '$golongan', '$email', '$telepon', '$foto')";
    return mysqli_query($koneksi, $sql);
}

// =============================================================
// 🔹 PROSES UPDATE PROFIL PEGAWAI
// =============================================================
if (isset($_GET['proses']) && $_GET['proses'] == 'update_profil') {
    $id = $_POST['id_pegawai'] ?? null;
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pegawai'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon'] ?? '');

    if (empty($id)) {
        echo "<script>alert('ID pegawai tidak ditemukan!');window.location='../index.php?halaman=pengaturan';</script>";
        exit;
    }

    $cek = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id_pegawai='$id'");
    if (!$cek || mysqli_num_rows($cek) == 0) {
        echo "<script>alert('Data pegawai tidak ditemukan!');window.location='../index.php?halaman=pengaturan';</script>";
        exit;
    }
    $dataLama = mysqli_fetch_assoc($cek);

    // Upload foto baru jika ada
    $fotoBaru = $dataLama['foto'] ?? null;
    if (!empty($_FILES['foto']['name'])) {
        $namaFile = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $namaBaru = 'pegawai_' . time() . '.' . $ext;
        $folderTujuan = '../assets/img/';

        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0777, true);
        }

        if (!empty($dataLama['foto']) && file_exists($folderTujuan . $dataLama['foto'])) {
            unlink($folderTujuan . $dataLama['foto']);
        }

        if (move_uploaded_file($tmpFile, $folderTujuan . $namaBaru)) {
            $fotoBaru = $namaBaru;
        }
    }

    // Update data pegawai
    $sql = "UPDATE pegawai SET 
                nama_pegawai='$nama',
                email='$email',
                telepon='$telepon',
                foto='$fotoBaru'
            WHERE id_pegawai='$id'";

    $update = mysqli_query($koneksi, $sql);

    if ($update) {
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        $_SESSION['telepon'] = $telepon;
        $_SESSION['foto'] = $fotoBaru;

        echo "<script>alert('✅ Profil berhasil diperbarui!');window.location='../index.php?halaman=pengaturan';</script>";
    } else {
        echo "<script>alert('❌ Gagal memperbarui profil!');window.location='../index.php?halaman=pengaturan';</script>";
    }
    exit;
}

// =============================================================
// 📋 TAMPILAN DATA PEGAWAI
// =============================================================
$query = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-users"></i> Data Pegawai
        </h3>
        <a href="index.php?halaman=tambah_pegawai" class="btn btn-light btn-sm">
            <i class="fas fa-plus"></i> Tambah Pegawai
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Golongan</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($query) > 0):
                        while ($data = mysqli_fetch_assoc($query)):
                            $foto = $data['foto'] ?? '';
                            $fotoPath = 'assets/img/' . $foto;
                    ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['nip'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['nama_pegawai'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['jabatan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($data['telepon'] ?? '-') ?></td>
                                <td class="text-center"><?= htmlspecialchars($data['golongan'] ?? '-') ?></td>
                                <td class="text-center">
                                    <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                                        <img src="<?= $fotoPath ?>" alt="Foto Pegawai" width="60" height="60" class="rounded-circle border">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?halaman=edit_pegawai&id=<?= urlencode($data['id_pegawai']) ?>" class="btn btn-warning btn-sm" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="hapus_pegawai.php?id=<?= urlencode($data['id_pegawai']) ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus data ini?');"
                                       title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                        endwhile;
                    else:
                        echo '<tr><td colspan="9" class="text-center text-muted">Data pegawai tidak ditemukan.</td></tr>';
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
