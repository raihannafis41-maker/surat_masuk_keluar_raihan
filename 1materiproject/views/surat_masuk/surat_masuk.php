<?php
include "koneksi.php";
$query = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY id_surat_masuk DESC");
?>
<div class="container mt-4">
    <h3>Data Surat Masuk</h3>
    <a href="index.php?halaman=tambah_surat_masuk" class="btn btn-primary mb-3">+ Tambah Surat Masuk</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>No Surat</th>
                <th>Tanggal Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Status</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['no_surat']; ?></td>
                <td><?= $data['tgl_surat']; ?></td>
                <td><?= $data['pengirim']; ?></td>
                <td><?= $data['perihal']; ?></td>
                <td><?= $data['status']; ?></td>
                <td>
                    <?php if ($data['file_surat']) { ?>
                        <a href="file_surat/<?= $data['file_surat']; ?>" target="_blank">Lihat</a>
                    <?php } else { echo '-'; } ?>
                </td>
                <td>
                    <a href="index.php?halaman=edit_surat_masuk&id_surat_masuk=<?= $data['id_surat_masuk']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="views/surat_masuk/hapus_surat.php?id_surat_masuk=<?= $data['id_surat_masuk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus surat ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
