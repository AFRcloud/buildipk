<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 

require './config/db_config.php';

// Get parameters
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';

// Database connection
$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

// Get admin number from database
$command = "mysql -u {$user} -p{$pass} -h {$host} -D {$db} -e \"SELECT hscsn FROM print_config LIMIT 1\" -s -N";
$admin_number = trim(shell_exec($command));

// Format phone number
if (strpos($admin_number, '62') === 0) {
    $cs_number = '0' . substr($admin_number, 2);
} else {
    $cs_number = $admin_number;
}
$formatted = substr($cs_number, 0, 4) . '-' . substr($cs_number, 4, 4) . '-' . substr($cs_number, 8);
?>        

<!doctype html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<style>

</style>
<body>
    <!-- Modal Dialog -->
    <div id="customConfirm" class="modal" style="display: none;">
        <div class="modal-content">
            <p id="confirmMessage" class="modal-message"></p>
            <div class="modal-actions">
                <button id="confirmYes" class="btn btn-primary">Ya</button>
                <button id="confirmNo" class="btn btn-secondary">Batal</button>
                <button id="confirmOk" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>

    <!-- Loading Screen -->
    <div id="pleaseWait" class="loading-screen" style="display:none;">
        <img src="/RadMonv2/img/logo/radmon-logo.png" alt="Logo" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-text">Menghubungkan ke jaringan...</div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-container">
<!-- Header -->
<header class="header">
    <div class="logo-container">
        <svg class="logo-icon" width="54" height="54" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
            <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
            <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
            <line x1="12" y1="20" x2="12.01" y2="20"></line>
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#0EA5E9" />
                    <stop offset="100%" stop-color="#8B5CF6" />
                </linearGradient>
            </defs>
        </svg>

        <p class="site-title">AFR-Cloud.NET</p>

        <div class="gradient-line"></div>

        <p class="site-subtitle">Unlimited Internet Hotspot</p>
    </div>
</header>
            
            <!-- Main Card -->
            <div class="main-card">
                <!-- Navigation Tabs -->
                <div class="nav-tabs">
                    <div class="nav-tab active" onclick="switchTab('login-tab', 0)">
                        <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        Login
                    </div>
                    <div class="nav-tab" onclick="switchTab('package-tab', 1)">
                        <svg class="btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        Paket
                    </div>
                    <div class="tab-indicator"></div>
                </div>

                <!-- Login Tab Content -->
                <div id="login-tab" class="tab-content active">
                    <!-- Clock Widget -->
                    <div class="clock-widget">
                        <div class="time-display" id="current-time">00:00:00</div>
                        <div class="date-display" id="current-date">Loading...</div>
                    </div>
                    
                    <!-- Login Info -->
                    <div class="login-info">
                        <svg class="info-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span class="info-text" id="infologin">Masukkan Kode Voucher untuk login</span>
                    </div>
                    
                    <!-- Network Status -->
                    <div class="network-status-container">
                        <div class="network-status">
                            <div class="network-info">
                                <div class="network-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
                                        <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                                        <line x1="12" y1="20" x2="12.01" y2="20"></line>
                                    </svg>
                                </div>
                                <div class="network-details">
                                    <div class="network-label">Status Jaringan</div>
                                    <div class="network-value" id="signal-status">Mengukur...</div>
                                </div>
                            </div>
                            <div class="signal-indicator">
                                <div class="signal-bars">
                                    <div class="signal-bar signal-bar-1" id="bar-1"></div>
                                    <div class="signal-bar signal-bar-2" id="bar-2"></div>
                                    <div class="signal-bar signal-bar-3" id="bar-3"></div>
                                    <div class="signal-bar signal-bar-4" id="bar-4"></div>
                                    <div class="signal-bar signal-bar-5" id="bar-5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Login Form -->
                    <form autocomplete="off" name="login" action="<?php echo $loginpath; ?>" method="post" class="login-form">
                        <input type="hidden" name="dst" value="$(link-orig)" />
                        <input type="hidden" name="popup" value="true" />
                        <input class="username" name="username" type="hidden" value="$(username)" />
                        <input type="hidden" name="challenge" value="<?php echo $challenge; ?>">
                        <input type="hidden" name="uamip" value="<?php echo $uamip; ?>">
                        <input type="hidden" name="uamport" value="<?php echo $uamport; ?>">
                        <input type="hidden" name="userurl" value="<?php echo $userurl; ?>">

                        <div class="form-group">
                            <input class="form-control" name="UserName" type="text" id="user" placeholder="Masukkan kode voucher di sini" required autofocus />
                            <button type="button" class="qr-button-input" onclick="window.location='https://maizil41.github.io/scanner';">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </button>
                        </div>
                        <input type="hidden" id="pass" class="password" name="Password" placeholder="Password" required />
                        <input type="hidden" name="button" value="Login">
                        
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary btn-ripple" onClick='javascript:popUp("$loginpath?res=popup1&uamip=$uamip&uamport=$uamport")'>
                                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                </svg>
                                MASUK
                            </button>
                            <button type="button" class="btn btn-secondary btn-ripple" onclick="handleTrial()" id="trialButton">
                                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"></path>
                                </svg>
                                GRATIS
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Package Tab Content -->
                <div id="package-tab" class="tab-content">
                    <div class="package-header-simple">
                        <h3 class="package-title-simple">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            </svg>
                            Pilih Paket Internet
                        </h3>
                    </div>
                    
                    <div class="package-grid" id="paket-list">
                        <!-- Loading skeleton -->
                        <div class="package-item skeleton">
                            <div class="package-content">
                                <div class="skeleton-name"></div>
                                <div class="skeleton-bandwidth"></div>
                                <div class="skeleton-price"></div>
                            </div>
                            <div class="package-buttons">
                                <div class="skeleton-btn"></div>
                                <div class="skeleton-btn-small"></div>
                            </div>
                        </div>
                        
                        <div class="package-item skeleton">
                            <div class="package-content">
                                <div class="skeleton-name"></div>
                                <div class="skeleton-bandwidth"></div>
                                <div class="skeleton-price"></div>
                            </div>
                            <div class="package-buttons">
                                <div class="skeleton-btn"></div>
                                <div class="skeleton-btn-small"></div>
                            </div>
                        </div>
                    </div>
                </div>



            <!-- Footer -->
            <footer class="footer">
                <p>Butuh bantuan? Hubungi kami</p>
                <a href="https://wa.me/<?php echo $admin_number ?>" class="contact-link">
                    <svg class="contact-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <?php echo $formatted ?>
                </a>
            </footer>
        </div>
    </div>

    <!-- Background Music -->
    <audio id="backgroundMusic" loop preload="auto" src="assets/audio/background-music.mp3"></audio>

    <script>
        // Global Variables
        const hostname = window.location.hostname;
        const macAddress = "<?php echo $mac; ?>";
        const adminNumber = "<?php echo $admin_number; ?>";
        
        let currentPrayerTimes = null;
        let prayerCountdownInterval = null;
        let isMaintenance = false;
        let maintenanceMsg = "";
        let backgroundMusic = null;
        let isMusicPlaying = false;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializePage();
            initializeMusic();
            loadMaintenanceStatus();
            cekStatus();
        });

        function initializePage() {
            document.getElementById('title').innerHTML = hostname + " > login";
            document.login.username.focus();
            
            const infologin = document.getElementById('infologin');
            infologin.innerHTML = "Masukkan Kode Voucher untuk login.";
            
            voucher(); // Set voucher mode
            updateClock();
            updateNetworkStatus();
            loadPackages();
            
            // Set tab indicator position
            const activeTab = document.querySelector('.nav-tab.active');
            const tabIndex = Array.from(activeTab.parentNode.children).indexOf(activeTab);
            document.querySelector('.tab-indicator').style.transform = `translateX(${tabIndex * 100}%)`;
            
            // Network status check interval
            setInterval(updateNetworkStatus, 10000);
        }

        // Clock Functions
        function updateClock() {
            const options = { 
                timeZone: 'Asia/Jakarta',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: false
            };
            
            const dateOptions = {
                timeZone: 'Asia/Jakarta',
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', options);
            const dateString = now.toLocaleDateString('id-ID', dateOptions);
            
            document.getElementById('current-time').textContent = timeString;
            document.getElementById('current-date').textContent = dateString;
            
            setTimeout(updateClock, 1000);
        }

        // Network Status Functions
        function updateNetworkStatus() {
            checkNetworkSpeed()
                .then(speed => updateSignalStrength(speed))
                .catch(error => {
                    console.error('Error checking network speed:', error);
                    setSignalStrength(0);
                });
        }

        function checkNetworkSpeed() {
            return new Promise((resolve, reject) => {
                const startTime = new Date().getTime();
                const imageUrl = '/RadMonv2/img/logo/radmon-logo.png?t=' + startTime;
                
                const img = new Image();
                img.onload = function() {
                    const endTime = new Date().getTime();
                    const duration = endTime - startTime;
                    
                    let speed;
                    if (duration < 100) speed = 5;
                    else if (duration < 300) speed = 4;
                    else if (duration < 600) speed = 3;
                    else if (duration < 1000) speed = 2;
                    else speed = 1;
                    
                    resolve(speed);
                };
                
                img.onerror = () => reject(new Error('Failed to load test image'));
                img.src = imageUrl;
                
                setTimeout(() => {
                    if (!img.complete) reject(new Error('Network test timed out'));
                }, 5000);
            });
        }

        function updateSignalStrength(level) {
            setSignalStrength(level);
            
            const statusTexts = {
                5: 'Sangat Baik (Kecepatan Tinggi)',
                4: 'Baik (Kecepatan Baik)',
                3: 'Sedang (Kecepatan Normal)',
                2: 'Lemah (Kecepatan Rendah)',
                1: 'Sangat Lemah (Kecepatan Lambat)',
                0: 'Tidak Tersedia (Periksa Koneksi)'
            };
            
            document.getElementById('signal-status').textContent = statusTexts[level] || statusTexts[0];
        }

        function setSignalStrength(level) {
            for (let i = 1; i <= 5; i++) {
                const bar = document.getElementById('bar-' + i);
                if (i <= level) {
                    bar.classList.remove('inactive');
                } else {
                    bar.classList.add('inactive');
                }
            }
        }

        // Login Functions
        function setpass() {
            const username = document.login.username;
            const password = document.getElementById('pass');
            const user = username.value.toLowerCase();
            username.value = user;
            password.value = user;
        }

        function voucher() {
            const username = document.login.username;
            const password = document.getElementById('pass');
            const infologin = document.getElementById('infologin');
            
            username.focus();
            username.onkeyup = setpass;
            username.placeholder = "Kode Voucher";
            username.style.borderRadius = "3px";
            password.type = "hidden";
            infologin.innerHTML = "Masukkan Kode Voucher<br>kemudian klik login.";
        }

        // Tab Functions
        function switchTab(tabId, tabIndex) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
            
            document.querySelector('.tab-indicator').style.transform = `translateX(${tabIndex * 100}%)`;
            
            if (tabId === 'prayer-tab' && !currentPrayerTimes) {
                loadPrayerTimes();
            }
        }

        // Trial Functions
        function handleTrial() {
            if (isMaintenance) {
                showAlert(maintenanceMsg);
                return;
            }

            fetch(`cek_trial.php?mac=${macAddress}`)
                .then(response => response.json())
                .then(data => {
                    if (data.TrialOk === true) {
                        showAlert("⚠️ Anda sudah menggunakan TRIAL hari ini.<br/>Silahkan kembali lagi besok!.");
                    } else {
                        window.location.href = `./trial.php?mac=${macAddress}`;
                    }
                })
                .catch(error => {
                    console.error('Gagal cek status trial:', error);
                    showAlert("Terjadi kesalahan saat mengecek status trial.");
                });
        }

        // Package Functions
        function loadPackages() {
            fetch('get_package.php')
                .then(response => response.json())
                .then(data => {
                    const ipAddress = "<?php echo $ip; ?>"; 
                    const paketList = document.getElementById('paket-list');
                    paketList.innerHTML = ""; 

                    data.sort((a, b) => parseInt(a.planCost) - parseInt(b.planCost));

                    data.forEach((paket, index) => {
                        const hargaAsli = parseInt(paket.planCost);
                        const hargaAcak = Math.floor(Math.random() * 100) + 1;
                        const hargaTotal = hargaAsli + hargaAcak;
                        
                        const duration = formatDurationFromData(paket);
                        
                        const card = document.createElement('div');
                        card.className = 'package-item';
                        card.style.animationDelay = `${index * 0.1}s`;
                        card.innerHTML = `
                            <div class="package-content">
                                <div class="package-name-simple">${paket.planName}</div>
                                <div class="package-duration-simple">${duration}</div>
                                <div class="package-price-simple">Rp ${hargaAsli.toLocaleString('id-ID')}</div>
                            </div>
                            <div class="package-buttons">
                                <button class="btn-buy-simple" onClick="beliPaket('${paket.planName}', ${hargaTotal}, '${ipAddress}', '${macAddress}')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Beli
                                </button>
                                <button class="btn-wa-simple" onClick="beliViaWhatsapp('${paket.planName}')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                    </svg>
                                    WA
                                </button>
                            </div>`;
                        paketList.appendChild(card);
                    });
                })
                .catch(error => console.error('Gagal mengambil data:', error));
        }

        function formatDuration(seconds) {
            if (seconds < 60) return `${seconds} detik`;
            else if (seconds < 3600) return `${Math.floor(seconds / 60)} menit`;
            else if (seconds < 86400) return `${Math.floor(seconds / 3600)} jam`;
            else return `${Math.floor(seconds / 86400)} hari`;
        }

        function formatDurationFromData(paket) {
            let duration = paket.duration_value || paket.planTimeBank;
            
            if (!duration || duration === '' || duration === '0') {
                return '⏱️ Unlimited';
            }
            
            let seconds = parseInt(duration);
            if (isNaN(seconds)) return '⏱️ -';
            
            return `⏱️ ${formatDuration(seconds)}`;
        }

        function beliPaket(namaPaket, hargapaket, ip, mac) {
            if (isMaintenance) {
                showAlert(maintenanceMsg);
                return;
            }
            
            const message = `Apakah Anda yakin ingin membeli paket ${namaPaket} dengan harga Rp.${hargapaket.toLocaleString('id-ID')}?`;
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

        function beliViaWhatsapp(namaPaket) {
            const message = `Beli ${namaPaket}`;
            
            showConfirmDialog(`Apakah Anda yakin ingin membeli paket ${namaPaket} via WhatsApp?`, function() {
                const whatsappUrl = `https://wa.me/${adminNumber}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
            });
        }

        // Prayer Times Functions

        // Maintenance Functions
        function loadMaintenanceStatus() {
            fetch('maintenance.php')
                .then(response => response.json())
                .then(data => {
                    isMaintenance = data.maintenance;
                    if (isMaintenance) {
                        maintenanceMsg = `⛔ ${data.pesan}<br>Estimasi: ${data.estimasi}`;
                    }
                })
                .catch(error => console.error('Gagal mengambil status maintenance:', error));
        }

        // Payment Status Functions
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

        // Music Functions
        function initializeMusic() {
            backgroundMusic = document.getElementById('backgroundMusic');
            
            if (backgroundMusic) {
                backgroundMusic.volume = 0.3;
                
                document.addEventListener('click', function() {
                    if (!isMusicPlaying) tryPlayMusic();
                }, { once: true });
                
                backgroundMusic.addEventListener('error', function() {
                    console.log('Error loading background music');
                });
            }
        }

        function tryPlayMusic() {
            if (backgroundMusic && !isMusicPlaying) {
                const playPromise = backgroundMusic.play();
                
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        isMusicPlaying = true;
                    }).catch(error => {
                        console.log('Autoplay prevented:', error);
                    });
                }
            }
        }

        function toggleMusic() {
            if (!backgroundMusic) return;
            
            if (isMusicPlaying) {
                backgroundMusic.pause();
                isMusicPlaying = false;
            } else {
                const playPromise = backgroundMusic.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        isMusicPlaying = true;
                    }).catch(error => {
                        console.log('Play failed:', error);
                    });
                }
            }
        }

        // Dialog Functions
        function showConfirmDialog(message, callbackYes, callbackNo) {
            document.getElementById('confirmMessage').innerHTML = message;

            document.getElementById('confirmYes').style.display = 'inline-block';
            document.getElementById('confirmNo').style.display = 'inline-block';
            document.getElementById('confirmOk').style.display = 'none';

            document.getElementById('customConfirm').style.display = 'flex';

            document.getElementById('confirmYes').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                callbackYes();
            };
            document.getElementById('confirmNo').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                if (callbackNo) callbackNo();
            };
        }

        function showAlert(message, callbackOk) {
            document.getElementById('confirmMessage').innerHTML = message;

            document.getElementById('confirmYes').style.display = 'none';
            document.getElementById('confirmNo').style.display = 'none';
            document.getElementById('confirmOk').style.display = 'inline-block';

            document.getElementById('customConfirm').style.display = 'flex';

            document.getElementById('confirmOk').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                if (callbackOk) callbackOk();
            };
        }
        // Tambahkan script ini di bagian JavaScript

    </script>

    <style>
        .package-header-simple {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .package-title-simple {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--text-primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .package-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .package-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            padding: 1rem;
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
            position: relative;
            overflow: hidden;
        }

        .package-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, 
                #ff0000, #ff9a00, #d0de21, #4fdc4a, #3fdad8, #2fc9e2, #1c7fee, #5f15f2, #ba0cf8, #fb07d9, #ff0000);
            background-size: 200% 100%;
            animation: rainbow 6s linear infinite;
            z-index: 1;
        }

        .package-item:hover {
            transform: translateY(-3px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            background: rgba(15, 23, 42, 0.8);
        }

        .package-content {
            margin-bottom: 1rem;
        }

        .package-name-simple {
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            line-height: 1.3;
        }

        .package-duration-simple {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 500;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            opacity: 0.8;
        }

        .package-price-simple {
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 0.2rem;
        }

        .package-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-buy-simple {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.6rem 0.8rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-buy-simple:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-wa-simple {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 0.6rem;
            background: linear-gradient(135deg, #25d366, #128c7e);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 60px;
        }

        .btn-wa-simple:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }

        /* Skeleton Loading */
        .package-item.skeleton {
            opacity: 0.6;
            pointer-events: none;
        }

        .skeleton-name, .skeleton-bandwidth, .skeleton-price, .skeleton-btn, .skeleton-btn-small {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            animation: pulse 2s infinite;
        }

        .skeleton-name {
            height: 1rem;
            width: 80%;
            margin-bottom: 0.5rem;
        }

        .skeleton-price {
            height: 1.1rem;
            width: 60%;
        }

        .skeleton-btn {
            height: 2.2rem;
            flex: 1;
        }

        .skeleton-btn-small {
            height: 2.2rem;
            width: 60px;
        }

        /* Animations */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes rainbow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .package-grid {
                gap: 0.75rem;
            }
            
            .package-item {
                padding: 0.8rem;
            }
            
            .package-name-simple {
                font-size: 0.9rem;
            }
            
            .package-price-simple {
                font-size: 1rem;
            }
            
            .btn-buy-simple {
                padding: 0.5rem 0.6rem;
                font-size: 0.75rem;
            }
            
            .btn-wa-simple {
                padding: 0.5rem;
                min-width: 50px;
            }
        }

        :root {
            --success: #22c55e;
        }
        

.gradient-line {
    height: 3px;
    width: 200px;
    background: linear-gradient(90deg,
        #ff0000, #ff9a00, #d0de21, #4fdc4a,
        #3fdad8, #2fc9e2, #1c7fee, #5f15f2,
        #ba0cf8, #fb07d9, #ff0000);
    background-size: 200% 100%;
    animation: moveGradient 5s linear infinite;
    clip-path: polygon(0% 50%, 5% 0%, 95% 0%, 100% 50%, 95% 100%, 5% 100%);
    
}

@keyframes moveGradient {
    0% {
        background-position: 0% 50%;
    }
    100% {
        background-position: 100% 50%;
    }
}

</style>
</body>
</html>