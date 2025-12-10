<?php
require_once __DIR__ . '/../config.php';
if(!isset($_SESSION['admin_id'])) header('Location: login.php');

// TAMBAH JADWAL
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add'])) {
    $hid = intval($_POST['hospital_id']);
    $tgl = $_POST['tanggal'];
    $slot = intval($_POST['slot']);

    $mysqli->query("INSERT INTO schedules (hospital_id,tanggal,slot_total,slot_available)
                    VALUES ($hid,'$tgl',$slot,$slot)");
}

// UPDATE JADWAL
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update'])) {
    $id  = intval($_POST['id']);
    $hid = intval($_POST['hospital_id']);
    $tgl = $_POST['tanggal'];
    $slot = intval($_POST['slot']);

    $old = $mysqli->query("SELECT slot_total, slot_available FROM schedules WHERE id=$id")->fetch_assoc();
    $selisih = $slot - $old['slot_total'];
    $slot_available = $old['slot_available'] + $selisih;
    if ($slot_available < 0) $slot_available = 0;

    $mysqli->query("UPDATE schedules SET 
        hospital_id = $hid,
        tanggal = '$tgl',
        slot_total = $slot,
        slot_available = $slot_available
        WHERE id = $id
    ");
}

// HAPUS JADWAL
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $mysqli->query("DELETE FROM schedules WHERE id=$id");
}

$hosp = $mysqli->query('SELECT * FROM hospitals ORDER BY name');
$rows = $mysqli->query('SELECT s.*, h.name as hospital_name FROM schedules s 
                        JOIN hospitals h ON h.id=s.hospital_id 
                        ORDER BY s.tanggal DESC');
?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>Kelola Jadwal</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body>
<nav class='navbar navbar-expand-lg navbar-dark bg-danger shadow-sm'>
  <div class='container'>
    <a class='navbar-brand fw-bold' href='#'>Admin Panel</a>
    <div class='collapse navbar-collapse'>
      <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="hospitals.php">Rumah Sakit</a></li>
                <li class="nav-item"><a class="nav-link active" href="schedules.php">Jadwal</a></li>
                <li class="nav-item"><a class="nav-link" href="appointments.php">Daftar Pendonor</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
  </div>
</nav>

<main class='container py-4'>
<h4 class='mb-3 fw-bold'>Kelola Jadwal Donor Darah</h4>

<!-- FORM TAMBAH -->
<form method='post' class='row g-2 mb-4'>
  <div class='col-md-4'>
    <select name='hospital_id' class='form-control'>
      <?php while($h=$hosp->fetch_assoc()) echo "<option value='$h[id]'>$h[name]</option>"; ?>
    </select>
  </div>
  <div class='col-md-3'>
    <input type='date' name='tanggal' class='form-control' required>
  </div>
  <div class='col-md-3'>
    <input type='number' name='slot' class='form-control' placeholder='Kuota' required>
  </div>
  <div class='col-md-2'>
    <button name='add' class='btn btn-primary w-100'>Tambah</button>
  </div>
</form>

<!-- TABLE -->
<table class='table table-striped table-bordered'>
<thead class='table-danger'>
<tr>
  <th>Rumah Sakit</th>
  <th>Tanggal</th>
  <th>Kuota</th>
  <th>Tersisa</th>
  <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php while($r=$rows->fetch_assoc()): ?>
<tr>
  <td><?= $r['hospital_name'] ?></td>
  <td><?= $r['tanggal'] ?></td>
  <td><?= $r['slot_total'] ?></td>
  <td><?= $r['slot_available'] ?></td>
  <td>
    <!-- tombol edit -->
    <button 
      class='btn btn-sm btn-warning'
      data-bs-toggle='modal'
      data-bs-target='#editModal'
      data-id='<?= $r["id"] ?>'
      data-hid='<?= $r["hospital_id"] ?>'
      data-tanggal='<?= $r["tanggal"] ?>'
      data-slot='<?= $r["slot_total"] ?>'
    >Edit</button>

    <!-- tombol hapus -->
    <button 
      class='btn btn-sm btn-danger'
      data-bs-toggle='modal'
      data-bs-target='#deleteModal'
      data-id='<?= $r["id"] ?>'
    >Hapus</button>

  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</main>


<!-- MODAL EDIT -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <form method="post" class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Edit Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="e_id">

        <label class='form-label'>Rumah Sakit</label>
        <select name="hospital_id" id="e_hospital" class="form-control mb-2">
          <?php 
            $hosp2 = $mysqli->query("SELECT * FROM hospitals ORDER BY name");
            while($h=$hosp2->fetch_assoc()) echo "<option value='$h[id]'>$h[name]</option>";
          ?>
        </select>

        <label class='form-label'>Tanggal</label>
        <input type="date" name="tanggal" id="e_tanggal" class="form-control mb-2">

        <label class='form-label'>Kuota</label>
        <input type="number" name="slot" id="e_slot" class="form-control">
      </div>

      <div class="modal-footer">
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
      </div>

    </form>
  </div>
</div>


<!-- MODAL HAPUS -->
<div class="modal fade" id="deleteModal">
  <div class="modal-dialog">
    <form method="post" class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Hapus Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus jadwal ini?</p>
        <input type="hidden" name="id" id="d_id">
      </div>

      <div class="modal-footer">
        <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
      </div>

    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// isi otomatis modal edit
document.getElementById('editModal').addEventListener('show.bs.modal', function (ev) {
    let btn = ev.relatedTarget;
    document.getElementById('e_id').value = btn.dataset.id;
    document.getElementById('e_hospital').value = btn.dataset.hid;
    document.getElementById('e_tanggal').value = btn.dataset.tanggal;
    document.getElementById('e_slot').value = btn.dataset.slot;
});

// isi otomatis modal hapus
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (ev) {
    let btn = ev.relatedTarget;
    document.getElementById('d_id').value = btn.dataset.id;
});
</script>

</body>
</html>
