<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - LoggingIn</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <style>
        :root {
            /* Main colors */
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
            
            /* Background colors */
            --bg-dark: #0F172A;
            --bg-dark-2: #1E293B;
            --bg-card: rgba(30, 41, 59, 0.7);
            --bg-card-hover: rgba(30, 41, 59, 0.9);
            --bg-input: rgba(15, 23, 42, 0.6);
            
            /* Text colors */
            --text-primary: #F8FAFC;
            --text-secondary: #CBD5E1;
            --text-muted: #94A3B8;
            --text-dark: #334155;
            
            /* Border colors */
            --border-light: rgba(148, 163, 184, 0.2);
            --border-input: rgba(148, 163, 184, 0.3);
            --border-primary: rgba(14, 165, 233, 0.5);
            
            /* Shadow */
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.1);
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-inner: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            
            /* Border radius */
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

        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        .logo-container {
            display: inline-block;
            margin-bottom: 2rem;
            position: relative;
        }

        .logo {
            width: 160px;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            animation: pulse 2s infinite;
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

        .loading-card {
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
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .loading-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--primary-light), var(--secondary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .loading-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .loading-spinner {
            position: relative;
            width: 80px;
            height: 80px;
            margin-bottom: 2rem;
        }

        .spinner-outer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 4px solid rgba(56, 189, 248, 0.1);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .spinner-middle {
            position: absolute;
            top: 15%;
            left: 15%;
            width: 70%;
            height: 70%;
            border: 4px solid rgba(139, 92, 246, 0.1);
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin 1.5s linear infinite reverse;
        }

        .spinner-inner {
            position: absolute;
            top: 30%;
            left: 30%;
            width: 40%;
            height: 40%;
            border: 3px solid rgba(6, 182, 212, 0.1);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 2s linear infinite;
        }

        .loading-progress {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-full);
            margin-bottom: 1rem;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: var(--radius-full);
            animation: progress 5s linear forwards;
        }

        .loading-message {
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .loading-message svg {
            margin-right: 0.5rem;
            animation: blink 1.5s infinite;
        }

        .redirect-link {
            margin-top: 1.5rem;
            color: var(--primary-light);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .redirect-link:hover {
            color: var(--primary);
            transform: translateY(-1px);
        }

        .redirect-link svg {
            margin-left: 0.35rem;
        }

        /* Animations */
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

        @keyframes progress {
            0% { width: 0; }
            100% { width: 100%; }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .main-container {
                padding: 1rem;
            }
            
            .loading-card {
                padding: 1.5rem;
            }
            
            .loading-title {
                font-size: 1.25rem;
            }
            
            .loading-subtitle {
                font-size: 0.9rem;
            }
            
            .loading-spinner {
                width: 70px;
                height: 70px;
            }
        }
    </style>
    <script type="text/javascript">
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
            // Set hostname in title
            var hostname = window.location.hostname;
            document.getElementById('title').innerHTML = hostname + " > Logging In";

            // Get login URL from parameter if available
            var paramUrl = getURLParam("loginurl");
            if (paramUrl) {
                loginUrl = paramUrl;
            }
            
            // Update countdown timer
            var seconds = 5;
            var countdownElement = document.getElementById('countdown');
            
            var countdownInterval = setInterval(function() {
                seconds--;
                if (countdownElement) {
                    countdownElement.textContent = seconds;
                }
                
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
            
            // Redirect after 5 seconds
            setTimeout(redirect, 5000);
            
            // Update loading messages
            var messages = [
                "Memeriksa kredensial...",
                "Menghubungkan ke jaringan...",
                "Memverifikasi akses...",
                "Hampir selesai...",
                "Menyiapkan koneksi..."
            ];
            
            var messageElement = document.getElementById('loading-message-text');
            var messageIndex = 0;
            
            setInterval(function() {
                if (messageElement && messageIndex < messages.length) {
                    messageElement.textContent = messages[messageIndex];
                    messageIndex++;
                }
            }, 1000);
        }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="content-container">
            <div class="loading-container">
                
                <h1 class="loading-title">AFR-Cloud.NET</h1>
                <p class="loading-subtitle">Sedang memproses login Anda</p>
                
                <div class="loading-card">
                    <div class="loading-spinner">
                        <div class="spinner-outer"></div>
                        <div class="spinner-middle"></div>
                        <div class="spinner-inner"></div>
                    </div>
                    
                    <div class="loading-progress">
                        <div class="progress-bar"></div>
                    </div>
                    
                    <div class="loading-message">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="2" x2="12" y2="6"></line>
                            <line x1="12" y1="18" x2="12" y2="22"></line>
                            <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                            <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                            <line x1="2" y1="12" x2="6" y2="12"></line>
                            <line x1="18" y1="12" x2="22" y2="12"></line>
                            <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                            <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                        </svg>
                        <span id="loading-message-text">Memeriksa kredensial...</span>
                    </div>
                    
                    <a href="#" onclick="javascript:return redirect();" class="redirect-link">
                        Redirect dalam <span id="countdown">5</span> detik
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>