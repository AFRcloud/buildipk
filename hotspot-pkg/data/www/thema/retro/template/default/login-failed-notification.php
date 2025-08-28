<?php
/* *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.
 **********************************************************************************************************/

function showCustomAlert($message) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>AFR-Cloud.NET | Login Failed</title>
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
                --error-color: #ff4757;
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
                font-family: "DM Sans", -apple-system, BlinkMacSystemFont, "segoe ui", Verdana, Roboto, "helvetica neue", Arial, sans-serif;
                font-size: 14px;
                margin: 0;
                background: var(--dark-bg);
                color: var(--light-text);
                line-height: 1.5;
                min-height: 100vh;
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
                    linear-gradient(rgba(255, 71, 87, 0.15) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 71, 87, 0.15) 1px, transparent 1px);
                background-size: 25px 25px;
                animation: gridFlicker 15s linear infinite;
            }

            .retro-bg::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 100%;
                background: radial-gradient(circle at center,
                    rgba(255, 71, 87, 0.1) 0%,
                    rgba(26, 26, 46, 0.8) 70%,
                    rgba(26, 26, 46, 0.95) 100%);
            }

            @keyframes gridFlicker {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.8;
                }
            }

            /* Overlay */
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

            /* Failed Box */
            .failed-box {
                background-color: var(--light-bg);
                border: 2px solid var(--error-color);
                box-shadow: 
                    0 0 30px rgba(255, 71, 87, 0.4),
                    inset 0 0 20px rgba(255, 71, 87, 0.1),
                    8px 8px 0 var(--error-color);
                padding: 3rem 2.5rem;
                max-width: 500px;
                width: 90%;
                text-align: center;
                position: relative;
                overflow: hidden;
                animation: failedBoxEntry 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }

            @keyframes failedBoxEntry {
                0% {
                    transform: scale(0.8) translateY(-50px);
                    opacity: 0;
                }
                100% {
                    transform: scale(1) translateY(0);
                    opacity: 1;
                }
            }

            /* Error Decorations */
            .failed-box::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: linear-gradient(90deg, 
                    var(--error-color) 0%, 
                    var(--warning-color) 50%, 
                    var(--error-color) 100%);
                animation: errorPulse 2s ease-in-out infinite;
            }

            .failed-box::after {
                content: "⚠";
                position: absolute;
                top: 15px;
                right: 15px;
                font-size: 1.5rem;
                color: var(--error-color);
                animation: warningBlink 1.5s infinite;
            }

            @keyframes errorPulse {
                0%, 100% {
                    opacity: 1;
                    filter: brightness(1);
                }
                50% {
                    opacity: 0.7;
                    filter: brightness(1.3);
                }
            }

            @keyframes warningBlink {
                0%, 50% {
                    opacity: 1;
                }
                51%, 100% {
                    opacity: 0.3;
                }
            }

            /* Error Icon */
            .error-icon {
                font-size: 4rem;
                color: var(--error-color);
                margin-bottom: 1.5rem;
                display: block;
                animation: iconShake 0.5s ease-in-out;
                text-shadow: 0 0 20px rgba(255, 71, 87, 0.5);
            }

            @keyframes iconShake {
                0%, 100% {
                    transform: translateX(0);
                }
                25% {
                    transform: translateX(-5px);
                }
                75% {
                    transform: translateX(5px);
                }
            }

            /* Message Text */
            .failed-box p {
                font-size: 1.25rem;
                color: var(--light-text);
                font-weight: 500;
                line-height: 1.6;
                margin-bottom: 2rem;
                position: relative;
                animation: textGlitch 3s infinite;
            }

            .failed-box p::before,
            .failed-box p::after {
                content: attr(data-text);
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
            }

            .failed-box p::before {
                left: -2px;
                text-shadow: 2px 0 var(--secondary-color);
                animation: textGlitch1 3s infinite ease-in-out;
            }

            .failed-box p::after {
                left: 2px;
                text-shadow: -2px 0 var(--error-color);
                animation: textGlitch2 3s infinite ease-in-out reverse;
            }

            @keyframes textGlitch {
                0%, 90%, 100% {
                    transform: translate(0);
                }
                10% {
                    transform: translate(-1px, 0);
                }
                20% {
                    transform: translate(1px, 0);
                }
            }

            @keyframes textGlitch1 {
                0%, 90%, 100% {
                    opacity: 0;
                }
                10% {
                    opacity: 0.8;
                    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
                }
            }

            @keyframes textGlitch2 {
                0%, 90%, 100% {
                    opacity: 0;
                }
                20% {
                    opacity: 0.8;
                    clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
                }
            }

            /* Actions */
            .confirm-actions {
                margin-top: 2rem;
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            .btn-confirm {
                padding: 1rem 2rem;
                background-color: var(--error-color);
                color: var(--light-text);
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
                content: "";
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
                background-color: var(--primary-color);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
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
                border: 2px solid var(--error-color);
                opacity: 0.7;
            }

            .cyber-corner.top-left {
                top: 15px;
                left: 15px;
                border-right: none;
                border-bottom: none;
                animation: cornerGlow 2s ease-in-out infinite alternate;
            }

            .cyber-corner.top-right {
                top: 15px;
                right: 15px;
                border-left: none;
                border-bottom: none;
                animation: cornerGlow 2s ease-in-out infinite alternate 0.5s;
            }

            .cyber-corner.bottom-left {
                bottom: 15px;
                left: 15px;
                border-right: none;
                border-top: none;
                animation: cornerGlow 2s ease-in-out infinite alternate 1s;
            }

            .cyber-corner.bottom-right {
                bottom: 15px;
                right: 15px;
                border-left: none;
                border-top: none;
                animation: cornerGlow 2s ease-in-out infinite alternate 1.5s;
            }

            @keyframes cornerGlow {
                0% {
                    opacity: 0.7;
                    border-color: var(--error-color);
                }
                100% {
                    opacity: 1;
                    border-color: var(--warning-color);
                    filter: drop-shadow(0 0 5px var(--warning-color));
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
                    var(--error-color) 50%, 
                    transparent 100%);
                animation: scanLine 3s linear infinite;
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
                .failed-box {
                    padding: 2rem 1.5rem;
                    margin: 1rem;
                }
                
                .error-icon {
                    font-size: 3rem;
                }
                
                .failed-box p {
                    font-size: 1.125rem;
                }
                
                .btn-confirm {
                    padding: 0.875rem 1.5rem;
                    font-size: 0.875rem;
                }
            }

            @media screen and (max-width: 480px) {
                .failed-box {
                    padding: 1.5rem 1rem;
                }
                
                .error-icon {
                    font-size: 2.5rem;
                }
                
                .failed-box p {
                    font-size: 1rem;
                }
                
                .btn-confirm {
                    padding: 0.75rem 1.25rem;
                    font-size: 0.75rem;
                    min-width: 100px;
                }
                
                .cyber-corner {
                    width: 20px;
                    height: 20px;
                }
            }

            /* Additional Error States */
            .expired-voucher {
                border-color: var(--warning-color);
                box-shadow: 
                    0 0 30px rgba(255, 165, 2, 0.4),
                    inset 0 0 20px rgba(255, 165, 2, 0.1),
                    8px 8px 0 var(--warning-color);
            }

            .expired-voucher::before {
                background: linear-gradient(90deg, 
                    var(--warning-color) 0%, 
                    var(--error-color) 50%, 
                    var(--warning-color) 100%);
            }

            .expired-voucher::after {
                content: "⏰";
                color: var(--warning-color);
            }

            .expired-voucher .cyber-corner {
                border-color: var(--warning-color);
            }
        </style>
    </head>
    
    <body>
        <!-- Retro Grid Background -->
        <div class="retro-bg"></div>
        
        <div class="confirm-overlay" id="customAlert">
            <div class="failed-box' . (strpos($message, 'kadaluarsa') !== false ? ' expired-voucher' : '') . '">
                <!-- Cyberpunk Corners -->
                <div class="cyber-corner top-left"></div>
                <div class="cyber-corner top-right"></div>
                <div class="cyber-corner bottom-left"></div>
                <div class="cyber-corner bottom-right"></div>
                
                <!-- Scan Line Effect -->
                <div class="scan-line"></div>
                
                <!-- Error Icon -->
                <div class="error-icon">❌</div>
                
                <!-- Error Message -->
                <p data-text="' . htmlspecialchars($message, ENT_QUOTES) . '">' . htmlspecialchars($message, ENT_QUOTES) . '</p>
                
                <!-- Actions -->
                <div class="confirm-actions">
                    <button class="btn-confirm" onclick="closeAlert()">OK</button>
                </div>
            </div>
        </div>
        
        <script>
            function closeAlert() {
                const alertBox = document.getElementById("customAlert");
                if (alertBox) {
                    alertBox.style.animation = "overlayFadeOut 0.3s ease-out forwards";
                    setTimeout(() => {
                        alertBox.remove();
                        // Redirect back to login page
                        window.history.back();
                    }, 300);
                }
            }
            
            // Add fade out animation
            const style = document.createElement("style");
            style.textContent = `
                @keyframes overlayFadeOut {
                    0% { opacity: 1; }
                    100% { opacity: 0; }
                }
            `;
            document.head.appendChild(style);
            
            // Auto close after 10 seconds
            setTimeout(closeAlert, 10000);
            
            // Add keyboard support
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter" || event.key === "Escape") {
                    closeAlert();
                }
            });
            
            // Add random glitch effects
            setInterval(function() {
                const failedBox = document.querySelector(".failed-box");
                if (Math.random() < 0.1) { // 10% chance
                    failedBox.style.transform = "translate(" + (Math.random() * 4 - 2) + "px, " + (Math.random() * 4 - 2) + "px)";
                    setTimeout(function() {
                        failedBox.style.transform = "translate(0, 0)";
                    }, 100);
                }
            }, 1000);
        </script>
    </body>
    </html>
    ';
}

// Handle different error messages
if ($reply == 'Your maximum never usage time has been reached') {
    showCustomAlert('⚠️ Kode voucher sudah kadaluarsa');
} else if ($reply) {
    showCustomAlert($reply);
} else {
    showCustomAlert(isset($h1Failed) ? $h1Failed : 'Login gagal. Silakan coba lagi.');
}
?>
