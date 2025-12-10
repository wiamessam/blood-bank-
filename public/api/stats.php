<?php
require_once __DIR__ . '/../../config.php';
$res = $mysqli->query("SELECT h.name, COUNT(a.id) as cnt FROM hospitals h LEFT JOIN schedules s ON s.hospital_id=h.id LEFT JOIN appointments a ON a.schedule_id=s.id GROUP BY h.id");
$labels=[];$values=[];
while($r=$res->fetch_assoc()){ $labels[]= $r['name']; $values[] = intval($r['cnt']); }
header('Content-Type: application/json'); echo json_encode(['labels'=>$labels,'values'=>$values]);