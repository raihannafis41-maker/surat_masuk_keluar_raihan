<?php
include "koneksi.php";

// Hitung total data
$jumlah_surat_masuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_masuk"))['total'];
$jumlah_surat_keluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM surat_keluar"))['total'];
$jumlah_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pegawai"))['total'];
$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];

// Ambil 5 surat terbaru
$surat_masuk = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY tgl_surat DESC LIMIT 5");
$surat_keluar = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY tgl_surat DESC LIMIT 5");

// Data Chart per bulan
$chart_masuk = [];
$chart_keluar = [];
for ($bulan = 1; $bulan <= 12; $bulan++) {
  $chart_masuk[] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_masuk WHERE MONTH(tgl_surat) = '$bulan'"))['jml'] ?? 0;
  $chart_keluar[] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM surat_keluar WHERE MONTH(tgl_surat) = '$bulan'"))['jml'] ?? 0;
}
?>

<!-- HEADER -->
<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0 text-light">📊 Dashboard Surat</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- KARTU STATISTIK -->
    <div class="row">
      <?php
      $stats = [
        ['bg' => 'bg-info', 'icon' => 'fas fa-envelope-open-text', 'title' => 'Surat Masuk', 'total' => $jumlah_surat_masuk, 'link' => 'surat_masuk'],
        ['bg' => 'bg-success', 'icon' => 'fas fa-paper-plane', 'title' => 'Surat Keluar', 'total' => $jumlah_surat_keluar, 'link' => 'surat_keluar'],
        ['bg' => 'bg-warning', 'icon' => 'fas fa-users', 'title' => 'Pegawai', 'total' => $jumlah_pegawai, 'link' => 'pegawai'],
        ['bg' => 'bg-danger', 'icon' => 'fas fa-folder-open', 'title' => 'Kategori', 'total' => $jumlah_kategori, 'link' => 'kategori'],
      ];
      foreach ($stats as $card): ?>
        <div class="col-lg-3 col-6">
          <div class="small-box <?= $card['bg']; ?> info-box">
            <div class="inner">
              <h3 class="counter" data-value="<?= $card['total']; ?>">0</h3>
              <p><?= $card['title']; ?></p>
            </div>
            <div class="icon"><i class="<?= $card['icon']; ?>"></i></div>
            <a href="?halaman=<?= $card['link']; ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- SURAT TERBARU -->
    <div class="row">
      <div class="col-md-6">
        <div class="card card-outline card-info shadow-lg">
          <div class="card-header bg-info">
            <h3 class="card-title"><i class="fas fa-envelope"></i> Surat Masuk Terbaru</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover table-dark mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat</th>
                  <th>Pengirim</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                while ($sm = mysqli_fetch_assoc($surat_masuk)): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $sm['no_surat']; ?></td>
                    <td><?= $sm['pengirim']; ?></td>
                    <td><?= date('d-m-Y', strtotime($sm['tgl_surat'])); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-outline card-success shadow-lg">
          <div class="card-header bg-success">
            <h3 class="card-title"><i class="fas fa-paper-plane"></i> Surat Keluar Terbaru</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover table-dark mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Surat</th>
                  <th>Tujuan</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                while ($sk = mysqli_fetch_assoc($surat_keluar)): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $sk['no_surat']; ?></td>
                    <td><?= $sk['tujuan']; ?></td>
                    <td><?= date('d-m-Y', strtotime($sk['tgl_surat'])); ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- CHART -->
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="card card-outline card-primary shadow-lg">
          <div class="card-header bg-primary">
            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Statistik Surat per Bulan</h3>
          </div>
          <div class="card-body">
            <canvas id="chartSurat" style="min-height: 300px;"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Chart.js -->
<script>
const ctx = document.getElementById('chartSurat');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    datasets: [
      {
        label: 'Surat Masuk',
        data: <?= json_encode($chart_masuk); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        borderRadius: 5
      },
      {
        label: 'Surat Keluar',
        data: <?= json_encode($chart_keluar); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.6)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
        borderRadius: 5
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    animation: { duration: 1500, easing: 'easeOutQuart' },
    plugins: {
      legend: {
        labels: { color: '#fff', font: { size: 14 } }
      }
    },
    scales: {
      x: { ticks: { color: '#ddd' }, grid: { color: 'rgba(255,255,255,0.1)' } },
      y: { ticks: { color: '#ddd', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.1)' } }
    }
  }
});
</script>

<!-- GSAP Animations -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Header animasi
  gsap.from(".content-header h1", { duration: 1, x: -50, opacity: 0, ease: "power2.out" });

  // Box statistik
  gsap.from(".info-box", { duration: 0.8, y: 40, opacity: 0, stagger: 0.2, ease: "power2.out", delay: 0.3 });

  // Counter animasi
  document.querySelectorAll(".counter").forEach((counter) => {
    const target = +counter.getAttribute("data-value");
    gsap.to(counter, {
      innerText: target,
      duration: 1.8,
      ease: "power1.out",
      snap: { innerText: 1 },
      onUpdate: () => {
        counter.innerText = Math.floor(counter.innerText);
      }
    });
  });

  // Kartu tabel
  gsap.from(".card", { duration: 0.9, y: 50, opacity: 0, stagger: 0.3, delay: 0.5, ease: "power2.out" });

  // Chart animasi masuk
  gsap.from("#chartSurat", { duration: 1, scale: 0.8, opacity: 0, delay: 0.7, ease: "elastic.out(1, 0.5)" });
});
</script>

<!-- Hover efek -->
<style>
.info-box {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.info-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}
</style>
