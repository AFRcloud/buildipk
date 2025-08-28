<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/

// Asumsi file ini akan diakses setelah login, dan $mac sudah tersedia dari MikroTik
// atau dari parameter URL.
// Pastikan 'mysqli_db.php' ada dan menginisialisasi $conn dengan benar.
require './config/mysqli_db.php';

// Fungsi-fungsi PHP yang dibutuhkan
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

$mac_address = isset($_GET['mac']) ? $_GET['mac'] : '';
$data = array();
$username = '';
$userIPAddress = '';
$userMacAddress = '';
$userDownload = '';
$userUpload = '';
$userTraffic = '';
$userLastConnected = '';
$userOnlineTime = '';
$userExpired = '';
$userKuota = '';
$totalSession = 0;
$totalKuota = 0;

if (!empty($mac_address) && $conn) {
    $mac_address_escaped = $conn->real_escape_string($mac_address);

    $query = "SELECT username, AcctStartTime,CASE WHEN AcctStopTime is NULL THEN timestampdiff(SECOND,AcctStartTime,NOW()) ELSE AcctSessionTime END AS AcctSessionTime,
              NASIPAddress,CalledStationId,FramedIPAddress,CallingStationId,AcctInputOctets,AcctOutputOctets
              FROM radacct
              WHERE callingstationid = '$mac_address_escaped' ORDER BY RadAcctId DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $userIPAddress = $row['FramedIPAddress'];
        $userMacAddress = $row['CallingStationId'];
        $userDownload = toxbyte($row['AcctOutputOctets']);
        $userUpload = toxbyte($row['AcctInputOctets']);
        $userTraffic = toxbyte($row['AcctOutputOctets'] + $row['AcctInputOctets']);
        $userLastConnected = $row['AcctStartTime'];
        $userOnlineTime = time2str($row['AcctSessionTime']);

        // Fetch total session
        $sqlUser = "SELECT username FROM radacct WHERE callingstationid='$mac_address_escaped' ORDER BY acctstarttime DESC LIMIT 1;";
        $resultUser = mysqli_fetch_assoc(mysqli_query($conn, $sqlUser));
        $user = $resultUser['username'];

        $sqlTotalSession = "SELECT g.value as total_session FROM radgroupcheck as g, radusergroup as u WHERE u.username = '$user' AND g.groupname = u.groupname AND g.attribute ='Max-All-Session';";
        $resultTotalSession = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotalSession));
        $totalSession = isset($resultTotalSession['total_session']) ? $resultTotalSession['total_session'] : 0;

        // Fetch total kuota
        $sqlTotalKuota = "SELECT VALUE AS total_kuota
                          FROM radgroupreply
                          WHERE ATTRIBUTE = 'ChilliSpot-Max-Total-Octets'
                            AND GROUPNAME = (
                                SELECT GROUPNAME
                                FROM radusergroup
                                WHERE USERNAME = '$user'
                            )";
        $resultTotalKuota = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotalKuota));
        if (is_array($resultTotalKuota) && isset($resultTotalKuota['total_kuota'])) {
            $totalKuota = $resultTotalKuota['total_kuota'];
        } else {
            $totalKuota = 0;
        }

        // Fetch kuota digunakan
        $sqlKuotaDigunakan = "SELECT SUM(acctinputoctets + acctoutputoctets) as kuota_terpakai FROM radacct WHERE username = '$user';";
        $resultKuotaDigunakan = mysqli_fetch_assoc(mysqli_query($conn, $sqlKuotaDigunakan));
        $KuotaDigunakan = $resultKuotaDigunakan['kuota_terpakai'];

        // Calculate remaining time and kuota
        $sqlFirstLogin = "SELECT acctstarttime AS first_login FROM radacct WHERE username='$user' ORDER BY acctstarttime ASC LIMIT 1;";
        $resultFirstLogin = mysqli_fetch_assoc(mysqli_query($conn, $sqlFirstLogin));
        $firstLogin = $resultFirstLogin['first_login'];
        $duration = $totalSession; // Assuming totalSession is in seconds
        $expiryTime = strtotime($firstLogin) + $duration;

        $sisaKuota = $totalKuota - $KuotaDigunakan;
        $remainingTime = $expiryTime - time();

        $userExpired = time2str($remainingTime);
        $userKuota = toxbyte($sisaKuota);
    }
    $conn->close();
}
?>
<!doctype html>
<html lang="en" data-theme="dark">
<head>
  <title id="title"></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="theme-color" content="#1a202c" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
  <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
      <style>
      /* ===== CSS VARIABLES - DARK THEME SYSTEM ===== */
      /* Replaced light theme with consistent 5-color dark system */
      :root {
          /* Primary Colors - Dark Theme */
          --primary-dark: #1a202c;
          --primary-blue: #3b82f6;
          --primary-green: #10b981;
          
          /* Neutral Colors */
          --neutral-white: #ffffff;
          --neutral-light: #f1f5f9;
          --neutral-medium: #64748b;
          
          /* Theme Variables - Dark as Default */
          /* Local Theme - Alternative Dark Palette */
          --bg-color: #0f172a;
          --container-bg: #1e293b;
          --text-color: #e2e8f0;
          --header-bg: #334155;
          --header-text: var(--neutral-white);
          --tab-border: #475569;
          --tab-button-color: #94a3b8;
          --tab-button-active-color: #06b6d4;
          --tab-button-active-bg: #1e293b;
          --tab-button-hover-bg: #334155;
          --otp-border: #475569;
          --otp-focus-border: #06b6d4;
          --otp-filled-border: var(--primary-green);
          --otp-filled-bg: rgba(16, 185, 129, 0.1);
          --table-header-bg: #1e293b;
          --table-border: #475569;
          --table-row-border: #334155;
          --modal-overlay-bg: rgba(0, 0, 0, 0.8);
          --modal-bg: #1e293b;
          --modal-text: #e2e8f0;
          --whatsapp-color: var(--primary-green);
          --qr-button-bg: #dc2626;
          --qr-button-hover-bg: #b91c1c;
          --btn-primary-bg: #06b6d4;
          --btn-primary-hover-bg: #0891b2;
          --btn-secondary-bg: var(--primary-green);
          --btn-secondary-hover-bg: #059669;
          --btn-outline-border: #06b6d4;
          --btn-outline-text: #06b6d4;
          --btn-outline-hover-bg: #06b6d4;
          --btn-outline-hover-text: var(--neutral-white);
          --scrollbar-track: #1e293b;
          --scrollbar-thumb: #475569;
          --scrollbar-thumb-hover: #64748b;
      }


      /* ===== RESET AND BASE STYLES ===== */
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
      /* Tab Navigation */
      .tab-nav {
          display: flex;
          background: var(--container-bg);
          border-bottom: 1px solid var(--tab-border);
      }
      .tab-button {
          flex: 1;
          padding: 16px 20px;
          background: transparent;
          border: none;
          font-size: 14px;
          font-weight: 500;
          cursor: pointer;
          color: var(--tab-button-color);
          border-bottom: 2px solid transparent;
          transition: all 0.2s ease;
      }
      .tab-button.active {
          color: var(--tab-button-active-color);
          border-bottom-color: var(--tab-button-active-color);
          background: var(--tab-button-active-bg);
      }
      .tab-button:hover:not(.active) {
          color: var(--tab-button-color);
          background: var(--tab-button-hover-bg);
      }
      /* Tab Content (used as general content padding) */
      .tab-content {
          padding: 24px 20px;
      }
      .tab-pane {
          display: none;
      }
      .tab-pane.active {
          display: block;
          animation: fadeIn 0.3s ease;
      }
      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(8px); }
          to { opacity: 1; transform: translateY(0); }
      }
      /* Login Content (general info text) */
      .login-info {
          color: var(--tab-button-color);
          font-size: 14px;
          line-height: 1.5;
          margin-bottom: 20px;
      }
      .whatsapp-info {
          color: var(--tab-button-color);
          font-size: 14px;
          margin-bottom: 24px;
      }
      .whatsapp-number {
          color: var(--whatsapp-color);
          font-weight: 600;
          text-decoration: none;
      }
      .whatsapp-number:hover {
          text-decoration: underline;
      }
      /* OTP Input Container */
      .otp-container {
          display: flex;
          justify-content: center;
          gap: 12px;
          margin: 32px 0;
      }
      .otp-input {
          width: 48px;
          height: 56px;
          text-align: center;
          font-size: 20px;
          font-weight: 600;
          border: 2px solid var(--otp-border);
          border-radius: 8px;
          background: var(--container-bg);
          transition: all 0.2s ease;
          text-transform: uppercase;
          color: var(--text-color);
      }
      .otp-input:focus {
          outline: none;
          border-color: var(--otp-focus-border);
          box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
      }
      .otp-input:not(:placeholder-shown) {
          border-color: var(--otp-filled-border);
          background: var(--otp-filled-bg);
      }
      /* Buttons */
      .button-group {
          display: flex;
          flex-direction: column;
          gap: 12px;
          margin-top: 32px;
      }
      .btn {
          width: 100%;
          padding: 14px 20px;
          border: none;
          border-radius: 8px;
          font-size: 16px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
      }
      .btn-primary {
          background: var(--btn-primary-bg);
          color: white;
      }
      .btn-primary:hover {
          background: var(--btn-primary-hover-bg);
          transform: translateY(-1px);
      }
      .btn-secondary {
          background: var(--btn-secondary-bg);
          color: white;
      }
      .btn-secondary:hover {
          background: var(--btn-secondary-hover-bg);
          transform: translateY(-1px);
      }
      .btn-outline {
          background: var(--container-bg);
          color: var(--btn-outline-text);
          border: 2px solid var(--btn-outline-border);
      }
      .btn-outline:hover {
          background: var(--btn-outline-hover-bg);
          color: var(--btn-outline-hover-text);
      }
      /* Hidden inputs */
      .hidden-input {
          position: absolute;
          left: -9999px;
          opacity: 0;
      }
      /* Package Table */
      .package-header {
          color: var(--text-color);
          font-size: 16px;
          font-weight: 600;
          margin-bottom: 16px;
          text-align: center;
      }
      .table-container {
          background: var(--container-bg);
          border-radius: 8px;
          overflow: hidden;
          border: 1px solid var(--table-border);
          max-height: 400px;
          overflow-y: auto;
      }
      table {
          width: 100%;
          border-collapse: collapse;
      }
      table th {
          background: var(--table-header-bg);
          padding: 12px 8px;
          text-align: center;
          font-size: 14px;
          font-weight: 600;
          color: var(--text-color);
          border-bottom: 1px solid var(--table-border);
      }
      table td {
          padding: 12px 8px;
          text-align: center;
          font-size: 14px;
          border-bottom: 1px solid var(--table-row-border);
          color: var(--text-color);
      }
      table tbody tr:hover {
          background: var(--tab-button-hover-bg);
      }
      .buy-btn {
          background: #f59e0b;
          color: white;
          border: none;
          padding: 6px 12px;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
      }
      .buy-btn:hover {
          background: #d97706;
          transform: translateY(-1px);
      }
      /* QR Code Button */
      .qr-button {
          background: var(--qr-button-bg);
          color: white;
          border: none;
          padding: 12px 20px;
          border-radius: 8px;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
          margin-bottom: 20px;
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
      }
      .qr-button:hover {
          background: var(--qr-button-hover-bg);
          transform: translateY(-1px);
      }
      /* Modal Styles */
      .modal-overlay {
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
      .modal-content {
          background: var(--modal-bg);
          padding: 24px;
          border-radius: 12px;
          box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
          max-width: 400px;
          width: 90%;
          text-align: center;
          color: var(--modal-text);
      }
      .modal-content p {
          margin-bottom: 20px;
          color: var(--modal-text);
          line-height: 1.5;
      }
      .modal-buttons {
          display: flex;
          gap: 12px;
          justify-content: center;
      }
      .modal-btn {
          padding: 10px 20px;
          border: none;
          border-radius: 6px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
      }
      .modal-btn-primary {
          background: var(--btn-primary-bg);
          color: white;
      }
      .modal-btn-secondary {
          background: var(--tab-button-color);
          color: white;
      }
      /* Loading Screen */
      .loading-screen {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: var(--container-bg);
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          z-index: 1001;
          color: var(--text-color);
      }
      .loading-spinner {
          width: 40px;
          height: 40px;
          border: 4px solid var(--tab-border);
          border-top: 4px solid var(--btn-primary-bg);
          border-radius: 50%;
          animation: spin 1s linear infinite;
          margin-bottom: 16px;
      }
      @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
      }
      /* Responsive Design */
      @media (max-width: 480px) {
          .container {
              max-width: 100%;
          }
          .otp-container {
              gap: 8px;
          }
          .otp-input {
              width: 44px;
              height: 52px;
              font-size: 18px;
          }
          .tab-content {
              padding: 20px 16px;
          }
          table th, table td {
              padding: 8px 4px;
              font-size: 12px;
          }
          .buy-btn {
              padding: 4px 8px;
              font-size: 11px;
          }
      }
      /* Custom Scrollbar */
      .table-container::-webkit-scrollbar {
          width: 4px;
      }
      .table-container::-webkit-scrollbar-track {
          background: var(--scrollbar-track);
      }
      .table-container::-webkit-scrollbar-thumb {
          background: var(--scrollbar-thumb);
          border-radius: 2px;
      }
      .table-container::-webkit-scrollbar-thumb:hover {
          background: var(--scrollbar-thumb-hover);
      }

      /* Specific styles for this page */
      .user-info-section {
          text-align: center;
          margin-bottom: 20px;
      }
      .user-info-section h3 {
          font-size: 24px;
          font-weight: 600;
          color: var(--text-color);
          margin-bottom: 8px;
      }
      .user-info-section svg { /* Target SVG directly */
          font-size: 50px;
          color: var(--tab-button-color);
          margin-bottom: 10px;
      }
      .user-info-section h2 {
          font-size: 28px;
          font-weight: 700;
          color: var(--btn-primary-bg); /* Use primary color for username */
      }
      .info-table {
          width: 100%;
          border-collapse: collapse;
          margin-bottom: 24px;
          background: var(--container-bg); /* Ensure table background matches container */
          border-radius: 8px; /* Match container border-radius */
          overflow: hidden; /* For rounded corners */
      }
      .info-table tr {
          display: flex; /* Make rows flex containers */
          justify-content: space-between; /* Distribute items */
          align-items: center; /* Vertically align items */
          padding: 14px 20px; /* More padding for rows */
          border-bottom: 1px solid var(--table-row-border);
      }
      .info-table tr:last-child {
          border-bottom: none; /* No border for the last row */
      }
      .info-table td {
          padding: 0; /* Remove default td padding as it's on tr now */
          font-size: 15px;
          color: var(--text-color);
          flex-grow: 1; /* Allow cells to grow */
          display: flex; /* Make td a flex container for icon and text */
          align-items: center;
          gap: 8px; /* Space between text and icon */
      }
      .info-table td:first-child {
          text-align: left; /* Align label to left */
          font-weight: 500;
          color: var(--tab-button-color);
          flex-basis: 50%; /* Give first column a base width */
          justify-content: flex-start; /* Align content to start */
      }
      .info-table td:last-child {
          text-align: right; /* Align value to right */
          font-weight: 600;
          flex-basis: 50%; /* Give second column a base width */
          justify-content: flex-end; /* Align content to end */
      }
      .info-table svg { /* Target SVG directly */
          width: 16px; /* Ensure consistent icon size */
          height: 16px;
          color: var(--scrollbar-thumb); /* Use a neutral icon color */
          flex-shrink: 0; /* Prevent icon from shrinking */
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
      </div>

      <div class="tab-content">
          <form action="http://10.10.10.1:3990/logoff" name="logout" onsubmit="return openLogout()">
              <div class="user-info-section">
                  <h3>Welcome</h3>
                  <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-circle"><path d="M18 20a6 6 0 0 0-12 0"/><circle cx="12" cy="10" r="4"/></svg>
                  <h2 id="user"><?php echo htmlspecialchars($username); ?></h2>
              </div>

              <table class="info-table">
                  <tr>
                      <td>IP Address <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-network"><rect x="16" y="16" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="9" y="2" width="6" height="6" rx="1"/><path d="M6 16v-4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v4"/><path d="M12 10V8"/><path d="M12 6V2"/></svg></td>
                      <td><?php echo htmlspecialchars($userIPAddress); ?></td>
                  </tr>
                  <tr>
                      <td>MAC Address <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-barcode"><path d="M3 5v14"/><path d="M8 5v14"/><path d="M12 5v14"/><path d="M17 5v14"/><path d="M21 5v14"/></svg></td>
                      <td><?php echo htmlspecialchars($userMacAddress); ?></td>
                  </tr>
                  <tr>
                      <td>Upload <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></td>
                      <td><div id="upload"><?php echo htmlspecialchars($userUpload); ?></div></td>
                  </tr>
                  <tr>
                      <td>Download <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></td>
                      <td><div id="download"><?php echo htmlspecialchars($userDownload); ?></div></td>
                  </tr>
                  <tr>
                      <td>Total Traffic <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-right"><path d="M8 3L4 7L8 11"/><path d="M4 7h16"/><path d="M16 21l4-4l-4-4"/><path d="M20 17H4"/></svg></td>
                      <td><div id="traffic"><?php echo htmlspecialchars($userTraffic); ?></div></td>
                  </tr>
                  <tr>
                      <td>Terkoneksi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></td>
                      <td><div id="aktif"><?php echo htmlspecialchars($userOnlineTime); ?></div></td>
                  </tr>
                  <?php if ($totalSession >= 1): ?>
                  <tr>
                      <td>Sisa Waktu <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></td>
                      <td><div id="expired"><?php echo htmlspecialchars($userExpired); ?></div></td>
                  </tr>
                  <?php endif; ?>
                  <?php if ($totalKuota >= 1): ?>
                  <tr>
                      <td>Sisa Kuota <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gauge"><path d="m12 14 4-4"/><path d="M3.34 19.1A8 8 0 1 1 20.7 19.1"/><path d="M17.76 17.76a7 7 0 1 0-2.52 2.52"/></svg></td>
                      <td><div id="kuota"><?php echo htmlspecialchars($userKuota); ?></div></td>
                  </tr>
                  <?php endif; ?>
              </table>

              <div class="button-group">
                  <button class="btn btn-outline" type="submit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="17 16 22 12 17 8"/><line x1="22" y1="12" x2="10" y2="12"/></svg> Logout
                  </button>
              </div>
          </form>
      </div>
  </div>

  <script src="assets/js/jquery-3.6.3.min.js"></script>
  <script type="text/javascript">
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
                      ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>'
                      : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>';
              }
          };

          // Get saved theme or default to dark
          const savedTheme = localStorage.getItem('theme') || 'dark';
          setTheme(savedTheme);

          // Add event listener to toggle button
          if (themeToggleBtn) {
              themeToggleBtn.addEventListener('click', () => {
                  const currentTheme = htmlElement.getAttribute('data-theme');
                  const newTheme = currentTheme === 'dark' ? 'local' : 'dark';
                  setTheme(newTheme);
              });
          }
      });

      // Mengatur judul halaman
      var hostname = window.location.hostname;
      document.getElementById('title').innerHTML = hostname + " > RadMon WiFi";

      // Fungsi openLogout (placeholder, sesuaikan jika ada logika khusus)
      function openLogout() {
          // Anda bisa menambahkan logika konfirmasi atau lainnya di sini
          return true; // Mengizinkan form untuk disubmit
      }

      // Script untuk refresh data secara periodik
      // Pastikan jQuery dimuat sebelum script ini dijalankan
      $(document).ready(function () {
          setInterval(function(){
              // Menggunakan window.location.href untuk memastikan parameter MAC tetap ada
              $("#download").load(window.location.href + " #download");
              $("#upload").load(window.location.href + " #upload");
              $("#traffic").load(window.location.href + " #traffic");
              $("#aktif").load(window.location.href + " #aktif");
              $("#expired").load(window.location.href + " #expired");
              $("#kuota").load(window.location.href + " #kuota");
          },1000); // Refresh setiap 1 detik
      });
  </script>
</body>
</html>
