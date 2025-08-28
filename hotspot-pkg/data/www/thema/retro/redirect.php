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

function generateUsername($length = 6) {
    $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $username = '';
    for ($i = 0; $i < $length; $i++) {
        $username .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $username;
}

$username = generateUsername();
$ipaddress = $_POST['ipaddress'] ?? '';
$macaddress = $_POST['macaddress'] ?? '';
$nominal = $_POST['harga'] ?? '';
$paket = $_POST['paket'] ?? '';
$whatsapp_number = trim(shell_exec("uci get whatsapp-bot.@whatsapp_bot[0].admin_number"));
$whatsapp_number = preg_replace('/^0/', '62', $whatsapp_number);
$now = date('Y-m-d H:i:s');

if (!$username || !$nominal) {
    die("Parameter tidak lengkap.");
}

$ref = "VCR-" . time();
$status = "Pending";

$stmt = $conn->prepare("INSERT INTO payment (trx_id, username, ipaddress, macaddress, profile, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssds", $ref, $username, $ipaddress, $macaddress, $paket, $nominal, $status);

if ($stmt->execute()) {
    $api_provider = trim(shell_exec("uci get whatsapp-bot.@whatsapp_bot[0].api_provider"));
    if ($api_provider == 'qrisajaib') {
        $merchant = trim(shell_exec("uci get whatsapp-bot.@whatsapp_bot[0].merchant_code"));
        $url = "https://orkut.biz.id/api/qris?merchant={$merchant}&amount=" . urlencode($nominal);
    } else {
        $url = "http://localhost:3000/qrcode?id=" . urlencode($ref) . "&harga=" . urlencode($nominal);
    }
    $gambar = file_get_contents($url);

    file_put_contents("qris/{$ref}.png", $gambar);
    $filename = "{$ref}.png";

    $_SESSION['transaksi'] = [
        'username' => $username,
        'paket' => $paket,
        'harga' => $nominal,
        'ref' => $ref,
        'qr' => $filename
    ];
    
    $message = "╔════════════════════╗\n"
        . "      🎟 *PEMBELIAN VOUCHER*\n"
        . "╚════════════════════╝\n"
        . "No.Transaksi: _*$ref*_\n"
        . "Harga: *_Rp " . number_format($nominal, 0, ',') . "_*\n"
        . "Status: _*Pending*_\n"
        . "Tanggal: _*$now*_\n"
        . "══════════════════════\n"
        . "Voucher: _*$username*_\n"
        . "Paket: _*$paket*_\n"
        . "Ip Addr: _*$ipaddress*_\n"
        . "Mac Addr: _*$macaddress*_\n"
        . "╔════════════════════╗\n"
        . "       Powered By *Mutiara-Wrt*\n"
        . "╚════════════════════╝";
    
    kirimPesanWhatsApp($whatsapp_number, $message);

    header("Location: purchase.php");
    exit;
} else {
    echo "Gagal menyimpan ke database: " . $stmt->error;
}

$stmt->close();
$conn->close();

function kirimPesanWhatsApp($whatsapp_number, $message) {
    $url = 'http://localhost:3000/send-message';

    $payload = json_encode([
        'to' => $whatsapp_number,
        'message' => $message
    ]);

    $escapedPayload = escapeshellarg($payload);

    $cmd = "curl -s -X POST -H 'Content-Type: application/json' -d $escapedPayload $url > /dev/null 2>&1 &";
    exec($cmd);
}

?>


