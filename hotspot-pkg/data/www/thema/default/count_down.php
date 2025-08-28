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

if (!isset($_GET['ref'])) {
    echo json_encode(['error' => 'Missing ref']);
    exit;
}

$ref = $_GET['ref'];
$stmt = $conn->prepare("
    SELECT 
        300 - TIMESTAMPDIFF(SECOND, `date`, NOW()) AS time_left 
    FROM payment 
    WHERE trx_id = ?
");
$stmt->bind_param("s", $ref);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    $time_left = (int)$data['time_left'];
    if ($time_left < 0) $time_left = 0;

    echo json_encode(['time_left' => $time_left]);
} else {
    echo json_encode(['error' => 'Data not found']);
}

$stmt->close();
$conn->close();
?>
