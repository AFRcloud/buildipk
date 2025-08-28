<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 

require './config/db_config.php';

// Get parameters
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';

// Database connection
$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

// Get admin number from database
$command = "mysql -u {$user} -p{$pass} -h {$host} -D {$db} -e \"SELECT hscsn FROM print_config LIMIT 1\" -s -N";
$admin_number = trim(shell_exec($command));

// Format phone number
if (strpos($admin_number, '62') === 0) {
    $cs_number = '0' . substr($admin_number, 2);
} else {
    $cs_number = $admin_number;
}
$formatted = substr($cs_number, 0, 4) . '-' . substr($cs_number, 4, 4) . '-' . substr($cs_number, 8);
?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - Successful</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <!-- CSS tetap sama seperti aslinya -->
    <style>
        /* Semua CSS tetap sama seperti file asli */
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

        .user-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .user-avatar svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .user-welcome {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .user-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-light);
            margin-bottom: 0.5rem;
        }

        .user-status {
            display: inline-flex;
            align-items: center;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .user-status svg {
            margin-right: 0.35rem;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
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

        .info-value.quota {
            color: var(--success);
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

        .btn-danger:active {
            transform: translateY(0);
        }

        .btn-icon {
            margin-right: 0.5rem;
        }

        .refresh-info {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .refresh-info svg {
            margin-right: 0.25rem;
            animation: spin 2s linear infinite;
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

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(139, 92, 246, 0.08) 0%, transparent 25%);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .loading-logo {
            margin-bottom: 2rem;
            width: 180px;
            height: auto;
            animation: pulse 2s infinite;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(56, 189, 248, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s linear infinite;
            margin-bottom: 1.5rem;
        }

        .loading-text {
            color: var(--text-secondary);
            font-size: 1rem;
            letter-spacing: 0.05em;
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

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="pleaseWait" class="loading-screen" style="display:none;">
        <img src="/RadMonv2/img/logo/radmon-logo.png" alt="Logo" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-text">Menghubungkan ke jaringan...</div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-container">
            
            <!-- Main Card -->
            <div class="main-card">
                <!-- UBAH: FORM ACTION KE LOGOFF.PHP -->
                <form action="template/<?php echo $template; ?>/logoff.php?mac=<?php echo isset($_GET['mac']) ? $_GET['mac'] : ''; ?>&uamip=<?php echo isset($uamip) ? $uamip : ''; ?>&uamport=<?php echo isset($uamport) ? $uamport : ''; ?>&loginpath=<?php echo urlencode($loginpath); ?>" name="logout" method="get">
                    <?php
                    if (isset($_GET['mac'])) {
                        
                        require './config/mysqli_db.php';

                        $mac_address = $_GET['mac'];
                        $query = "SELECT username, AcctStartTime,CASE WHEN AcctStopTime is NULL THEN timestampdiff(SECOND,AcctStartTime,NOW()) ELSE AcctSessionTime END AS AcctSessionTime,
                                NASIPAddress,CalledStationId,FramedIPAddress,CallingStationId,AcctInputOctets,AcctOutputOctets 
                                FROM radacct
                                WHERE callingstationid = '$mac_address' ORDER BY RadAcctId DESC LIMIT 1";

                        $result = $conn->query($query);

                        $data = array();

                        $sqlUser = "SELECT username FROM radacct WHERE callingstationid='$mac_address' ORDER BY acctstarttime DESC LIMIT 1;";
                        $resultUser = mysqli_fetch_assoc(mysqli_query($conn, $sqlUser));
                        $user = $resultUser['username'];
                                
                        $sqlTotalSession = "SELECT g.value as total_session FROM radgroupcheck as g, radusergroup as u WHERE u.username = '$user' AND g.groupname = u.groupname AND g.attribute ='Max-All-Session';";
                        $resultTotalSession = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotalSession));
                        $totalSession = isset($resultTotalSession['total_session']) ? $resultTotalSession['total_session'] : 0;

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
                        
                        $sqlKuotaDigunakan = "SELECT SUM(acctinputoctets + acctoutputoctets) as kuota_terpakai FROM radacct WHERE username = '$user';";
                        $resultKuotaDigunakan = mysqli_fetch_assoc(mysqli_query($conn, $sqlKuotaDigunakan));
                        $KuotaDigunakan = $resultKuotaDigunakan['kuota_terpakai'];
                
                        $sqlFirstLogin = "SELECT acctstarttime AS first_login FROM radacct WHERE username='$user' ORDER BY acctstarttime ASC LIMIT 1;";
                        $resultFirstLogin = mysqli_fetch_assoc(mysqli_query($conn, $sqlFirstLogin));
                        $firstLogin = $resultFirstLogin['first_login'];

                        $duration = $totalSession;
                        $expiryTime = strtotime($firstLogin) + $duration;
                        
                        $sisaKuota = $totalKuota - $KuotaDigunakan;

                        $remainingTime = $expiryTime - time();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $username = $row['username'];
                                $userUpload = toxbyte($row['AcctInputOctets']);
                                $userDownload = toxbyte($row['AcctOutputOctets']);
                                $userTraffic = toxbyte($row['AcctOutputOctets'] + $row['AcctInputOctets']);
                                $userLastConnected = $row['AcctStartTime'];
                                $userOnlineTime = time2str($row['AcctSessionTime']);
                                $nasIPAddress = $row['NASIPAddress'];
                                $nasMacAddress = $row['CalledStationId'];
                                $userIPAddress = $row['FramedIPAddress'];
                                $userMacAddress = $row['CallingStationId'];
                                $userExpired = time2str($remainingTime);
                                $UserKuota = toxbyte($sisaKuota);
                                
                                $data[] = array(
                                'username' => $username,
                                'userIPAddress' => $userIPAddress,
                                'userMacAddress' => $userMacAddress,
                                'userDownload' => $userDownload,
                                'userUpload' => $userUpload,
                                'userTraffic' => $userTraffic,
                                'userLastConnected' => $userLastConnected,
                                'userOnlineTime' => $userOnlineTime,
                                'userExpired' => $userExpired,
                                'userKuota' => $UserKuota,
                                );
                            }
                        }

                        $conn->close();
                    
                        foreach ($data as $row) {
                            echo '<div class="user-profile">';
                            echo '<div class="user-avatar">';
                            echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                            echo '</div>';
                            echo '<div class="user-welcome">Selamat Datang</div>';
                            echo '<div class="user-name" id="user">' . htmlspecialchars($row['username']) . '</div>';
                            echo '<div class="user-status">';
                            echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
                            echo 'Anda Telah Terhubung';
                            echo '</div>';
                            echo '</div>';
                            
                            echo '<table class="info-table">';
                            
                            echo '<tr>';
                            echo '<td>IP Address <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></div></td>';
                            echo '<td>' . htmlspecialchars($row['userIPAddress']) . '</td>';
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td>MAC <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><line x1="2" y1="10" x2="22" y2="10"></line></svg></div></td>';
                            echo '<td>' . htmlspecialchars($row['userMacAddress']) . '</td>';
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td>Upload <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg></div></td>';
                            echo '<td><div class="info-value upload" id="upload">' . htmlspecialchars($row['userUpload']) . '</div></td>';
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td>Download <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></div></td>';
                            echo '<td><div class="info-value download" id="download">' . htmlspecialchars($row['userDownload']) . '</div></td>';
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td>Total Traffic <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></div></td>';
                            echo '<td><div class="info-value traffic" id="traffic">' . htmlspecialchars($row['userTraffic']) . '</div></td>';
                            echo '</tr>';
                            
                            echo '<tr>';
                            echo '<td>Terkoneksi <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div></td>';
                            echo '<td><div class="info-value time" id="aktif">' . htmlspecialchars($row['userOnlineTime']) . '</div></td>';
                            echo '</tr>';
                            
                            if ($totalSession >= 1) {
                                echo '<tr>';
                                echo '<td>Sisa Waktu <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div></td>';
                                echo '<td><div class="info-value time" id="expired">' . htmlspecialchars($row['userExpired']) . '</div></td>';
                                echo '</tr>';
                            }
                            
                            if ($totalKuota >= 1) {
                                echo '<tr>';
                                echo '<td>Sisa Kuota <div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg></div></td>';
                                echo '<td><div class="info-value quota" id="kuota">' . htmlspecialchars($row['userKuota']) . '</div></td>';
                                echo '</tr>';
                            }
                            
                            echo '</table>';
                            
                            echo '<button class="btn btn-danger" type="submit">';
                            echo '<svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>';
                            echo 'Logout';
                            echo '</button>';
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
                </form>
                
                <div class="refresh-info">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                    </svg>
                    Data diperbarui secara otomatis
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <p>Butuh bantuan? Hubungi kami</p>
                <a href="https://wa.me/<?php echo $admin_number ?>" class="contact-link">
                    <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <?php echo $formatted ?>
                </a>
            </footer>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.3.min.js"></script>
    <script>
    const adminNumber = "<?php echo $admin_number; ?>";
    
        $(document).ready(function () {
            // Set hostname in title
            var hostname = window.location.hostname;
            document.getElementById('title').innerHTML = hostname + " > Connected";
            
            // Auto refresh data
            setInterval(function(){
                $("#download").load(window.location.href + " #download");
                $("#upload").load(window.location.href + " #upload");
                $("#traffic").load(window.location.href + " #traffic");
                $("#aktif").load(window.location.href + " #aktif");
                $("#expired").load(window.location.href + " #expired");
                $("#kuota").load(window.location.href + " #kuota");
            }, 1000);
        });
    </script>
</body>
</html>