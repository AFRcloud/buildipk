<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waktu Habis</title>
    <style>
        body {
          font-family: 'Inter', sans-serif;
          background-color: #00d69f;
          color: #333;
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 80vh;
          padding: 20px;
        }
        .timeout-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 420px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #d9534f;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            background-color: #007bff;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="timeout-container">
        <h2>Waktu Pembayaran Habis</h2>
        <p>Maaf, waktu untuk melakukan pembayaran telah habis.</p>
        <p>Silakan lakukan pemesanan ulang atau hubungi layanan pelanggan.</p>
        <a href="http://10.10.10.1:3990" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>