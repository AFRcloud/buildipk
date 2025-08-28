<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/
?>
<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title"></title>
    <meta name="theme-color" content="#2563eb" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <style>
        /* CSS Variables for Theming */
        :root {
            --bg-color: #f8fafc;
            --container-bg: white;
            --text-color: #334155;
            --header-bg: #2563eb;
            --header-text: white;
            --tab-border: #e2e8f0;
            --tab-button-color: #64748b;
            --tab-button-active-color: #2563eb;
            --tab-button-active-bg: #f8fafc;
            --tab-button-hover-bg: #f1f5f9;
            --otp-border: #e2e8f0;
            --otp-focus-border: #2563eb;
            --otp-filled-border: #059669;
            --otp-filled-bg: #f0fdf4;
            --table-header-bg: #f8fafc;
            --table-border: #e2e8f0;
            --table-row-border: #f1f5f9;
            --modal-overlay-bg: rgba(0, 0, 0, 0.5);
            --modal-bg: white;
            --modal-text: #374151;
            --whatsapp-color: #059669;
            --qr-button-bg: #dc2626;
            --qr-button-hover-bg: #b91c1c;
            --btn-primary-bg: #2563eb;
            --btn-primary-hover-bg: #1d4ed8;
            --btn-secondary-bg: #059669;
            --btn-secondary-hover-bg: #047857;
            --btn-outline-border: #2563eb;
            --btn-outline-text: #2563eb;
            --btn-outline-hover-bg: #2563eb;
            --btn-outline-hover-text: white;
            --scrollbar-track: #f1f5f9;
            --scrollbar-thumb: #cbd5e1;
            --scrollbar-thumb-hover: #94a3b8;
        }

        [data-theme="dark"] {
            --bg-color: #1a202c; /* Darker background */
            --container-bg: #2d3748; /* Darker container */
            --text-color: #e2e8f0; /* Light text */
            --header-bg: #4a5568; /* Darker header */
            --header-text: white;
            --tab-border: #4a5568;
            --tab-button-color: #a0aec0;
            --tab-button-active-color: #63b3ed; /* Lighter blue for active */
            --tab-button-active-bg: #2d3748;
            --tab-button-hover-bg: #4a5568;
            --otp-border: #4a5568;
            --otp-focus-border: #63b3ed;
            --otp-filled-border: #48bb78; /* Darker green */
            --otp-filled-bg: #2f4f4f; /* Darker green background */
            --table-header-bg: #2d3748;
            --table-border: #4a5568;
            --table-row-border: #2d3748;
            --modal-overlay-bg: rgba(0, 0, 0, 0.7);
            --modal-bg: #2d3748;
            --modal-text: #e2e8f0;
            --whatsapp-color: #48bb78; /* Lighter green */
            --qr-button-bg: #e53e3e; /* Slightly brighter red */
            --qr-button-hover-bg: #c53030;
            --btn-primary-bg: #63b3ed; /* Lighter blue */
            --btn-primary-hover-bg: #4299e1;
            --btn-secondary-bg: #48bb78; /* Lighter green */
            --btn-secondary-hover-bg: #38a169;
            --btn-outline-border: #63b3ed;
            --btn-outline-text: #63b3ed;
            --btn-outline-hover-bg: #63b3ed;
            --btn-outline-hover-text: white;
            --scrollbar-track: #2d3748;
            --scrollbar-thumb: #4a5568;
            --scrollbar-thumb-hover: #64748b;
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-color);
            min-height: 100vh;
            color: var(--text-color);
        }
        /* Main Container */
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: var(--container-bg);
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 20px; /* Add padding for content at the bottom */
        }
        /* Header */
        .header {
            background: var(--header-bg);
            color: var(--header-text);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between; /* Added for theme toggle button */
            gap: 12px;
            width: 100%; /* Ensure header spans full width of container */
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-logo-img {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: contain;
            background: white;
            padding: 4px;
        }
        .header-title {
            font-size: 18px;
            font-weight: 600;
        }
        .theme-toggle-button {
            background: none;
            border: none;
            color: var(--header-text);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease;
        }
        .theme-toggle-button:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .theme-toggle-button svg {
            width: 20px;
            height: 20px;
        }

        /* Specific styles for timeout.php */
        .timeout-content {
            text-align: center;
            padding: 40px 20px;
            flex-grow: 1; /* Allow content to grow and push footer down */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .timeout-content h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--qr-button-bg); /* Red for error/timeout */
            margin-bottom: 20px;
        }
        .timeout-content p {
            font-size: 16px;
            color: var(--tab-button-color);
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 24px;
            background: var(--btn-primary-bg);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 20px;
            width: calc(100% - 40px); /* Adjust width for padding */
            max-width: 360px;
        }
        .btn:hover {
            background: var(--btn-primary-hover-bg);
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }
            .timeout-content {
                padding: 30px 15px;
            }
            .timeout-content h2 {
                font-size: 24px;
                margin-bottom: 15px;
            }
            .timeout-content p {
                font-size: 15px;
                margin-bottom: 10px;
            }
            .btn {
                padding: 12px 20px;
                font-size: 15px;
                width: calc(100% - 30px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <img src="assets/images/radmon.png" alt="RadMon Logo" class="header-logo-img">
                <div class="header-title">RadMon WiFi</div>
            </div>
            <button id="theme-toggle" class="theme-toggle-button">
                <!-- Icon will be set by JavaScript -->
            </button>
        </div>

        <div class="timeout-content">
            <h2>Waktu Pembayaran Habis</h2>
            <p>Maaf, waktu untuk melakukan pembayaran telah habis.</p>
            <p>Silakan lakukan pemesanan ulang atau hubungi layanan pelanggan.</p>
            <a href="http://10.10.10.1:3990" class="btn">Kembali ke Beranda</a>
        </div>
    </div>

    <script type="text/javascript">
        // Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const htmlElement = document.documentElement;
            const themeToggleBtn = document.getElementById('theme-toggle');

            // Function to set theme
            const setTheme = (theme) => {
                htmlElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                updateThemeIcon(theme);
            };

            // Function to update icon
            const updateThemeIcon = (theme) => {
                if (themeToggleBtn) {
                    themeToggleBtn.innerHTML = theme === 'dark'
                        ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/></svg>'
                        : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>';
                }
            };

            // Get saved theme or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);

            // Add event listener to toggle button
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const currentTheme = htmlElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    setTheme(newTheme);
                });
            }
        });

        // Mengatur judul halaman
        var hostname = window.location.hostname;
        document.getElementById('title').innerHTML = hostname + " > Waktu Habis";
    </script>
</body>
</html>
