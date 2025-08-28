<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 

// Tambahkan parameter debug
$debug = isset($_GET['debug']) ? true : false;

if ($debug) {
    header('Content-Type: text/html; charset=UTF-8');
    echo "<h2>Debug Package Database - Mencari Bandwidth</h2>";
} else {
    header('Content-Type: application/json');
}

require './config/mysqli_db.php';

if ($debug) {
    // Debug mode - cek tabel bandwidth
    
    // 1. Cek struktur tabel bandwidth
    echo "<h3>1. Struktur tabel bandwidth:</h3>";
    $result = $conn->query("DESCRIBE bandwidth");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tabel bandwidth tidak ditemukan</p>";
    }

    // 2. Cek data sample dari bandwidth
    echo "<h3>2. Sample data dari bandwidth:</h3>";
    $result = $conn->query("SELECT * FROM bandwidth LIMIT 10");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "</tr>";
                $first = false;
            }
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // 3. Cek data billing_plans
    echo "<h3>3. Data billing_plans:</h3>";
    $result = $conn->query("SELECT * FROM billing_plans WHERE planCost > 0 AND planCode != 'PPPoE' ORDER BY planName");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach (array_keys($row) as $key) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "</tr>";
                $first = false;
            }
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // 4. Cek relasi antara billing_plans dan bandwidth dengan berbagai cara
    echo "<h3>4. Cek relasi billing_plans dengan bandwidth (by name):</h3>";
    $result = $conn->query("
        SELECT bp.id, bp.planName, bp.planCost, bp.planTimeBank, bw.id as bw_id, bw.name as bandwidth_name, bw.rate_down, bw.rate_up
        FROM billing_plans bp
        LEFT JOIN bandwidth bw ON bp.planName = bw.name
        WHERE bp.planCost > 0 AND bp.planCode != 'PPPoE'
        ORDER BY bp.planName
    ");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        echo "<tr><th>BP ID</th><th>Plan Name</th><th>Cost</th><th>Time Bank</th><th>BW ID</th><th>Bandwidth Name</th><th>Rate Down</th><th>Rate Up</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planCost']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planTimeBank']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bw_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bandwidth_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_down']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_up']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // 5. Cek relasi dengan ID
    echo "<h3>5. Cek relasi billing_plans dengan bandwidth (by ID):</h3>";
    $result = $conn->query("
        SELECT bp.id, bp.planName, bp.planCost, bp.planTimeBank, bw.id as bw_id, bw.name as bandwidth_name, bw.rate_down, bw.rate_up
        FROM billing_plans bp
        LEFT JOIN bandwidth bw ON bp.id = bw.id
        WHERE bp.planCost > 0 AND bp.planCode != 'PPPoE'
        ORDER BY bp.planName
    ");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        echo "<tr><th>BP ID</th><th>Plan Name</th><th>Cost</th><th>Time Bank</th><th>BW ID</th><th>Bandwidth Name</th><th>Rate Down</th><th>Rate Up</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planCost']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planTimeBank']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bw_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bandwidth_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_down']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_up']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // 6. Test query yang akan digunakan
    echo "<h3>6. Test query final:</h3>";
    $sql = "SELECT 
              bp.planName,
              bp.planCost,
              bp.planTimeBank,
              COALESCE(rg1.value, rg2.value, rg3.value) AS duration_value,
              CASE 
                WHEN rg1.value IS NOT NULL THEN 'Max-All-Session'
                WHEN rg2.value IS NOT NULL THEN 'Access-Period'
                WHEN rg3.value IS NOT NULL THEN 'Session-Timeout'
              END AS duration_attribute,
              bw.rate_down,
              bw.rate_up,
              bw.name as bandwidth_name
            FROM billing_plans bp
            LEFT JOIN radgroupcheck rg1 
              ON rg1.groupname = bp.planName AND rg1.attribute = 'Max-All-Session'
            LEFT JOIN radgroupcheck rg2 
              ON rg2.groupname = bp.planName AND rg2.attribute = 'Access-Period'
            LEFT JOIN radgroupcheck rg3 
              ON rg3.groupname = bp.planName AND rg3.attribute = 'Session-Timeout'
            LEFT JOIN bandwidth bw 
              ON bp.planName = bw.name OR bp.id = bw.id
            WHERE bp.planCost > 0 
              AND bp.planCode != 'PPPoE'
            ORDER BY bp.id";

    $result = $conn->query($sql);
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
        echo "<tr><th>Plan Name</th><th>Cost</th><th>Time Bank</th><th>Duration Value</th><th>Duration Attr</th><th>Rate Down</th><th>Rate Up</th><th>Bandwidth Name</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['planName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planCost']) . "</td>";
            echo "<td>" . htmlspecialchars($row['planTimeBank']) . "</td>";
            echo "<td>" . htmlspecialchars($row['duration_value']) . "</td>";
            echo "<td>" . htmlspecialchars($row['duration_attribute']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_down']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rate_up']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bandwidth_name']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    $conn->close();
    exit;
}

// Mode normal - return JSON dengan bandwidth dari tabel bandwidth
$sql = "SELECT 
          bp.planName,
          bp.planCost,
          bp.planTimeBank,
          COALESCE(rg1.value, rg2.value, rg3.value) AS duration_value,
          CASE 
            WHEN rg1.value IS NOT NULL THEN 'Max-All-Session'
            WHEN rg2.value IS NOT NULL THEN 'Access-Period'
            WHEN rg3.value IS NOT NULL THEN 'Session-Timeout'
          END AS duration_attribute,
          bw.rate_down,
          bw.rate_up,
          bw.name as bandwidth_name
        FROM billing_plans bp
        LEFT JOIN radgroupcheck rg1 
          ON rg1.groupname = bp.planName AND rg1.attribute = 'Max-All-Session'
        LEFT JOIN radgroupcheck rg2 
          ON rg2.groupname = bp.planName AND rg2.attribute = 'Access-Period'
        LEFT JOIN radgroupcheck rg3 
          ON rg3.groupname = bp.planName AND rg3.attribute = 'Session-Timeout'
        LEFT JOIN bandwidth bw 
          ON bp.planName = bw.name OR bp.id = bw.id
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
