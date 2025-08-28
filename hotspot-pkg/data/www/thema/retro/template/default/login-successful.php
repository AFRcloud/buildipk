<?php
/* ********************************************************************************************************* * Hotspotlogin RadMon by Maizil https://t.me/maizil41 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work. * Don't change what doesn't need to be changed, please respect others' work * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.  **********************************************************************************************************/
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
<!DOCTYPE html>
<html lang="en">
<head>
    <title id="title">AFR-Cloud.NET - Successful</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#0F172A" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.io" sizes="32x32">
    <style>
:root {
  --primary-color: #ff2e63;
  --secondary-color: #08d9d6;
  --accent-color: #f9c80e;
  --success-color: #2ed573;
  --dark-bg: #1a1a2e;
  --darker-bg: #16213e;
  --light-bg: #252a34;
  --light-text: #eaeaea;
  --light-text-secondary: #b2b2b2;
  --dark-text: #1a1a2e;
  --transition-speed: 0.3s;
}
* {
  box-sizing: border-box;
  -webkit-tap-highlight-color: transparent;
  margin: 0;
  padding: 0;
}
body {
  font-family: "DM Sans", -apple-system, BlinkMacSystemFont, "segoe ui", Verdana,
    Roboto, "helvetica neue", Arial, sans-serif;
  font-size: 14px;
  margin: 0;
  background: var(--dark-bg);
  color: var(--light-text);
  line-height: 1.5;
  min-height: 100vh;
  padding: 0;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
  position: relative;
}
/* Retro Grid Background */
.retro-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
  background-color: var(--dark-bg);
  background-image: linear-gradient(
      rgba(46, 213, 115, 0.1) 1px,
      transparent 1px
    ),
    linear-gradient(90deg, rgba(46, 213, 115, 0.1) 1px, transparent 1px);
  background-size: 20px 20px;
  perspective: 1000px;
  animation: gridMove 20s linear infinite;
}
.retro-bg::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 100%;
  background: linear-gradient(
    to bottom,
    rgba(26, 26, 46, 0.8) 0%,
    rgba(26, 26, 46, 0.2) 40%,
    rgba(26, 26, 46, 0.2) 60%,
    rgba(26, 26, 46, 0.8) 100%
  );
}
@keyframes gridMove {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 20px 20px;
  }
}
/* Header */
.header {
  width: 100%;
  padding: 1.5rem;
  background-color: var(--darker-bg);
  border-bottom: 2px solid var(--success-color);
  position: relative;
  overflow: hidden;
}
.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}
.logo-text {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--light-text);
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
  animation: textShadow 1.5s infinite;
}
.logo-text::before,
.logo-text::after {
  content: "AFR-CLOUD.NET"; /* Hardcoded content for glitch effect */
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
  background-color: transparent;
}
.logo-text::before {
  left: -2px;
  text-shadow: -2px 0 var(--secondary-color);
  animation: glitch-1 2.5s infinite ease-in-out;
  opacity: 0.8;
}
.logo-text::after {
  left: 2px;
  text-shadow: 2px 0 var(--success-color);
  animation: glitch-2 2s infinite ease-in-out reverse;
  opacity: 0.8;
}
.logo-highlight {
  color: var(--success-color);
}
.status-indicator {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--success-color);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.status-dot {
  width: 12px;
  height: 12px;
  background-color: var(--success-color);
  border-radius: 50%;
  animation: statusPulse 2s ease-in-out infinite;
}
@keyframes statusPulse {
  0%,
  100% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.7;
    transform: scale(1.2);
  }
}
/* Main Container */
.main {
  flex: 1;
  width: 100%;
  max-width: 800px;
  margin: 2rem auto;
  padding: 0 1rem;
}
/* Welcome Section */
.welcome-section {
  text-align: center;
  margin-bottom: 2rem;
  padding: 2rem;
  background-color: var(--light-bg);
  border: 1px solid var(--success-color);
  box-shadow: 5px 5px 0 var(--success-color);
  position: relative;
  overflow: hidden;
}
.welcome-section::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(
    90deg,
    var(--success-color) 0%,
    var(--secondary-color) 50%,
    var(--accent-color) 100%
  );
  animation: welcomeGlow 3s ease-in-out infinite;
}
@keyframes welcomeGlow {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
    filter: brightness(1.3);
  }
}
.welcome-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--success-color);
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 1rem;
  animation: welcomeGlitch 4s infinite;
}
@keyframes welcomeGlitch {
  0%,
  90%,
  100% {
    transform: translate(0);
  }
  10% {
    transform: translate(-2px, 0);
  }
  20% {
    transform: translate(2px, 0);
  }
}
/* User Avatar SVG styling */
.user-avatar svg {
  font-size: 4rem; /* Matches .user-icon size */
  color: var(--success-color);
  margin-bottom: 1rem;
  display: block;
  animation: iconFloat 3s ease-in-out infinite;
  text-shadow: 0 0 20px rgba(46, 213, 115, 0.5);
  width: 4rem; /* Ensure explicit size for SVG */
  height: 4rem; /* Ensure explicit size for SVG */
  margin-left: auto;
  margin-right: auto;
}
@keyframes iconFloat {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
}
.username {
  font-size: 3rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 1rem;
  animation: welcomeGlitch 1s infinite;
  color: var(--primary-color);
}
.user-status {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  color: var(--secondary-color);
  font-weight: 500;
  font-size: 1rem;
}
.user-status svg {
  width: 18px;
  height: 18px;
  color: var(--success-color);
}

/* Stats Table */
.stats-container {
  background-color: var(--light-bg);
  border: 1px solid var(--secondary-color);
  box-shadow: 5px 5px 0 var(--secondary-color);
  margin-bottom: 2rem;
  position: relative;
  overflow: hidden;
}
.stats-header {
  background-color: var(--secondary-color);
  color: var(--dark-bg);
  padding: 1rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-align: center;
}
.table2 {
  width: 100%;
  border-collapse: collapse;
  background-color: transparent;
}
.table2 tr {
  border-bottom: 1px solid rgba(8, 217, 214, 0.2);
  transition: all 0.3s ease;
}
.table2 tr:last-child {
  border-bottom: none;
}
.table2 tr:hover {
  background-color: rgba(8, 217, 214, 0.1);
}
.table2 td {
  padding: 1rem;
  color: var(--light-text);
  font-size: 0.875rem;
  position: relative;
}
.table2 td:first-child {
  font-weight: 600;
  color: var(--secondary-color);
  text-transform: uppercase;
  letter-spacing: 1px;
  width: 60%;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.table2 td:last-child {
  font-weight: 500;
  color: var(--light-text);
  text-align: right;
}
.info-icon svg {
  width: 14px;
  height: 14px;
  color: var(--accent-color);
}
/* Real-time Data Animation */
.data-update {
  animation: dataFlash 0.5s ease-in-out;
}
@keyframes dataFlash {
  0% {
    background-color: rgba(46, 213, 115, 0.3);
  }
  100% {
    background-color: transparent;
  }
}
/* Logout Button */
.button2 {
  display: flex; /* biar isi di dalamnya tetap center */
  align-items: center;
  justify-content: center;
  padding: 1rem 2rem;
  background-color: var(--primary-color);
  color: var(--light-text);
  border: none;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: inherit;
  font-size: 1rem;
  gap: 0.5rem;
  margin: 2rem auto; /* ini yang membuat tombol di tengah */
  position: relative;
  overflow: hidden;
  width: fit-content; /* supaya tombol sesuai isi */
  width: 75%;
}

.button2::before {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.2),
    transparent
  );
  transition: 0.5s;
}
.button2:hover {
  background-color: var(--accent-color);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(255, 46, 99, 0.4);
}
.button2:hover::before {
  left: 100%;
}
.button2:active {
  transform: translateY(0);
}
.btn-icon {
  width: 18px;
  height: 18px;
  color: var(--light-text);
}

/* Progress Bars for Data Usage (not used in current HTML, but kept for completeness) */
.progress-bar {
  width: 100%;
  height: 4px;
  background-color: var(--darker-bg);
  border-radius: 2px;
  margin-top: 0.5rem;
  overflow: hidden;
}
.progress-fill {
  height: 100%;
  background: linear-gradient(
    90deg,
    var(--success-color) 0%,
    var(--secondary-color) 100%
  );
  border-radius: 2px;
  transition: width 0.3s ease;
}

/* Loading Screen Styles */
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: var(--dark-bg);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  color: var(--light-text);
  font-size: 1.2rem;
}
.loading-logo {
  width: 100px;
  height: auto;
  margin-bottom: 20px;
}
.loading-spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid var(--primary-color);
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  margin-bottom: 15px;
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.loading-text {
  color: var(--secondary-color);
  font-weight: 600;
  letter-spacing: 1px;
}

/* Refresh Info Styles */
.refresh-info {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1.5rem;
  font-size: 0.85rem;
  color: var(--light-text-secondary);
  text-align: center;
}
.refresh-info svg {
  width: 16px;
  height: 16px;
  color: var(--accent-color);
}

.contact-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--secondary-color);
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}
.contact-link:hover {
  color: var(--accent-color);
}
.contact-icon {
  width: 18px;
  height: 18px;
  color: var(--secondary-color);
}

/* Specific data value colors */
.info-value.upload {
  color: var(--success-color);
}
.info-value.download {
  color: var(--secondary-color);
}
.info-value.traffic {
  color: var(--accent-color);
}
.info-value.time {
  color: var(--primary-color);
}
.info-value.quota {
  color: var(--success-color);
}

/* Responsive Design */
@media screen and (max-width: 768px) {
  .header {
    padding: 1rem;
  }
  .logo-text {
    font-size: 1.5rem;
  }
  .welcome-section {
    padding: 1.5rem;
  }
  .welcome-title {
    font-size: 1.5rem;
  }
  .user-avatar svg {
    font-size: 3rem;
    width: 3rem;
    height: 3rem;
  }
  .table2 td {
    padding: 0.75rem;
    font-size: 0.75rem;
  }
}
@media screen and (max-width: 480px) {
  .main {
    margin: 1rem auto;
    padding: 0 0.5rem;
  }
  .welcome-section {
    padding: 1rem;
  }
  .welcome-title {
    font-size: 1.25rem;
  }
  .user-avatar svg {
    font-size: 2.5rem;
    width: 2.5rem;
    height: 2.5rem;
  }
  .table2 td {
    padding: 0.5rem;
  }
  .table2 td:first-child {
    width: 45%;
  }
}
/* Animations */
@keyframes textShadow {
  0% {
    text-shadow: 0.4389924193300864px 0 1px rgba(46, 213, 115, 0.5),
      -0.4389924193300864px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  5% {
    text-shadow: 2.7928974010788217px 0 1px rgba(46, 213, 115, 0.5),
      -2.7928974010788217px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  10% {
    text-shadow: 0.02956275843481219px 0 1px rgba(46, 213, 115, 0.5),
      -0.02956275843481219px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  15% {
    text-shadow: 0.40218538552878136px 0 1px rgba(46, 213, 115, 0.5),
      -0.40218538552878136px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  20% {
    text-shadow: 3.4794037899852017px 0 1px rgba(46, 213, 115, 0.5),
      -3.4794037899852017px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  25% {
    text-shadow: 1.6125630401149584px 0 1px rgba(46, 213, 115, 0.5),
      -1.6125630401149584px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  30% {
    text-shadow: 0.7015590085143956px 0 1px rgba(46, 213, 115, 0.5),
      -0.7015590085143956px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  35% {
    text-shadow: 3.896914047650351px 0 1px rgba(46, 213, 115, 0.5),
      -3.896914047650351px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  40% {
    text-shadow: 3.870905614848819px 0 1px rgba(46, 213, 115, 0.5),
      -3.870905614848819px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  45% {
    text-shadow: 2.231056963361899px 0 1px rgba(46, 213, 115, 0.5),
      -2.231056963361899px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  50% {
    text-shadow: 0.08084290417898504px 0 1px rgba(46, 213, 115, 0.5),
      -0.08084290417898504px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  55% {
    text-shadow: 2.3758461067427543px 0 1px rgba(46, 213, 115, 0.5),
      -2.3758461067427543px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  60% {
    text-shadow: 2.202193051050636px 0 1px rgba(46, 213, 115, 0.5),
      -2.202193051050636px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  65% {
    text-shadow: 2.8638780614874975px 0 1px rgba(46, 213, 115, 0.5),
      -2.8638780614874975px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  70% {
    text-shadow: 0.48874025155497314px 0 1px rgba(46, 213, 115, 0.5),
      -0.48874025155497314px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  75% {
    text-shadow: 1.8948491305757957px 0 1px rgba(46, 213, 115, 0.5),
      -1.8948491305757957px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  80% {
    text-shadow: 0.0833037308038857px 0 1px rgba(46, 213, 115, 0.5),
      -0.0833037308038857px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  85% {
    text-shadow: 0.09769827255241735px 0 1px rgba(46, 213, 115, 0.5),
      -0.09769827255241735px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  90% {
    text-shadow: 3.443339761481782px 0 1px rgba(46, 213, 115, 0.5),
      -3.443339761481782px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  95% {
    text-shadow: 2.1841838852799786px 0 1px rgba(46, 213, 115, 0.5),
      -2.1841838852799786px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  100% {
    text-shadow: 2.6208764473832513px 0 1px rgba(46, 213, 115, 0.5),
      -2.6208764473832513px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
}
@keyframes glitch-1 {
  0% {
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    transform: translate(0);
  }
  10% {
    clip-path: polygon(0 15%, 100% 15%, 100% 40%, 0 40%);
    transform: translate(-3px, 0);
  }
  20% {
    clip-path: polygon(0 10%, 100% 10%, 100% 50%, 0 50%);
    transform: translate(3px, 0);
  }
  30% {
    clip-path: polygon(0 30%, 100% 30%, 100% 65%, 0 65%);
    transform: translate(0, 0);
  }
  40% {
    clip-path: polygon(0 45%, 100% 45%, 100% 60%, 0 60%);
    transform: translate(3px, 0);
  }
  50% {
    clip-path: polygon(0 25%, 100% 25%, 100% 35%, 0 35%);
    transform: translate(-3px, 0);
  }
  60% {
    clip-path: polygon(0 40%, 100% 40%, 100% 80%, 0 80%);
    transform: translate(3px, 0);
  }
  70% {
    clip-path: polygon(0 60%, 100% 60%, 100% 75%, 0 75%);
    transform: translate(-3px, 0);
  }
  80% {
    clip-path: polygon(0 75%, 100% 75%, 100% 90%, 0 90%);
    transform: translate(0, 0);
  }
  90% {
    clip-path: polygon(0 80%, 100% 80%, 100% 100%, 0 100%);
    transform: translate(-3px, 0);
  }
  100% {
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    transform: translate(0, 0);
  }
}
@keyframes glitch-2 {
  0% {
    clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
    transform: translate(0);
  }
  15% {
    clip-path: polygon(0 65%, 100% 65%, 100% 80%, 0 80%);
    transform: translate(5px, 0);
  }
  30% {
    clip-path: polygon(0 75%, 100% 75%, 100% 100%, 0 100%);
    transform: translate(-5px, 0);
  }
  45% {
    clip-path: polygon(0 85%, 100% 85%, 100% 95%, 0 95%);
    transform: translate(0, 0);
  }
  60% {
    clip-path: polygon(0 55%, 100% 55%, 100% 70%, 0 70%);
    transform: translate(5px, 0);
  }
  75% {
    clip-path: polygon(0 70%, 100% 70%, 100% 85%, 0 85%);
    transform: translate(-5px, 0);
  }
  90% {
    clip-path: polygon(0 80%, 100% 80%, 100% 95%, 0 95%);
    transform: translate(5px, 0);
  }
  100% {
    clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
    transform: translate(0, 0);
  }
}

.footer {
  position: relatif;
  bottom: 0;
  left: 0;
  width: 100%;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: var(--darker-bg);
  padding: 0.5rem; /* Lebih ringkas */
  border-top: none; /* Hapus border solid, gunakan ::after */
  z-index: 100;
  backdrop-filter: blur(10px);
  box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
  overflow: hidden;
}
.footer::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: linear-gradient(
      rgba(255, 46, 99, 0.05) 1px,
      transparent 1px
    ),
    linear-gradient(90deg, rgba(255, 46, 99, 0.05) 1px, transparent 1px);
  background-size: 20px 20px;
  opacity: 0.5;
  pointer-events: none;
}
.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  font-size: 0.875rem;
  color: var(--light-text-secondary);
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem; /* Lebih ringkas */
}
.footer-grid {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  flex-wrap: wrap;
  gap: 0.5rem; /* Lebih ringkas */
}
.footer-brand {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.1rem; /* Sangat ringkas */
}
.footer-logo {
  font-size: 1.2rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--light-text);
  text-shadow: 0 0 8px var(--secondary-color), 0 0 15px var(--primary-color); /* Glow lebih kuat */
}
.footer-logo-icon {
  font-size: 1.5rem;
  margin-right: 0.25rem;
  color: var(--accent-color);
}
.footer-highlight {
  color: var(--primary-color);
}
.footer-tagline {
  font-size: 0.7rem; /* Lebih kecil */
  color: var(--light-text-secondary);
  letter-spacing: 0.5px;
}
.footer-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.1rem; /* Sangat ringkas */
}
.footer-status,
.footer-speed {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.75rem; /* Lebih kecil */
  color: var(--light-text);
}
.status-dot {
  width: 7px; /* Lebih kecil */
  height: 7px;
  background-color: #00ff00;
  border-radius: 50%;
  animation: blink 1.5s infinite;
  box-shadow: 0 0 7px #00ff00, 0 0 12px rgba(0, 255, 0, 0.5); /* Glow lebih kuat */
}
@keyframes blink {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.3;
  }
}
.footer-divider {
  width: 80%;
  height: 2px; /* Sedikit lebih tebal */
  background: linear-gradient(
    90deg,
    transparent 0%,
    var(--primary-color) 25%,
    var(--secondary-color) 50%,
    var(--accent-color) 75%,
    transparent 100%
  );
  background-size: 600% 100%; /* Ukuran background lebih besar untuk animasi */
  animation: moveGradient 15s linear infinite; /* Animasi lebih lambat dan halus */
  margin: 0.2rem 0; /* Margin sangat ringkas */
  opacity: 0.8; /* Sedikit lebih terlihat */
  box-shadow: 0 0 5px rgba(255, 46, 99, 0.5), 0 0 10px rgba(8, 217, 214, 0.5); /* Glow pada divider */
}
@keyframes moveGradient {
  0% {
    background-position-x: 0%;
  }
  100% {
    background-position-x: -500%; /* Menggeser gradien lebih jauh */
  }
}
.footer-bottom {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.1rem; /* Sangat ringkas */
  font-size: 0.1rem; /* Lebih kecil */
  flex-wrap: wrap;
}
.footer-copyright {
  color: var(--light-text-secondary);
}
.footer-separator {
  color: var(--primary-color);
  margin: 0; /* Lebih ringkas */
}
.footer-made {
  color: var(--light-text-secondary);
}
.footer-brand-link {
  color: var(--primary-color);
  font-weight: 600;
  transition: all 0.3s ease;
  position: relative;
}
.footer-brand-link::after {
  content: "";
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 1px;
  background-color: var(--secondary-color);
  transition: width 0.3s ease;
}
.footer-brand-link:hover {
  color: var(--secondary-color);
}
.footer-brand-link:hover::after {
  width: 100%;
}
.footer-decoration {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 150px;
  height: 150px;
  background-color: var(--primary-color);
  opacity: 0.1;
  clip-path: polygon(0 0, 0 100%, 100% 100%);
}
.footer::after {
  content: "";
  position: absolute;
  top: 0; /* Posisikan di bagian atas footer */
  left: 0;
  width: 100%;
  height: 3px; /* Lebih tebal */
  background: linear-gradient(
    90deg,
    transparent 0%,
    var(--primary-color) 20%,
    var(--secondary-color) 50%,
    var(--primary-color) 80%,
    transparent 100%
  );
  animation: footerGlow 3s ease-in-out infinite alternate;
  box-shadow: 0 0 15px var(--primary-color), 0 0 30px var(--secondary-color); /* Glow lebih kuat */
}
@keyframes footerGlow {
  0% {
    opacity: 0.7;
    transform: scaleX(0.95);
    box-shadow: 0 0 10px var(--primary-color), 0 0 20px var(--secondary-color);
  }
  50% {
    opacity: 1;
    transform: scaleX(1);
    box-shadow: 0 0 20px var(--primary-color), 0 0 40px var(--secondary-color);
  }
  100% {
    opacity: 0.7;
    transform: scaleX(0.95);
    box-shadow: 0 0 10px var(--primary-color), 0 0 20px var(--secondary-color);
  }
}
@media screen and (max-width: 768px) {
  .package-list {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }
  .footer-grid {
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.5rem; /* Lebih ringkas */
  }
  .footer-brand,
  .footer-info {
    align-items: center;
  }
  .footer-bottom {
    flex-direction: column;
    gap: 0.25rem; /* Lebih ringkas */
  }
  .footer-separator {
    display: none;
  }
}
@media screen and (max-width: 480px) {
  .header {
    padding: 1rem;
  }
  .logo-text {
    font-size: 1.5rem;
    align-items: center;
  }
  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  .card-body {
    padding: 1rem;
  }
  .package-list {
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
  }
  .package-item {
    padding: 0.75rem;
  }
  .package-name {
    font-size: 0.9rem;
  }
  .package-details {
    font-size: 0.75rem;
  }
  .package-price {
    font-size: 1rem;
  }
  .footer-content {
    gap: 0.5rem; /* Lebih ringkas */
  }
  .footer-grid {
    gap: 0.5rem; /* Lebih ringkas */
  }
  .footer-logo {
    font-size: 1rem;
  }
  .footer-logo-icon {
    font-size: 1.2rem;
  }
  .footer-tagline {
    font-size: 0.65rem; /* Lebih kecil lagi */
  }
  .footer-status,
  .footer-speed {
    font-size: 0.7rem; /* Lebih kecil lagi */
  }
  .footer-copyright,
  .footer-made {
    font-size: 0.65rem; /* Lebih kecil lagi */
  }
}
@keyframes textShadow {
  0% {
    text-shadow: 0.4389924193300864px 0 1px rgba(255, 46, 99, 0.5),
      -0.4389924193300864px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  5% {
    text-shadow: 2.7928974010788217px 0 1px rgba(255, 46, 99, 0.5),
      -2.7928974010788217px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  10% {
    text-shadow: 0.02956275843481219px 0 1px rgba(255, 46, 99, 0.5),
      -0.02956275843481219px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  15% {
    text-shadow: 0.40218538552878136px 0 1px rgba(255, 46, 99, 0.5),
      -0.40218538552878136px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  20% {
    text-shadow: 3.4794037899852017px 0 1px rgba(255, 46, 99, 0.5),
      -3.4794037899852017px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  25% {
    text-shadow: 1.6125630401149584px 0 1px rgba(255, 46, 99, 0.5),
      -1.6125630401149584px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  30% {
    text-shadow: 0.7015590085143956px 0 1px rgba(255, 46, 99, 0.5),
      -0.7015590085143956px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  35% {
    text-shadow: 3.896914047650351px 0 1px rgba(255, 46, 99, 0.5),
      -3.896914047650351px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  40% {
    text-shadow: 3.870905614848819px 0 1px rgba(255, 46, 99, 0.5),
      -3.870905614848819px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  45% {
    text-shadow: 2.231056963361899px 0 1px rgba(255, 46, 99, 0.5),
      -2.231056963361899px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  50% {
    text-shadow: 0.08084290417898504px 0 1px rgba(255, 46, 99, 0.5),
      -0.08084290417898504px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  55% {
    text-shadow: 2.3758461067427543px 0 1px rgba(255, 46, 99, 0.5),
      -2.3758461067427543px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  60% {
    text-shadow: 2.202193051050636px 0 1px rgba(255, 46, 99, 0.5),
      -2.202193051050636px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  65% {
    text-shadow: 2.8638780614874975px 0 1px rgba(255, 46, 99, 0.5),
      -2.8638780614874975px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  70% {
    text-shadow: 0.48874025155497314px 0 1px rgba(255, 46, 99, 0.5),
      -0.48874025155497314px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  75% {
    text-shadow: 1.8948491305757957px 0 1px rgba(255, 46, 99, 0.5),
      -1.8948491305757957px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  80% {
    text-shadow: 0.0833037308038857px 0 1px rgba(255, 46, 99, 0.5),
      -0.0833037308038857px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  85% {
    text-shadow: 0.09769827255241735px 0 1px rgba(255, 46, 99, 0.5),
      -0.09769827255241735px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  90% {
    text-shadow: 3.443339761481782px 0 1px rgba(255, 46, 99, 0.5),
      -3.443339761481782px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  95% {
    text-shadow: 2.1841838852799786px 0 1px rgba(255, 46, 99, 0.5),
      -2.1841838852799786px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
  100% {
    text-shadow: 2.6208764473832513px 0 1px rgba(255, 46, 99, 0.5),
      -2.6208764473832513px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
  }
}
@keyframes glitch-1 {
  0% {
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    transform: translate(0);
  }
  10% {
    clip-path: polygon(0 15%, 100% 15%, 100% 40%, 0 40%);
    transform: translate(-3px, 0);
  }
  20% {
    clip-path: polygon(0 10%, 100% 10%, 100% 50%, 0 50%);
    transform: translate(3px, 0);
  }
  30% {
    clip-path: polygon(0 30%, 100% 30%, 100% 65%, 0 65%);
    transform: translate(0, 0);
  }
  40% {
    clip-path: polygon(0 45%, 100% 45%, 100% 60%, 0 60%);
    transform: translate(3px, 0);
  }
  50% {
    clip-path: polygon(0 25%, 100% 25%, 100% 35%, 0 35%);
    transform: translate(-3px, 0);
  }
  60% {
    clip-path: polygon(0 40%, 100% 40%, 100% 80%, 0 80%);
    transform: translate(3px, 0);
  }
  70% {
    clip-path: polygon(0 60%, 100% 60%, 100% 75%, 0 75%);
    transform: translate(-3px, 0);
  }
  80% {
    clip-path: polygon(0 75%, 100% 75%, 100% 90%, 0 90%);
    transform: translate(0, 0);
  }
  90% {
    clip-path: polygon(0 80%, 100% 80%, 100% 100%, 0 100%);
    transform: translate(-3px, 0);
  }
  100% {
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    transform: translate(0, 0);
  }
}
@keyframes glitch-2 {
  0% {
    clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
    transform: translate(0);
  }
  15% {
    clip-path: polygon(0 65%, 100% 65%, 100% 80%, 0 80%);
    transform: translate(5px, 0);
  }
  30% {
    clip-path: polygon(0 75%, 100% 75%, 100% 100%, 0 100%);
    transform: translate(-5px, 0);
  }
  45% {
    clip-path: polygon(0 85%, 100% 85%, 100% 95%, 0 95%);
    transform: translate(0, 0);
  }
  60% {
    clip-path: polygon(0 55%, 100% 55%, 100% 70%, 0 70%);
    transform: translate(5px, 0);
  }
  75% {
    clip-path: polygon(0 70%, 100% 70%, 100% 85%, 0 85%);
    transform: translate(-5px, 0);
  }
  90% {
    clip-path: polygon(0 80%, 100% 80%, 100% 95%, 0 95%);
    transform: translate(5px, 0);
  }
  100% {
    clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
    transform: translate(0, 0);
  }
}

    </style>
</head>
<body>
    <div class="retro-bg"></div>
    <!-- Loading Screen -->
    <div id="pleaseWait" class="loading-screen" style="display:none;">
        <img src="/RadMonv2/img/logo/radmon-logo.png" alt="Logo" class="loading-logo">
        <div class="loading-spinner"></div>
        <div class="loading-text">Menghubungkan ke jaringan...</div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-text"><span class="logo-highlight"></span></div>
            <div class="status-indicator">
                <span class="status-dot"></span>
                <span>CONNECTED</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main">
        <?php
        if (isset($_GET['mac'])) {
            require './config/mysqli_db.php';
            $mac_address = $_GET['mac'];
            $query = "SELECT username, AcctStartTime,CASE WHEN AcctStopTime is NULL THEN timestampdiff(SECOND,AcctStartTime,NOW()) ELSE AcctSessionTime END AS AcctSessionTime,
                        NASIPAddress,CalledStationId,FramedIPAddress,CallingStationId,AcctInputOctets,AcctOutputOctets
                         FROM radacct
                        WHERE callingstationid = '$mac_address' ORDER BY RadAcctId DESC LIMIT 1";
            $result = $conn->query($query);
            $data = array();
            $sqlUser = "SELECT username FROM radacct WHERE callingstationid='$mac_address' ORDER BY acctstarttime DESC LIMIT 1;";
            $resultUser = mysqli_fetch_assoc(mysqli_query($conn, $sqlUser));
            $user = $resultUser['username'];

            $sqlTotalSession = "SELECT g.value as total_session FROM radgroupcheck as g, radusergroup as u WHERE u.username = '$user' AND g.groupname = u.groupname AND g.attribute ='Max-All-Session';";
            $resultTotalSession = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotalSession));
            $totalSession = isset($resultTotalSession['total_session']) ? $resultTotalSession['total_session'] : 0;
            $sqlTotalKuota = "SELECT VALUE AS total_kuota
                FROM radgroupreply
                WHERE ATTRIBUTE = 'ChilliSpot-Max-Total-Octets'
                  AND GROUPNAME = (
                    SELECT GROUPNAME
                    FROM radusergroup
                    WHERE USERNAME = '$user'
                  )";
            $resultTotalKuota = mysqli_fetch_assoc(mysqli_query($conn, $sqlTotalKuota));
            if (is_array($resultTotalKuota) && isset($resultTotalKuota['total_kuota'])) {
                $totalKuota = $resultTotalKuota['total_kuota'];
            } else {
                $totalKuota = 0;
            }

            $sqlKuotaDigunakan = "SELECT SUM(acctinputoctets + acctoutputoctets) as kuota_terpakai FROM radacct WHERE username = '$user';";
            $resultKuotaDigunakan = mysqli_fetch_assoc(mysqli_query($conn, $sqlKuotaDigunakan));
            $KuotaDigunakan = $resultKuotaDigunakan['kuota_terpakai'];

            $sqlFirstLogin = "SELECT acctstarttime AS first_login FROM radacct WHERE username='$user' ORDER BY acctstarttime ASC LIMIT 1;";
            $resultFirstLogin = mysqli_fetch_assoc(mysqli_query($conn, $sqlFirstLogin));
            $firstLogin = $resultFirstLogin['first_login'];
            $duration = $totalSession;
            $expiryTime = strtotime($firstLogin) + $duration;

            $sisaKuota = $totalKuota - $KuotaDigunakan;
            $remainingTime = $expiryTime - time();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $username = $row['username'];
                    $userUpload = toxbyte($row['AcctInputOctets']);
                    $userDownload = toxbyte($row['AcctOutputOctets']);
                    $userTraffic = toxbyte($row['AcctOutputOctets'] + $row['AcctInputOctets']);
                    $userLastConnected = $row['AcctStartTime'];
                    $userOnlineTime = time2str($row['AcctSessionTime']);
                    $nasIPAddress = $row['NASIPAddress'];
                    $nasMacAddress = $row['CalledStationId'];
                    $userIPAddress = $row['FramedIPAddress'];
                    $userMacAddress = $row['CallingStationId'];
                    $userExpired = time2str($remainingTime);
                    $UserKuota = toxbyte($sisaKuota);

                    $data[] = array(
                        'username' => $username,
                        'userIPAddress' => $userIPAddress,
                        'userMacAddress' => $userMacAddress,
                        'userDownload' => $userDownload,
                        'userUpload' => $userUpload,
                        'userTraffic' => $userTraffic,
                        'userLastConnected' => $userLastConnected,
                        'userOnlineTime' => $userOnlineTime,
                        'userExpired' => $userExpired,
                        'userKuota' => $UserKuota,
                    );
                }
            }
            $conn->close();

            foreach ($data as $row) {
                echo '<div class="welcome-section">'; // Changed from user-profile
                echo '<div class="user-avatar">';
                echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
                echo '</div>';
                echo '<div class="welcome-title">Selamat Datang </div>'; // Changed from user-welcome
                echo '<div class="username" id="user">' . htmlspecialchars($row['username']) . '</div>'; // Changed from user-name
                echo '<div class="user-status">';
                echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
                echo 'Anda Telah Terhubung';
                echo '</div>';
                echo '</div>';

                echo '<div class="stats-container">'; // New wrapper for table and button
                echo '<div class="stats-header">CONNECTION INFORMATION</div>'; // New header for stats
                echo '<form action="template/' . $template . '/logoff.php?mac=' . (isset($_GET['mac']) ? $_GET['mac'] : '') . '&uamip=' . (isset($uamip) ? $uamip : '') . '&uamport=' . (isset($uamport) ? $uamport : '') . '&loginpath=' . urlencode($loginpath) . '" name="logout" method="get">';
                echo '<table class="table2">'; // Changed from info-table

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></div>IP Address </td>';
                echo '<td>' . htmlspecialchars($row['userIPAddress']) . '</td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><line x1="2" y1="10" x2="22" y2="10"></line></svg></div>MAC Address</td>';
                echo '<td>' . htmlspecialchars($row['userMacAddress']) . '</td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg></div>DATA UPLOAD</td>';
                echo '<td><div class="info-value upload" id="upload">' . htmlspecialchars($row['userUpload']) . '</div></td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></div>DATA DOWNLOAD</td>';
                echo '<td><div class="info-value download" id="download">' . htmlspecialchars($row['userDownload']) . '</div></td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></div>TOTAL TRAFFIC</td>';
                echo '<td><div class="info-value traffic" id="traffic">' . htmlspecialchars($row['userTraffic']) . '</div></td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>CONNECTED</td>';
                echo '<td><div class="info-value time" id="aktif">' . htmlspecialchars($row['userOnlineTime']) . '</div></td>';
                echo '</tr>';

                if ($totalSession >= 1) {
                    echo '<tr>';
                    echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>REMAINING TIME</td>';
                    echo '<td><div class="info-value time" id="expired">' . htmlspecialchars($row['userExpired']) . '</div></td>';
                    echo '</tr>';
                }

                if ($totalKuota >= 1) {
                    echo '<tr>';
                    echo '<td><div class="info-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg></div>REMAINING QUOTA</td>';
                    echo '<td><div class="info-value quota" id="kuota">' . htmlspecialchars($row['userKuota']) . '</div></td>';
                    echo '</tr>';
                }

                echo '</table>';

                echo '<button class="button2" type="submit">'; // Changed from btn btn-danger
                echo '<svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>';
                echo 'Logout';
                echo '</button>';
                echo '</form>'; // Close the form here
                echo '<div class="refresh-info">';
                echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
                echo '<path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/><br>';
                echo '</svg>';
                echo 'Data diperbarui secara otomatis <br>';
                echo '<br>';
                echo '</div>';
                echo '</div>'; // Close stats-container
            }
        }
        function toxbyte($size) {
            if ($size > 1073741824) {
                return round($size / 1073741824, 2) . " GB";
            } elseif ($size > 1048576) {
                return round($size / 1048576, 2) . " MB";
            } elseif ($size > 1024) {
                return round($size / 1024, 2) . " KB";
            } else {
                return $size . " B";
            }
        }

        function time2str($time) {
            $str = "";
            $time = floor($time);
            if (!$time)
                return "0 detik";
            $d = $time/86400;
            $d = floor($d);
            if ($d){
                $str .= "$d hari, ";
                $time = $time % 86400;
            }
            $h = $time/3600;
            $h = floor($h);
            if ($h){
                $str .= "$h jam, ";
                $time = $time % 3600;
            }
            $m = $time/60;
            $m = floor($m);
            if ($m){
                $str .= "$m menit, ";
                $time = $time % 60;
            }
            if ($time)
                $str .= "$time detik, ";
            $str = preg_replace("/, $/",'',$str);
            return $str;
        }
        ?>
    </div>
    <!-- FOOTER -->

    
    <script src="assets/js/jquery-3.6.3.min.js"></script>
    <script>
    const adminNumber = "<?php echo $admin_number; ?>";
            $(document).ready(function () {
            // Set hostname in title
            var hostname = window.location.hostname;
            document.getElementById('title').innerHTML = hostname + " > Connected";

            // Auto refresh data
            setInterval(function(){
                $("#download").load(window.location.href + " #download");
                $("#upload").load(window.location.href + " #upload");
                $("#traffic").load(window.location.href + " #traffic");
                $("#aktif").load(window.location.href + " #aktif");
                $("#expired").load(window.location.href + " #expired");
                $("#kuota").load(window.location.href + " #kuota");
            }, 1000);
        });
    </script>
</body>
</html>