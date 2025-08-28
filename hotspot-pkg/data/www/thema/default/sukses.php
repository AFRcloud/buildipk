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

if (!isset($_SESSION['transaksi_sukses'])) {
  header("Location: ./");
  exit();
}

$data = $_SESSION['transaksi_sukses'];
$username = $data['username'];
$reff = $data['reff'];
$plan_name = $data['paket'];
$harga = $data['harga'];

// unset($_SESSION['transaksi_sukses']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Berhasil</title>
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
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 30px 20px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      text-align: center;
    }

    h1 {
      color: #2ecc71;
      font-weight: 400;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .info {
      margin-top: 20px;
      font-size: 18px;
      line-height: 1.6;
    }

    .info p {
      margin: 8px 0;
    }

    .btn {
      display: inline-block;
      margin-top: 30px;
      padding: 14px 30px;
      font-size: 18px;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.2s ease-in-out;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 24px;
      }

      .info {
        font-size: 16px;
      }

      .btn {
        width: 100%;
        padding: 14px 0;
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>✅ Pembayaran Berhasil!</h1>
    <div class="info">
      <p><strong>Paket:</strong> <?= $plan_name ?></p>
      <p><strong>Harga:</strong> Rp <?= number_format((int)$harga, 0, ',', '.') ?></p>
      <p><strong>ReffID:</strong> <?= $reff ?></p>
        <p><strong>Kode Voucher:</strong> 
          <span id="voucher-container" style="position: relative; display: inline-block; cursor: pointer;" onclick="copyVoucher()">
            <span id="voucher" style="color: #2ecc71; font-weight: bold;"><?= $username ?></span>
            <span id="copied" style="
              display: none;
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              text-align: center;
              background: white;
              color: red;
              font-weight: bold;
            ">Tersalin!</span>
          </span>
        </p>
    </div>
    <a href="http://10.10.10.1:3990/login?username=<?= $username ?>&password=Accept" class="btn">Login Sekarang</a>
  </div>
<script>
function copyVoucher() {
  const text = document.getElementById("voucher").innerText;
  const input = document.createElement("input");
  input.setAttribute("value", text);
  document.body.appendChild(input);
  input.select();
  document.execCommand("copy");
  document.body.removeChild(input);

  document.getElementById("copied").style.display = "inline";
  setTimeout(() => {
    document.getElementById("copied").style.display = "none";
  }, 2000);
}
</script>
</body>
</html>
