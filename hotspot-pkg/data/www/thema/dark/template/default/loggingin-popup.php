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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFR-Cloud.NET - LoggingIn</title>
    <link rel="stylesheet" href="assets/css/styles.css">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: transparent;
            color: var(--text-primary);
            line-height: 1.6;
            overflow: hidden;
        }

        .popup-container {
            width: 100%;
            max-width: 100%;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            width: 100%;
            max-width: 320px;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            overflow: hidden;
            padding: 1.5rem;
            animation: fadeInUp 0.5s ease;
            text-align: center;
        }

        .popup-icon {
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
        }

        .loading-spinner {
            position: relative;
            width: 60px;
            height: 60px;
        }

        .spinner-outer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 3px solid rgba(56, 189, 248, 0.1);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .spinner-inner {
            position: absolute;
            top: 25%;
            left: 25%;
            width: 50%;
            height: 50%;
            border: 3px solid rgba(139, 92, 246, 0.1);
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin 1.5s linear infinite reverse;
        }

        .popup-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-light);
        }

        .popup-message {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .loading-dots {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 10px;
        }

        .loading-dots div {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-light);
            animation: dots 1.2s linear infinite;
        }

        .loading-dots div:nth-child(1) {
            left: 6px;
            animation-delay: 0s;
        }

        .loading-dots div:nth-child(2) {
            left: 26px;
            animation-delay: 0.2s;
        }

        .loading-dots div:nth-child(3) {
            left: 46px;
            animation-delay: 0.4s;
        }

        /* Animations */
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

        @keyframes dots {
            0%, 80%, 100% { 
                transform: scale(0);
                opacity: 0;
            }
            40% { 
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .popup-content {
                max-width: 280px;
                padding: 1.25rem;
            }
            
            .popup-title {
                font-size: 1.1rem;
            }
            
            .popup-message {
                font-size: 0.9rem;
            }
            
            .loading-spinner {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-icon">
                <div class="loading-spinner">
                    <div class="spinner-outer"></div>
                    <div class="spinner-inner"></div>
                </div>
            </div>
            
            <h3 class="popup-title"><?php echo isset($h1Loggingin) ? $h1Loggingin : 'Logging In'; ?></h3>
            
            <p class="popup-message"><?php echo isset($centerPleasewait) ? $centerPleasewait : 'Please wait while we connect you...'; ?></p>
            
            <div class="loading-dots">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</body>
</html>