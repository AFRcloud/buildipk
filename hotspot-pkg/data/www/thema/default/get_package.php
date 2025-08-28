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

$sql = "SELECT 
          bp.planName,
          bp.planCost,
          COALESCE(rg1.value, rg2.value) AS value,
          CASE 
            WHEN rg1.value IS NOT NULL THEN 'Max-All-Session'
            WHEN rg2.value IS NOT NULL THEN 'Access-Period'
          END AS attribute
        FROM billing_plans bp
        LEFT JOIN radgroupcheck rg1 
          ON rg1.groupname = bp.planName AND rg1.attribute = 'Max-All-Session'
        LEFT JOIN radgroupcheck rg2 
          ON rg2.groupname = bp.planName AND rg2.attribute = 'Access-Period'
        WHERE bp.planCost > 0 
          AND bp.planCode != 'PPPoE'
        ORDER BY bp.id";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query gagal: " . $conn->error]);
    exit;
}

$paket = [];
while ($row = $result->fetch_assoc()) {
    $paket[] = $row;
}

$conn->close();

echo json_encode($paket);
exit;
?>
