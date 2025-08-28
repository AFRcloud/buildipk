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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waktu Habis - AFR-Cloud.NET</title>
    <meta name="theme-color" content="#0F172A" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Main Content -->
    <div class="main-container">
        <div class="content-container">
            <!-- Header -->
            <header class="header">
                <div class="logo-container">
                    <img src="/RadMonv2/img/logo/radmon-logo.png" width="100%" height="auto" style="max-width: 400px; margin-bottom: 10px;" alt="Logo" class="logo">
                    <div class="logo-glow"></div>
                </div>
            </header>
            
            <!-- Main Card -->
            <div class="main-card">
                <!-- Timeout Content -->
                <div class="tab-content active">
                    <!-- Clock Widget -->
                    <div class="clock-widget">
                        <div class="time-display" id="current-time">00:00:00</div>
                        <div class="date-display" id="current-date">Loading...</div>
                    </div>
                    
                    <!-- Timeout Info -->
                    <div class="login-info" style="background: rgba(239, 68, 68, 0.1); border-left-color: var(--danger);">
                        <svg class="info-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--danger);">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <span class="info-text" style="color: var(--danger); font-weight: 600;">Waktu Pembayaran Telah Habis</span>
                    </div>
                    
                    <!-- Timeout Message -->
                    <div style="text-align: center; padding: 2rem 1rem; background: rgba(15, 23, 42, 0.5); border-radius: var(--radius); margin-bottom: 1.5rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <div style="margin-bottom: 1.5rem;">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.8;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        
                        <h2 style="color: var(--text-primary); font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; background: linear-gradient(to right, var(--danger), #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Waktu Pembayaran Habis
                        </h2>
                        
                        <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.6; margin-bottom: 1rem;">
                            Maaf, waktu untuk melakukan pembayaran telah habis.
                        </p>
                        
                        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">
                            Silakan lakukan pemesanan ulang atau hubungi layanan pelanggan untuk bantuan lebih lanjut.
                        </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-ripple" onclick="window.location.href='http://10.10.10.1:3990'">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Kembali ke Beranda
                        </button>
                        <button type="button" class="btn btn-secondary btn-ripple" onclick="window.location.reload()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <polyline points="1 20 1 14 7 14"></polyline>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                            </svg>
                            Muat Ulang
                        </button>
                    </div>
                    
                    <!-- Additional Info -->
                    <div style="background: rgba(139, 92, 246, 0.1); border-radius: var(--radius); padding: 1rem; margin-top: 1.5rem; border: 1px solid rgba(139, 92, 246, 0.2); text-align: center;">
                        <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">
                            Butuh bantuan?
                        </div>
                        <div style="color: var(--secondary-light); font-size: 1rem; font-weight: 600;">
                            Hubungi Customer Service
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <p>Sistem akan otomatis mengarahkan Anda kembali</p>
                <div style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.8rem;">
                    <span id="countdown">Mengarahkan dalam <span id="countdown-timer">10</span> detik...</span>
                </div>
            </footer>
        </div>
    </div>

    <script type="text/javascript">
        // Clock functionality for Jakarta/WIB timezone
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
            
            // Update every second
            setTimeout(updateClock, 1000);
        }
        
        // Initialize clock
        updateClock();

        // Countdown timer for auto redirect
        let countdownTime = 10;
        const countdownElement = document.getElementById('countdown-timer');
        const countdownContainer = document.getElementById('countdown');
        
        function updateCountdown() {
            countdownElement.textContent = countdownTime;
            
            if (countdownTime <= 0) {
                countdownContainer.textContent = 'Mengarahkan...';
                window.location.href = 'http://10.10.10.1:3990';
                return;
            }
            
            countdownTime--;
            setTimeout(updateCountdown, 1000);
        }
        
        // Start countdown
        updateCountdown();

        // Add ripple effect to buttons
        document.querySelectorAll('.btn-ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add fade in animation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.main-container').style.animation = 'fadeInUp 0.8s ease';
        });
    </script>

    <style>
        /* Additional styles for timeout page */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Pulse animation for the clock icon */
        .main-card svg[width="64"] {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        /* Smooth transitions */
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }
    </style>
</body>
</html>
