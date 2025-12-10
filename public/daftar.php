<?php
require_once __DIR__ . '/../config.php';

$id = intval($_GET['id'] ?? 0);

$s = $mysqli->prepare("
    SELECT s.*, h.name AS hospital_name 
    FROM schedules s 
    JOIN hospitals h ON h.id = s.hospital_id 
    WHERE s.id = ?
");
$s->bind_param('i', $id);
$s->execute();
$res = $s->get_result();
$sch = $res->fetch_assoc();

$msg   = '';
$queue = null;

if (!$sch) {
    die('Jadwal tidak ditemukan');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name       = $mysqli->real_escape_string($_POST['name']);
    $phone      = preg_replace('/\D/', '', $_POST['phone']); // hanya angka
    $blood_type = $mysqli->real_escape_string($_POST['blood_type']);
    $birthdate  = $mysqli->real_escape_string($_POST['birthdate']);

    // Validasi telepon
    if (strlen($phone) < 10 || strlen($phone) > 15) {
        $msg = "Nomor telepon harus 10–15 digit.";
    } elseif ($sch['slot_available'] <= 0) {
        $msg = 'Maaf, slot sudah penuh.';
    } else {

        // Hitung nomor antrian
        $cnt = $mysqli->query("
            SELECT COUNT(*) AS c 
            FROM appointments 
            WHERE schedule_id = {$sch['id']}
        ")->fetch_assoc()['c'];

        $queue = intval($cnt) + 1;

        $ins = $mysqli->prepare("
            INSERT INTO appointments 
            (schedule_id, name, phone, blood_type, birthdate, queue_no) 
            VALUES (?,?,?,?,?,?)
        ");
        $ins->bind_param('issssi', $id, $name, $phone, $blood_type, $birthdate, $queue);

        if ($ins->execute()) {
            $mysqli->query("UPDATE schedules SET slot_available = slot_available - 1 WHERE id = {$sch['id']}");
            $msg = 'Pendaftaran berhasil! Nomor antrian Anda: ' . $queue;
        } else {
            $msg = 'Gagal mendaftar';
        }
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Daftar Donor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .ticket-box {
            width: 340px;
            margin: auto;
            padding: 25px;
            border: 2px dashed #dc3545;
            border-radius: 12px;
            background: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .ticket-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .queue-number {
            font-size: 50px;
            font-weight: 900;
            text-align: center;
            color: #dc3545;
            margin: 10px 0;
        }

        .ticket-divider {
            border-bottom: 1px dashed #999;
            margin: 12px 0;
        }
    </style>

    <script>
        // hanya angka saat mengetik
        function onlyNumber(evt) {
            const charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode < 48 || charCode > 57) {
                evt.preventDefault();
            }
        }
    </script>
</head>

<body class="bg-light">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        async function downloadTicket() {
            const ticket = document.getElementById("ticketArea");

            const canvas = await html2canvas(ticket, {
                scale: 3,
                useCORS: true,
            });

            const imgData = canvas.toDataURL("image/png");
            const pdfWidth = canvas.width;
            const pdfHeight = canvas.height;

            const pdf = new jspdf.jsPDF({
                orientation: pdfWidth > pdfHeight ? "landscape" : "portrait",
                unit: "px",
                format: [pdfWidth, pdfHeight]
            });

            pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
            pdf.save("tiket_donor.pdf");
        }
    </script>

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

    <main class="container py-4">

        <div class="card mx-auto shadow" style="max-width:720px;">
            <div class="card-body">

                <h4 class="mb-2">Daftar Donor - <?= htmlspecialchars($sch['hospital_name']) ?></h4>
                <p class="mb-3">
                    Tanggal: <?= htmlspecialchars($sch['tanggal']) ?> |
                    Slot tersedia: <?= $sch['slot_available'] ?>
                </p>

                <?php if ($msg): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
                <?php endif; ?>

                <form method="post" class="row g-3">

                    <div class="col-12">
                        <label>Nama</label>
                        <input name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Telepon</label>
                        <input name="phone" class="form-control" maxlength="15" minlength="10"
                            onkeypress="onlyNumber(event)" required>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birthdate" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label>Golongan Darah</label>
                        <select name="blood_type" class="form-control" required>
                            <option value="">-- Pilih Golongan Darah --</option>
                            <option>A</option>
                            <option>B</option>
                            <option>AB</option>
                            <option>O</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-danger w-100" type="submit">Daftar & Ambil Antrian</button>
                    </div>

                </form>

                <!-- TIKET CETAK -->
                <?php if ($queue): ?>
                    <div class="text-center mt-4">
                        <button class="btn btn-success me-2" onclick="window.print()">Cetak Tiket</button>
                        <button class="btn btn-primary" onclick="downloadTicket()">Download Tiket</button>
                    </div>

                    <div id="ticketArea" style="padding:20px; display:inline-block;">

                        <h3 class="text-center">TIKET DONOR DARAH</h3>
                        <hr>

                        <p><strong>Rumah Sakit:</strong> <?= htmlspecialchars($sch['hospital_name']) ?></p>
                        <p><strong>Tanggal Donor:</strong> <?= htmlspecialchars($sch['tanggal']) ?></p>
                        <p>
                            <strong>Nomor Antrian:</strong>
                            <span style="font-size:22px; font-weight:bold;"><?= $queue ?></span>
                        </p>
                        <p><strong>Nama:</strong> <?= htmlspecialchars($_POST['name']) ?></p>
                        <p><strong>Telepon:</strong> <?= htmlspecialchars($phone) ?></p>
                        <p><strong>Golongan Darah:</strong> <?= htmlspecialchars($_POST['blood_type']) ?></p>
                        <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($_POST['birthdate']) ?></p>

                        <hr>
                        <p class="text-center">Tunjukkan tiket ini saat registrasi</p>

                    </div>
                <?php endif; ?>

            </div>
        </div>

    </main>

</body>

</html>
