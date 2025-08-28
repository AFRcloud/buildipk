<?php
/**
 * AFRCloud-NET Login Form
 * WiFi Hotspot Login Interface with Package Management
 */

// Database Configuration
require './config/db_config.php';

// Get URL Parameters
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';

// Database Connection Settings
$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

// Get Admin WhatsApp Number from Database
$command = "mysql -u {$user} -p{$pass} -h {$host} -D {$db} -e \"SELECT hscsn FROM print_config LIMIT 1\" -s -N";
$admin_number = trim(shell_exec($command));

// Format Phone Number
if (strpos($admin_number, '62') === 0) {
    $cs_number = '0' . substr($admin_number, 2);
} else {
    $cs_number = $admin_number;
}
$formatted = substr($cs_number, 0, 4) . '-' . substr($cs_number, 4, 4) . '-' . substr($cs_number, 8);
?>

<!doctype html>
<html lang="en" data-theme="">
<head>
    <title id="title">AFRCloud-NET</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#2563eb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    
    <style>
        /* ========================================
           CSS VARIABLES - THEME SYSTEM
        ======================================== */
        :root {
            /* Primary Brand Color - Dark */
            --primary-dark: #0f172a;        /* Main dark background */
            --primary-dark-light: #1e293b;  /* Elevated surfaces */
            --primary-dark-lighter: #334155; /* Interactive elements */
            
            /* Neutral Colors */
            --neutral-white: #ffffff;
            --neutral-light: #f1f5f9;       /* Light text on dark */
            --neutral-medium: #64748b;      /* Secondary text */
            --neutral-border: #475569;      /* Borders and dividers */
            
            /* Accent Colors */
            --accent-blue: #3b82f6;         /* Primary actions */
            --accent-blue-hover: #2563eb;   /* Primary hover states */
            --accent-green: #10b981;        /* Success states */
            --accent-green-hover: #059669;  /* Success hover */
            --accent-red: #ef4444;          /* Error/danger states */
            
            /* ========================================
               SEMANTIC COLOR MAPPINGS
            ======================================== */
            
            /* Background Colors */
            --bg-color: var(--primary-dark);
            --container-bg: var(--primary-dark-light);
            --header-bg: var(--primary-dark-lighter);
            --modal-bg: var(--primary-dark-light);
            --table-header-bg: var(--primary-dark-light);
            
            /* Text Colors */
            --text-color: var(--neutral-light);
            --header-text: var(--neutral-white);
            --modal-text: var(--neutral-light);
            
            /* Interactive Elements */
            --tab-border: var(--neutral-border);
            --tab-button-color: var(--neutral-medium);
            --tab-button-active-color: var(--accent-blue);
            --tab-button-active-bg: var(--primary-dark-light);
            --tab-button-hover-bg: var(--primary-dark-lighter);
            
            /* Form Elements */
            --otp-border: var(--neutral-border);
            --otp-focus-border: var(--accent-blue);
            --otp-filled-border: var(--accent-green);
            --otp-filled-bg: rgba(16, 185, 129, 0.1);
            
            /* Table Elements */
            --table-border: var(--neutral-border);
            --table-row-border: var(--primary-dark-light);
            
            /* Modal Elements */
            --modal-overlay-bg: rgba(15, 23, 42, 0.8);
            
            /* Button Colors */
            --btn-primary-bg: var(--accent-blue);
            --btn-primary-hover-bg: var(--accent-blue-hover);
            --btn-secondary-bg: var(--accent-green);
            --btn-secondary-hover-bg: var(--accent-green-hover);
            --btn-outline-border: var(--accent-blue);
            --btn-outline-text: var(--accent-blue);
            --btn-outline-hover-bg: var(--accent-blue);
            --btn-outline-hover-text: var(--neutral-white);
            
            /* Special Elements */
            --whatsapp-color: var(--accent-green);
            --qr-button-bg: var(--accent-red);
            --qr-button-hover-bg: #dc2626;
            
            /* Scrollbar */
            --scrollbar-track: var(--primary-dark-light);
            --scrollbar-thumb: var(--neutral-border);
            --scrollbar-thumb-hover: var(--neutral-medium);
        }

        /* ========================================
           LOCAL THEME - TRANSPARENT OVERLAY VARIANT
        ======================================== */
        [data-theme="lokal"] {
            /* Updated local theme to use consistent color system with transparency */
            --bg-color: transparent;
            --container-bg: rgba(30, 41, 59, 0.15);
            --text-color: var(--primary-dark);
            --header-bg: rgba(15, 23, 42, 0.15);
            --header-text: var(--neutral-white);
            
            /* Interactive Elements with Transparency */
            --tab-border: rgba(71, 85, 105, 0.3);
            --tab-button-color: var(--neutral-medium);
            --tab-button-active-color: var(--accent-blue);
            --tab-button-active-bg: rgba(30, 41, 59, 0.25);
            --tab-button-hover-bg: rgba(51, 65, 85, 0.25);
            
            /* Form Elements */
            --otp-border: rgba(71, 85, 105, 0.3);
            --otp-focus-border: var(--accent-blue);
            --otp-filled-border: var(--accent-green);
            --otp-filled-bg: rgba(16, 185, 129, 0.1);
            
            /* Table Elements */
            --table-header-bg: rgba(248, 250, 252, 0.2);
            --table-border: rgba(51, 65, 85, 0.3);
            --table-row-border: rgba(241, 245, 249, 0.2);
            
            /* Modal Elements */
            --modal-overlay-bg: rgba(15, 23, 42, 0.4);
            --modal-bg: var(--primary-dark-light);
            --modal-text: var(--neutral-light);
            
            /* Buttons remain consistent */
            --btn-primary-bg: var(--accent-blue);
            --btn-primary-hover-bg: var(--accent-blue-hover);
            --btn-secondary-bg: var(--accent-green);
            --btn-secondary-hover-bg: var(--accent-green-hover);
            
            /* Special Elements */
            --whatsapp-color: var(--accent-green);
            --qr-button-bg: var(--accent-red);
            --qr-button-hover-bg: #dc2626;
            
            /* Scrollbar */
            --scrollbar-track: var(--primary-dark-light);
            --scrollbar-thumb: var(--neutral-border);
            --scrollbar-thumb-hover: var(--neutral-medium);
        }

        /* ========================================
           GLOBAL STYLES
        ======================================== */
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

        /* Local Theme Background */
        [data-theme="lokal"] body {
            background-image: url('assets/images/local_background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        [data-theme="lokal"] .container,
        [data-theme="lokal"] .header {
            backdrop-filter: blur(5px);
        }

        /* ========================================
           MAIN CONTAINER
        ======================================== */
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: var(--container-bg);
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* ========================================
           HEADER SECTION
        ======================================== */
        .header {
            background: var(--header-bg);
            color: var(--header-text);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        /* Theme Toggle Buttons */
        .theme-toggle-container {
            display: flex;
            gap: 8px;
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

        .theme-toggle-button.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .theme-toggle-button svg {
            width: 20px;
            height: 20px;
        }

        /* ========================================
           CLOCK SECTION
        ======================================== */
        .jam-container {
            padding: 20px;
            text-align: center;
            background: var(--container-bg);
            border-bottom: 1px solid var(--tab-border);
        }

        .jam {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: -2px;
            color: var(--text-color);
            margin-bottom: 4px;
            line-height: 1;
        }

        .tanggal {
            font-size: 1rem;
            font-weight: 500;
            color: var(--tab-button-color);
        }

        /* ========================================
           TAB NAVIGATION
        ======================================== */
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

        /* ========================================
           TAB CONTENT
        ======================================== */
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

        /* ========================================
           LOGIN FORM STYLES
        ======================================== */
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

        /* OTP Input Container */
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
            color: var(--text-color);
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

        /* Hidden Form Inputs */
        .hidden-input {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }

        /* ========================================
           BUTTON STYLES
        ======================================== */
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

        /* ========================================
           PACKAGE TABLE STYLES
        ======================================== */
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

        /* ========================================
           MODAL STYLES
        ======================================== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--modal-overlay-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--modal-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
            justify-content: center;
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

        /* ========================================
           LOADING SCREEN
        ======================================== */
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
            justify-content: center;
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

        /* ========================================
           CUSTOM SCROLLBAR
        ======================================== */
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

        /* ========================================
           RESPONSIVE DESIGN
        ======================================== */
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
    </style>
</head>

<body>
    <!-- Modal Dialog -->
    <div id="customModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <p id="modalMessage"></p>
            <div class="modal-buttons">
                <button id="modalYes" class="modal-btn modal-btn-primary">Ya</button>
                <button id="modalNo" class="modal-btn modal-btn-secondary">Batal</button>
                <button id="modalOk" class="modal-btn modal-btn-primary">OK</button>
            </div>
        </div>
    </div>

    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-screen" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Redirecting...</p>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-left">
                <img src="assets/images/radmon.png" alt="RadMon Logo" class="header-logo-img">
                <div class="header-title">AFRCloud-NET</div>
            </div>
            <div class="theme-toggle-container">
                <button id="light-theme-toggle" class="theme-toggle-button" onclick="setTheme('light')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun">
                        <circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2"/>
                        <path d="M12 20v2"/>
                        <path d="M4.93 4.93l1.41 1.41"/>
                        <path d="M17.66 17.66l1.41 1.41"/>
                        <path d="M2 12h2"/>
                        <path d="M20 12h2"/>
                        <path d="M4.93 19.07l1.41-1.41"/>
                        <path d="M17.66 6.34l1.41-1.41"/>
                    </svg>
                </button>
                <button id="lokal-theme-toggle" class="theme-toggle-button" onclick="setTheme('lokal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                        <circle cx="9" cy="9" r="2"/>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button class="tab-button active" onclick="switchTab('login')">Login</button>
            <button class="tab-button" onclick="switchTab('packages')">List Paket</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Clock Section -->
            <div class="jam-container">
                <div id="live-clock" class="jam"></div>
                <div id="live-date" class="tanggal"></div>
            </div>

            <!-- Login Tab -->
            <div id="loginTab" class="tab-pane active">
                <div class="login-info"></div>
                <div class="whatsapp-info">
                    Kode voucher dapat dibeli melalui 
                    <a href="https://wa.me/<?php echo $admin_number ?>" class="whatsapp-number">WHATSAPP</a>
                </div>

                <form autocomplete="off" name="login" action="<?php echo $loginpath; ?>" method="post">
                    <!-- Hidden Form Fields -->
                    <input type="hidden" name="dst" value="$(link-orig)" />
                    <input type="hidden" name="popup" value="true" />
                    <input class="username hidden-input" name="username" type="hidden" value="$(username)" />
                    <input type="hidden" name="challenge" value="<?php echo $challenge; ?>">
                    <input type="hidden" name="uamip" value="<?php echo $uamip; ?>">
                    <input type="hidden" name="uamport" value="<?php echo $uamport; ?>">
                    <input type="hidden" name="userurl" value="<?php echo $userurl; ?>">

                    <!-- OTP Input Fields -->
                    <div class="otp-container">
                        <input type="text" class="otp-input" id="otp1" maxlength="1" />
                        <input type="text" class="otp-input" id="otp2" maxlength="1" />
                        <input type="text" class="otp-input" id="otp3" maxlength="1" />
                        <input type="text" class="otp-input" id="otp4" maxlength="1" />
                        <input type="text" class="otp-input" id="otp5" maxlength="1" />
                        <input type="text" class="otp-input" id="otp6" maxlength="1" />
                    </div>

                    <!-- Hidden Login Fields -->
                    <input class="username hidden-input" name="UserName" type="text" id="user" />
                    <input type="hidden" id="pass" class="password" name="Password" />
                    <input type="hidden" name="button" value="Login">

                    <!-- Action Buttons -->
                    <div class="button-group">
                        <button type="button" class="btn btn-secondary" onclick="handleTrial()">GRATIS</button>
                    </div>
                </form>
            </div>

            <!-- Packages Tab -->
            <div id="packagesTab" class="tab-pane">
                <div class="package-header">📦 Daftar Paket Internet</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Durasi</th>
                                <th>Harga</th>
                                <th>Beli</th>
                            </tr>
                        </thead>
                        <tbody id="paket-list">
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 20px; text-align: center; color: var(--tab-button-color); font-size: 14px;">
                    💬 Voucher bisa dibeli melalui<br>
                    WhatsApp: <a href="https://wa.me/<?php echo $admin_number ?>" class="whatsapp-number"><?php echo $formatted ?></a>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        // ========================================
        // THEME MANAGEMENT
        // ========================================
        document.addEventListener('DOMContentLoaded', () => {
            const htmlElement = document.documentElement;
            const themeToggleBtns = document.querySelectorAll('.theme-toggle-button');

            // Set Theme Function
            window.setTheme = (theme) => {
                htmlElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                updateThemeButtons(theme);
            };

            // Update Theme Button States
            const updateThemeButtons = (activeTheme) => {
                themeToggleBtns.forEach(btn => {
                    btn.classList.remove('active');
                });
                const activeBtn = document.getElementById(activeTheme + '-theme-toggle');
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }
            };

            // Load Saved Theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);
        });

        // ========================================
        // LIVE CLOCK AND DATE
        // ========================================
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', options);
            
            const clockElement = document.getElementById('live-clock');
            const dateElement = document.getElementById('live-date');
            
            if (clockElement) {
                clockElement.textContent = timeString;
            }
            if (dateElement) {
                dateElement.textContent = dateString;
            }
        }
        
        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock();

        // ========================================
        // PAGE INITIALIZATION
        // ========================================
        var hostname = window.location.hostname;
        document.getElementById('title').innerHTML = hostname + " > RadMon WiFi";
        
        var username = document.getElementById('user');
        var password = document.getElementById('pass');

        // ========================================
        // TAB SWITCHING FUNCTIONALITY
        // ========================================
        function switchTab(tabName) {
            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            // Show selected tab and activate button
            document.getElementById(tabName + 'Tab').classList.add('active');
            event.target.classList.add('active');
            
            // Focus on first OTP input when switching to login tab
            if (tabName === 'login') {
                setTimeout(() => document.getElementById('otp1').focus(), 100);
            }
        }

        // ========================================
        // OTP INPUT HANDLING
        // ========================================
        const otpInputs = document.querySelectorAll('.otp-input');
        
        otpInputs.forEach((input, index) => {
            // Handle input events
            input.addEventListener('input', (e) => {
                const value = e.target.value.toUpperCase();
                e.target.value = value;
                
                // Move to next input if value entered
                if (value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                
                // Update voucher code
                updateVoucherCode();
            });
            
            // Handle keyboard events
            input.addEventListener('keydown', (e) => {
                // Handle backspace navigation
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
                
                // Handle paste functionality
                if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    navigator.clipboard.readText().then(text => {
                        const cleanText = text.replace(/\s/g, '').toUpperCase().slice(0, 6);
                        for (let i = 0; i < cleanText.length && i < otpInputs.length; i++) {
                            otpInputs[i].value = cleanText[i];
                        }
                        updateVoucherCode();
                        if (cleanText.length < 6) {
                            otpInputs[cleanText.length].focus();
                        }
                    });
                }
            });
        });

        // Update voucher code and auto-submit
        function updateVoucherCode() {
            const voucherCode = Array.from(otpInputs).map(input => input.value).join('');
            username.value = voucherCode.toLowerCase();
            password.value = voucherCode.toLowerCase();

            // Auto-submit when 6 characters entered
            if (voucherCode.length === 6) {
                document.forms.login.submit();
            }
        }

        // Focus on first OTP input on page load
        document.getElementById('otp1').focus();

        // ========================================
        // TRIAL FUNCTIONALITY
        // ========================================
        function handleTrial() {
            const mac = "<?php echo $mac; ?>";
            fetch(`cek_trial.php?mac=${mac}`)
                .then(response => response.json())
                .then(data => {
                    if (data.TrialOk === true) {
                        showAlert("⚠️ Anda sudah menggunakan TRIAL hari ini.<br/>Silahkan kembali lagi besok!");
                    } else {
                        window.location.href = `./trial.php?mac=${mac}`;
                    }
                })
                .catch(error => {
                    console.error('Gagal cek status trial:', error);
                    showAlert("Terjadi kesalahan saat mengecek status trial.");
                });
        }

        // ========================================
        // UTILITY FUNCTIONS
        // ========================================
        function formatTime(seconds) {
            if (seconds < 60) {
                return `${seconds} detik`;
            } else if (seconds < 3600) {
                let minutes = Math.floor(seconds / 60);
                return `${minutes} menit`;
            } else if (seconds < 86400) {
                let hours = Math.floor(seconds / 3600);
                return `${hours} jam`;
            } else {
                let days = Math.floor(seconds / 86400);
                return `${days} hari`;
            }
        }

        // ========================================
        // PACKAGE LOADING AND DISPLAY
        // ========================================
        fetch('get_package.php')
            .then(response => response.json())
            .then(data => {
                let ipAddress = "<?php echo $ip; ?>";
                let macAddress = "<?php echo $mac; ?>";
                let paketList = document.getElementById('paket-list');
                
                // Sort packages by price
                data.sort((a, b) => parseInt(a.planCost) - parseInt(b.planCost));
                paketList.innerHTML = "";
                
                // Generate package rows
                data.forEach(paket => {
                    let hargaAsli = parseInt(paket.planCost);
                    let hargaAcak = Math.floor(Math.random() * 100) + 1;
                    let hargaTotal = hargaAsli + hargaAcak;
                    
                    let row = `
                        <tr>
                            <td>${paket.planName}</td>
                            <td>${formatTime(paket.value)}</td>
                            <td>Rp.${hargaAsli.toLocaleString('id-ID')}</td>
                            <td>
                                <button class="buy-btn" onClick="beliPaket('${paket.planName}', ${hargaTotal}, '${ipAddress}', '${macAddress}')">Beli</button>
                            </td>
                        </tr>
                    `;
                    paketList.innerHTML += row;
                });
            })
            .catch(error => console.error('Gagal mengambil data:', error));

        // ========================================
        // PACKAGE PURCHASE FUNCTIONALITY
        // ========================================
        function beliPaket(namaPaket, hargapaket, ip, mac) {
            let message = `Apakah Anda yakin ingin membeli paket ${namaPaket} dengan harga Rp.${hargapaket.toLocaleString('id-ID')}?`;
            showConfirmDialog(message, function () {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'redirect.php';
                
                const fields = {
                    paket: namaPaket,
                    harga: hargapaket,
                    ipaddress: ip,
                    macaddress: mac
                };
                
                for (const key in fields) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = fields[key];
                    form.appendChild(input);
                }
                
                document.body.appendChild(form);
                form.submit();
            });
        }

        // ========================================
        // MODAL DIALOG FUNCTIONS
        // ========================================
        function showConfirmDialog(message, callbackYes, callbackNo) {
            document.getElementById('modalMessage').innerHTML = message;
            document.getElementById('modalYes').style.display = 'inline-block';
            document.getElementById('modalNo').style.display = 'inline-block';
            document.getElementById('modalOk').style.display = 'none';
            document.getElementById('customModal').style.display = 'flex';
            
            document.getElementById('modalYes').onclick = function () {
                document.getElementById('customModal').style.display = 'none';
                callbackYes();
            };
            
            document.getElementById('modalNo').onclick = function () {
                document.getElementById('customModal').style.display = 'none';
                if (callbackNo) callbackNo();
            };
        }

        function showAlert(message, callbackOk) {
            document.getElementById('modalMessage').innerHTML = message;
            document.getElementById('modalYes').style.display = 'none';
            document.getElementById('modalNo').style.display = 'none';
            document.getElementById('modalOk').style.display = 'inline-block';
            document.getElementById('customModal').style.display = 'flex';
            
            document.getElementById('modalOk').onclick = function () {
                document.getElementById('customModal').style.display = 'none';
                if (callbackOk) callbackOk();
            };
        }

        // ========================================
        // PAYMENT STATUS CHECKING
        // ========================================
        const macAddress = "<?php echo $mac; ?>";
        
        function cekStatus() {
            fetch(`cek_payment.php?mac=${encodeURIComponent(macAddress)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const url = 'redirect_sukses.php?username=' + encodeURIComponent(data.username) +
                                    '&paket=' + encodeURIComponent(data.profile) +
                                    '&harga=' + encodeURIComponent(data.amount) +
                                    '&ref=' + encodeURIComponent(data.trx_id);
                        window.location.href = url;
                    } else {
                        setTimeout(cekStatus, 1000);
                    }
                })
                .catch(err => {
                    console.error('Error cek status:', err);
                    setTimeout(cekStatus, 1000);
                });
        }

        // Start payment status checking on page load
        window.addEventListener('load', () => {
            cekStatus();
        });
    </script>
</body>
</html>
