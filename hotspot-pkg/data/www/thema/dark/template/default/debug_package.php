<?php
/*
 * File debug untuk melihat struktur database dan data paket
 */
header('Content-Type: text/html; charset=UTF-8');

require './config/mysqli_db.php';

echo "<h2>Debug Package Database</h2>";

// 1. Cek struktur tabel billing_plans
echo "<h3>1. Struktur tabel billing_plans:</h3>";
$result = $conn->query("DESCRIBE billing_plans");
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
}

// 2. Cek data sample dari billing_plans
echo "<h3>2. Sample data dari billing_plans:</h3>";
$result = $conn->query("SELECT * FROM billing_plans WHERE planCost > 0 AND planCode != 'PPPoE' LIMIT 5");
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

// 3. Cek struktur tabel radgroupcheck
echo "<h3>3. Struktur tabel radgroupcheck:</h3>";
$result = $conn->query("DESCRIBE radgroupcheck");
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
}

// 4. Cek semua attribute yang ada di radgroupcheck
echo "<h3>4. Semua attribute di radgroupcheck:</h3>";
$result = $conn->query("SELECT DISTINCT attribute FROM radgroupcheck ORDER BY attribute");
if ($result) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($row['attribute']) . "</li>";
    }
    echo "</ul>";
}

// 5. Cek data radgroupcheck untuk paket tertentu
echo "<h3>5. Sample data radgroupcheck (untuk melihat format bandwidth):</h3>";
$result = $conn->query("
    SELECT rg.groupname, rg.attribute, rg.value 
    FROM radgroupcheck rg 
    INNER JOIN billing_plans bp ON bp.planName = rg.groupname 
    WHERE bp.planCost > 0 
    ORDER BY rg.groupname, rg.attribute 
    LIMIT 20
");
if ($result) {
    echo "<table border='1' style='border-collapse: collapse; margin-bottom: 20px;'>";
    echo "<tr><th>Group Name</th><th>Attribute</th><th>Value</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['groupname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['attribute']) . "</td>";
        echo "<td>" . htmlspecialchars($row['value']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// 6. Cek apakah ada tabel lain yang mungkin berisi info bandwidth
echo "<h3>6. Daftar semua tabel di database:</h3>";
$result = $conn->query("SHOW TABLES");
if ($result) {
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";
}

$conn->close();
?>
