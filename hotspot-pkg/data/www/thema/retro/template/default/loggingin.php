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
    <title>AFR-Cloud.NET | Redirecting...</title>
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
            height: 90vh;
            overflow: hidden;
            display: flex;
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
            background-size: 30px 30px;
            perspective: 1000px;
            animation: gridMove 25s linear infinite;
        }

        .retro-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: radial-gradient(circle at center,
                rgba(26, 26, 46, 0.3) 0%,
                rgba(26, 26, 46, 0.7) 70%,
                rgba(26, 26, 46, 0.9) 100%);
        }

        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 30px 30px;
            }
        }

        /* Main Container */
        .redirect-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Logo/Brand */
        .brand-logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--light-text);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 2rem;
            position: relative;
            animation: logoGlitch 4s infinite;
        }

        .brand-logo::before,
        .brand-logo::after {
            content: 'AFR-CLOUD.NET';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .brand-logo::before {
            left: -2px;
            text-shadow: 2px 0 var(--secondary-color);
            animation: glitch-1 3s infinite ease-in-out;
            opacity: 0.8;
        }

        .brand-logo::after {
            left: 2px;
            text-shadow: -2px 0 var(--primary-color);
            animation: glitch-2 3s infinite ease-in-out reverse;
            opacity: 0.8;
        }

        .brand-highlight {
            color: var(--primary-color);
        }

        @keyframes logoGlitch {
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

        /* Status Message */
        .status-message {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            animation: statusPulse 2s ease-in-out infinite alternate;
        }

        @keyframes statusPulse {
            0% {
                opacity: 0.7;
                transform: scale(1);
            }
            100% {
                opacity: 1;
                transform: scale(1.05);
            }
        }

        /* Loading Animation */
        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 3px solid var(--darker-bg);
            border-top: 3px solid var(--primary-color);
            border-right: 3px solid var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: relative;
        }

        .loading-spinner::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            border: 2px solid transparent;
            border-top: 2px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1.5s linear infinite reverse;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Progress Bar */
        .progress-container {
            width: 300px;
            height: 6px;
            background-color: var(--darker-bg);
            border: 1px solid var(--primary-color);
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
            animation: progressFill 5s ease-in-out forwards;
            position: relative;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.5) 100%);
            animation: progressShine 1s ease-in-out infinite;
        }

        @keyframes progressFill {
            0% {
                width: 0;
            }
            100% {
                width: 100%;
            }
        }

        @keyframes progressShine {
            0% {
                transform: translateX(-20px);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateX(20px);
                opacity: 0;
            }
        }

        /* Loading Text */
        .loading-text {
            color: var(--light-text-secondary);
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .loading-dots {
            display: inline-block;
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

        /* Click to Continue */
        .click-continue {
            position: absolute;
            bottom: 3rem;
            left: 50%;
            transform: translateX(-50%);
            color: var(--light-text-secondary);
            font-size: 0.875rem;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border: 1px solid var(--primary-color);
            background-color: rgba(255, 46, 99, 0.1);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: clickPulse 2s ease-in-out infinite;
        }

        .click-continue:hover {
            background-color: var(--primary-color);
            color: var(--dark-bg);
            transform: translateX(-50%) translateY(-2px);
            text-decoration: none;
        }

        @keyframes clickPulse {
            0%, 100% {
                box-shadow: 0 0 5px rgba(255, 46, 99, 0.3);
            }
            50% {
                box-shadow: 0 0 20px rgba(255, 46, 99, 0.6);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .brand-logo {
                font-size: 2rem;
                letter-spacing: 2px;
            }
            
            .status-message {
                font-size: 1.25rem;
            }
            
            .loading-spinner {
                width: 60px;
                height: 60px;
            }
            
            .loading-spinner::before {
                width: 45px;
                height: 45px;
            }
            
            .progress-container {
                width: 250px;
            }
        }

        @media screen and (max-width: 480px) {
            .brand-logo {
                font-size: 1.5rem;
                letter-spacing: 1px;
            }
            
            .status-message {
                font-size: 1rem;
            }
            
            .loading-spinner {
                width: 50px;
                height: 50px;
            }
            
            .loading-spinner::before {
                width: 35px;
                height: 35px;
            }
            
            .progress-container {
                width: 200px;
            }
            
            .click-continue {
                bottom: 2rem;
                font-size: 0.75rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Cyberpunk Decorations */
        .cyber-decoration {
            position: absolute;
            width: 100px;
            height: 100px;
            border: 1px solid var(--secondary-color);
            opacity: 0.3;
        }

        .cyber-decoration.top-left {
            top: 2rem;
            left: 2rem;
            border-right: none;
            border-bottom: none;
            animation: decorationGlow 3s ease-in-out infinite alternate;
        }

        .cyber-decoration.top-right {
            top: 2rem;
            right: 2rem;
            border-left: none;
            border-bottom: none;
            animation: decorationGlow 3s ease-in-out infinite alternate 0.5s;
        }

        .cyber-decoration.bottom-left {
            bottom: 2rem;
            left: 2rem;
            border-right: none;
            border-top: none;
            animation: decorationGlow 3s ease-in-out infinite alternate 1s;
        }

        .cyber-decoration.bottom-right {
            bottom: 2rem;
            right: 2rem;
            border-left: none;
            border-top: none;
            animation: decorationGlow 3s ease-in-out infinite alternate 1.5s;
        }

        @keyframes decorationGlow {
            0% {
                opacity: 0.3;
                border-color: var(--secondary-color);
            }
            100% {
                opacity: 0.8;
                border-color: var(--primary-color);
            }
        }
    </style>

    <script type="text/javascript" language="Javascript">
        //<!--
        function getURLParam(name) {
            var params = new URLSearchParams(window.location.search);
            return params.get(name);
        }

        var loginUrl = 'http://10.10.10.1:3990/prelogin';

        function redirect() {
            if (loginUrl) {
                window.location = loginUrl;
            } else {
                console.error('Login URL is not defined.');
            }
            return false;
        }

        window.onload = function() {
            var paramUrl = getURLParam("loginurl");
            if (paramUrl) {
                loginUrl = paramUrl;
            }
            setTimeout(redirect, 5000);
        }

        // Add some dynamic effects
        document.addEventListener('DOMContentLoaded', function() {
            // Random glitch effects
            setInterval(function() {
                const brand = document.querySelector('.brand-logo');
                if (Math.random() < 0.05) { // 5% chance
                    brand.style.transform = 'translate(' + (Math.random() * 6 - 3) + 'px, ' + (Math.random() * 6 - 3) + 'px)';
                    setTimeout(function() {
                        brand.style.transform = 'translate(0, 0)';
                    }, 100);
                }
            }, 1000);

            // Update loading text periodically
            const loadingTexts = [
                'Initializing connection',
                'Establishing secure link',
                'Authenticating credentials',
                'Finalizing setup'
            ];
            let textIndex = 0;
            const loadingTextElement = document.querySelector('.loading-text');
            
            setInterval(function() {
                if (loadingTextElement) {
                    textIndex = (textIndex + 1) % loadingTexts.length;
                    loadingTextElement.innerHTML = loadingTexts[textIndex] + '<span class="loading-dots"></span>';
                }
            }, 1500);
        });
        //-->
    </script>
</head>

<body>
    <!-- Retro Grid Background -->
    <div class="retro-bg"></div>

    <!-- Cyberpunk Decorations -->
    <div class="cyber-decoration top-left"></div>
    <div class="cyber-decoration top-right"></div>
    <div class="cyber-decoration bottom-left"></div>
    <div class="cyber-decoration bottom-right"></div>

    <!-- Main Container -->
    <div class="redirect-container">
        <!-- Brand Logo -->
        <div class="brand-logo">
            AFR-<span class="brand-highlight">CLOUD</span>.NET
        </div>

        <!-- Status Message -->
        <div class="status-message">
            Redirecting to Network
        </div>

        <!-- Loading Container -->
        <div class="loading-container">
            <!-- Loading Spinner -->
            

            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>

            <!-- Loading Text -->
            <div class="loading-text">
                Initializing connection<span class="loading-dots"></span>
            </div>
        </div>

    </div>
</body>
</html>
