<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
session_start();

require './config/mysqli_db.php';

$username   = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : '';
$reff       = isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : '';
$plan_name  = isset($_GET['paket']) ? htmlspecialchars($_GET['paket']) : '';
$harga      = isset($_GET['harga']) ? htmlspecialchars($_GET['harga']) : '';

$_SESSION['transaksi_sukses'] = [
    'username' => $username,
    'paket'    => $plan_name,
    'harga'    => $harga,
    'reff'     => $reff,
];

if (!empty($reff)) {
    $stmt = $conn->prepare("UPDATE payment SET used = '1' WHERE trx_id = ?");
    $stmt->bind_param("s", $reff);
    $stmt->execute();
    $stmt->close();
}

header("Location: ./sukses.php");
exit();
?>
