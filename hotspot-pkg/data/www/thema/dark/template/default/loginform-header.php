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
<body>

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
</body>

