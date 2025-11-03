<?php
include "koneksi.php";

// ====== HITUNG JUMLAH DATA ======
$jumlah_surat_masuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_masuk"))['total'];
$jumlah_surat_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_keluar"))['total'];
$jumlah_pegawai      = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pegawai"))['total'];
$jumlah_kategori     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];

// ====== SURAT BELUM DIDISPOSISI ======
$belum_disposisi = mysqli_fetch_assoc(mysqli_query($koneksi, "
  SELECT COUNT(*) AS total 
  FROM surat_masuk 
  WHERE id_surat_masuk NOT IN (SELECT id_surat_masuk FROM disposisi)
"))['total'];

// ====== AKTIVITAS TERAKHIR ======
$last_aktivitas = mysqli_fetch_assoc(mysqli_query($koneksi, "
  SELECT 'Surat Masuk' AS jenis, no_surat, tgl_surat AS tanggal FROM surat_masuk
  UNION ALL
  SELECT 'Surat Keluar' AS jenis, no_surat, tgl_surat FROM surat_keluar
  ORDER BY tanggal DESC LIMIT 1
"));

// ====== DATA TERBARU ======
$surat_masuk = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY tgl_surat DESC LIMIT 5");
$surat_keluar = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY tgl_surat DESC LIMIT 5");
$disposisi = mysqli_query($koneksi, "
  SELECT d.*, sm.no_surat, p.nama_pegawai 
  FROM disposisi d
  LEFT JOIN surat_masuk sm ON d.id_surat_masuk = sm.id_surat_masuk
  LEFT JOIN pegawai p ON d.id_pegawai = p.id_pegawai
  ORDER BY d.tgl_disposisi DESC
  LIMIT 5
");

// ====== DATA CHART ======
$chart_masuk = [];
$chart_keluar = [];
for ($bulan = 1; $bulan <= 12; $bulan++) {
  $q_masuk  = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_masuk WHERE MONTH(tgl_surat) = '$bulan'");
  $chart_masuk[] = mysqli_fetch_assoc($q_masuk)['jml'] ?? 0;
  $q_keluar = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_keluar WHERE MONTH(tgl_surat) = '$bulan'");
  $chart_keluar[] = mysqli_fetch_assoc($q_keluar)['jml'] ?? 0;
}
?>

<!-- ====== HEADER ====== -->
<div class="content-header animate__animated animate__fadeInDown">
  <div class="container-fluid">
    <h1 class="m-0 text-light"><i class="fas fa-envelope-open-text"></i> Dashboard Surat</h1>
    <small class="text-muted">Ringkasan aktivitas surat masuk, keluar, dan disposisi</small>
  </div>
</div>

<!-- ====== KONTEN DASHBOARD ====== -->
<section class="content animate__animated animate__fadeInUp">
  <div class="container-fluid">

    <!-- ====== KARTU STATISTIK ====== -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $jumlah_surat_masuk; ?></h3>
            <p>Surat Masuk</p>
          </div>
          <div class="icon"><i class="fas fa-envelope-open-text"></i></div>
          <a href="?halaman=surat_masuk" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $jumlah_surat_keluar; ?></h3>
            <p>Surat Keluar</p>
          </div>
          <div class="icon"><i class="fas fa-paper-plane"></i></div>
          <a href="?halaman=surat_keluar" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $jumlah_pegawai; ?></h3>
            <p>Pegawai</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
          <a href="?halaman=pegawai" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $jumlah_kategori; ?></h3>
            <p>Kategori</p>
          </div>
          <div class="icon"><i class="fas fa-folder-open"></i></div>
          <a href="?halaman=kategori" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <!-- ====== INFO TAMBAHAN ====== -->
    <div class="row">
      <div class="col-md-6">
        <div class="info-box bg-dark">
          <span class="info-box-icon bg-primary"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Aktivitas Terakhir</span>
            <span class="info-box-number"><?= $last_aktivitas ? $last_aktivitas['jenis'] . " (" . $last_aktivitas['no_surat'] . ")" : "Belum ada aktivitas"; ?></span>
            <div class="progress"><div class="progress-bar bg-light" style="width: 100%"></div></div>
            <span class="progress-description"><?= $last_aktivitas ? $last_aktivitas['tanggal'] : "-"; ?></span>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="info-box bg-dark">
          <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-circle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Surat Belum Didisposisi</span>
            <span class="info-box-number"><?= $belum_disposisi; ?></span>
            <div class="progress">
              <div class="progress-bar bg-danger" style="width: <?= min(($belum_disposisi/($jumlah_surat_masuk?:1))*100,100); ?>%"></div>
            </div>
            <span class="progress-description">Perlu tindak lanjut</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== TABEL SURAT MASUK & KELUAR ====== -->
    <div class="row">
      <div class="col-md-6 animate__animated animate__fadeInLeft">
        <div class="card card-dark">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-envelope"></i> 5 Surat Masuk Terbaru</h3></div>
          <div class="card-body p-0">
            <table class="table table-striped table-dark mb-0">
              <thead><tr><th>No</th><th>No Surat</th><th>Pengirim</th><th>Tanggal</th></tr></thead>
              <tbody>
                <?php $no=1; while($sm=mysqli_fetch_assoc($surat_masuk)): ?>
                <tr><td><?= $no++; ?></td><td><?= $sm['no_surat']; ?></td><td><?= $sm['pengirim']; ?></td><td><?= $sm['tgl_surat']; ?></td></tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6 animate__animated animate__fadeInRight">
        <div class="card card-dark">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-paper-plane"></i> 5 Surat Keluar Terbaru</h3></div>
          <div class="card-body p-0">
            <table class="table table-striped table-dark mb-0">
              <thead><tr><th>No</th><th>No Surat</th><th>Tujuan</th><th>Tanggal</th></tr></thead>
              <tbody>
                <?php $no=1; while($sk=mysqli_fetch_assoc($surat_keluar)): ?>
                <tr><td><?= $no++; ?></td><td><?= $sk['no_surat']; ?></td><td><?= $sk['tujuan']; ?></td><td><?= $sk['tgl_surat']; ?></td></tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== TABEL DISPOSISI ====== -->
    <div class="row mt-3 animate__animated animate__fadeInUp">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-share-square"></i> 5 Disposisi Terbaru</h3>
            <div class="card-tools">
              <a href="?halaman=disposisi" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Lihat Semua</a>
            </div>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped table-dark mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat</th>
                  <th>Pegawai</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th>Catatan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; while($d=mysqli_fetch_assoc($disposisi)): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $d['no_surat']; ?></td>
                  <td><?= $d['nama_pegawai']; ?></td>
                  <td>
                    <?php 
                      $status = $d['status_disposisi'] ?? $d['status'] ?? '-';
                      if($status == 'Selesai'){
                        echo "<span class='badge bg-success'>Selesai</span>";
                      } elseif($status == 'Proses'){
                        echo "<span class='badge bg-warning text-dark'>Proses</span>";
                      } elseif($status == 'Belum Dibaca'){
                        echo "<span class='badge bg-secondary'>Belum Dibaca</span>";
                      } else {
                        echo "<span class='badge bg-light text-dark'>-</span>";
                      }
                    ?>
                  </td>
                  <td><?= $d['tgl_disposisi']; ?></td>
                  <td><?= $d['catatan']; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== CHART ====== -->
    <div class="row mt-3 animate__animated animate__fadeInUp">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header"><h3 class="card-title"><i class="fas fa-chart-line"></i> Statistik Surat per Bulan</h3></div>
          <div class="card-body">
            <canvas id="suratChart" style="min-height:300px"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ====== ANIMASI & CHART JS ====== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
const ctx=document.getElementById('suratChart').getContext('2d');
new Chart(ctx,{
  type:'bar',
  data:{
    labels:['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
    datasets:[
      {label:'Surat Masuk',backgroundColor:'rgba(54,162,235,0.7)',data:<?=json_encode($chart_masuk)?>},
      {label:'Surat Keluar',backgroundColor:'rgba(255,99,132,0.7)',data:<?=json_encode($chart_keluar)?>}
    ]
  },
  options:{
    responsive:true,
    maintainAspectRatio:false,
    plugins:{legend:{labels:{color:'#fff'}}},
    scales:{
      x:{ticks:{color:'#ccc'},grid:{color:'rgba(255,255,255,0.1)'}},
      y:{ticks:{color:'#ccc'},grid:{color:'rgba(255,255,255,0.1)'}}
    }
  }
});
</script>
