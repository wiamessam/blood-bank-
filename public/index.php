<?php
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Blood Donation Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" />
</head>
<body class="bg-gray-50">
<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Blood Donation</a>
    <div class="ms-auto">
      <a class="btn btn-outline-light me-2" href="index.php">Beranda</a>
      <a class="btn btn-outline-light me-2" href="jadwal.php">Lihat Jadwal</a>
      <a class="btn btn-light" href="../admin/login.php">Admin</a>
    </div>
  </div>
</nav>

<main class="container py-5">
  <div class="row g-4">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title">Donor Darah, Selamatkan Nyawa</h3>
          <p>Daftar untuk jadwal donor terdekat, lihat ketersediaan, dan dapatkan nomor antrian saat mendaftar.</p>
          <hr>
          <h5>Rumah Sakit dengan Jadwal Terdekat</h5>
          <?php
          $q = $mysqli->query("SELECT s.*, h.name as hospital_name FROM schedules s JOIN hospitals h ON h.id=s.hospital_id WHERE s.tanggal>=CURDATE() ORDER BY s.tanggal LIMIT 5");
          if($q->num_rows==0) echo '<p class="text-muted">Belum ada jadwal.</p>';
          while($r=$q->fetch_assoc()):
          ?>
          <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
            <div>
              <strong><?=htmlspecialchars($r['hospital_name'])?></strong><br>
              Tanggal: <?=htmlspecialchars($r['tanggal'])?> — Kuota tersedia: <span class="badge bg-danger"><?= $r['slot_available'] ?></span>
            </div>
            <div>
              <a class="btn btn-sm btn-danger" href="daftar.php?id=<?= $r['id'] ?>">Daftar</a>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>

    <aside class="col-lg-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h6>Info Stok & Statistik</h6>
          <canvas id="chartStats" height="150"></canvas>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <h6>Kontak Darurat</h6>
          <p>RSU Ananda: 0812-3456-7890</p>
        </div>
      </div>
    </aside>
  </div>
</main>

<footer class="text-center py-3">
  <small class="text-muted">© <?=date('Y')?> Blood Donation Portal</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch('api/stats.php').then(r=>r.json()).then(data=>{
  const ctx = document.getElementById('chartStats').getContext('2d');
  new Chart(ctx,{type:'bar',data:{labels:data.labels,datasets:[{label:'Pendaftar per RS',data:data.values}]}}); 
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
