<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
session_start();

if (!isset($_SESSION['transaksi_sukses'])) {
  header("Location: ./");
  exit();
}

$data = $_SESSION['transaksi_sukses'];
$username = $data['username'];
$reff = $data['reff'];
$plan_name = $data['paket'];
$harga = $data['harga'];

// unset($_SESSION['transaksi_sukses']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - AFR-Cloud.NET</title>
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
                <!-- Success Content -->
                <div class="tab-content active">
                    <!-- Clock Widget -->
                    <div class="clock-widget">
                        <div class="time-display" id="current-time">00:00:00</div>
                        <div class="date-display" id="current-date">Loading...</div>
                    </div>
                    
                    <!-- Success Info -->
                    <div class="login-info" style="background: rgba(34, 197, 94, 0.1); border-left-color: var(--success);">
                        <svg class="info-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--success);">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span class="info-text" style="color: var(--success); font-weight: 600;">Pembayaran Berhasil!</span>
                    </div>
                    
                    <!-- Success Animation -->
                    <div style="text-align: center; padding: 2rem 1rem; margin-bottom: 1.5rem;">
                        <div class="success-animation" style="margin-bottom: 1.5rem;">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: successPulse 2s infinite;">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        
                        <h2 style="color: var(--text-primary); font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; background: linear-gradient(to right, var(--success), #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Pembayaran Berhasil!
                        </h2>
                        
                        <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.6;">
                            Transaksi Anda telah berhasil diproses
                        </p>
                    </div>
                    
                    <!-- Transaction Details -->
                    <div class="transaction-details" style="background: rgba(15, 23, 42, 0.5); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <h3 style="color: var(--text-primary); font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Detail Transaksi
                        </h3>
                        
                        <div class="detail-grid" style="display: grid; gap: 1rem;">
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Paket:</span>
                                <span style="color: var(--text-primary); font-weight: 600;"><?= $plan_name ?></span>
                            </div>
                            
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Harga:</span>
                                <span style="color: var(--success); font-weight: 700; font-size: 1.1rem;">Rp <?= number_format((int)$harga, 0, ',', '.') ?></span>
                            </div>
                            
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Ref ID:</span>
                                <span style="color: var(--text-primary); font-weight: 600; font-family: monospace;"><?= $reff ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Voucher Code -->
                    <div class="voucher-section" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1)); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(139, 92, 246, 0.2); text-align: center;">
                        <h3 style="color: var(--text-primary); font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            Kode Voucher Anda
                        </h3>
                        
                        <div class="voucher-code-container" style="background: rgba(15, 23, 42, 0.8); border-radius: var(--radius); padding: 1rem; margin-bottom: 1rem; border: 2px dashed rgba(139, 92, 246, 0.3);">
                            <div id="voucher-container" class="voucher-code" onclick="copyVoucher()" style="cursor: pointer; position: relative; display: inline-block; padding: 0.5rem 1rem; background: rgba(139, 92, 246, 0.1); border-radius: var(--radius-sm); transition: all 0.3s ease;">
                                <span id="voucher" style="color: var(--secondary-light); font-weight: 700; font-size: 1.5rem; font-family: monospace; letter-spacing: 2px;"><?= $username ?></span>
                                <svg style="margin-left: 0.5rem; vertical-align: middle;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </div>
                            
                            <div id="copied-notification" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: var(--success); color: white; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-weight: 600; z-index: 1000; animation: fadeInOut 2s ease;">
                                ✅ Tersalin!
                            </div>
                        </div>
                        
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0;">
                            Klik kode voucher untuk menyalin
                        </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-ripple" onclick="window.location.href='http://10.10.10.1:3990/login?username=<?= $username ?>&password=Accept'">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Login Sekarang
                        </button>
                        <button type="button" class="btn btn-secondary btn-ripple" onclick="window.location.href='http://10.10.10.1:3990'">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Kembali ke Beranda
                        </button>
                    </div>
                    
                    <!-- Additional Info -->
                    <div style="background: rgba(34, 197, 94, 0.1); border-radius: var(--radius); padding: 1rem; margin-top: 1.5rem; border: 1px solid rgba(34, 197, 94, 0.2); text-align: center;">
                        <div style="color: var(--success); font-size: 0.9rem; margin-bottom: 0.5rem; font-weight: 600;">
                            ✅ Transaksi Berhasil
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.85rem;">
                            Voucher siap digunakan untuk akses internet
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <p>Terima kasih telah menggunakan layanan kami</p>
                <div style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.8rem;">
                    Simpan kode voucher Anda dengan aman
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

        // Enhanced copy voucher function
        function copyVoucher() {
            const text = document.getElementById("voucher").innerText;
            const container = document.getElementById("voucher-container");
            const notification = document.getElementById("copied-notification");
            
            // Modern clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopySuccess();
                }).catch(() => {
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                fallbackCopyTextToClipboard(text);
            }
            
            function fallbackCopyTextToClipboard(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    showCopySuccess();
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                
                document.body.removeChild(textArea);
            }
            
            function showCopySuccess() {
                // Add visual feedback
                container.style.transform = "scale(0.95)";
                container.style.background = "rgba(34, 197, 94, 0.2)";
                
                // Show notification
                notification.style.display = "block";
                
                setTimeout(() => {
                    container.style.transform = "scale(1)";
                    container.style.background = "rgba(139, 92, 246, 0.1)";
                    notification.style.display = "none";
                }, 2000);
            }
        }

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

        // Add hover effect to voucher container
        document.getElementById('voucher-container').addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.background = 'rgba(139, 92, 246, 0.15)';
        });

        document.getElementById('voucher-container').addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.background = 'rgba(139, 92, 246, 0.1)';
        });

        // Add fade in animation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.main-container').style.animation = 'fadeInUp 0.8s ease';
        });

        // Confetti effect (optional)
        function createConfetti() {
            const colors = ['#22c55e', '#3b82f6', '#8b5cf6', '#f59e0b', '#ef4444'];
            
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = '-10px';
                    confetti.style.width = '10px';
                    confetti.style.height = '10px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                    confetti.style.pointerEvents = 'none';
                    confetti.style.zIndex = '9999';
                    confetti.style.animation = `confettiFall ${Math.random() * 3 + 2}s linear forwards`;
                    
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 5000);
                }, i * 100);
            }
        }

        // Trigger confetti on page load
        setTimeout(createConfetti, 500);
    </script>

    <style>
        /* Additional styles for success page */
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

        /* Success pulse animation */
        @keyframes successPulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        /* Confetti animation */
        @keyframes confettiFall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Fade in out animation for notifications */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            20% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
            80% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
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

        .voucher-code {
            transition: all 0.3s ease;
        }

        .detail-item {
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            transform: translateX(4px);
        }

        /* Success color variable */
        :root {
            --success: #22c55e;
        }
    </style>
</body>
</html>
