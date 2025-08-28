<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 

// Ambil informasi admin dari database jika tersedia
$admin_number = '';
$formatted = '';

if (isset($db_config) && is_array($db_config)) {
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
}

// Dapatkan tahun saat ini untuk copyright
$current_year = date('Y');
?>

<footer class="cool-footer">
    <div class="footer-content">
        <div class="footer-left">
            <div class="footer-logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <span class="logo-text">AFR-Cloud.NET</span>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                <span id="attribution-text"></span>
                <br>&copy; <?php echo $current_year; ?> <br> All rights reserved.
            </div>
            <div class="footer-legal">
                <a href="#" class="legal-link">Terms of Service</a>
                <span class="separator">|</span>
                <a href="#" class="legal-link">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>

<script>
const _0x562861=_0x1286;(function(_0x2747b2,_0x194125){const _0x44ce05=_0x1286,_0x2ddddb=_0x2747b2();while(!![]){try{const _0x52c2fc=-parseInt(_0x44ce05(0x18c))/0x1+parseInt(_0x44ce05(0x18e))/0x2+parseInt(_0x44ce05(0x187))/0x3+parseInt(_0x44ce05(0x186))/0x4+-parseInt(_0x44ce05(0x188))/0x5+-parseInt(_0x44ce05(0x18a))/0x6+parseInt(_0x44ce05(0x189))/0x7;if(_0x52c2fc===_0x194125)break;else _0x2ddddb['push'](_0x2ddddb['shift']());}catch(_0x2fad00){_0x2ddddb['push'](_0x2ddddb['shift']());}}}(_0xf440,0x8b48b));function _0x1286(_0x33a287,_0x2a856e){const _0xf44051=_0xf440();return _0x1286=function(_0x128662,_0x3669d7){_0x128662=_0x128662-0x186;let _0x4ab3c1=_0xf44051[_0x128662];return _0x4ab3c1;},_0x1286(_0x33a287,_0x2a856e);}const source='Source:\x20<a\x20href=\x22https://t.me/maizil41\x22\x20target=\x22_blank\x22\x20class=\x22author-link\x22>Mutiara-WRT</a>\x20|\x20Edited\x20by:\x20<a\x20href=\x22https://t.me/afrcloud\x22\x20target=\x22_blank\x22\x20class=\x22editor-link\x22>AFR-Cloud.NET</a>';function _0xf440(){const _0xc1c1c5=['865438cESYXr','attribution-text','251816tALUdk','2410700MgMSVY','2961558rRlSmC','804085jPUvXD','6596065cjTQYl','6367812uArRCJ','getElementById'];_0xf440=function(){return _0xc1c1c5;};return _0xf440();}document[_0x562861(0x18b)](_0x562861(0x18d))['innerHTML']=source;
</script>

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
        --text-primary: #F8FAFC;
        --text-secondary: #CBD5E1;
        --text-muted: #94A3B8;
        --bg-dark: #0F172A;
        --bg-dark-2: #1E293B;
        --radius: 0.5rem;
        --radius-full: 9999px;
    }

    .cool-footer {
        width: 100%;
        padding: 1rem 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
        animation: fadeIn 0.5s ease;
        position: relative;
        overflow: hidden;
        color: var(--text-secondary);
    }

    .cool-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--primary-light), var(--secondary-light), transparent);
    }

    .footer-content {
        max-width: 480px;
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .footer-left {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .logo-text {
        font-weight: 600;
        font-size: 1.1rem;
        background: linear-gradient(to right, var(--primary-light), var(--secondary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        margin-left: 0.5rem;
    }

    .footer-bottom {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .copyright {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .footer-legal {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .legal-link {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .legal-link:hover {
        color: var(--primary-light);
    }

    .separator {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .author-link, .editor-link {
        color: var(--primary-light);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .author-link::after, .editor-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: linear-gradient(to right, var(--primary-light), var(--secondary-light));
        transition: width 0.3s ease;
    }

    .author-link:hover::after, .editor-link:hover::after {
        width: 100%;
    }

    .editor-link {
        color: var(--accent);
    }

    .editor-link::after {
        background: linear-gradient(to right, var(--accent), var(--secondary-light));
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .footer-content {
            padding: 0 1rem;
        }
        
        .footer-bottom {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
</style>
