<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/
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
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title id="title"></title>
  <meta name="theme-color" content="#2563eb" />
  <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
  <style>
    /* CSS Variables for Theming */
    :root {
        --bg-color: #f8fafc;
        --container-bg: white;
        --text-color: #334155;
        --header-bg: #2563eb;
        --header-text: white;
        --tab-border: #e2e8f0;
        --tab-button-color: #64748b;
        --tab-button-active-color: #2563eb;
        --tab-button-active-bg: #f8fafc;
        --tab-button-hover-bg: #f1f5f9;
        --otp-border: #e2e8f0;
        --otp-focus-border: #2563eb;
        --otp-filled-border: #059669;
        --otp-filled-bg: #f0fdf4;
        --table-header-bg: #f8fafc;
        --table-border: #e2e8f0;
        --table-row-border: #f1f5f9;
        --modal-overlay-bg: rgba(0, 0, 0, 0.5);
        --modal-bg: white;
        --modal-text: #374151;
        --whatsapp-color: #059669;
        --qr-button-bg: #dc2626;
        --qr-button-hover-bg: #b91c1c;
        --btn-primary-bg: #2563eb;
        --btn-primary-hover-bg: #1d4ed8;
        --btn-secondary-bg: #059669;
        --btn-secondary-hover-bg: #047857;
        --btn-outline-border: #2563eb;
        --btn-outline-text: #2563eb;
        --btn-outline-hover-bg: #2563eb;
        --btn-outline-hover-text: white;
        --scrollbar-track: #f1f5f9;
        --scrollbar-thumb: #cbd5e1;
        --scrollbar-thumb-hover: #94a3b8;
    }

    [data-theme="dark"] {
        --bg-color: #1a202c; /* Darker background */
        --container-bg: #2d3748; /* Darker container */
        --text-color: #e2e8f0; /* Light text */
        --header-bg: #4a5568; /* Darker header */
        --header-text: white;
        --tab-border: #4a5568;
        --tab-button-color: #a0aec0;
        --tab-button-active-color: #63b3ed; /* Lighter blue for active */
        --tab-button-active-bg: #2d3748;
        --tab-button-hover-bg: #4a5568;
        --otp-border: #4a5568;
        --otp-focus-border: #63b3ed;
        --otp-filled-border: #48bb78; /* Darker green */
        --otp-filled-bg: #2f4f4f; /* Darker green background */
        --table-header-bg: #2d3748;
        --table-border: #4a5568;
        --table-row-border: #2d3748;
        --modal-overlay-bg: rgba(0, 0, 0, 0.7);
        --modal-bg: #2d3748;
        --modal-text: #e2e8f0;
        --whatsapp-color: #48bb78; /* Lighter green */
        --qr-button-bg: #e53e3e; /* Slightly brighter red */
        --qr-button-hover-bg: #c53030;
        --btn-primary-bg: #63b3ed; /* Lighter blue */
        --btn-primary-hover-bg: #4299e1;
        --btn-secondary-bg: #48bb78; /* Lighter green */
        --btn-secondary-hover-bg: #38a169;
        --btn-outline-border: #63b3ed;
        --btn-outline-text: #63b3ed;
        --btn-outline-hover-bg: #63b3ed;
        --btn-outline-hover-text: white;
        --scrollbar-track: #2d3748;
        --scrollbar-thumb: #4a5568;
        --scrollbar-thumb-hover: #64748b;
    }

    /* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: var(--bg-color);
        min-height: 100vh;
        color: var(--text-color);
    }
    /* Main Container */
    .container {
        max-width: 400px;
        margin: 0 auto;
        background: var(--container-bg);
        min-height: 100vh;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 20px; /* Add padding for content at the bottom */
    }
    /* Header */
    .header {
        background: var(--header-bg);
        color: var(--header-text);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between; /* Added for theme toggle button */
        gap: 12px;
        width: 100%; /* Ensure header spans full width of container */
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-logo-img {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        object-fit: contain;
        background: white;
        padding: 4px;
    }
    .header-title {
        font-size: 18px;
        font-weight: 600;
    }
    .theme-toggle-button {
        background: none;
        border: none;
        color: var(--header-text);
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }
    .theme-toggle-button:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    .theme-toggle-button svg {
        width: 20px;
        height: 20px;
    }

    /* Modal Styles (for customConfirm) */
    .confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--modal-overlay-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .confirm-box {
        background: var(--modal-bg);
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 90%;
        text-align: center;
        color: var(--modal-text);
    }
    .confirm-box p {
        margin-bottom: 20px;
        color: var(--modal-text);
        line-height: 1.5;
    }
    .confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    .btn-confirm {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--btn-primary-bg);
        color: white;
    }
    .btn-confirm:hover {
        background: var(--btn-primary-hover-bg);
    }

    /* Specific styles for purchase.php */
    .payment-container {
        text-align: center;
        padding: 40px 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .payment-container h2 {
        font-size: 28px;
        font-weight: 700;
        color: var(--btn-primary-bg);
        margin-bottom: 20px;
    }
    .pay-info {
        font-size: 16px;
        color: var(--tab-button-color);
        margin-bottom: 15px;
    }
    .qr-code {
        width: 200px;
        height: 200px;
        border: 1px solid var(--tab-border);
        border-radius: 8px;
        margin-bottom: 20px;
        object-fit: contain;
    }
    #total-pembayaran {
        font-size: 24px;
        font-weight: 700;
        color: var(--btn-secondary-bg); /* Green for total payment */
        margin-top: 10px;
        display: block; /* Ensure it takes full width for centering */
    }
    .countdown {
        font-size: 20px;
        font-weight: 600;
        color: var(--qr-button-bg); /* Red for countdown */
        margin-top: 10px;
        display: block;
    }
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        width: 100%;
        justify-content: center;
        flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
    }
    .btn {
        flex: 1; /* Allow buttons to grow/shrink */
        min-width: 140px; /* Minimum width for buttons */
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none; /* For anchor tags */
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-download {
        background: #f59e0b;
        color: white;
    }
    .btn-download:hover {
        background: #d97706;
        transform: translateY(-1px);
    }
    .btn-status {
        background: var(--btn-primary-bg);
        color: white;
    }
    .btn-status:hover {
        background: var(--btn-primary-hover-bg);
        transform: translateY(-1px);
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        .container {
            max-width: 100%;
        }
        .payment-container {
            padding: 30px 15px;
        }
        .payment-container h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .pay-info {
            font-size: 15px;
            margin-bottom: 10px;
        }
        .qr-code {
            width: 180px;
            height: 180px;
        }
        #total-pembayaran {
            font-size: 20px;
        }
        .countdown {
            font-size: 18px;
        }
        .button-group {
            flex-direction: column; /* Stack buttons vertically on small screens */
            gap: 10px;
        }
        .btn {
            width: 100%; /* Full width for stacked buttons */
            padding: 12px 20px;
            font-size: 15px;
        }
    }
  </style>
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

  <div class="container">
    <div class="header">
        <div class="header-left">
            <img src="assets/images/radmon.png" alt="RadMon Logo" class="header-logo-img">
            <div class="header-title">RadMon WiFi</div>
        </div>
        <button id="theme-toggle" class="theme-toggle-button">
            <!-- Icon will be set by JavaScript -->
        </button>
    </div>

    <div class="payment-container">
        <h2>Pembayaran Paket</h2>
        <p class="pay-info">Silahkan scan QRIS di bawah ini:</p>
        <img src="/placeholder.svg" alt="QRIS Code" class="qr-code" id="qrcode">
        <p class="pay-info"><strong>Total Pembayaran:</strong> <span id="total-pembayaran">Rp 0</span></p>
        <p>Waktu tersisa: <span id="countdown" class="countdown">5:00</span></p>
        <div class="button-group">
          <button class="btn btn-download" onclick="downloadQR()">Download</button>
          <button class="btn btn-status" onclick="cekStatus()">Cek Status</button>
        </div>
    </div>
  </div>

<script>
  // Theme Toggle Logic
  document.addEventListener('DOMContentLoaded', () => {
      const htmlElement = document.documentElement;
      const themeToggleBtn = document.getElementById('theme-toggle');

      // Function to set theme
      const setTheme = (theme) => {
          htmlElement.setAttribute('data-theme', theme);
          localStorage.setItem('theme', theme);
          updateThemeIcon(theme);
      };

      // Function to update icon
      const updateThemeIcon = (theme) => {
          if (themeToggleBtn) {
              themeToggleBtn.innerHTML = theme === 'dark'
                  ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/></svg>'
                  : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>';
          }
      };

      // Get saved theme or default to light
      const savedTheme = localStorage.getItem('theme') || 'light';
      setTheme(savedTheme);

      // Add event listener to toggle button
      if (themeToggleBtn) {
          themeToggleBtn.addEventListener('click', () => {
              const currentTheme = htmlElement.getAttribute('data-theme');
              const newTheme = currentTheme === 'light' ? 'dark' : 'light';
              setTheme(newTheme);
          });
      }
  });

  // Mengatur judul halaman
  var hostname = window.location.hostname;
  document.getElementById('title').innerHTML = hostname + " > Pembayaran Paket";

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

  function showConfirmDialog(message, callbackYes) {
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
        // Fallback if ref is not available, though it should be from session
        showConfirmDialog("Terjadi kesalahan: Kode referensi pembayaran tidak ditemukan.");
      }

      // Initial alert for payment instructions
      showConfirmDialog("⚠️ Jika setelah membayar tapi kode voucher tidak muncul, silahkan hubungi WhatsApp: <br> <?php echo $formatted ?>");
  };
</script>
</body>
</html>
