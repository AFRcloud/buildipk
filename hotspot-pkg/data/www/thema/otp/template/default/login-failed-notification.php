<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/

// Asumsi variabel $reply dan $h1Failed sudah didefinisikan di tempat lain
// atau Anda bisa mendefinisikannya di sini jika ini adalah file mandiri
// Contoh:
// $reply = "invalid username or password";
// $h1Failed = "Login Gagal";

// Fungsi showCustomAlert akan diubah untuk menggunakan struktur modal yang sudah ada
// dan akan dipanggil di bagian bawah file setelah HTML dan JS dimuat.
?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
    <title id="title"></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#2563eb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
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
        /* Tab Navigation (not used in this file, but kept for consistency) */
        .tab-nav {
            display: flex;
            background: var(--container-bg);
            border-bottom: 1px solid var(--tab-border);
        }
        .tab-button {
            flex: 1;
            padding: 16px 20px;
            background: transparent;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            color: var(--tab-button-color);
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }
        .tab-button.active {
            color: var(--tab-button-active-color);
            border-bottom-color: var(--tab-button-active-color);
            background: var(--tab-button-active-bg);
        }
        .tab-button:hover:not(.active) {
            color: var(--tab-button-color);
            background: var(--tab-button-hover-bg);
        }
        /* Tab Content (used as general content padding) */
        .tab-content {
            padding: 24px 20px;
        }
        .tab-pane {
            display: none;
        }
        .tab-pane.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Login Content (general info text) */
        .login-info {
            color: var(--tab-button-color);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .whatsapp-info {
            color: var(--tab-button-color);
            font-size: 14px;
            margin-bottom: 24px;
        }
        .whatsapp-number {
            color: var(--whatsapp-color);
            font-weight: 600;
            text-decoration: none;
        }
        .whatsapp-number:hover {
            text-decoration: underline;
        }
        /* OTP Input Container (not used in this file) */
        .otp-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 32px 0;
        }
        .otp-input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            border: 2px solid var(--otp-border);
            border-radius: 8px;
            background: var(--container-bg);
            transition: all 0.2s ease;
            text-transform: uppercase;
        }
        .otp-input:focus {
            outline: none;
            border-color: var(--otp-focus-border);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .otp-input:not(:placeholder-shown) {
            border-color: var(--otp-filled-border);
            background: var(--otp-filled-bg);
        }
        /* Buttons */
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 32px;
        }
        .btn {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary {
            background: var(--btn-primary-bg);
            color: white;
        }
        .btn-primary:hover {
            background: var(--btn-primary-hover-bg);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: var(--btn-secondary-bg);
            color: white;
        }
        .btn-secondary:hover {
            background: var(--btn-secondary-hover-bg);
            transform: translateY(-1px);
        }
        .btn-outline {
            background: var(--container-bg);
            color: var(--btn-outline-text);
            border: 2px solid var(--btn-outline-border);
        }
        .btn-outline:hover {
            background: var(--btn-outline-hover-bg);
            color: var(--btn-outline-hover-text);
        }
        /* Hidden inputs (not used in this file) */
        .hidden-input {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }
        /* Package Table (not used in this file) */
        .package-header {
            color: var(--text-color);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            text-align: center;
        }
        .table-container {
            background: var(--container-bg);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--table-border);
            max-height: 400px;
            overflow-y: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: var(--table-header-bg);
            padding: 12px 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
            border-bottom: 1px solid var(--table-border);
        }
        table td {
            padding: 12px 8px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid var(--table-row-border);
            color: var(--text-color);
        }
        table tbody tr:hover {
            background: var(--tab-button-hover-bg);
        }
        .buy-btn {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .buy-btn:hover {
            background: #d97706;
            transform: translateY(-1px);
        }
        /* QR Code Button (not used in this file) */
        .qr-button {
            background: var(--qr-button-bg);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .qr-button:hover {
            background: var(--qr-button-hover-bg);
            transform: translateY(-1px);
        }
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--modal-overlay-bg);
            display: flex;
            align-items: center;
            justify: center;
            z-index: 1000;
        }
        .modal-content {
            background: var(--modal-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
            color: var(--modal-text);
        }
        .modal-content p {
            margin-bottom: 20px;
            color: var(--modal-text);
            line-height: 1.5;
        }
        .modal-buttons {
            display: flex;
            gap: 12px;
            justify: center;
        }
        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .modal-btn-primary {
            background: var(--btn-primary-bg);
            color: white;
        }
        .modal-btn-secondary {
            background: var(--tab-button-color);
            color: white;
        }
        /* Loading Screen (not used in this file) */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--container-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify: center;
            z-index: 1001;
            color: var(--text-color);
        }
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--tab-border);
            border-top: 4px solid var(--btn-primary-bg);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 16px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }
                        .otp-container {
                gap: 8px;
            }
                        .otp-input {
                width: 44px;
                height: 52px;
                font-size: 18px;
            }
                        .tab-content {
                padding: 20px 16px;
            }
                        table th, table td {
                padding: 8px 4px;
                font-size: 12px;
            }
                        .buy-btn {
                padding: 4px 8px;
                font-size: 11px;
            }
        }
        /* Custom Scrollbar */
        .table-container::-webkit-scrollbar {
            width: 4px;
        }
        .table-container::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }
        .table-container::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 2px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb-hover);
        }

        /* Specific styles for the alert modal */
        .modal-content .alert-icon {
            color: var(--qr-button-bg); /* Red for error */
            margin-bottom: 16px;
        }
        .modal-content .alert-icon svg {
            width: 64px;
            height: 64px;
        }
        .modal-content .alert-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 12px;
        }
        .modal-content .alert-message {
            font-size: 16px;
            color: var(--tab-button-color);
            margin-bottom: 24px;
        }
        .modal-content .confirm-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        .modal-content .btn-confirm {
            background: var(--btn-primary-bg);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .modal-content .btn-confirm:hover {
            background: var(--btn-primary-hover-bg);
        }
    </style>
</head>
<body>
    <!-- Modal structure from loginform-login.php -->
    <div id="customModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="alert-icon">
                <!-- Icon for error/info -->
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h3 class="alert-title" id="modalTitle"></h3>
            <p class="alert-message" id="modalMessage"></p>
            <div class="confirm-actions">
                <button id="modalOk" class="btn-confirm">OK</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const htmlElement = document.documentElement;
            const themeToggleBtn = document.getElementById('theme-toggle'); // This file might not have a toggle button in header, but the logic is here for consistency.

            // Function to set theme
            const setTheme = (theme) => {
                htmlElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                // No icon update needed for this specific page as it's a modal
            };

            // Get saved theme or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);
        });

        // Mengatur judul halaman
        var hostname = window.location.hostname;
        document.getElementById('title').innerHTML = hostname + " > RadMon WiFi";

        // Fungsi untuk menampilkan alert menggunakan modal yang sudah ada
        function showAlert(title, message, callbackOk) {
            document.getElementById('modalTitle').innerHTML = title;
            document.getElementById('modalMessage').innerHTML = message;
            document.getElementById('modalOk').style.display = 'inline-block';
            document.getElementById('customModal').style.display = 'flex';

            document.getElementById('modalOk').onclick = function () {
                document.getElementById('customModal').style.display = 'none';
                if (callbackOk) callbackOk();
            };
        }

        // Logika PHP untuk menentukan pesan yang akan ditampilkan
        <?php
        $alertTitle = "Login Gagal";
        $alertMessage = "";

        if (isset($reply)) {
            if ($reply == 'Your maximum never usage time has been reached') {
                $alertMessage = '⚠️ Kode voucher sudah kadaluarsa';
            } else {
                $alertMessage = $reply;
            }
        } else if (isset($h1Failed)) {
            $alertMessage = $h1Failed;
        } else {
            $alertMessage = "Terjadi kesalahan yang tidak diketahui."; // Default fallback
        }
        ?>

        // Panggil fungsi showAlert setelah DOM dimuat
        document.addEventListener('DOMContentLoaded', function() {
            showAlert(
                "<?php echo htmlspecialchars($alertTitle, ENT_QUOTES); ?>",
                "<?php echo htmlspecialchars($alertMessage, ENT_QUOTES); ?>",
                function() {
                    window.history.back(); // Kembali ke halaman sebelumnya setelah OK
                }
            );

            // Auto close after 5 seconds
            setTimeout(() => {
                // Pastikan modal masih terlihat sebelum menutup
                if (document.getElementById('customModal').style.display === 'flex') {
                    window.history.back(); // Kembali ke halaman sebelumnya
                }
            }, 5000);
        });
    </script>
</body>
</html>
