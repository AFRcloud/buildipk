<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/

require './config/db_config.php';

$mac = $_GET['mac'] ?? '';

if (empty($mac)) {
    echo json_encode(['status' => 'error', 'message' => 'MAC address not provided']);
    exit;
}

$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4", 
        $user, 
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->prepare("
        SELECT trx_id, username, profile, amount 
        FROM payment 
        WHERE macaddress = :mac 
          AND status = 'Accept'
          AND used = '0'
          AND date >= NOW() - INTERVAL 5 MINUTE
        ORDER BY date DESC
        LIMIT 1
    ");
    $stmt->execute(['mac' => $mac]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    if ($data) {
        echo json_encode([
            'status' => 'success',
            'username' => $data['username'],
            'trx_id' => $data['trx_id'],
            'profile' => $data['profile'],
            'amount' => $data['amount'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['status' => 'pending']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
