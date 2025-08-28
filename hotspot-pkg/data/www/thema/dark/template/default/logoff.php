<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 

// Ambil parameter dari URL
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';
$uamip = isset($_GET['uamip']) ? $_GET['uamip'] : '10.10.10.1';
$uamport = isset($_GET['uamport']) ? $_GET['uamport'] : '3990';
$loginpath = isset($_GET['loginpath']) ? urldecode($_GET['loginpath']) : '';
$confirmed = isset($_GET['confirmed']) ? $_GET['confirmed'] : '';

// Jika sudah konfirmasi, lakukan logout ke ChilliSpot
if ($confirmed === 'yes') {
    // Redirect ke ChilliSpot untuk logout
    $logoutUrl = "http://$uamip:$uamport/logoff";
    header("Location: $logoutUrl");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - Logout</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    
    <!-- CSS tetap sama seperti aslinya -->
    <style>
        /* Semua CSS tetap sama seperti file asli, tambah style untuk konfirmasi */
        :root {
            --primary: #0EA5E9;
            --primary-light: #38BDF8;
            --primary-dark: #0284C7;
            --secondary: #8B5CF6;
            --secondary-light: #A78BFA;
            --secondary-dark: #7C3AED;
            --accent: #06B6D4;
            --accent-light: #22D3EE;
            --accent-dark: #0891B2;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg-dark: #0F172A;
            --bg-dark-2: #1E293B;
            --bg-card: rgba(30, 41, 59, 0.7);
            --bg-card-hover: rgba(30, 41, 59, 0.9);
            --bg-input: rgba(15, 23, 42, 0.6);
            --text-primary: #F8FAFC;
            --text-secondary: #CBD5E1;
            --text-muted: #94A3B8;
            --text-dark: #334155;
            --border-light: rgba(148, 163, 184, 0.2);
            --border-input: rgba(148, 163, 184, 0.3);
            --border-primary: rgba(14, 165, 233, 0.5);
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.1);
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-inner: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-full: 9999px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(139, 92, 246, 0.08) 0%, transparent 25%);
            background-attachment: fixed;
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 1.5rem;
            max-width: 100%;
            width: 100%;
        }

        .content-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease;
            position: relative;
        }

        .logo-container {
            display: inline-block;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .logo {
            width: 160px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .logo-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 180px;
            height: 80px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
            z-index: -1;
            border-radius: var(--radius-full);
        }

        .site-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary-light), var(--secondary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .site-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .main-card {
            width: 100%;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            overflow: hidden;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease;
            padding: 1.5rem;
        }

        .logout-confirmation {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .confirmation-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--warning), #D97706);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .confirmation-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .confirmation-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--warning);
            margin-bottom: 0.5rem;
        }

        .confirmation-message {
            font-size: 1rem;
            color: var(--text-secondary);
            text-align: center;
            max-width: 320px;
            margin-bottom: 1rem;
        }

        .user-summary {
            background: rgba(15, 23, 42, 0.5);
            border-radius: var(--radius);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .summary-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .summary-title svg {
            margin-right: 0.5rem;
            color: var(--primary-light);
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 0.75rem 0;
            vertical-align: middle;
        }

        .info-table td:first-child {
            width: 40%;
            text-align: right;
            padding-right: 1rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .info-table td:last-child {
            color: var(--text-primary);
        }

        .info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 50%;
            margin-left: 0.5rem;
            color: var(--primary-light);
        }

        .info-value {
            display: flex;
            align-items: center;
        }

        .info-value.upload {
            color: var(--primary-light);
        }

        .info-value.download {
            color: var(--secondary-light);
        }

        .info-value.traffic {
            color: var(--accent-light);
        }

        .info-value.time {
            color: var(--warning);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            position: relative;
            overflow: hidden;
            width: 100%;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #DC2626);
            color: white;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            color: white;
            box-shadow: 0 4px 6px rgba(139, 92, 246, 0.25);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(139, 92, 246, 0.3);
        }

        .btn-icon {
            margin-right: 0.5rem;
        }

        .button-group {
            display: flex;
            gap: 0.75rem;
            width: 100%;
        }

        .button-group .btn {
            margin-bottom: 0;
        }

        .footer {
            text-align: center;
            margin-top: 1rem;
            padding: 1rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            animation: fadeInUp 0.8s ease;
        }

        .contact-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-light);
            text-decoration: none;
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(14, 165, 233, 0.1);
            border-radius: var(--radius-full);
            transition: all 0.3s ease;
        }

        .contact-link:hover {
            background: rgba(14, 165, 233, 0.2);
            transform: translateY(-1px);
        }

        .contact-icon {
            margin-right: 0.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 1rem;
            }
            
            .button-group {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="main-container">
        <div class="content-container">
            <!-- 
            <header class="header">
                <div class="logo-container">
                    <img src="/RadMonv2/img/logo/radmon-logo.png" alt="Logo" class="logo">
                    <div class="logo-glow"></div>
                </div>
                 <h2 class="confirmation-title">Konfirmasi Logout</h2>
            </header>
             -->

            <!-- Main Card -->
            <div class="main-card" id="main-card">
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
                if ($mac) {
                    
                    require '../../config/mysqli_db.php';

                    $mac_address = $mac;
                    $query = "SELECT username, AcctStartTime, AcctStopTime, AcctSessionTime,
                            NASIPAddress, CalledStationId, FramedIPAddress, CallingStationId, AcctInputOctets, AcctOutputOctets 
                            FROM radacct
                            WHERE callingstationid = '$mac_address' ORDER BY RadAcctId DESC LIMIT 1";

                    $result = $conn->query($query);

                    $data = array();

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
                
                    if (!empty($data)) {
                        foreach ($data as $row) {
                            echo '<div class="user-summary">';
                            echo '<div class="summary-title">';
                            echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                            echo 'Sesi Saat Ini';
                            echo '</div>';
                            
                            echo '<table class="info-table">';
                            
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
                }

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
                ?>

                <!-- BUTTON KONFIRMASI -->
                <div class="button-group">
                    <a href="?mac=<?php echo urlencode($mac); ?>&uamip=<?php echo urlencode($uamip); ?>&uamport=<?php echo urlencode($uamport); ?>&loginpath=<?php echo urlencode($loginpath); ?>&confirmed=yes" class="btn btn-danger">
                        <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Ya, Logout
                    </a>
                    
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6L6 18"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>

            <!-- Footer
            <footer class="footer">
                <p>Butuh bantuan? Hubungi kami</p>
                <a href="https://wa.me/<?php echo isset($admin_number) ? $admin_number : ''; ?>" class="contact-link">
                    <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <?php echo isset($formatted) ? $formatted : 'Hubungi Admin'; ?>
                </a>
            </footer>
             -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set hostname in title
            var hostname = window.location.hostname;
            document.getElementById('title').innerHTML = hostname + " > Logout Confirmation";
        });
    </script>
</body>
</html>