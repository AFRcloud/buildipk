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

$reff = $_GET['ref'] ?? '';

if ($reff == '') {
    echo json_encode(['status' => 'EXPIRED']);
    exit;
}

$stmt = $conn->prepare("SELECT status FROM payment WHERE trx_id = ?");
$stmt->bind_param("s", $reff);
$stmt->execute();
$stmt->bind_result($db_status);

if ($stmt->fetch()) {
    $status = strtolower(trim($db_status));
    if ($status === 'accept') {
        echo json_encode(['status' => 'PAID']);
    } else if ($status === 'expired') {
        echo json_encode(['status' => 'EXPIRED']);
    } else {
        echo json_encode(['status' => 'UNPAID']);
    }
} else {
    echo json_encode(['status' => 'EXPIRED']);
}

$stmt->close();
$conn->close();
?>
