<?php
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) header('Location: login.php');

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name  = $mysqli->real_escape_string($_POST['name']);
    $addr  = $mysqli->real_escape_string($_POST['address']);
    $phone = $mysqli->real_escape_string($_POST['phone']);

    $mysqli->query("INSERT INTO hospitals (name,address,phone) 
                    VALUES ('$name','$addr','$phone')");
    header("Location: hospitals.php?success=added");
    exit;
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id    = (int)$_POST['id'];
    $name  = $mysqli->real_escape_string($_POST['name']);
    $addr  = $mysqli->real_escape_string($_POST['address']);
    $phone = $mysqli->real_escape_string($_POST['phone']);

    $mysqli->query("UPDATE hospitals 
                    SET name='$name', address='$addr', phone='$phone' 
                    WHERE id=$id");
    header("Location: hospitals.php?success=updated");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $mysqli->query("DELETE FROM hospitals WHERE id=$id");
    header("Location: hospitals.php?success=deleted");
    exit;
}

$rows = $mysqli->query("SELECT * FROM hospitals ORDER BY id DESC");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kelola Rumah Sakit</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">ADMIN PANEL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="hospitals.php">Rumah Sakit</a></li>
                <li class="nav-item"><a class="nav-link" href="schedules.php">Jadwal</a></li>
                  <li class="nav-item"><a class="nav-link" href="appointments.php">Daftar Pendonor</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">

<h3 class="mb-3">Kelola Rumah Sakit</h3>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">
    <?= ($_GET['success']=='added'?'Berhasil menambahkan.':
         ($_GET['success']=='updated'?'Berhasil mengupdate.':'Berhasil menghapus.')) ?>
</div>
<?php endif; ?>

<!-- FORM TAMBAH -->
<div class="card mb-4">
    <div class="card-header">Tambah Rumah Sakit</div>
    <div class="card-body">
        <form method="post" class="row g-3">
            <div class="col-md-4"><input name="name" class="form-control" placeholder="Nama RS" required></div>
            <div class="col-md-4"><input name="address" class="form-control" placeholder="Alamat" required></div>
            <div class="col-md-2"><input name="phone" class="form-control" placeholder="Telp" required></div>
            <div class="col-md-2"><button name="add" class="btn btn-primary w-100">Tambah</button></div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card">
    <div class="card-header">Daftar Rumah Sakit</div>
    <div class="card-body p-0">
<table class="table table-striped m-0">
<thead class="table-danger">
<tr>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Telepon</th>
    <th style="width:120px">Aksi</th>
</tr>
</thead>
<tbody>
<?php while($r = $rows->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($r['name']) ?></td>
    <td><?= htmlspecialchars($r['address']) ?></td>
    <td><?= htmlspecialchars($r['phone']) ?></td>
    <td>
        <button 
            class="btn btn-warning btn-sm"
            onclick="editData(<?= $r['id'] ?>,'<?= htmlspecialchars($r['name'], ENT_QUOTES) ?>','<?= htmlspecialchars($r['address'], ENT_QUOTES) ?>','<?= htmlspecialchars($r['phone'], ENT_QUOTES) ?>')"
            data-bs-toggle="modal" data-bs-target="#editModal">
            Edit
        </button>
        <a class="btn btn-danger btn-sm"
           onclick="return confirm('Hapus rumah sakit ini?')"
           href="?delete=<?= $r['id'] ?>">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
    </div>
</div>

</main>

<!-- MODAL EDIT (HANYA SATU) -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<form method="post" class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Edit Rumah Sakit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">

        <div class="mb-2">
            <label>Nama</label>
            <input name="name" id="edit_name" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Alamat</label>
            <input name="address" id="edit_address" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Telepon</label>
            <input name="phone" id="edit_phone" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button name="update" class="btn btn-primary">Simpan</button>
    </div>
</form>
</div>
</div>

<script>
function editData(id, name, address, phone){
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_address").value = address;
    document.getElementById("edit_phone").value = phone;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
