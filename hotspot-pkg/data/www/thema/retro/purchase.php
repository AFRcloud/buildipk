<?php
/* *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.
 **********************************************************************************************************/

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
    <title>AFR-Cloud.NET | Payment</title>
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

        /* Payment Container */
        .payment-container {
            flex: 1;
            width: 93%;
            max-width: 400px;
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
            content: '💳';
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
            color: var(--secondary-color);
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
            margin-bottom: 1.5rem;
            font-size: 1rem;
            font-weight: 500;
        }

        .pay-info strong {
            color: var(--accent-color);
            font-weight: 700;
        }

        /* QR Code */
        .qr-code {
            width: 280px;
            height: 280px;
            display: block;
            margin: 2rem auto;
            border: 3px solid var(--secondary-color);
            box-shadow: 
                0 0 20px rgba(8, 217, 214, 0.4),
                inset 0 0 20px rgba(8, 217, 214, 0.1);
            position: relative;
            animation: qrPulse 3s ease-in-out infinite;
        }

        @keyframes qrPulse {
            0%, 100% {
                box-shadow: 
                    0 0 20px rgba(8, 217, 214, 0.4),
                    inset 0 0 20px rgba(8, 217, 214, 0.1);
            }
            50% {
                box-shadow: 
                    0 0 30px rgba(8, 217, 214, 0.6),
                    inset 0 0 30px rgba(8, 217, 214, 0.2);
            }
        }

        /* Total Payment */
        #total-pembayaran {
            color: var(--accent-color);
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(249, 200, 14, 0.5);
        }

        /* Countdown */
        .countdown {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            text-shadow: 0 0 10px rgba(255, 46, 99, 0.5);
            animation: countdownBlink 1s infinite;
        }

        @keyframes countdownBlink {
            0%, 50% {
                opacity: 1;
            }
            51%, 100% {
                opacity: 0.7;
            }
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

        .btn-download {
            background-color: var(--secondary-color);
            color: var(--dark-bg);
        }

        .btn-download:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(8, 217, 214, 0.4);
        }

        .btn-status {
            background-color: var(--primary-color);
            color: var(--light-text);
        }

        .btn-status:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 46, 99, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Custom Confirm Dialog */
        .confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(26, 26, 46, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: overlayFadeIn 0.3s ease-out;
        }

        @keyframes overlayFadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .confirm-box {
            background-color: var(--light-bg);
            border: 2px solid var(--accent-color);
            box-shadow: 
                0 0 30px rgba(249, 200, 14, 0.4),
                inset 0 0 20px rgba(249, 200, 14, 0.1),
                10px 10px 0 var(--accent-color);
            padding: 2.5rem 2rem;
            max-width: 450px;
            width: 90%;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: confirmBoxEntry 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes confirmBoxEntry {
            0% {
                transform: scale(0.8) translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .confirm-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, 
                var(--accent-color) 0%, 
                var(--secondary-color) 50%, 
                var(--primary-color) 100%);
            animation: confirmGlow 2s ease-in-out infinite;
        }

        @keyframes confirmGlow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
                filter: brightness(1.3);
            }
        }

        .confirm-box::after {
            content: 'ℹ️';
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.2rem;
            animation: infoBlink 2s infinite;
        }

        @keyframes infoBlink {
            0%, 50% {
                opacity: 1;
            }
            51%, 100% {
                opacity: 0.5;
            }
        }

        .confirm-box p {
            font-size: 1.125rem;
            color: var(--light-text);
            font-weight: 500;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .confirm-actions {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .btn-confirm {
            padding: 1rem 2rem;
            background-color: var(--accent-color);
            color: var(--dark-bg);
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
            min-width: 120px;
        }

        .btn-confirm::before {
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

        .btn-confirm:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 200, 14, 0.4);
        }

        .btn-confirm:hover::before {
            left: 100%;
        }

        .btn-confirm:active {
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
            
            .qr-code {
                width: 280px;
                height: 280px;
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
            
            .qr-code {
                width: 280px;
                height: 280px;
            }
            
            .countdown {
                font-size: 1.5rem;
            }
            
            #total-pembayaran {
                font-size: 1.25rem;
            }
        }

        /* Animations */
        @keyframes textShadow {
            0% {
                text-shadow: 0.4389924193300864px 0 1px rgba(8, 217, 214, 0.5), -0.4389924193300864px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            5% {
                text-shadow: 2.7928974010788217px 0 1px rgba(8, 217, 214, 0.5), -2.7928974010788217px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            10% {
                text-shadow: 0.02956275843481219px 0 1px rgba(8, 217, 214, 0.5), -0.02956275843481219px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            15% {
                text-shadow: 0.40218538552878136px 0 1px rgba(8, 217, 214, 0.5), -0.40218538552878136px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            20% {
                text-shadow: 3.4794037899852017px 0 1px rgba(8, 217, 214, 0.5), -3.4794037899852017px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            25% {
                text-shadow: 1.6125630401149584px 0 1px rgba(8, 217, 214, 0.5), -1.6125630401149584px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            30% {
                text-shadow: 0.7015590085143956px 0 1px rgba(8, 217, 214, 0.5), -0.7015590085143956px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            35% {
                text-shadow: 3.896914047650351px 0 1px rgba(8, 217, 214, 0.5), -3.896914047650351px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            40% {
                text-shadow: 3.870905614848819px 0 1px rgba(8, 217, 214, 0.5), -3.870905614848819px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            45% {
                text-shadow: 2.231056963361899px 0 1px rgba(8, 217, 214, 0.5), -2.231056963361899px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            50% {
                text-shadow: 0.08084290417898504px 0 1px rgba(8, 217, 214, 0.5), -0.08084290417898504px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            55% {
                text-shadow: 2.3758461067427543px 0 1px rgba(8, 217, 214, 0.5), -2.3758461067427543px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            60% {
                text-shadow: 2.202193051050636px 0 1px rgba(8, 217, 214, 0.5), -2.202193051050636px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            65% {
                text-shadow: 2.8638780614874975px 0 1px rgba(8, 217, 214, 0.5), -2.8638780614874975px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            70% {
                text-shadow: 0.48874025155497314px 0 1px rgba(8, 217, 214, 0.5), -0.48874025155497314px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            75% {
                text-shadow: 1.8948491305757957px 0 1px rgba(8, 217, 214, 0.5), -1.8948491305757957px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            80% {
                text-shadow: 0.0833037308038857px 0 1px rgba(8, 217, 214, 0.5), -0.0833037308038857px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            85% {
                text-shadow: 0.09769827255241735px 0 1px rgba(8, 217, 214, 0.5), -0.09769827255241735px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            90% {
                text-shadow: 3.443339761481782px 0 1px rgba(8, 217, 214, 0.5), -3.443339761481782px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            95% {
                text-shadow: 2.1841838852799786px 0 1px rgba(8, 217, 214, 0.5), -2.1841838852799786px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
            }
            100% {
                text-shadow: 2.6208764473832513px 0 1px rgba(8, 217, 214, 0.5), -2.6208764473832513px 0 1px rgba(249, 200, 14, 0.3), 0 0 3px;
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
    <!-- Retro Grid Background -->
    <div class="retro-bg"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-text"><span class="logo-highlight"></span></div>
            <div class="status-indicator">
                <div class="status-dot"></div>
                PAYMENT
            </div>
        </div>
    </header>

    <!-- Custom Confirm Dialog -->
    <div id="customConfirm" class="confirm-overlay" style="display: none;">
        <div class="confirm-box">
            <!-- Cyberpunk Corners -->
            <div class="cyber-corner top-left"></div>
            <div class="cyber-corner top-right"></div>
            <div class="cyber-corner bottom-left"></div>
            <div class="cyber-corner bottom-right"></div>
            
            <!-- Scan Line Effect -->
            <div class="scan-line"></div>
            
            <p id="confirmMessage"></p>
            <div class="confirm-actions">
                <button id="confirmYes" class="btn-confirm">OK</button>
            </div>
        </div>
    </div>

    <!-- Payment Container -->
    <div class="payment-container">
        <!-- Cyberpunk Corners -->
        <div class="cyber-corner top-left"></div>
        <div class="cyber-corner top-right"></div>
        <div class="cyber-corner bottom-left"></div>
        <div class="cyber-corner bottom-right"></div>
        
        <!-- Scan Line Effect -->
        <div class="scan-line"></div>
        
        <h2>Pembayaran Paket</h2>
        <p class="pay-info">Silahkan scan QRIS di bawah ini:</p>
        
        <img src="/placeholder.svg" alt="QRIS Code" class="qr-code" id="qrcode">
        
        <p class="pay-info">
            <strong>Total Pembayaran:</strong> 
            <span id="total-pembayaran">Rp 0</span>
        </p>
        
        <p class="pay-info">
            Waktu tersisa: <span id="countdown" class="countdown">5:00</span>
        </p>
        
        <div class="button-group">
            <button class="btn btn-download" onclick="downloadQR()">
                📥 Download
            </button>
            <button class="btn btn-status" onclick="cekStatus()">
                🔍 Cek Status
            </button>
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
            
            // Add visual feedback
            const downloadBtn = document.querySelector('.btn-download');
            const originalText = downloadBtn.innerHTML;
            downloadBtn.innerHTML = '✅ Downloaded';
            downloadBtn.style.backgroundColor = 'var(--success-color)';
            
            setTimeout(() => {
                downloadBtn.innerHTML = originalText;
                downloadBtn.style.backgroundColor = 'var(--secondary-color)';
            }, 2000);
        }

        function checkPaymentStatus(ref) {
            const interval = setInterval(() => {
                fetch(`cek_status.php?ref=${encodeURIComponent(ref)}`)
                    .then(response => response.json())
                    .then(data => {
                        const status = (data.status || "").trim().toUpperCase();
                        if (status === 'PAID') {
                            clearInterval(interval);
                            // Add success animation before redirect
                            document.body.style.animation = 'successFlash 0.5s ease-out';
                            setTimeout(() => {
                                window.location.href = "redirect_sukses.php?username=" + encodeURIComponent(username) + "&paket=" + encodeURIComponent(paket) + "&harga=" + encodeURIComponent(harga) + "&ref=" + encodeURIComponent(ref);
                            }, 500);
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
            let message = `💳 Pembayaran belum diterima!<br><br>Silahkan lakukan pembayaran terlebih dahulu.`;
            showConfirmDialog(message);
            
            // Add visual feedback to button
            const statusBtn = document.querySelector('.btn-status');
            const originalText = statusBtn.innerHTML;
            statusBtn.innerHTML = '🔄 Checking...';
            statusBtn.style.backgroundColor = 'var(--warning-color)';
            
            setTimeout(() => {
                statusBtn.innerHTML = originalText;
                statusBtn.style.backgroundColor = 'var(--primary-color)';
            }, 2000);
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
                showConfirmDialog("❌ Kode referensi tidak ditemukan.");
            }

            showConfirmDialog("⚠️ Jika setelah membayar tapi kode voucher tidak muncul, silahkan hubungi WhatsApp: <br><br>📱 <?php echo $formatted ?>");
        };

        // Add success flash animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes successFlash {
                0% { background-color: var(--dark-bg); }
                50% { background-color: rgba(46, 213, 115, 0.2); }
                100% { background-color: var(--dark-bg); }
            }
        `;
        document.head.appendChild(style);

        // Add some dynamic effects
        setInterval(function() {
            const paymentContainer = document.querySelector('.payment-container');
            if (Math.random() < 0.05) { // 5% chance
                paymentContainer.style.transform = 'translate(' + (Math.random() * 4 - 2) + 'px, ' + (Math.random() * 4 - 2) + 'px)';
                setTimeout(function() {
                    paymentContainer.style.transform = 'translate(0, 0)';
                }, 100);
            }
        }, 3000);
    </script>
</body>
</html>
