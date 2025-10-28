<div class="container mt-4">
    <h3>Tambah Surat Masuk</h3>
    <form action="db/db_surat_masuk.php?proses=tambah" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="no_surat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="tgl_surat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Terima</label>
            <input type="date" name="tgl_terima" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pengirim</label>
            <input type="text" name="pengirim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat Pengirim</label>
            <input type="text" name="alamat_pengirim" class="form-control">
        </div>
        <div class="mb-3">
            <label>Perihal</label>
            <input type="text" name="perihal" class="form-control">
        </div>
        <div class="mb-3">
            <label>Isi Surat</label>
            <textarea name="isi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>File Surat</label>
            <input type="file" name="file_surat" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="baru">Baru</option>
                <option value="dibaca">Dibaca</option>
            </select>
        </div>
        <div class="mb-3">
            <label>ID Pegawai</label>
            <input type="number" name="id_pegawai" class="form-control" value="1">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php?halaman=surat_masuk" class="btn btn-secondary">Kembali</a>
    </form>
</div>
