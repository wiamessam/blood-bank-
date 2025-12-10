<?php
require_once __DIR__ . '/../config.php';
if(isset($_SESSION['admin_id'])) header('Location: dashboard.php');
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $u = $mysqli->real_escape_string($_POST['username']);
  $p = $_POST['password'];
  $q = $mysqli->query("SELECT * FROM admins WHERE username='{$u}' LIMIT 1");
  if($q && $q->num_rows){
    $row = $q->fetch_assoc();
    if(md5($p) === $row['password']){
      $_SESSION['admin_id'] = $row['id'];
      $_SESSION['admin_user'] = $row['username'];
      header('Location: dashboard.php'); exit;
    }
  }
  $err='Login gagal';
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Admin Login</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Blood Donation</a>
    <div class="ms-auto">
        <a class="btn btn-outline-light me-2" href="../public/index.php">Beranda</a>
        <a class="btn btn-outline-light me-2" href="../public/jadwal.php">Lihat Jadwal</a>
        <!-- <a class="btn btn-light" href="../admin/login.php">Admin</a> -->
    </div>
  </div>
</nav><body class='bg-gray-50'>
<div class='container py-5'>
  <div class='row justify-content-center'><div class='col-md-5'>
    <div class='card'><div class='card-body'>
      <h4>Admin Login</h4>
      <?php if($err): ?><div class='alert alert-danger'><?=htmlspecialchars($err)?></div><?php endif; ?>
      <form method='post'>
        <div class='mb-2'><input name='username' class='form-control' placeholder='Username'></div>
        <div class='mb-2'><input type='password' name='password' class='form-control' placeholder='Password'></div>
        <div class='d-grid'><button class='btn btn-danger'>Login</button></div>
      </form>
    </div></div>
  </div></div>
</div></body></html>