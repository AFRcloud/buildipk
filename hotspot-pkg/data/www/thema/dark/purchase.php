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
require './config/db_config.php';

if (!isset($_SESSION['transaksi'])) {
    die("Akses tidak sah.");
}

$username = $_SESSION['transaksi']['username'];
$paket = $_SESSION['transaksi']['paket'];
$harga = $_SESSION['transaksi']['harga'];
$ref = $_SESSION['transaksi']['ref'];
$qrFile = $_SESSION['transaksi']['qr'];

$host = $db_config['servername'];
$user = $db_config['username'];
$pass = $db_config['password'];
$db   = $db_config['dbname'];

$command = "mysql -u {$user} -p{$pass} -h {$host} -D {$db} -e \"SELECT hscsn FROM print_config LIMIT 1\" -s -N";

$admin_number = trim(shell_exec($command));

if (strpos($admin_number, '62') === 0) {
    $cs_number = '0' . substr($admin_number, 2);
} else {
    $cs_number = $admin_number;
}

$formatted = substr($cs_number, 0, 4) . '-' . substr($cs_number, 4, 4) . '-' . substr($cs_number, 8);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Paket - AFR-Cloud.NET</title>
    <meta name="theme-color" content="#0F172A" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Modal Dialog -->
    <div id="customConfirm" class="modal" style="display: none;">
        <div class="modal-content">
            <p id="confirmMessage" class="modal-message"></p>
            <div class="modal-actions">
                <button id="confirmYes" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-container">
            <!-- Header -->
            <header class="header">
                <div class="logo-container">
                    <div class="logo-glow"></div>
                </div>
            </header>
            
            <!-- Main Card -->
            <div class="main-card">
                <!-- Payment Content -->
                <div class="tab-content active">
                    <!-- Clock Widget -->
                    <div class="clock-widget">
                        <div class="time-display" id="current-time">00:00:00</div>
                        <div class="date-display" id="current-date">Loading...</div>
                    </div>
                    
                    <!-- Payment Info -->
                    <div class="login-info" style="background: rgba(59, 130, 246, 0.1); border-left-color: var(--primary);">
                        <svg class="info-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        <span class="info-text" style="color: var(--primary); font-weight: 600;">Silakan Scan QR Code untuk Pembayaran</span>
                    </div>
                    
                    <!-- Package Details -->
                    <div class="package-details" style="background: rgba(15, 23, 42, 0.5); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <h3 style="color: var(--text-primary); font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            Detail Paket
                        </h3>
                        
                        <div class="detail-grid" style="display: grid; gap: 1rem;">
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Paket:</span>
                                <span style="color: var(--text-primary); font-weight: 600;"><?php echo htmlspecialchars($paket); ?></span>
                            </div>
                            
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Total Pembayaran:</span>
                                <span id="total-pembayaran" style="color: var(--primary); font-weight: 700; font-size: 1.2rem;">Rp 0</span>
                            </div>
                            
                            <div class="detail-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(255, 255, 255, 0.02); border-radius: var(--radius-sm); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <span style="color: var(--text-muted); font-size: 0.9rem;">Ref ID:</span>
                                <span style="color: var(--text-primary); font-weight: 600; font-family: monospace;"><?php echo htmlspecialchars($ref); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QR Code Section -->
                    <div class="qr-section" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02)); border-radius: var(--radius); padding: 2rem; margin-bottom: 1.5rem; border: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
                        <div class="qr-container" style="position: relative; display: inline-block; padding: 1rem; background: white; border-radius: var(--radius); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); margin-bottom: 1rem;">
                            <img src="/placeholder.svg" alt="QRIS Code" id="qrcode" style="width: 200px; height: 200px; display: block; border-radius: var(--radius-sm);">
                            <div class="qr-loading" id="qr-loading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                                <div class="loading-spinner" style="width: 40px; height: 40px; border: 4px solid rgba(59, 130, 246, 0.2); border-top: 4px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                            </div>
                        </div>
                        
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                            Scan QR Code menggunakan aplikasi pembayaran digital Anda
                        </p>
                        
                        <!-- Countdown Timer -->
                        <div class="countdown-container" style="background: rgba(239, 68, 68, 0.1); border-radius: var(--radius); padding: 1rem; margin-bottom: 1rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                            <div style="color: var(--danger); font-size: 0.9rem; margin-bottom: 0.5rem; font-weight: 600;">
                                ⏰ Waktu Tersisa
                            </div>
                            <div id="countdown" style="color: var(--danger); font-size: 2rem; font-weight: 700; font-family: monospace; letter-spacing: 2px;">5:00</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-ripple" onclick="downloadQR()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download QR
                        </button>
                        <button type="button" class="btn btn-secondary btn-ripple" onclick="cekStatus()">
                            <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <polyline points="1 20 1 14 7 14"></polyline>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                            </svg>
                            Cek Status
                        </button>
                    </div>
                    
                    <!-- Payment Methods Info -->
                    <div class="payment-methods" style="background: rgba(139, 92, 246, 0.1); border-radius: var(--radius); padding: 1rem; margin-top: 1.5rem; border: 1px solid rgba(139, 92, 246, 0.2);">
                        <div style="color: var(--text-primary); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem; text-align: center;">
                            💳 Metode Pembayaran yang Didukung
                        </div>
                        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                            <span style="color: var(--text-muted); font-size: 0.8rem; padding: 0.25rem 0.5rem; background: rgba(255, 255, 255, 0.05); border-radius: var(--radius-sm);">GoPay</span>
                            <span style="color: var(--text-muted); font-size: 0.8rem; padding: 0.25rem 0.5rem; background: rgba(255, 255, 255, 0.05); border-radius: var(--radius-sm);">OVO</span>
                            <span style="color: var(--text-muted); font-size: 0.8rem; padding: 0.25rem 0.5rem; background: rgba(255, 255, 255, 0.05); border-radius: var(--radius-sm);">DANA</span>
                            <span style="color: var(--text-muted); font-size: 0.8rem; padding: 0.25rem 0.5rem; background: rgba(255, 255, 255, 0.05); border-radius: var(--radius-sm);">ShopeePay</span>
                            <span style="color: var(--text-muted); font-size: 0.8rem; padding: 0.25rem 0.5rem; background: rgba(255, 255, 255, 0.05); border-radius: var(--radius-sm);">LinkAja</span>
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

    <script type="text/javascript">
        // Variables from PHP
        let username = "<?php echo addslashes($username); ?>";
        let paket = "<?php echo addslashes($paket); ?>";
        let harga = "<?php echo addslashes($harga); ?>";
        let ref = "<?php echo addslashes($ref); ?>";
        let qrFile = "<?php echo addslashes($qrFile); ?>";

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

        // Enhanced countdown function
        function updateCountdown(ref) {
            fetch(`./count_down.php?ref=${encodeURIComponent(ref)}`)
                .then(res => res.json())
                .then(data => {
                    if (!data || data.error || typeof data.time_left !== "number") {
                        window.location.href = "timeout.php";
                        return;
                    }
                    let timeLeft = data.time_left;
                    
                    function tick() {
                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        const countdownElement = document.getElementById('countdown');
                        const countdownContainer = document.querySelector('.countdown-container');
                        
                        countdownElement.innerText = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
                        
                        // Change color based on time left
                        if (timeLeft <= 60) {
                            countdownContainer.style.background = 'rgba(239, 68, 68, 0.2)';
                            countdownElement.style.animation = 'pulse 1s infinite';
                        } else if (timeLeft <= 180) {
                            countdownContainer.style.background = 'rgba(245, 158, 11, 0.1)';
                        }
                        
                        if (timeLeft > 0) {
                            timeLeft--;
                            setTimeout(tick, 1000);
                        } else {
                            window.location.href = "timeout.php";
                        }
                    }
                    tick();
                })
                .catch(err => {
                    console.error("Gagal mengambil waktu dari server:", err);
                    window.location.href = "timeout.php";
                });
        }

        // Enhanced download function
        function downloadQR() {
            const qrCode = document.getElementById('qrcode');
            const link = document.createElement('a');
            
            // Show loading state
            const qrContainer = document.querySelector('.qr-container');
            qrContainer.style.opacity = '0.7';
            
            // Create canvas to add branding
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.crossOrigin = 'anonymous';
            img.onload = function() {
                canvas.width = img.width + 40;
                canvas.height = img.height + 80;
                
                // White background
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Draw QR code
                ctx.drawImage(img, 20, 20);
                
                // Add text
                ctx.fillStyle = '#1e293b';
                ctx.font = 'bold 16px Arial';
                ctx.textAlign = 'center';
                ctx.fillText(`Paket: ${paket}`, canvas.width / 2, img.height + 45);
                ctx.fillText(`Ref: ${ref}`, canvas.width / 2, img.height + 65);
                
                // Download
                link.href = canvas.toDataURL('image/png');
                link.download = `qrcode-${ref}.png`;
                link.click();
                
                // Reset loading state
                qrContainer.style.opacity = '1';
                
                // Show success feedback
                showToast('QR Code berhasil didownload!', 'success');
            };
            
            img.src = qrCode.src;
        }

        // Enhanced payment status check
        function checkPaymentStatus(ref) {
            const interval = setInterval(() => {
                fetch(`cek_status.php?ref=${encodeURIComponent(ref)}`)
                    .then(response => response.json())
                    .then(data => {
                        const status = (data.status || "").trim().toUpperCase();
                        if (status === 'PAID') {
                            clearInterval(interval);
                            showToast('Pembayaran berhasil! Mengalihkan...', 'success');
                            setTimeout(() => {
                                window.location.href = "redirect_sukses.php?username=" + encodeURIComponent(username) + "&paket=" + encodeURIComponent(paket) + "&harga=" + encodeURIComponent(harga) + "&ref=" + encodeURIComponent(ref);
                            }, 1500);
                        } else if (status === 'EXPIRED') {
                            clearInterval(interval);
                            window.location.href = "timeout.php";
                        }
                    })
                    .catch(err => {
                        console.error('Gagal memeriksa status pembayaran:', err);
                    });
            }, 2000); // Check every 2 seconds
        }

        // Enhanced status check function
        function cekStatus() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = `
                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                </svg>
                Mengecek...
            `;
            button.disabled = true;
            
            // Check status
            fetch(`cek_status.php?ref=${encodeURIComponent(ref)}`)
                .then(response => response.json())
                .then(data => {
                    const status = (data.status || "").trim().toUpperCase();
                    let message = '';
                    
                    if (status === 'PAID') {
                        message = '✅ Pembayaran berhasil! Mengalihkan ke halaman sukses...';
                        setTimeout(() => {
                            window.location.href = "redirect_sukses.php?username=" + encodeURIComponent(username) + "&paket=" + encodeURIComponent(paket) + "&harga=" + encodeURIComponent(harga) + "&ref=" + encodeURIComponent(ref);
                        }, 2000);
                    } else if (status === 'EXPIRED') {
                        message = '⏰ Waktu pembayaran telah habis. Mengalihkan...';
                        setTimeout(() => {
                            window.location.href = "timeout.php";
                        }, 2000);
                    } else {
                        message = '⚠️ Pembayaran belum diterima. Silakan coba lagi dalam beberapa saat.';
                    }
                    
                    showConfirmDialog(message);
                })
                .catch(err => {
                    console.error('Gagal memeriksa status:', err);
                    showConfirmDialog('❌ Gagal mengecek status pembayaran. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 1000);
                });
        }

        // Enhanced modal function
        function showConfirmDialog(message, callbackYes) {
            document.getElementById('confirmMessage').innerHTML = message;
            document.getElementById('customConfirm').style.display = 'flex';

            document.getElementById('confirmYes').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                if(callbackYes) callbackYes();
            };
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? 'var(--success)' : type === 'error' ? 'var(--danger)' : 'var(--primary)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: var(--radius);
                font-weight: 600;
                z-index: 10000;
                animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
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

        // Initialize page
        window.onload = function () {
            // Set total payment
            if (harga) {
                document.getElementById('total-pembayaran').innerText = "Rp " + parseInt(harga).toLocaleString('id-ID');
            }

            // Load QR code
            if (ref && qrFile) {
                const qrImg = document.getElementById('qrcode');
                const qrLoading = document.getElementById('qr-loading');
                
                qrLoading.style.display = 'block';
                qrImg.style.opacity = '0';
                
                qrImg.onload = function() {
                    qrLoading.style.display = 'none';
                    qrImg.style.opacity = '1';
                    qrImg.style.transition = 'opacity 0.3s ease';
                };
                
                qrImg.src = 'qris/' + encodeURIComponent(qrFile);

                // Clear old countdown data
                Object.keys(localStorage).forEach((key) => {
                    if (key.startsWith("countdown_") && key !== `countdown_${ref}`) {
                        localStorage.removeItem(key);
                    }
                });

                // Start payment monitoring
                checkPaymentStatus(ref);
                updateCountdown(ref);
            } else {
                showConfirmDialog("❌ Kode referensi tidak ditemukan.");
            }

            // Show initial warning
            showConfirmDialog("⚠️ Jika setelah membayar tapi kode voucher tidak muncul, silahkan hubungi WhatsApp: <br><br><?php echo $formatted ?>");

            // Add fade in animation
            document.querySelector('.main-container').style.animation = 'fadeInUp 0.8s ease';
        };
    </script>

    <style>
        /* Additional styles for purchase page */
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

        /* Spin animation for loading */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Pulse animation for countdown */
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

        /* Slide in animation for toast */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
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

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .detail-item {
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            transform: translateX(4px);
        }

        .qr-container {
            transition: all 0.3s ease;
        }

        .qr-container:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        /* Color variables */
        :root {
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #22c55e;
        }
    </style>
</body>
</html>
