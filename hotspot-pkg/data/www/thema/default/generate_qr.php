<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
require_once 'phpqrcode/qrlib.php';

function convertCRC16($str) {
    $crc = 0xFFFF;
    for ($c = 0; $c < strlen($str); $c++) {
        $crc ^= ord($str[$c]) << 8;
        for ($i = 0; $i < 8; $i++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ 0x1021;
            } else {
                $crc = $crc << 1;
            }
        }
    }
    $hex = strtoupper(dechex($crc & 0xFFFF));
    return str_pad($hex, 4, '0', STR_PAD_LEFT);
}

if ($argc < 3) {
    exit(1);
}

$qris = trim(shell_exec("uci get whatsapp-bot.@whatsapp_bot[0].qrisid | xargs"));
$qty  = $argv[1];
$ref = $argv[2];

$qris = substr($qris, 0, -4);
$step1 = str_replace("010211", "010212", $qris);
$step2 = explode("5802ID", $step1);
$uang = "54" . str_pad(strlen($qty), 2, '0', STR_PAD_LEFT) . $qty;
$uang .= "5802ID";

$fix = trim($step2[0]) . $uang . trim($step2[1]);
$fix .= convertCRC16($fix);

$pixel_size = 10;
$margin = 2;
QRcode::png($fix, "qris/{$ref}.png", QR_ECLEVEL_H, $pixel_size, $margin);
?>
