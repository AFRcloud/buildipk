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
// unset($_SESSION['transaksi_sukses']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pembayaran Berhasil | AFR-Cloud.NET</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="icon" type="image" href="assets/images/favicon.ico" sizes="32x32">
    <style>
        /* Base Styles - Retro Cyberpunk Theme */
        :root {
            --primary-color: #ff2e63;
            --secondary-color: #08d9d6;
            --accent-color: #f9c80e;
            --success-color: #2ed573;
            --warning-color: #ffa502;
            --dark-bg: #1a1a2e;
            --darker-bg: #16213e;
            --light-bg: #252a34;
            --light-text: #eaeaea;
            --light-text-secondary: #b2b2b2;
            --dark-text: #1a1a2e;
            --transition-speed: 0.3s;
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
                linear-gradient(rgba(8, 217, 214, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(8, 217, 214, 0.1) 1px, transparent 1px);
            background-size: 25px 25px;
            perspective: 1000px;
            animation: gridMove 30s linear infinite;
        }
        .retro-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: radial-gradient(circle at center,
                rgba(8, 217, 214, 0.05) 0%,
                rgba(26, 26, 46, 0.8) 70%,
                rgba(26, 26, 46, 0.95) 100%);
        }
        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 25px 25px;
            }
        }
        /* Header */
        .header {
            width: 100%;
            padding: 1.5rem;
            background-color: var(--darker-bg);
            border-bottom: 2px solid var(--secondary-color);
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
            content: ''; /* Update this if your logo text is different */
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
            text-shadow: 2px 0 var(--accent-color);
            animation: glitch-2 2s infinite ease-in-out reverse;
            opacity: 0.8;
        }
        .logo-highlight {
            color: var(--secondary-color);
        }
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-dot {
            width: 12px;
            height: 12px;
            background-color: var(--accent-color);
            border-radius: 50%;
            animation: paymentPulse 2s ease-in-out infinite;
        }
        @keyframes paymentPulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(249, 200, 14, 0.7);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.2);
                box-shadow: 0 0 0 10px rgba(249, 200, 14, 0);
            }
        }
        /* Payment Container (used for success message) */
        .payment-container {
            flex: 1;
            width: 92%;
            max-height: 400px;
            max-width: 480px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: var(--light-bg);
            border: 2px solid var(--secondary-color);
            box-shadow:
                0 0 30px rgba(8, 217, 214, 0.3),
                10px 10px 0 var(--secondary-color);
            position: relative;
            overflow: hidden;
            animation: containerEntry 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        @keyframes containerEntry {
            0% {
                transform: scale(0.8) translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }
        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg,
                var(--secondary-color) 0%,
                var(--accent-color) 50%,
                var(--primary-color) 100%);
            animation: paymentGlow 3s ease-in-out infinite;
        }
        @keyframes paymentGlow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
                filter: brightness(1.3);
            }
        }
        .payment-container::after {
            content: ''; /* Changed icon for success */
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            animation: paymentIcon 2s ease-in-out infinite;
        }
        @keyframes paymentIcon {
            0%, 100% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(10deg);
            }
        }
        /* Payment Title */
        .payment-container h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--success-color); /* Changed color for success */
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: 1.5rem;
            position: relative;
            animation: titleGlitch 4s infinite;
        }
        @keyframes titleGlitch {
            0%, 90%, 100% {
                transform: translate(0);
            }
            10% {
                transform: translate(-2px, 0);
            }
            20% {
                transform: translate(2px, 0);
            }
        }
        /* Payment Info */
        .pay-info {
            color: var(--light-text);
            text-align: center;
            margin-bottom: 1rem; /* Adjusted margin */
            font-size: 1rem;
            font-weight: 500;
        }
        .pay-info strong {
            color: var(--accent-color);
            font-weight: 700;
        }
        /* Voucher specific styling */
        #voucher-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border: 1px dashed var(--secondary-color);
            background-color: rgba(8, 217, 214, 0.1);
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        #voucher-container:hover {
            background-color: rgba(8, 217, 214, 0.2);
            box-shadow: 0 0 10px rgba(8, 217, 214, 0.5);
        }
        #voucher {
            color: var(--accent-color); /* Changed color for voucher */
            font-weight: bold;
            font-size: 1.1rem;
            letter-spacing: 1px;
            text-shadow: 0 0 5px rgba(249, 200, 14, 0.5);
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
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-color);
            font-weight: bold;
            border-radius: 4px;
            animation: copiedFadeIn 0.3s ease-out;
        }
        @keyframes copiedFadeIn {
            0% { opacity: 0; transform: translateY(5px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: center;
        }
        .btn {
            padding: 1rem 2rem;
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            min-width: 140px;
            text-decoration: none; /* For anchor tag */
            display: inline-flex; /* For anchor tag */
            align-items: center;
            justify-content: center;
        }
        .btn::before {
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
        .btn:hover::before {
            left: 100%;
        }
        .btn-download { /* Used for Login button */
            background-color: var(--secondary-color);
            color: var(--dark-bg);
        }
        .btn-download:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(8, 217, 214, 0.4);
        }
        .btn:active {
            transform: translateY(0);
        }
        /* Cyberpunk Corners */
        .cyber-corner {
            position: absolute;
            width: 25px;
            height: 25px;
            border: 2px solid var(--secondary-color);
            opacity: 0.7;
        }
        .cyber-corner.top-left {
            top: 15px;
            left: 15px;
            border-right: none;
            border-bottom: none;
            animation: cornerGlow 3s ease-in-out infinite alternate;
        }
        .cyber-corner.top-right {
            top: 15px;
            right: 15px;
            border-left: none;
            border-bottom: none;
            animation: cornerGlow 3s ease-in-out infinite alternate 0.5s;
        }
        .cyber-corner.bottom-left {
            bottom: 15px;
            left: 15px;
            border-right: none;
            border-top: none;
            animation: cornerGlow 3s ease-in-out infinite alternate 1s;
        }
        .cyber-corner.bottom-right {
            bottom: 15px;
            right: 15px;
            border-left: none;
            border-top: none;
            animation: cornerGlow 3s ease-in-out infinite alternate 1.5s;
        }
        @keyframes cornerGlow {
            0% {
                opacity: 0.7;
                border-color: var(--secondary-color);
            }
            100% {
                opacity: 1;
                border-color: var(--accent-color);
                filter: drop-shadow(0 0 5px var(--accent-color));
            }
        }
        /* Scan Line Effect */
        .scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg,
                transparent 0%,
                var(--secondary-color) 50%,
                transparent 100%);
            animation: scanLine 4s linear infinite;
        }
        @keyframes scanLine {
            0% {
                top: 0;
                opacity: 1;
            }
            100% {
                top: 100%;
                opacity: 0;
            }
        }
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .payment-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            .payment-container h2 {
                font-size: 1.5rem;
            }
            .button-group {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
        @media screen and (max-width: 480px) {
            .payment-container {
                margin: 0.5rem;
                padding: 1rem;
            }
            .payment-container h2 {
                font-size: 1.25rem;
            }
        }
        /* Animations */
        @keyframes textShadow {
            0% {                text-shadow: 0.4389924193300864px 0 1px rgba(8, 217, 214, 0.5), -0.4389924193300864px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            5% {                text-shadow: 2.7928974010788217px 0 1px rgba(8, 217, 214, 0.5), -2.7928974010788217px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            10% {                text-shadow: 0.02956275843481219px 0 1px rgba(8, 217, 214, 0.5), -0.02956275843481219px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            15% {                text-shadow: 0.40218538552878136px 0 1px rgba(8, 217, 214, 0.5), -0.40218538552878136px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            20% {                text-shadow: 3.4794037899852017px 0 1px rgba(8, 217, 214, 0.5), -3.4794037899852017px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            25% {                text-shadow: 1.6125630401149584px 0 1px rgba(8, 217, 214, 0.5), -1.6125630401149584px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            30% {                text-shadow: 0.7015590085143956px 0 1px rgba(8, 217, 214, 0.5), -0.7015590085143956px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            35% {                text-shadow: 3.896914047650351px 0 1px rgba(8, 217, 214, 0.5), -3.896914047650351px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            40% {                text-shadow: 3.870905614848819px 0 1px rgba(8, 217, 214, 0.5), -3.870905614848819px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            45% {                text-shadow: 2.231056963361899px 0 1px rgba(8, 217, 214, 0.5), -2.231056963361899px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            50% {                text-shadow: 0.08084290417898504px 0 1px rgba(8, 217, 214, 0.5), -0.08084290417898504px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            55% {                text-shadow: 2.3758461067427543px 0 1px rgba(8, 217, 214, 0.5), -2.3758461067427543px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            60% {                text-shadow: 2.202193051050636px 0 1px rgba(8, 217, 214, 0.5), -2.202193051050636px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            65% {                text-shadow: 2.8638780614874975px 0 1px rgba(8, 217, 214, 0.5), -2.8638780614874975px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            70% {                text-shadow: 0.48874025155497314px 0 1px rgba(8, 217, 214, 0.5), -0.48874025155497314px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            75% {                text-shadow: 1.8948491305757957px 0 1px rgba(8, 217, 214, 0.5), -1.8948491305757957px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            80% {                text-shadow: 0.0833037308038857px 0 1px rgba(8, 217, 214, 0.5), -0.0833037308038857px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            85% {                text-shadow: 0.09769827255241735px 0 1px rgba(8, 217, 214, 0.5), -0.09769827255241735px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            90% {                text-shadow: 3.443339761481782px 0 1px rgba(8, 217, 214, 0.5), -3.443339761481782px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            95% {                text-shadow: 2.1841838852799786px 0 1px rgba(8, 217, 214, 0.5), -2.1841838852799786px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }            100% {                text-shadow: 2.6208764473832513px 0 1px rgba(8, 217, 214, 0.5), -2.6208764473832513px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;            }        }
        @keyframes glitch-1 {
            0% {                clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);                transform: translate(0);            }            10% {                clip-path: polygon(0 15%, 100% 15%, 100% 40%, 0 40%);                transform: translate(-3px, 0);            }            20% {                clip-path: polygon(0 10%, 100% 10%, 100% 50%, 0 50%);                transform: translate(3px, 0);            }            30% {                clip-path: polygon(0 30%, 100% 30%, 100% 65%, 0 65%);                transform: translate(0, 0);            }            40% {                clip-path: polygon(0 45%, 100% 45%, 100% 60%, 0 60%);                transform: translate(3px, 0);            }            50% {                clip-path: polygon(0 25%, 100% 25%, 100% 35%, 0 35%);                transform: translate(-3px, 0);            }            60% {                clip-path: polygon(0 40%, 100% 40%, 100% 80%, 0 80%);                transform: translate(3px, 0);            }            70% {                clip-path: polygon(0 60%, 100% 60%, 100% 75%, 0 75%);                transform: translate(-3px, 0);            }            80% {                clip-path: polygon(0 75%, 100% 75%, 100% 90%, 0 90%);                transform: translate(0, 0);            }            90% {                clip-path: polygon(0 80%, 100% 80%, 100% 100%, 0 100%);                transform: translate(-3px, 0);            }            100% {                clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);                transform: translate(0, 0);            }        }
        @keyframes glitch-2 {
            0% {                clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);                transform: translate(0);            }            15% {                clip-path: polygon(0 65%, 100% 65%, 100% 80%, 0 80%);                transform: translate(5px, 0);            }            30% {                clip-path: polygon(0 75%, 100% 75%, 100% 100%, 0 100%);                transform: translate(-5px, 0);            }            45% {                clip-path: polygon(0 85%, 100% 85%, 100% 95%, 0 95%);                transform: translate(0, 0);            }            60% {                clip-path: polygon(0 55%, 100% 55%, 100% 70%, 0 70%);                transform: translate(5px, 0);            }            75% {                clip-path: polygon(0 70%, 100% 70%, 100% 85%, 0 85%);                transform: translate(-5px, 0);            }            90% {                clip-path: polygon(0 80%, 100% 80%, 100% 95%, 0 95%);                transform: translate(5px, 0);            }            100% {                clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);                transform: translate(0, 0);            }        }
        @keyframes successFlash {
            0% { background-color: var(--dark-bg); }
            50% { background-color: rgba(46, 213, 115, 0.2); }
            100% { background-color: var(--dark-bg); }
        }
    </style>
</head>
<body>
    <!-- Retro Grid Background -->
    <div class="retro-bg"></div>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-text"><span class="logo-highlight"></span></div>
            <div class="status-indicator">
                <div class="status-dot" style="background-color: var(--success-color); animation: none;"></div> <!-- Static green dot for success -->
                SUCCESS
            </div>
        </div>
    </header>

    <!-- Payment Container (used for success message) -->
    <div class="payment-container">
        <!-- Cyberpunk Corners -->
        <div class="cyber-corner top-left"></div>
        <div class="cyber-corner top-right"></div>
        <div class="cyber-corner bottom-left"></div>
        <div class="cyber-corner bottom-right"></div>

        <!-- Scan Line Effect -->
        <div class="scan-line"></div>

        <h2>Pembayaran Berhasil!</h2>
        <p class="pay-info"><strong>Paket:</strong> <?= $plan_name ?></p>
        <p class="pay-info"><strong>Harga:</strong> Rp <?= number_format((int)$harga, 0, ',', '.') ?></p>
        <p class="pay-info"><strong>ReffID:</strong> <?= $reff ?></p>
        <p class="pay-info">
            <strong>Kode Voucher:</strong>
            <span id="voucher-container" onclick="copyVoucher()">
                <span id="voucher"><?= $username ?></span>
                <span id="copied">Tersalin!</span>
            </span>
        </p>
        <div class="button-group">
            <a href="http://10.10.10.1:3990/login?username=<?= $username ?>&password=Accept" class="btn btn-download">
                Login Sekarang
            </a>
        </div>
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

            const copiedSpan = document.getElementById("copied");
            copiedSpan.style.display = "flex"; // Use flex to center text
            setTimeout(() => {
                copiedSpan.style.display = "none";
            }, 2000);
        }

        // Add some dynamic effects from the example
        window.onload = function() {
            document.body.style.animation = 'successFlash 0.5s ease-out'; // Flash green on load

            setInterval(function() {
                const paymentContainer = document.querySelector('.payment-container');
                if (Math.random() < 0.05) { // 5% chance
                    paymentContainer.style.transform = 'translate(' + (Math.random() * 4 - 2) + 'px, ' + (Math.random() * 4 - 2) + 'px)';
                    setTimeout(function() {
                        paymentContainer.style.transform = 'translate(0, 0)';
                    }, 100);
                }
            }, 3000);
        };
    </script>
</body>
</html>