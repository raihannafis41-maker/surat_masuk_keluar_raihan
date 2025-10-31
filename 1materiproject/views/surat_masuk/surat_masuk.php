<?php
require_once __DIR__ . '/../../db/db_surat_masuk.php';
$dataSurat = getAllSuratMasuk($koneksi);
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-envelope"></i> Data Surat Masuk</h4>
        <a href="index.php?halaman=tambah_surat_masuk" class="btn btn-success btn-sm float-right">
            <i class="fas fa-plus"></i> Tambah Surat
        </a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">

                <tr class="text-center">
                    <th>No</th>
                    <th>No Surat</th>
                    <th>Tgl Surat</th>
                    <th>Tgl Terima</th>
                    <th>Pengirim</th>
                    <th>Alamat Pengirim</th>
                    <th>Perihal</th>
                    <th>Isi</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataSurat as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['no_surat']; ?></td>
                        <td><?= $row['tgl_surat']; ?></td>
                        <td><?= $row['tgl_terima']; ?></td>
                        <td><?= $row['pengirim']; ?></td>
                        <td><?= $row['alamat_pengirim']; ?></td>
                        <td><?= $row['perihal']; ?></td>
                        <td><?= $row['isi']; ?></td>
                        <td class="text-center">
                            <?php if (!empty($row['file_surat'])): ?>
                                <?php
                                $file = $row['file_surat'];
                                $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                $path = "uploads/" . $file;
                                ?>

                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <a href="<?= $path; ?>" target="_blank">
                                        <img src="<?= $path; ?>" alt="file" width="80" class="img-thumbnail">
                                    </a>
                                <?php elseif ($ext === 'pdf'): ?>
                                    <a href="<?= $path; ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-file-pdf"></i> Lihat PDF
                                    </a>
                                <?php elseif (in_array($ext, ['doc', 'docx'])): ?>
                                    <a href="<?= $path; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-file-word"></i> Lihat Dokumen
                                    </a>
                                <?php else: ?>
                                    <a href="<?= $path; ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-file"></i> Lihat File
                                    </a>
                                <?php endif; ?>

                            <?php else: ?>
                                <span class="text-muted">Tidak ada file</span>
                            <?php endif; ?>
                        </td>

                        <td><?= ucfirst($row['status']); ?></td>
                        <td class="text-center">
                            <a href="index.php?halaman=edit_surat_masuk&id=<?= $row['id_surat_masuk']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="index.php?halaman=hapus_surat_masuk&id=<?= $row['id_surat_masuk']; ?>" onclick="return confirm('Yakin hapus surat ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>