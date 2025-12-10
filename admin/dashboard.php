<?php
require_once __DIR__ . '/../config.php';
if(!isset($_SESSION['admin_id'])) header('Location: login.php');
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Admin Dashboard</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='bg-gray-50'>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">ADMIN PANEL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link active" href="hospitals.php">Rumah Sakit</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="schedules.php">Jadwal</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="donors.php">Pendonor</a></li> -->
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class='container py-4'>
  <div class='row'>
    <div class='col-md-4'>
      <div class='list-group'>
        <a href='dashboard.php' class='list-group-item list-group-item-action active'>Ringkasan</a>
        <a href='hospitals.php' class='list-group-item list-group-item-action'>Kelola Rumah Sakit</a>
        <a href='schedules.php' class='list-group-item list-group-item-action'>Kelola Jadwal</a>
        <a href='appointments.php' class='list-group-item list-group-item-action'>Pendonor</a>
      </div>
    </div>
    <div class='col-md-8'>
      <div class='card'><div class='card-body'>
        <h5>Ringkasan Sistem</h5>
        <?php
        $h = $mysqli->query('SELECT COUNT(*) as c FROM hospitals')->fetch_assoc()['c'];
        $s = $mysqli->query('SELECT COUNT(*) as c FROM schedules')->fetch_assoc()['c'];
        $a = $mysqli->query('SELECT COUNT(*) as c FROM appointments')->fetch_assoc()['c'];
        ?>
        <div class='row'>
          <div class='col'><div class='p-3 bg-white rounded shadow-sm'><h6>Hospitals</h6><strong><?= $h ?></strong></div></div>
          <div class='col'><div class='p-3 bg-white rounded shadow-sm'><h6>Schedules</h6><strong><?= $s ?></strong></div></div>
          <div class='col'><div class='p-3 bg-white rounded shadow-sm'><h6>Appointments</h6><strong><?= $a ?></strong></div></div>
        </div>
      </div></div>
    </div>
  </div>
</main></body></html>