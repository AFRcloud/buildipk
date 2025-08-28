<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/
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
// unset($_SESSION['transaksi_sukaksi']); // Uncomment this line if you want to clear the session after displaying
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    /* Specific styles for success.php */
    .container h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--btn-secondary-bg); /* Green for success */
        text-align: center;
        margin-top: 40px;
        margin-bottom: 30px;
        padding: 0 20px;
    }
    .info {
        background: var(--otp-filled-bg); /* Light green background */
        border: 1px solid var(--otp-filled-border); /* Green border */
        border-radius: 8px;
        padding: 20px;
        margin: 0 20px 30px;
        width: calc(100% - 40px); /* Adjust width for padding */
        max-width: 360px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .info p {
        font-size: 16px;
        margin-bottom: 12px;
        color: var(--text-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info p:last-child {
        margin-bottom: 0;
    }
    .info strong {
        font-weight: 600;
        color: var(--text-color);
    }
    #voucher-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        background: var(--otp-filled-bg); /* Lighter green background for clickable area */
        transition: background 0.2s ease;
    }
    #voucher-container:hover {
        background: var(--otp-filled-border);
    }
    #voucher {
        color: var(--whatsapp-color); /* Darker green for voucher text */
        font-weight: bold;
    }
    #copied {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--modal-bg); /* Semi-transparent white */
        color: var(--qr-button-bg); /* Red for "Tersalin!" */
        font-weight: bold;
        border-radius: 4px;
        animation: fadeOut 2s forwards; /* Animation for fade out */
    }
    @keyframes fadeOut {
        0% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 24px;
        background: var(--btn-primary-bg);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        width: calc(100% - 40px); /* Adjust width for padding */
        max-width: 360px;
    }
    .btn:hover {
        background: var(--btn-primary-hover-bg);
        transform: translateY(-1px);
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        .container {
            max-width: 100%;
        }
        .container h1 {
            font-size: 24px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .info {
            padding: 15px;
            margin: 0 15px 25px;
            width: calc(100% - 30px);
        }
        .info p {
            font-size: 15px;
            margin-bottom: 10px;
        }
        .btn {
            padding: 12px 20px;
            font-size: 15px;
            width: calc(100% - 30px);
        }
    }
  </style>
</head>
<body>
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

    <h1>✅ Pembayaran Berhasil!</h1>
    <div class="info">
      <p><strong>Paket:</strong> <span><?= htmlspecialchars($plan_name) ?></span></p>
      <p><strong>Harga:</strong> <span>Rp <?= number_format((int)$harga, 0, ',', '.') ?></span></p>
      <p><strong>ReffID:</strong> <span><?= htmlspecialchars($reff) ?></span></p>
      <p><strong>Kode Voucher:</strong>
        <span id="voucher-container" onclick="copyVoucher()">
          <span id="voucher"><?= htmlspecialchars($username) ?></span>
          <span id="copied">Tersalin!</span>
        </span>
      </p>
    </div>
    <a href="http://10.10.10.1:3990/login?username=<?= urlencode($username) ?>&password=Accept" class="btn">Login Sekarang</a>
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
document.getElementById('title').innerHTML = hostname + " > Pembayaran Berhasil";

function copyVoucher() {
  const text = document.getElementById("voucher").innerText;
  const input = document.createElement("input");
  input.setAttribute("value", text);
  document.body.appendChild(input);
  input.select();
  document.execCommand("copy");
  document.body.removeChild(input);

  const copiedSpan = document.getElementById("copied");
  copiedSpan.style.display = "flex"; // Use flex to center text
  copiedSpan.style.opacity = "1"; // Ensure it's visible at start of animation

  setTimeout(() => {
    copiedSpan.style.display = "none"; // Hide after animation
  }, 2000); // Matches animation duration
}
</script>
</body>
</html>
