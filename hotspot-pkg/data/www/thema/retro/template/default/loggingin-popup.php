<?php
/* *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.
 **********************************************************************************************************/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>AFR-Cloud.NET | Connecting...</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
                linear-gradient(rgba(255, 46, 99, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 46, 99, 0.1) 1px, transparent 1px);
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

        /* Container */
        .container-fluid {
            width: 100%;
            max-width: 600px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .alert-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
        }

        /* Alert Box - Retro Cyberpunk Style */
        .alert {
            background-color: var(--light-bg);
            border: 2px solid var(--primary-color);
            box-shadow: 
                0 0 20px rgba(255, 46, 99, 0.3),
                5px 5px 0 var(--primary-color);
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            text-align: center;
            animation: alertPulse 2s ease-in-out infinite alternate;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, 
                var(--secondary-color) 0%, 
                var(--primary-color) 50%, 
                var(--accent-color) 100%);
            animation: colorShift 3s ease-in-out infinite;
        }

        .alert::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 10px;
            height: 10px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        @keyframes alertPulse {
            0% {
                box-shadow: 
                    0 0 20px rgba(255, 46, 99, 0.3),
                    5px 5px 0 var(--primary-color);
            }
            100% {
                box-shadow: 
                    0 0 30px rgba(255, 46, 99, 0.5),
                    5px 5px 0 var(--primary-color);
            }
        }

        @keyframes colorShift {
            0% {
                background: linear-gradient(90deg, 
                    var(--secondary-color) 0%, 
                    var(--primary-color) 50%, 
                    var(--accent-color) 100%);
            }
            33% {
                background: linear-gradient(90deg, 
                    var(--accent-color) 0%, 
                    var(--secondary-color) 50%, 
                    var(--primary-color) 100%);
            }
            66% {
                background: linear-gradient(90deg, 
                    var(--primary-color) 0%, 
                    var(--accent-color) 50%, 
                    var(--secondary-color) 100%);
            }
            100% {
                background: linear-gradient(90deg, 
                    var(--secondary-color) 0%, 
                    var(--primary-color) 50%, 
                    var(--accent-color) 100%);
            }
        }

        @keyframes blink {
            0%, 50% {
                opacity: 1;
            }
            51%, 100% {
                opacity: 0;
            }
        }

        /* Typography */
        .alert h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--light-text);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            position: relative;
            animation: textGlitch 3s infinite;
        }

        .alert h1::before,
        .alert h1::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .alert h1::before {
            left: -2px;
            text-shadow: 2px 0 var(--secondary-color);
            animation: glitch-1 2s infinite ease-in-out;
            opacity: 0.8;
        }

        .alert h1::after {
            left: 2px;
            text-shadow: -2px 0 var(--primary-color);
            animation: glitch-2 2s infinite ease-in-out reverse;
            opacity: 0.8;
        }

        @keyframes textGlitch {
            0%, 90%, 100% {
                transform: translate(0);
            }
            10% {
                transform: translate(-2px, 0);
            }
            20% {
                transform: translate(2px, 0);
            }
            30% {
                transform: translate(-2px, 0);
            }
            40% {
                transform: translate(2px, 0);
            }
            50% {
                transform: translate(0);
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

        /* Divider */
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                var(--secondary-color) 20%, 
                var(--primary-color) 50%, 
                var(--accent-color) 80%, 
                transparent 100%);
            margin: 2rem 0;
            animation: dividerGlow 2s ease-in-out infinite alternate;
        }

        @keyframes dividerGlow {
            0% {
                opacity: 0.7;
                filter: brightness(1);
            }
            100% {
                opacity: 1;
                filter: brightness(1.3);
            }
        }

        /* Message Text */
        .mb-0 {
            margin-bottom: 0;
            font-size: 1.125rem;
            color: var(--light-text-secondary);
            font-weight: 500;
            letter-spacing: 1px;
            position: relative;
        }

        /* Loading Animation */
        .loading-dots {
            display: inline-block;
            position: relative;
            margin-left: 0.5rem;
        }

        .loading-dots::after {
            content: '';
            animation: loadingDots 1.5s infinite;
        }

        @keyframes loadingDots {
            0%, 20% {
                content: '';
            }
            40% {
                content: '.';
            }
            60% {
                content: '..';
            }
            80%, 100% {
                content: '...';
            }
        }

        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 4px;
            background-color: var(--darker-bg);
            margin-top: 2rem;
            position: relative;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, 
                var(--secondary-color) 0%, 
                var(--primary-color) 50%, 
                var(--accent-color) 100%);
            width: 0;
            animation: progressFill 3s ease-in-out infinite;
        }

        @keyframes progressFill {
            0% {
                width: 0;
                transform: translateX(0);
            }
            50% {
                width: 100%;
                transform: translateX(0);
            }
            100% {
                width: 100%;
                transform: translateX(100%);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }
            
            .alert {
                padding: 2rem 1.5rem;
            }
            
            .alert h1 {
                font-size: 1.5rem;
            }
            
            .mb-0 {
                font-size: 1rem;
            }
        }

        @media screen and (max-width: 480px) {
            .alert {
                padding: 1.5rem 1rem;
            }
            
            .alert h1 {
                font-size: 1.25rem;
                letter-spacing: 1px;
            }
            
            .mb-0 {
                font-size: 0.875rem;
            }
        }

        /* Additional Cyberpunk Elements */
        .cyber-corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid var(--secondary-color);
        }

        .cyber-corner.top-left {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .cyber-corner.top-right {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }

        .cyber-corner.bottom-left {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }

        .cyber-corner.bottom-right {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }

        /* Scanning Line Effect */
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
            animation: scanLine 2s linear infinite;
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
    </style>
</head>

<body>
    <!-- Retro Grid Background -->
    <div class="retro-bg"></div>

    <?php
    // Set default values if variables are not defined
    $h1Loggingin = isset($h1Loggingin) ? $h1Loggingin : 'CONNECTING TO NETWORK';
    $centerPleasewait = isset($centerPleasewait) ? $centerPleasewait : 'Please wait while we establish your connection';

    echo "<div class='container-fluid'>";
    echo "<div class='alert-wrapper text-center'>";
    echo "<div class='alert alert-primary text-center' role='alert'>";
    
    // Add cyberpunk corner elements
    echo "<div class='cyber-corner top-left'></div>";
    echo "<div class='cyber-corner top-right'></div>";
    echo "<div class='cyber-corner bottom-left'></div>";
    echo "<div class='cyber-corner bottom-right'></div>";
    
    // Add scanning line effect
    echo "<div class='scan-line'></div>";
    
    // Main content
    echo "<h1 data-text='" . strtoupper($h1Loggingin) . "'>" . strtoupper($h1Loggingin) . "</h1>";
    echo "<hr>";
    echo "<p class='mb-0'>" . $centerPleasewait . "<span class='loading-dots'></span></p>";
    
    // Add progress bar
    echo "<div class='progress-container'>";
    echo "<div class='progress-bar'></div>";
    echo "</div>";
    
    echo "</div>";
    echo "</div>";
    echo "</div>";
    ?>

    <script>
        // Auto-refresh or redirect logic can be added here
        // For example, redirect after a certain time
        setTimeout(function() {
            // You can add redirect logic here if needed
            // window.location.href = 'success-page.php';
        }, 5000);

        // Add some dynamic effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add random glitch effects
            setInterval(function() {
                const alert = document.querySelector('.alert');
                if (Math.random() < 0.1) { // 10% chance
                    alert.style.transform = 'translate(' + (Math.random() * 4 - 2) + 'px, ' + (Math.random() * 4 - 2) + 'px)';
                    setTimeout(function() {
                        alert.style.transform = 'translate(0, 0)';
                    }, 100);
                }
            }, 500);
        });
    </script>
</body>
</html>
