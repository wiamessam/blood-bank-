<?php
require_once __DIR__ . '/../config.php';

$q = $mysqli->query("
    SELECT s.*, h.name AS hospital_name 
    FROM schedules s 
    JOIN hospitals h ON h.id = s.hospital_id 
    WHERE s.tanggal >= CURDATE() 
    ORDER BY s.tanggal
");
?>
<!doctype html>
<html lang="id">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Jadwal Donor</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .nav-link.active-nav {
        font-weight: bold;
        text-decoration: underline;
    }
</style>

</head>

<body class="bg-gray-50">

<!-- NAVBAR -->
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

<!-- CONTENT -->
<main class="container py-4">
    <h3 class="mb-4 fw-bold">Jadwal Donor Darah</h3>

    <div class="row">
        <?php while ($r = $q->fetch_assoc()): ?>
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm border-0 rounded-3">
                <div class="card-body">

                    <h5 class="fw-bold"><?= htmlspecialchars($r['hospital_name']) ?></h5>

                    <p class="mb-1">
                        Tanggal: <strong><?= htmlspecialchars($r['tanggal']) ?></strong>
                    </p>

                    <p class="mb-3">
                        Kuota tersedia:
                        <span class="fw-bold text-success"><?= $r['slot_available'] ?></span>
                    </p>

                    <a class="btn btn-danger px-4" href="daftar.php?id=<?= $r['id'] ?>">
                        Daftar Sekarang
                    </a>

                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
