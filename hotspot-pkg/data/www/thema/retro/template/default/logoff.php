<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/
// Ambil parameter dari URL
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';
$uamip = isset($_GET['uamip']) ? $_GET['uamip'] : '10.10.10.1';
$uamport = isset($_GET['uamport']) ? $_GET['uamport'] : '3990';
$loginpath = isset($_GET['loginpath']) ? urldecode($_GET['loginpath']) : '';
$confirmed = isset($_GET['confirmed']) ? $_GET['confirmed'] : '';

// DEBUG: Tampilkan nilai parameter awal
// echo "<!-- DEBUG: MAC: " . htmlspecialchars($mac) . " -->\n";
// echo "<!-- DEBUG: Confirmed: " . htmlspecialchars($confirmed) . " -->\n";

// Jika sudah konfirmasi, lakukan logout ke ChilliSpot
if ($confirmed === 'yes') {
    // Redirect ke ChilliSpot untuk logout
    $logoutUrl = "http://$uamip:$uamport/logoff";
    header("Location: $logoutUrl");
    exit; // Penting: Pastikan skrip berhenti di sini setelah redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - Logout</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
<meta name="viewport" content="width=360, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <style>
        /* Base Styles - Retro Cyberpunk Theme */
        :root {
            --primary-color: #ff2e63;
            --secondary-color: #08d9d6;
            --accent-color: #f9c80e;
            --success-color: #2ed573;
            --dark-bg: #1a1a2e;
            --darker-bg: #16213e;
            --light-bg: #252a34;
            --light-text: #eaeaea;
            --light-text-secondary: #b2b2b2;
            --dark-text: #1a1a2e;
            --transition-speed: 0.3s;
            --danger-color: #ff2e63; /* Explicitly define for disconnected status */
        }
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, "segoe ui", Verdana, Roboto, "helvetica neue", Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            background: var(--dark-bg);
            color: var(--light-text);
            line-height: 1.5;
            min-height: 100vh;
            padding: 0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        /* Retro Grid Background */
        .retro-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background-color: var(--dark-bg);
            background-image:
                linear-gradient(rgba(46, 213, 115, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(46, 213, 115, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            perspective: 1000px;
            animation: gridMove 20s linear infinite;
        }
        .retro-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(to bottom,
                rgba(26, 26, 46, 0.8) 0%,
                rgba(26, 26, 46, 0.2) 40%,
                rgba(26, 26, 46, 0.2) 60%,
                rgba(26, 26, 46, 0.8) 100%);
        }
        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 20px 20px;
            }
        }
        /* Header */
        .header {
            width: 100%;
            padding: 1.5rem;
            background-color: var(--darker-bg);
            border-bottom: 2px solid var(--primary-color); /* Changed to primary for logout theme */
            position: relative;
            overflow: hidden;
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        .logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--light-text);
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            animation: textShadow 1.5s infinite;
        }
        .logo-text::before,
        .logo-text::after {

            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
            background-color: transparent;
        }
        .logo-text::before {
            left: -2px;
            text-shadow: -2px 0 var(--secondary-color);
            animation: glitch-1 2.5s infinite ease-in-out;
            opacity: 0.8;
        }
        .logo-text::after {
            left: 2px;
            text-shadow: 2px 0 var(--success-color);
            animation: glitch-2 2s infinite ease-in-out reverse;
            opacity: 0.8;
        }
        .logo-highlight {
            color: var(--success-color);
        }
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--danger-color); /* Changed to danger for disconnected */
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-dot {
            width: 12px;
            height: 12px;
            background-color: var(--danger-color); /* Changed to danger for disconnected */
            border-radius: 50%;
            animation: none; /* No pulse for disconnected */
        }

        /* Main Container */
       

        /* Stats Container (Main Card equivalent) */
        .stats-container {
    width: 93%;
    max-width: 400px;
    padding: 2rem;
    background-color: var(--darker-bg);
    border: 2px solid var(--secondary-color);
    box-shadow:
        0 0 30px rgba(8, 217, 214, 0.3),
        10px 10px 0 var(--secondary-color);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    overflow: hidden;
    animation: containerEntry 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

        .stats-header {
            background-color: var(--primary-color); /* Header color for logout card */
            color: var(--dark-bg);
            padding: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            margin: -2rem -2rem 2rem -2rem; /* Adjust to fill card top */
        }

        /* Logout Confirmation Section */
        .logout-confirmation {
            text-align: center;
            margin-bottom: 2rem;
        }
        .confirmation-icon svg {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
            width: 4rem;
            height: 4rem;
            margin-left: auto;
            margin-right: auto;
        }
        .confirmation-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }
        .confirmation-message {
            font-size: 1rem;
            color: var(--light-text-secondary);
            margin-bottom: 1.5rem;
        }

        /* User Summary Card Styling */
        .user-summary { /* Original class name, applying card-like styles */
            background-color: var(--darker-bg); /* Slightly darker background for summary */
            border: 1px solid var(--accent-color);
            box-shadow: 3px 3px 0 var(--accent-color);
            margin-top: 2rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .user-summary .summary-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(249, 200, 14, 0.3);
        }
        .user-summary .summary-title svg {
            width: 24px;
            height: 24px;
            color: var(--accent-color);
        }

        /* Stats Table (info-table equivalent) */
        .table2 {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }
        .table2 tr {
            border-bottom: 1px solid rgba(255, 46, 99, 0.2); /* Border color for logout theme */
            transition: all 0.3s ease;
        }
        .table2 tr:last-child {
            border-bottom: none;
        }
        .table2 tr:hover {
            background-color: rgba(255, 46, 99, 0.1); /* Hover color for logout theme */
        }
        .table2 td {
            padding: 1rem;
            color: var(--light-text);
            font-size: 0.875rem;
            position: relative;
        }
        .table2 td:first-child {
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 40%;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .table2 td:last-child {
            font-weight: 500;
            color: var(--light-text);
            text-align: right;
        }
        .info-value.upload { color: var(--success-color); }
        .info-value.download { color: var(--secondary-color); }
        .info-value.traffic { color: var(--accent-color); }
        .info-value.time { color: var(--primary-color); }
        .info-value.quota { color: var(--success-color); }


        /* Button Group */
        .button-group {
            display: flex;
            flex-direction: column; /* Stack buttons on small screens */
            gap: 1rem;
            margin-top: 2rem;
            padding: 0 1rem;
        }

        /* Buttons */
        .button2 {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            font-size: 1rem;
            gap: 0.5rem;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .button2::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }
        .button2:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 46, 99, 0.4);
        }
        .button2:hover::before {
            left: 100%;
        }
        .button2:active {
            transform: translateY(0);
        }
        .btn-icon {
            width: 18px;
            height: 18px;
            color: var(--light-text);
        }

        .button2.secondary {
            background-color: var(--darker-bg);
            border: 1px solid var(--secondary-color);
            box-shadow: 0 0 10px rgba(8, 217, 214, 0.3);
        }

        .button2.secondary:hover {
            background-color: var(--secondary-color);
            color: var(--dark-bg);
            box-shadow: 0 0 15px rgba(8, 217, 214, 0.6);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .header {
                padding: 1rem;
            }
            .logo-text {
                font-size: 1.5rem;
            }
            .stats-container {
                padding: 1.5rem;
            }
            .stats-header {
                margin: -1.5rem -1.5rem 1.5rem -1.5rem;
            }
            .confirmation-title {
                font-size: 1.5rem;
            }
            .confirmation-icon svg {
                font-size: 3rem;
                width: 3rem;
                height: 3rem;
            }
            .table2 td {
                padding: 0.75rem;
                font-size: 0.75rem;
            }
        }
        @media screen and (max-width: 480px) {
            .main {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }
            .stats-container {
                padding: 1rem;
            }
            .stats-header {
                margin: -1rem -1rem 1rem -1rem;
            }
            .confirmation-title {
                font-size: 1.25rem;
            }
            .confirmation-icon svg {
                font-size: 2.5rem;
                width: 2.5rem;
                height: 2.5rem;
            }
            .table2 td {
                padding: 0.5rem;
            }
            .table2 td:first-child {
                width: 45%;
            }
            .button-group {
                flex-direction: column;
            }
            .button-group .button2 {
                width: 100%;
            }
        }
        /* Animations */
        @keyframes textShadow {
            0% {
                text-shadow: 0.4389924193300864px 0 1px rgba(46, 213, 115, 0.5), -0.4389924193300864px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            5% {
                text-shadow: 2.7928974010788217px 0 1px rgba(46, 213, 115, 0.5), -2.7928974010788217px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            10% {
                text-shadow: 0.02956275843481219px 0 1px rgba(46, 213, 115, 0.5), -0.02956275843481219px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            15% {
                text-shadow: 0.40218538552878136px 0 1px rgba(46, 213, 115, 0.5), -0.40218538552878136px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            20% {
                text-shadow: 3.4794037899852017px 0 1px rgba(46, 213, 115, 0.5), -3.4794037899852017px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            25% {
                text-shadow: 1.6125630401149584px 0 1px rgba(46, 213, 115, 0.5), -1.6125630401149584px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            30% {
                text-shadow: 0.7015590085143956px 0 1px rgba(46, 213, 115, 0.5), -0.7015590085143956px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            35% {
                text-shadow: 3.896914047650351px 0 1px rgba(46, 213, 115, 0.5), -3.896914047650351px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            40% {
                text-shadow: 3.870905614848819px 0 1px rgba(46, 213, 115, 0.5), -3.870905614848819px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            45% {
                text-shadow: 2.231056963361899px 0 1px rgba(46, 213, 115, 0.5), -2.231056963361899px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            50% {
                text-shadow: 0.08084290417898504px 0 1px rgba(46, 213, 115, 0.5), -0.08084290417898504px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            55% {
                text-shadow: 2.3758461067427543px 0 1px rgba(46, 213, 115, 0.5), -2.3758461067427543px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            60% {
                text-shadow: 2.202193051050636px 0 1px rgba(46, 213, 115, 0.5), -2.202193051050636px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            65% {
                text-shadow: 2.8638780614874975px 0 1px rgba(46, 213, 115, 0.5), -2.8638780614874975px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            70% {
                text-shadow: 0.48874025155497314px 0 1px rgba(46, 213, 115, 0.5), -0.48874025155497314px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            75% {
                text-shadow: 1.8948491305757957px 0 1px rgba(46, 213, 115, 0.5), -1.8948491305757957px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            80% {
                text-shadow: 0.0833037308038857px 0 1px rgba(46, 213, 115, 0.5), -0.0833037308038857px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            85% {
                text-shadow: 0.09769827255241735px 0 1px rgba(46, 213, 115, 0.5), -0.09769827255241735px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            90% {
                text-shadow: 3.443339761481782px 0 1px rgba(46, 213, 115, 0.5), -3.443339761481782px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            95% {
                text-shadow: 2.1841838852799786px 0 1px rgba(46, 213, 115, 0.5), -2.1841838852799786px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
            100% {
                text-shadow: 2.6208764473832513px 0 1px rgba(46, 213, 115, 0.5), -2.6208764473832513px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
            }
        }
        @keyframes glitch-1 {
            0% {
                clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
                transform: translate(0);
            }
            10% {
                clip-path: polygon(0 15%, 100% 15%, 100% 40%, 0 40%);
                transform: translate(-3px, 0);
            }
            20% {
                clip-path: polygon(0 10%, 100% 10%, 100% 50%, 0 50%);
                transform: translate(3px, 0);
            }
            30% {
                clip-path: polygon(0 30%, 100% 30%, 100% 65%, 0 65%);
                transform: translate(0, 0);
            }
            40% {
                clip-path: polygon(0 45%, 100% 45%, 100% 60%, 0 60%);
                transform: translate(3px, 0);
            }
            50% {
                clip-path: polygon(0 25%, 100% 25%, 100% 35%, 0 35%);
                transform: translate(-3px, 0);
            }
            60% {
                clip-path: polygon(0 40%, 100% 40%, 100% 80%, 0 80%);
                transform: translate(3px, 0);
            }
            70% {
                clip-path: polygon(0 60%, 100% 60%, 100% 75%, 0 75%);
                transform: translate(-3px, 0);
            }
            80% {
                clip-path: polygon(0 75%, 100% 75%, 100% 90%, 0 90%);
                transform: translate(0, 0);
            }
            90% {
                clip-path: polygon(0 80%, 100% 80%, 100% 100%, 0 100%);
                transform: translate(-3px, 0);
            }
            100% {
                clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
                transform: translate(0, 0);
            }
        }
        @keyframes glitch-2 {
            0% {
                clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
                transform: translate(0);
            }
            15% {
                clip-path: polygon(0 65%, 100% 65%, 100% 80%, 0 80%);
                transform: translate(5px, 0);
            }
            30% {
                clip-path: polygon(0 75%, 100% 75%, 100% 100%, 0 100%);
                transform: translate(-5px, 0);
            }
            45% {
                clip-path: polygon(0 85%, 100% 85%, 100% 95%, 0 95%);
                transform: translate(0, 0);
            }
            60% {
                clip-path: polygon(0 55%, 100% 55%, 100% 70%, 0 70%);
                transform: translate(5px, 0);
            }
            75% {
                clip-path: polygon(0 70%, 100% 70%, 100% 85%, 0 85%);
                transform: translate(-5px, 0);
            }
            90% {
                clip-path: polygon(0 80%, 100% 80%, 100% 95%, 0 95%);
                transform: translate(5px, 0);
            }
            100% {
                clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
                transform: translate(0, 0);
            }
        }
    </style>
</head>
<body>
    <div class="retro-bg"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-text"><span class="logo-highlight"></span></div>
            <div class="status-indicator">
                <span class="status-dot"></span>
                <span>DISCONNECTED</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
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
            // DEBUG: Cek apakah MAC address diterima
            // echo "<!-- DEBUG: MAC address for query: " . htmlspecialchars($mac) . " -->\n";

            if ($mac) {
                // DEBUG: Cek apakah file koneksi database ditemukan
                // if (!file_exists('../../config/mysqli_db.php')) {
                //     echo "<!-- DEBUG: ERROR: mysqli_db.php not found! -->\n";
                // }
                require '../../config/mysqli_db.php';

                // DEBUG: Cek status koneksi database
                // if ($conn->connect_error) {
                //     echo "<!-- DEBUG: ERROR: Database connection failed: " . $conn->connect_error . " -->\n";
                // } else {
                //     echo "<!-- DEBUG: Database connected successfully. -->\n";
                // }

                $mac_address = $mac;
                $query = "SELECT username, AcctStartTime, AcctStopTime, AcctSessionTime,
                            NASIPAddress, CalledStationId, FramedIPAddress, CallingStationId, AcctInputOctets, AcctOutputOctets
                             FROM radacct
                            WHERE callingstationid = '$mac_address' ORDER BY RadAcctId DESC LIMIT 1";
                $result = $conn->query($query);

                // DEBUG: Tampilkan query SQL
                // echo "<!-- DEBUG: SQL Query: " . htmlspecialchars($query) . " -->\n";

                $data = array();
                if ($result && $result->num_rows > 0) {
                    // DEBUG: Jumlah baris ditemukan
                    // echo "<!-- DEBUG: Rows found: " . $result->num_rows . " -->\n";
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
                } else {
                    // DEBUG: Tidak ada baris ditemukan atau query gagal
                    // echo "<!-- DEBUG: No rows found or query failed. Error: " . $conn->error . " -->\n";
                }
                $conn->close();

                // DEBUG: Cek apakah array data kosong
                // echo "<!-- DEBUG: Data array empty: " . (empty($data) ? 'Yes' : 'No') . " -->\n";

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
    <!-- Footer (tetap dikomentari untuk menjaga fungsionalitas asli) -->
    <!--
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set hostname in title
            var hostname = window.location.hostname;
            document.getElementById('title').innerHTML = hostname + " > Logout Confirmation";
        });
    </script>
</body>
</html>