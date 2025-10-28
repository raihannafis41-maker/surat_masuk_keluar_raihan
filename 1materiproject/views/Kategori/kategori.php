<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi selalu bisa diakses dari mana pun
include __DIR__ . '/../../koneksi.php';

// Proses Simpan Data jika ada POST
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_kategori'] ?? '');
    $ket  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

    if ($nama !== '') {
        mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$nama', '$ket')");
        header('Location: index.php?halaman=kategori');
        exit;
    }
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Kategori Surat</h3>
    </div>
    <div class="card-body">
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label>Nama Kategori:</label>
                <input type="text" name="nama_kategori" class="form-control" required>
            </div>
            <div class="form-group mt-2">
                <label>Keterangan:</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <div class="mt-2">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori DESC");
                    while ($d = mysqli_fetch_assoc($data)) {
                        $id = $d['id_kategori'];
                        echo "<tr>
                            <td>{$no}</td>
                            <td>" . htmlspecialchars($d['nama_kategori']) . "</td>
                            <td>" . htmlspecialchars($d['keterangan']) . "</td>
                            <td>
                                <a href='index.php?halaman=edit_kategori&id={$id}' class='btn btn-sm btn-warning'>Edit</a>
                                <a href='index.php?halaman=hapus_kategori&id={$id}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
