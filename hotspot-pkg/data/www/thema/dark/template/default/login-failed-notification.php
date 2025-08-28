<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
function showCustomAlert($message) {
    echo '
    <div class="confirm-overlay" id="customAlert">
        <div class="failed-box">
            <div class="alert-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h3 class="alert-title">Login Gagal</h3>
            <p class="alert-message">' . htmlspecialchars($message, ENT_QUOTES) . '</p>
            <div class="confirm-actions">
                <button class="btn-confirm" onclick="closeAlert()">OK</button>
            </div>
        </div>
    </div>

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

        .confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        .failed-box {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1.75rem;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: zoomIn 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .alert-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--danger), #DC2626);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        .alert-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .alert-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--danger);
            margin-bottom: 0.75rem;
        }

        .alert-message {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .confirm-actions {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .btn-confirm {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 6px rgba(14, 165, 233, 0.25);
            min-width: 120px;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(14, 165, 233, 0.3);
        }

        .btn-confirm:active {
            transform: translateY(0);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 480px) {
            .failed-box {
                padding: 1.5rem;
                max-width: 320px;
            }
            
            .alert-icon {
                width: 56px;
                height: 56px;
            }
            
            .alert-icon svg {
                width: 28px;
                height: 28px;
            }
            
            .alert-title {
                font-size: 1.15rem;
            }
            
            .alert-message {
                font-size: 0.95rem;
            }
        }
    </style>

    <script>
    function closeAlert() {
        const alertBox = document.getElementById("customAlert");
        if (alertBox) {
            alertBox.style.opacity = "0";
            alertBox.style.transform = "scale(0.95)";
            alertBox.style.transition = "opacity 0.3s ease, transform 0.3s ease";
            
            setTimeout(() => {
                if (alertBox) alertBox.remove();
                window.history.back();
            }, 300);
        }
    }
    
    // Auto close after 5 seconds
    setTimeout(() => {
        closeAlert();
    }, 5000);
    </script>
    ';
}

if ($reply == 'Your maximum never usage time has been reached') {
    showCustomAlert('⚠️ Kode voucher sudah kadaluarsa');
} else if ($reply) {
    showCustomAlert($reply);
} else {
    showCustomAlert($h1Failed);
}
?>