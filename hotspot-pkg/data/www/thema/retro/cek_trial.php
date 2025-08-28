<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
header('Content-Type: application/json');
require './config/mysqli_db.php';

$mac = $_GET['mac'];
$tanggal = date('Y-m-d');

$query = "SELECT * FROM userbillinfo 
          WHERE contactperson = ? 
          AND planName = 'TRIAL' 
          AND DATE(creationdate) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $mac, $tanggal);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['TrialOk' => true]);
} else {
    echo json_encode(['TrialOk' => false]);
}
?>
