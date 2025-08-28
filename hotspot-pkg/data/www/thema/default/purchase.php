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
require './config/db_config.php';

if (!isset($_SESSION['transaksi'])) {
    die("Akses tidak sah.");
}

$username = $_SESSION['transaksi']['username'];
$paket = $_SESSION['transaksi']['paket'];
$harga = $_SESSION['transaksi']['harga'];
$ref = $_SESSION['transaksi']['ref'];
$qrFile = $_SESSION['transaksi']['qr'];

$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

$command = "mysql -u {$user} -p{$pass} -h {$host} -D {$db} -e \"SELECT hscsn FROM print_config LIMIT 1\" -s -N";

$admin_number = trim(shell_exec($command));

if (strpos($admin_number, '62') === 0) {
    $cs_number = '0' . substr($admin_number, 2);
} else {
    $cs_number = $admin_number;
}

$formatted = substr($cs_number, 0, 4) . '-' . substr($cs_number, 4, 4) . '-' . substr($cs_number, 8);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Paket</title>
  <link rel="stylesheet" href="assets/purchase.css">
</head>
<body>
<div id="customConfirm" class="confirm-overlay" style="display: none;">
    <div class="confirm-box">
        <p id="confirmMessage"></p>
        <div class="confirm-actions">
            <button id="confirmYes" class="btn-confirm">Ok</button>
        </div>
    </div>
</div>
  <div class="payment-container">
    <h2>Pembayaran Paket</h2>
    <p class="pay-info">Silahkan scan QRIS di bawah ini:</p>
    <img src="" alt="QRIS Code" class="qr-code" id="qrcode">
    <p class="pay-info"><strong>Total Pembayaran:</strong> <span id="total-pembayaran">Rp 0</span></p>
    <p>Waktu tersisa: <span id="countdown" class="countdown">5:00</span></p>
    <div class="button-group">
      <button class="btn btn-download" onclick="downloadQR()">Download</button>
      <button class="btn btn-status" onclick="cekStatus()">Cek Status</button>
    </div>
  </div>
<script>
  let username = "<?php echo addslashes($username); ?>";
  let paket = "<?php echo addslashes($paket); ?>";
  let harga = "<?php echo addslashes($harga); ?>";
  let ref = "<?php echo addslashes($ref); ?>";
  let qrFile = "<?php echo addslashes($qrFile); ?>";

  function updateCountdown(ref) {
    fetch(`./count_down.php?ref=${encodeURIComponent(ref)}`)
      .then(res => res.json())
      .then(data => {
        if (!data || data.error || typeof data.time_left !== "number") {
          window.location.href = "timeout.php";
          return;
        }
        let timeLeft = data.time_left;
        function tick() {
          const minutes = Math.floor(timeLeft / 60);
          const seconds = timeLeft % 60;
          document.getElementById('countdown').innerText =
            minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
          if (timeLeft > 0) {
            timeLeft--;
            setTimeout(tick, 1000);
          } else {
            window.location.href = "timeout.php";
          }
        }
        tick();
      })
      .catch(err => {
        console.error("Gagal mengambil waktu dari server:", err);
        window.location.href = "timeout.php";
      });
  }

  function downloadQR() {
    const qrCode = document.getElementById('qrcode');
    const link = document.createElement('a');
    link.href = qrCode.src;
    link.download = 'qrcode.png';
    link.click();
  }

  function checkPaymentStatus(ref) {
    const interval = setInterval(() => {
      fetch(`cek_status.php?ref=${encodeURIComponent(ref)}`)
        .then(response => response.json())
        .then(data => {
          const status = (data.status || "").trim().toUpperCase();
          if (status === 'PAID') {
            clearInterval(interval);
            window.location.href = "redirect_sukses.php?username=" + encodeURIComponent(username) + "&paket=" + encodeURIComponent(paket) + "&harga=" + encodeURIComponent(harga) + "&ref=" + encodeURIComponent(ref);
          } else if (status === 'EXPIRED') {
            clearInterval(interval);
            window.location.href = "timeout.php";
          }
        })
        .catch(err => {
          console.error('Gagal memeriksa status pembayaran:', err);
        });
    }, 1000);
  }

  function cekStatus() {
      let message = `Pembayaran belum diterima !`;
      showConfirmDialog(message);
  }

  function showConfirmDialog(message, callbackYes, callbackNo) {
      document.getElementById('confirmMessage').innerHTML = message;
      document.getElementById('customConfirm').style.display = 'flex';

      document.getElementById('confirmYes').onclick = function () {
          document.getElementById('customConfirm').style.display = 'none';
          if(callbackYes) callbackYes();
      };
  }
  
  window.onload = function () {
      if (harga) {
        document.getElementById('total-pembayaran').innerText = "Rp " + parseInt(harga).toLocaleString('id-ID');
      }
  
      if (ref) {
        document.getElementById('qrcode').src = 'qris/' + encodeURIComponent(qrFile);
  
        Object.keys(localStorage).forEach((key) => {
          if (key.startsWith("countdown_") && key !== `countdown_${ref}`) {
            localStorage.removeItem(key);
          }
        });
  
        checkPaymentStatus(ref);
        updateCountdown(ref);
      } else {
        alert("Kode reff tidak ditemukan.");
      }
  
      showConfirmDialog("⚠️ Jika setelah membayar tapi kode voucher tidak muncul, silahkan hubungi WhatsApp: <br> <?php echo $formatted ?>");

  };
</script>

</body>
</html>
