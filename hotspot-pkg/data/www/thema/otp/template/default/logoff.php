<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/

// Ambil parameter dari URL
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';
$uamip = isset($_GET['uamip']) ? $_GET['uamip'] : '10.10.10.1';
$uamport = isset($_GET['uamport']) ? $_GET['uamport'] : '3990';
$loginpath = isset($_GET['loginpath']) ? urldecode($_GET['loginpath']) : '';
$confirmed = isset($_GET['confirmed']) ? $_GET['confirmed'] : '';

if ($confirmed === 'yes') {
  $logoutUrl = "http://$uamip:$uamport/logoff";
  header("Location: $logoutUrl");
  exit; // Penting: Pastikan skrip berhenti di sini setelah redirect
}

// Fungsi-fungsi PHP yang dibutuhkan (dari login-successful.php)
function toxbyte($size) {
  if ($size > 1073741824) {
      return round($size / 1073741824, 2) . " GB";
  } elseif ($size > 1048576) {
      return round($size / 1048576, 2) . " MB";
  } elseif ($size > 1024) {
      return round($size / 1024, 2) . " KB";
  } else {
      return $size . " B";
  }
}

function time2str($time) {
  $str = "";
  $time = floor($time);
  if (!$time)
      return "0 detik";
  $d = $time/86400;
  $d = floor($d);
  if ($d){
      $str .= "$d hari, ";
      $time = $time % 86400;
  }
  $h = $time/3600;
  $h = floor($h);
  if ($h){
      $str .= "$h jam, ";
      $time = $time % 3600;
  }
  $m = $time/60;
  $m = floor($m);
  if ($m){
      $str .= "$m menit, ";
      $time = $time % 60;
  }
  if ($time)
      $str .= "$time detik, ";
  $str = preg_replace("/, $/",'',$str);
  return $str;
}

// Data sesi pengguna
$data = array();
if ($mac) {
  // Memastikan file koneksi database ada
  if (file_exists('./config/mysqli_db.php')) {
      require './config/mysqli_db.php';

      if ($conn->connect_error) {
          // Handle error koneksi database
          error_log("Database connection failed: " . $conn->connect_error);
      } else {
          $mac_address_escaped = $conn->real_escape_string($mac);
          $query = "SELECT username, AcctStartTime, AcctStopTime, AcctSessionTime,
                    NASIPAddress, CalledStationId, FramedIPAddress, CallingStationId, AcctInputOctets, AcctOutputOctets
                    FROM radacct
                    WHERE callingstationid = '$mac_address_escaped' ORDER BY RadAcctId DESC LIMIT 1";
          $result = $conn->query($query);

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $username = $row['username'];
                  $userUpload = toxbyte($row['AcctInputOctets']);
                  $userDownload = toxbyte($row['AcctOutputOctets']);
                  $userTraffic = toxbyte($row['AcctOutputOctets'] + $row['AcctInputOctets']);
                  $userLastConnected = $row['AcctStartTime'];
                  $userOnlineTime = time2str($row['AcctSessionTime']);
                  $userIPAddress = $row['FramedIPAddress'];
                  $userMacAddress = $row['CallingStationId'];
                  $data[] = array(
                      'username' => $username,
                      'userIPAddress' => $userIPAddress,
                      'userMacAddress' => $userMacAddress,
                      'userDownload' => $userDownload,
                      'userUpload' => $userUpload,
                      'userTraffic' => $userTraffic,
                      'userLastConnected' => $userLastConnected,
                      'userOnlineTime' => $userOnlineTime,
                  );
              }
          }
          $conn->close();
      }
  } else {
      error_log("Error: ./config/mysqli_db.php not found!");
  }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <title id="title"></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="theme-color" content="#2563eb" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
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

      /* Specific styles for logoff.php */
      .main {
          flex-grow: 1;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          padding: 20px;
          width: 100%;
      }
      .stats-container {
          background: var(--container-bg);
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
          padding: 24px;
          width: 100%;
          max-width: 360px;
          text-align: center;
      }
      .stats-header {
          font-size: 20px;
          font-weight: 600;
          color: var(--text-color);
          margin-bottom: 20px;
      }
      .logout-confirmation {
          margin-bottom: 24px;
      }
      .confirmation-icon {
          color: #f59e0b; /* Warning color */
          margin-bottom: 16px;
          display: inline-block; /* To center SVG */
      }
      .confirmation-icon svg {
          width: 64px;
          height: 64px;
      }
      .confirmation-title {
          font-size: 24px;
          font-weight: 700;
          color: var(--text-color);
          margin-bottom: 12px;
      }
      .confirmation-message {
          font-size: 15px;
          color: var(--tab-button-color);
          line-height: 1.5;
      }
      .user-summary {
          background: var(--tab-button-hover-bg); /* Light gray background for summary */
          border-radius: 8px;
          padding: 16px;
          margin-top: 20px;
          text-align: left;
      }
      .summary-title {
          font-size: 16px;
          font-weight: 600;
          color: var(--text-color);
          margin-bottom: 12px;
          display: flex;
          align-items: center;
          gap: 8px;
      }
      .summary-title svg {
          width: 18px;
          height: 18px;
          color: var(--tab-button-color);
      }
      .table2 {
          width: 100%;
          border-collapse: collapse;
      }
      .table2 td {
          padding: 8px 0;
          font-size: 14px;
          border-bottom: 1px solid var(--table-row-border);
      }
      .table2 td:first-child {
          font-weight: 500;
          color: var(--tab-button-color);
          width: 40%;
      }
      .table2 td:last-child {
          font-weight: 600;
          color: var(--text-color);
          text-align: right;
      }
      .table2 tr:last-child td {
          border-bottom: none;
      }
      .button-group {
          display: flex;
          flex-direction: column;
          gap: 12px;
          margin-top: 30px;
          width: 100%;
      }
      .button2 {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 14px 24px;
          border: none;
          border-radius: 8px;
          font-size: 16px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
          text-decoration: none;
          color: white;
          background: var(--btn-primary-bg);
      }
      .button2:hover {
          background: var(--btn-primary-hover-bg);
          transform: translateY(-1px);
      }
      .button2.secondary {
          background: var(--tab-button-color);
      }
      .button2.secondary:hover {
          background: var(--tab-button-hover-bg);
      }
      .btn-icon {
          margin-right: 8px;
      }

      /* Responsive Design */
      @media (max-width: 480px) {
          .container {
              max-width: 100%;
          }
          .main {
              padding: 15px;
          }
          .stats-container {
              padding: 20px;
          }
          .stats-header {
              font-size: 18px;
          }
          .confirmation-icon svg {
              width: 50px;
              height: 50px;
          }
          .confirmation-title {
              font-size: 20px;
          }
          .confirmation-message {
              font-size: 14px;
          }
          .user-summary {
              padding: 12px;
          }
          .summary-title {
              font-size: 15px;
          }
          .table2 td {
              font-size: 13px;
              padding: 6px 0;
          }
          .button2 {
              padding: 12px 20px;
              font-size: 15px;
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

      <div class="main">
          <div class="stats-container" id="main-card">
              <div class="stats-header">Konfirmasi Logout</div>
              <div class="logout-confirmation">
                  <div class="confirmation-icon">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                          <line x1="12" y1="9" x2="12" y2="13"></line>
                          <line x1="12" y1="17" x2="12.01" y2="17"></line>
                      </svg>
                  </div>
                  <h2 class="confirmation-title">Konfirmasi Logout</h2>
                  <p class="confirmation-message">Apakah Anda yakin ingin keluar dari jaringan? Sesi internet Anda akan berakhir.</p>
              </div>
              <?php
              if (!empty($data)) {
                  foreach ($data as $row) {
                      echo '<div class="user-summary">';
                      echo '<div class="summary-title">';
                      echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                      echo 'Sesi Saat Ini';
                      echo '</div>';
                      echo '<table class="table2">';
                      echo '<tr>';
                      echo '<td>Username</td>';
                      echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<td>Waktu Online</td>';
                      echo '<td>' . htmlspecialchars($row['userOnlineTime']) . '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<td>Upload</td>';
                      echo '<td class="info-value upload">' . htmlspecialchars($row['userUpload']) . '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<td>Download</td>';
                      echo '<td class="info-value download">' . htmlspecialchars($row['userDownload']) . '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<td>Total Traffic</td>';
                      echo '<td class="info-value traffic">' . htmlspecialchars($row['userTraffic']) . '</td>';
                      echo '</tr>';
                      echo '</table>';
                      echo '</div>';
                  }
              }
              ?>
              <!-- BUTTON KONFIRMASI -->
              <div class="button-group">
                  <a href="?mac=<?php echo urlencode($mac); ?>&uamip=<?php echo urlencode($uamip); ?>&uamport=<?php echo urlencode($uamport); ?>&loginpath=<?php echo urlencode($loginpath); ?>&confirmed=yes" class="button2">
                      <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                          <polyline points="16 17 21 12 16 7"></polyline>
                          <line x1="21" y1="12" x2="9" y2="12"></line>
                      </svg>
                      Ya, Logout
                  </a>
                  <a href="javascript:history.back()" class="button2 secondary">
                      <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M18 6L6 18"></path>
                          <path d="M6 6l12 12"></path>
                      </svg>
                      Batal
                  </a>
              </div>
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

      document.addEventListener('DOMContentLoaded', function() {
          // Set hostname in title
          var hostname = window.location.hostname;
          document.getElementById('title').innerHTML = hostname + " > Logout Confirmation";
      });
  </script>
</body>
</html>
