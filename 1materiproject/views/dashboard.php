<?php
include "koneksi.php";

// --- Hitung jumlah data ---
$jumlah_surat_masuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_masuk"))['total'];
$jumlah_surat_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_keluar"))['total'];
$jumlah_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pegawai"))['total'];
$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];

// --- Ambil 5 surat masuk & keluar terbaru ---
$surat_masuk = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY tgl_surat DESC LIMIT 5");
$surat_keluar = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY tgl_surat DESC LIMIT 5");

// --- Ambil data untuk Chart (jumlah surat per bulan) ---
$chart_masuk = [];
$chart_keluar = [];
for ($bulan = 1; $bulan <= 12; $bulan++) {
    $q_masuk = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_masuk WHERE MONTH(tgl_surat) = '$bulan'");
    $chart_masuk[] = mysqli_fetch_assoc($q_masuk)['jml'] ?? 0;

    $q_keluar = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_keluar WHERE MONTH(tgl_surat) = '$bulan'");
    $chart_keluar[] = mysqli_fetch_assoc($q_keluar)['jml'] ?? 0;
}
?>

<!-- Dashboard Content -->
<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0 text-light">📊 Dashboard Surat</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- Statistik Kartu -->
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

    <!-- Surat Terbaru -->
    <div class="row">
      <div class="col-md-6">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-envelope"></i> 5 Surat Masuk Terbaru</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat</th>
                  <th>Pengirim</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              
              <tbody>
                <?php $no=1; while($sm = mysqli_fetch_assoc($surat_masuk)): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $sm['no_surat']; ?></td>
                  <td><?= $sm['pengirim']; ?></td>
                  <td><?= $sm['tgl_surat']; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-paper-plane"></i> 5 Surat Keluar Terbaru</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat</th>
                  <th>Tujuan</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; while($sk = mysqli_fetch_assoc($surat_keluar)): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $sk['no_surat']; ?></td>
                  <td><?= $sk['tujuan']; ?></td>
                  <td><?= $sk['tgl_surat']; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Statistik Surat -->
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Statistik Surat per Bulan</h3>
          </div>
          <div class="card-body">
            <canvas id="suratChart" style="min-height: 300px;"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Chart.js Script -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
  const ctx = document.getElementById('suratChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [
        {
          label: 'Surat Masuk',
          backgroundColor: 'rgba(54, 162, 235, 0.7)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          data: <?= json_encode($chart_masuk); ?>
        },
        {
          label: 'Surat Keluar',
          backgroundColor: 'rgba(255, 99, 132, 0.7)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          data: <?= json_encode($chart_keluar); ?>
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: { color: '#fff' }
        }
      },
      scales: {
        x: {
          ticks: { color: '#ccc' },
          grid: { color: 'rgba(255,255,255,0.1)' }
        },
        y: {
          ticks: { color: '#ccc', stepSize: 1 },
          grid: { color: 'rgba(255,255,255,0.1)' }
        }
      }
    }
  });
</script>
