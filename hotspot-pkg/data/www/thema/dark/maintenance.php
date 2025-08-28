<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
require './config/mysqli_db.php';

$sql = "SELECT status, message, estimate FROM maintenance ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $maintenanceStatus = (strtoupper($row['status']) === 'ON') ? true : false;

    echo json_encode([
        'maintenance' => $maintenanceStatus,
        'pesan' => $row['message'],
        'estimasi' => $row['estimate']
    ]);
} else {
    echo json_encode([
        'maintenance' => false,
        'pesan' => 'Tidak ada data maintenance.',
        'estimasi' => ''
    ]);
}

$conn->close();
