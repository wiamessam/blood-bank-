<?php
require_once __DIR__ . '/../config.php';
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
$rows = $mysqli->query('SELECT a.*, s.tanggal, h.name as hospital_name FROM appointments a JOIN schedules s ON s.id=a.schedule_id JOIN hospitals h ON h.id=s.hospital_id ORDER BY a.created_at DESC');
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Pendaftar</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">ADMIN PANEL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="hospitals.php">Rumah Sakit</a></li>
                <li class="nav-item"><a class="nav-link" href="schedules.php">Jadwal</a></li>
                <li class="nav-item"><a class="nav-link active" href="appointments.php">Daftar Pendonor</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class='container py-4'><h4>Pendaftar</h4>
<table class='table table-sm'><thead><tr><th>#</th><th>Nama</th><th>Telp</th><th>RS</th><th>Tanggal</th><th>Antrian</th></tr></thead><tbody><?php while($r=$rows->fetch_assoc()){echo "<tr><td>$r[id]</td><td>$r[name]</td><td>$r[phone]</td><td>$r[hospital_name]</td><td>$r[tanggal]</td><td>$r[queue_no]</td></tr>";} ?></tbody></table>
</main></body></html>