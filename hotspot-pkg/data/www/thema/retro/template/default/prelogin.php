<?php
/* *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>.
 **********************************************************************************************************/

require './config/db_config.php';

$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$mac = isset($_GET['mac']) ? $_GET['mac'] : '';

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
<html lang="en">

<head>
	<title id="title">AFR-Cloud.NET | Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="theme-color" content="#1a1a2e" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<link rel="icon" type="image" href="assets/images/favicon.ico" sizes="32x32">
	<style>
		/* Base Styles */
		:root {
			/* Completely new color palette - retro cyberpunk */
			--primary-color: #ff2e63;
			--secondary-color: #08d9d6;
			--accent-color: #f9c80e;
			--dark-bg: #1a1a2e;
			--darker-bg: #16213e;
			--light-bg: #252a34;
			--light-text: #eaeaea;
			--light-text-secondary: #b2b2b2;
			--dark-text: #1a1a2e;
			/* Sizing and spacing */
			--transition-speed: 0.3s;
			--border-radius-sm: 0;
			--border-radius-md: 0;
			--border-radius-lg: 0;
			--border-radius-xl: 0;
			/* Mobile-specific variables */
			--mobile-padding: 1rem;
			--mobile-font-size: 1rem;
			--mobile-touch-target: 2.75rem;
		}

		* {
			box-sizing: border-box;
			-webkit-tap-highlight-color: transparent;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, "segoe ui", Verdana, Roboto, "helvetica neue", Arial, sans-serif, "apple color emoji";
			font-size: 14px;
			margin: 0;
			background: var(--dark-bg);
			color: var(--light-text);
			line-height: 1.5;
			min-height: 100vh;
			padding: 0 0 60px 0;
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
			background-image:
				linear-gradient(rgba(255, 46, 99, 0.1) 1px, transparent 1px),
				linear-gradient(90deg, rgba(255, 46, 99, 0.1) 1px, transparent 1px);
			background-size: 20px 20px;
			perspective: 1000px;
		}

		.retro-bg::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			height: 100%;
			background: linear-gradient(to bottom,
					rgba(26, 26, 46, 0.8) 0%,
					rgba(26, 26, 46, 0.2) 40%,
					rgba(26, 26, 46, 0.2) 60%,
					rgba(26, 26, 46, 0.8) 100%);
		}

		/* Typography */
		a {
			text-decoration: none;
			color: var(--secondary-color);
			transition: color var(--transition-speed);
		}

		a:hover {
			color: var(--primary-color);
		}

		/* HEADER */
		.header {
			width: 100%;
			padding: 1.5rem;
			background-color: var(--darker-bg);
			border-bottom: 2px solid var(--primary-color);
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

		.logo-container {
			display: flex;
			align-items: center;
		}

		.logo-text {
			font-size: 1.75rem;
			font-weight: 700;
			color: var(--light-text);
			text-transform: uppercase;
			letter-spacing: 2px;
			position: relative;
			padding-left: 0.5rem;
			animation: textShadow 1.5s infinite;
		}

		.logo-text::before,
		.logo-text::after {
			content: 'AFR-CLOUD.NET';
			position: absolute;
			top: 0;
			left: 0.5rem;
			width: 100%;
			height: 100%;
			clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
			background-color: transparent;
		}

		.logo-text::before {
			left: 0.48rem;
			text-shadow: -2px 0 var(--secondary-color);
			animation: glitch-1 2.5s infinite ease-in-out;
			opacity: 0.8;
		}

		.logo-text::after {
			left: 0.52rem;
			text-shadow: 2px 0 var(--primary-color);
			animation: glitch-2 2s infinite ease-in-out reverse;
			opacity: 0.8;
		}

		.logo-highlight {
			color: var(--primary-color);
		}

		.header-decoration {
			position: absolute;
			top: 0;
			right: 0;
			width: 150px;
			height: 150px;
			background-color: var(--primary-color);
			opacity: 0.1;
			clip-path: polygon(100% 0, 0 0, 100% 100%);
		}

		/* MAIN */
		.main {
			flex: 1;
			width: 100%;
			max-width: 800px;
			margin: 2rem auto;
			padding: 0 1rem;
		}

		/* Card Component - Retro Tech Style */
		.card {
			background-color: var(--light-bg);
			border: 1px solid var(--primary-color);
			box-shadow: 5px 5px 0 var(--primary-color);
			margin-bottom: 2rem;
			position: relative;
			overflow: hidden;
		}

		.card-header {
			background-color: var(--primary-color);
			color: var(--dark-bg);
			padding: 1rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.card-header-tabs {
			display: flex;
		}

		.card-tab {
			padding: 0.5rem 1rem;
			background-color: var(--dark-bg);
			color: var(--light-text);
			margin-right: 0.5rem;
			cursor: pointer;
			transition: all 0.3s ease;
			border: 1px solid transparent;
		}

		.card-tab.active {
			background-color: var(--secondary-color);
			color: var(--dark-bg);
			font-weight: 700;
		}

		.card-tab:hover:not(.active) {
			border-color: var(--secondary-color);
		}

		.card-body {
			padding: 1.5rem;
		}

		/* Tab Content */
		.tab-content {
			display: none;
		}

		.tab-content.active {
			display: block;
		}

		/* Login Form - Retro Tech Style */
		.form-group {
			margin-bottom: 1.5rem;
		}

		.form-label {
			display: block;
			margin-bottom: 0.5rem;
			font-weight: 500;
			color: var(--secondary-color);
			text-transform: uppercase;
			letter-spacing: 1px;
			font-size: 0.875rem;
		}

		.input {
			width: 100%;
			padding: 0.75rem;
			background-color: var(--darker-bg);
			border: 1px solid var(--secondary-color);
			color: var(--light-text);
			font-size: 1rem;
			transition: all 0.3s ease;
			outline: none;
			font-family: inherit;
		}

		.input:focus {
			border-color: var(--primary-color);
			box-shadow: 0 0 0 2px rgba(255, 46, 99, 0.3);
		}

		.input::placeholder {
			color: var(--light-text-secondary);
			opacity: 0.7;
		}

		/* Button - Retro Tech Style */
		.btn {
			display: inline-block;
			padding: 0.75rem 1.5rem;
			background-color: var(--secondary-color);
			color: var(--dark-bg);
			border: none;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-family: inherit;
			font-size: 1rem;
			position: relative;
			overflow: hidden;
		}

		.btn:hover {
			background-color: var(--primary-color);
			transform: translateY(-2px);
		}

		.btn:active {
			transform: translateY(0);
		}

		/* Animated Login Button */
		.btn-login {
			position: relative;
			overflow: hidden;
			transition: all 0.3s ease;
			width: 100%;
			margin-bottom: 0.5rem;
		}

		.btn-login::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg,
					transparent,
					rgba(255, 255, 255, 0.2),
					transparent);
			transition: 0.5s;
		}

		.btn-login:hover::before {
			left: 100%;
		}

		.btn-login.glitch {
			animation: btn-glitch 0.3s ease;
		}

		@keyframes btn-glitch {
			0% {
				transform: translate(0);
			}

			20% {
				transform: translate(-3px, 0);
			}

			40% {
				transform: translate(3px, 0);
			}

			60% {
				transform: translate(-3px, 0);
			}

			80% {
				transform: translate(3px, 0);
			}

			100% {
				transform: translate(0);
			}
		}

		/* WhatsApp Button - Retro Tech Style */
		.whatsapp-btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 0.75rem 1.5rem;
			background-color: var(--accent-color);
			color: var(--dark-bg);
			border: none;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-family: inherit;
			font-size: 0.875rem;
			gap: 0.5rem;
			margin-top: 1rem;
			width: 100%;
		}

		.whatsapp-btn:hover {
			background-color: var(--primary-color);
			color: var(--light-text);
		}

		.whatsapp-icon {
			width: 20px;
			height: 20px;
			fill: currentColor;
		}

		/* Package List - Retro Tech Style */
		.package-list {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
			gap: 1rem;
		}

		.package-item {
			background-color: var(--darker-bg);
			border: 1px solid var(--secondary-color);
			padding: 1rem;
			display: flex;
			flex-direction: column;
			transition: all 0.3s ease;
			position: relative;
			overflow: hidden;
		}

		.package-item:hover {
			border-color: var(--primary-color);
			transform: translateY(-5px);
		}

		.package-item::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 5px;
			background-color: var(--secondary-color);
		}

		.package-item:hover::before {
			background-color: var(--primary-color);
		}

		.package-name {
			font-weight: 700;
			color: var(--secondary-color);
			margin-bottom: 0.5rem;
			font-size: 1.125rem;
			text-transform: uppercase;
		}

		.package-details {
			margin-bottom: 1rem;
			color: var(--light-text-secondary);
			font-size: 0.875rem;
		}

		.package-price {
			margin-top: auto;
			font-weight: 700;
			font-size: 1.25rem;
			color: var(--primary-color);
			align-self: flex-end;
		}

		.package-buy-btn {
			padding: 0.5rem 1rem;
			background-color: var(--accent-color);
			color: var(--dark-bg);
			border: none;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-family: inherit;
			font-size: 0.75rem;
			margin-top: 1rem;
		}

		.package-buy-btn:hover {
			background-color: var(--primary-color);
			color: var(--light-text);
			transform: translateY(-2px);
		}

		/* Notice - Retro Tech Style */
		.notice {
			background-color: var(--darker-bg);
			padding: 0.75rem;
			margin-bottom: 1rem;
			font-size: 0.875rem;
			border-left: 5px solid var(--primary-color);
		}

		/* Info - Retro Tech Style */
		.info {
			background-color: var(--darker-bg);
			padding: 0.75rem;
			margin-bottom: 1rem;
			font-size: 0.875rem;
			border-left: 5px solid var(--secondary-color);
		}

		/* Custom Confirm Dialog */
		.confirm-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(26, 26, 46, 0.9);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 1000;
		}

		.confirm-box {
			background-color: var(--light-bg);
			border: 2px solid var(--primary-color);
			box-shadow: 10px 10px 0 var(--primary-color);
			padding: 2rem;
			max-width: 400px;
			width: 90%;
			text-align: center;
		}

		.confirm-actions {
			margin-top: 1.5rem;
			display: flex;
			gap: 1rem;
			justify-content: center;
		}

		.btn-confirm,
		.btn-cancel {
			padding: 0.75rem 1.5rem;
			border: none;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-family: inherit;
		}

		.btn-confirm {
			background-color: var(--secondary-color);
			color: var(--dark-bg);
		}

		.btn-confirm:hover {
			background-color: var(--primary-color);
			color: var(--light-text);
		}

		.btn-cancel {
			background-color: var(--darker-bg);
			color: var(--light-text);
			border: 1px solid var(--primary-color);
		}

		.btn-cancel:hover {
			background-color: var(--primary-color);
		}

		/* QR Button */
		.qr-button {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 0.75rem 1.5rem;
			background-color: var(--secondary-color);
			color: var(--dark-bg);
			border: none;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-family: inherit;
			font-size: 0.875rem;
			gap: 0.5rem;
			width: 100%;
			margin-bottom: 1rem;
		}

		.qr-button:hover {
			background-color: var(--primary-color);
			color: var(--light-text);
			transform: translateY(-2px);
		}

		/* Please Wait Screen */
		#pleaseWait {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: var(--dark-bg);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			z-index: 999;
		}

		#pleaseWait img {
			filter: brightness(0) saturate(100%) invert(85%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
		}

		/* FOOTER */
		.footer {
			position: absolute;
			bottom: 0;
			left: 0;
			width: 100%;
			bottom: 0;
			left: 0;
			width: 100%;
			background-color: var(--darker-bg);
			padding: 0.5rem;
			/* Lebih ringkas */
			border-top: none;
			/* Hapus border solid, gunakan ::after */
			z-index: 100;
			backdrop-filter: blur(10px);
			box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
			overflow: hidden;
		}

		.footer::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-image:
				linear-gradient(rgba(255, 46, 99, 0.05) 1px, transparent 1px),
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
			gap: 0.5rem;
			/* Lebih ringkas */
		}

		.footer-grid {
			display: flex;
			justify-content: space-between;
			align-items: center;
			width: 100%;
			flex-wrap: wrap;
			gap: 0.5rem;
			/* Lebih ringkas */
		}

		.footer-brand {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			gap: 0.1rem;
			/* Sangat ringkas */
		}

		.footer-logo {
			font-size: 1.2rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 1px;
			color: var(--light-text);
			text-shadow: 0 0 8px var(--secondary-color), 0 0 15px var(--primary-color);
			/* Glow lebih kuat */
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
			font-size: 0.7rem;
			/* Lebih kecil */
			color: var(--light-text-secondary);
			letter-spacing: 0.5px;
		}

		.footer-info {
			display: flex;
			flex-direction: column;
			align-items: flex-end;
			gap: 0.1rem;
			/* Sangat ringkas */
		}

		.footer-status,
		.footer-speed {
			display: flex;
			align-items: center;
			gap: 0.5rem;
			font-size: 0.75rem;
			/* Lebih kecil */
			color: var(--light-text);
		}

		.status-dot {
			width: 7px;
			/* Lebih kecil */
			height: 7px;
			background-color: #00ff00;
			border-radius: 50%;
			animation: blink 1.5s infinite;
			box-shadow: 0 0 7px #00ff00, 0 0 12px rgba(0, 255, 0, 0.5);
			/* Glow lebih kuat */
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
			height: 2px;
			/* Sedikit lebih tebal */
			background: linear-gradient(90deg, transparent 0%, var(--primary-color) 25%, var(--secondary-color) 50%, var(--accent-color) 75%, transparent 100%);
			background-size: 600% 100%;
			/* Ukuran background lebih besar untuk animasi */
			animation: moveGradient 15s linear infinite;
			/* Animasi lebih lambat dan halus */
			margin: 0.2rem 0;
			/* Margin sangat ringkas */
			opacity: 0.8;
			/* Sedikit lebih terlihat */
			box-shadow: 0 0 5px rgba(255, 46, 99, 0.5), 0 0 10px rgba(8, 217, 214, 0.5);
			/* Glow pada divider */
		}

		@keyframes moveGradient {
			0% {
				background-position-x: 0%;
			}

			100% {
				background-position-x: -500%;
				/* Menggeser gradien lebih jauh */
			}
		}

		.footer-bottom {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 0.1rem;
			/* Sangat ringkas */
			font-size: 0.10rem;
			/* Lebih kecil */
			flex-wrap: wrap;
		}

		.footer-copyright {
			color: var(--light-text-secondary);
		}

		.footer-separator {
			color: var(--primary-color);
			margin: 0;
			/* Lebih ringkas */
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
			content: '';
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
			content: '';
			position: absolute;
			top: 0;
			/* Posisikan di bagian atas footer */
			left: 0;
			width: 100%;
			height: 3px;
			/* Lebih tebal */
			background: linear-gradient(90deg,
					transparent 0%,
					var(--primary-color) 20%,
					var(--secondary-color) 50%,
					var(--primary-color) 80%,
					transparent 100%);
			animation: footerGlow 3s ease-in-out infinite alternate;
			box-shadow: 0 0 15px var(--primary-color), 0 0 30px var(--secondary-color);
			/* Glow lebih kuat */
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
				gap: 0.5rem;
				/* Lebih ringkas */
			}

			.footer-brand,
			.footer-info {
				align-items: center;
			}

			.footer-bottom {
				flex-direction: column;
				gap: 0.25rem;
				/* Lebih ringkas */
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
				gap: 0.5rem;
				/* Lebih ringkas */
			}

			.footer-grid {
				gap: 0.5rem;
				/* Lebih ringkas */
			}

			.footer-logo {
				font-size: 1rem;
			}

			.footer-logo-icon {
				font-size: 1.2rem;
			}

			.footer-tagline {
				font-size: 0.65rem;
				/* Lebih kecil lagi */
			}

			.footer-status,
			.footer-speed {
				font-size: 0.7rem;
				/* Lebih kecil lagi */
			}

			.footer-copyright,
			.footer-made {
				font-size: 0.65rem;
				/* Lebih kecil lagi */
			}
		}

		@keyframes textShadow {
			0% {
				text-shadow: 0.4389924193300864px 0 1px rgba(255, 46, 99, 0.5), -0.4389924193300864px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			5% {
				text-shadow: 2.7928974010788217px 0 1px rgba(255, 46, 99, 0.5), -2.7928974010788217px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			10% {
				text-shadow: 0.02956275843481219px 0 1px rgba(255, 46, 99, 0.5), -0.02956275843481219px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			15% {
				text-shadow: 0.40218538552878136px 0 1px rgba(255, 46, 99, 0.5), -0.40218538552878136px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			20% {
				text-shadow: 3.4794037899852017px 0 1px rgba(255, 46, 99, 0.5), -3.4794037899852017px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			25% {
				text-shadow: 1.6125630401149584px 0 1px rgba(255, 46, 99, 0.5), -1.6125630401149584px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			30% {
				text-shadow: 0.7015590085143956px 0 1px rgba(255, 46, 99, 0.5), -0.7015590085143956px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			35% {
				text-shadow: 3.896914047650351px 0 1px rgba(255, 46, 99, 0.5), -3.896914047650351px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			40% {
				text-shadow: 3.870905614848819px 0 1px rgba(255, 46, 99, 0.5), -3.870905614848819px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			45% {
				text-shadow: 2.231056963361899px 0 1px rgba(255, 46, 99, 0.5), -2.231056963361899px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			50% {
				text-shadow: 0.08084290417898504px 0 1px rgba(255, 46, 99, 0.5), -0.08084290417898504px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			55% {
				text-shadow: 2.3758461067427543px 0 1px rgba(255, 46, 99, 0.5), -2.3758461067427543px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			60% {
				text-shadow: 2.202193051050636px 0 1px rgba(255, 46, 99, 0.5), -2.202193051050636px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			65% {
				text-shadow: 2.8638780614874975px 0 1px rgba(255, 46, 99, 0.5), -2.8638780614874975px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			70% {
				text-shadow: 0.48874025155497314px 0 1px rgba(255, 46, 99, 0.5), -0.48874025155497314px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			75% {
				text-shadow: 1.8948491305757957px 0 1px rgba(255, 46, 99, 0.5), -1.8948491305757957px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			80% {
				text-shadow: 0.0833037308038857px 0 1px rgba(255, 46, 99, 0.5), -0.0833037308038857px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			85% {
				text-shadow: 0.09769827255241735px 0 1px rgba(255, 46, 99, 0.5), -0.09769827255241735px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			90% {
				text-shadow: 3.443339761481782px 0 1px rgba(255, 46, 99, 0.5), -3.443339761481782px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			95% {
				text-shadow: 2.1841838852799786px 0 1px rgba(255, 46, 99, 0.5), -2.1841838852799786px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
			}

			100% {
				text-shadow: 2.6208764473832513px 0 1px rgba(255, 46, 99, 0.5), -2.6208764473832513px 0 1px rgba(8, 217, 214, 0.3), 0 0 3px;
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
	<!-- Retro Grid Background -->
	<div class="retro-bg"></div>
	<!-- HEADER -->
	<header class="header">
		<div class="header-decoration"></div>
		<div class="header-content">
			<div class="logo-container">
				<h1 class="logo-text">AFR-<span class="logo-highlight">CLOUD</span>.NET</h1>
			</div>
			<div class="tagline" style="color: var(--light-text-secondary); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 1px;"></div>
		</div>
	</header>
	<!-- Custom Confirm Dialog -->
	<div id="customConfirm" class="confirm-overlay" style="display: none;">
		<div class="confirm-box">
			<p id="confirmMessage"></p>
			<div class="confirm-actions">
				<button id="confirmYes" class="btn-confirm">Ya</button>
				<button id="confirmNo" class="btn-cancel">Batal</button>
				<button id="confirmOk" class="btn-confirm">OK</button>
			</div>
		</div>
	</div>
	<!-- MAIN -->
	<main class="main">
		<!-- Single Card with Tabs -->
		<div class="card">
			<div class="card-header">
				<div></div>
				<div class="card-header-tabs">
					<div class="card-tab active" id="voucher-tab">LOGIN VOUCHER</div>
					<div class="card-tab" id="packages-tab">LIST PACKAGES</div>
				</div>
			</div>
			<div class="card-body">
				<!-- Tab Contents -->
				<div class="tab-content active" id="voucher-content">
					<div id="infologin" class="info"> Masukkan Kode Voucher kemudian klik login </div>
					<!-- QR Scanner Button -->
					<button class="qr-button" onclick="window.location='https://maizil41.github.io/scanner';">
						<i class="icon">📱</i> Scan QR Code </button>
					<form autocomplete="off" name="login" action="<?php echo $loginpath; ?>" method="post">
						<input type="hidden" name="dst" value="$(link-orig)" />
						<input type="hidden" name="popup" value="true" />
						<input type="hidden" name="challenge" value="<?php echo $challenge; ?>">
						<input type="hidden" name="uamip" value="<?php echo $uamip; ?>">
						<input type="hidden" name="uamport" value="<?php echo $uamport; ?>">
						<input type="hidden" name="userurl" value="<?php echo $userurl; ?>">
						<div class="form-group">
							<label class="form-label" for="username">Kode Voucher</label>
							<input class="input" id="username" name="UserName" type="text" placeholder="Masukkan kode voucher di sini" autocomplete="off" autocorrect="off" autocapitalize="off" />
						</div>
						<input type="hidden" id="pass" name="Password" />
						<input type="hidden" name="button" value="Login">
						<button class="btn btn-login" id="voucherLoginBtn" type="submit">LOGIN</button>
						<button type="button" class="btn btn-login" onclick="handleTrial()" id="trialButton" style="background-color: var(--accent-color);"> GRATIS 10 Menit </button>
					</form>
					<div style="text-align: center; margin-top: 1.5rem;">
						<a href="https://wa.me/<?php echo $admin_number ?>" class="whatsapp-btn">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="whatsapp-icon">
								<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
							</svg> BELI VIA WHATSAPP </a>
					</div>
				</div>
				<div class="tab-content" id="packages-content">
					<div class="package-list" id="paket-list">
						<!-- Package items will be loaded here by JavaScript -->
					</div>
					<div style="text-align: center; margin-top: 1.5rem;">
						<a href="https://wa.me/<?php echo $admin_number ?>" class="whatsapp-btn">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="whatsapp-icon">
								<path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
							</svg> BELI VIA WHATSAPP </a>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- Please Wait Screen 
    <div id="pleaseWait" style="display:none; text-align: center; padding-top: 50%;">
        <img src="assets/images/mutiara.png" alt="" border="0" height="50" width="150"/>
        <br>
        <small><img src="assets/images/wait.gif"/> redirecting...</small>
        <br><br>
    </div>
    -->
	<!-- FOOTER -->

	<script type="text/javascript">
		// Tab Switching
		document.addEventListener('DOMContentLoaded', function() {
			const voucherTab = document.getElementById('voucher-tab');
			const packagesTab = document.getElementById('packages-tab');
			const voucherContent = document.getElementById('voucher-content');
			const packagesContent = document.getElementById('packages-content');
			voucherTab.addEventListener('click', function() {
				voucherTab.classList.add('active');
				packagesTab.classList.remove('active');
				voucherContent.classList.add('active');
				packagesContent.classList.remove('active');
			});
			packagesTab.addEventListener('click', function() {
				packagesTab.classList.add('active');
				voucherTab.classList.remove('active');
				packagesContent.classList.add('active');
				voucherContent.classList.remove('active');
			});
			// Initialize login form
			var hostname = window.location.hostname;
			document.getElementById('title').innerHTML = hostname + " > login";
			const username = document.getElementById('username');
			const password = document.getElementById('pass');
			if (username) {
				username.placeholder = "Masukkan kode voucher di sini";
				username.focus();
				// Set password = username for voucher login
				username.addEventListener('input', function() {
					const user = username.value;
					username.value = user;
					password.value = user;
				});
			}
			// Set login info
			const infologin = document.getElementById('infologin');
			if (infologin) {
				infologin.innerHTML = "Masukkan Kode Voucher kemudian klik login.";
			}
			// Login Button Animation
			const voucherLoginBtn = document.getElementById('voucherLoginBtn');
			if (voucherLoginBtn) {
				voucherLoginBtn.addEventListener('click', function(e) {
					// Check if form is valid
					const voucherInput = document.getElementById('username');
					if (voucherInput && voucherInput.value.trim() === '') {
						// Show glitch effect for invalid input
						this.classList.add('glitch');
						setTimeout(() => {
							this.classList.remove('glitch');
						}, 300);
						e.preventDefault();
						return;
					}
				});
			}
		});
		// RadMon PHP Functions Integration
		function handleTrial() {
			const mac = "<?php echo $mac; ?>";
			fetch(`cek_trial.php?mac=${mac}`).then(response => response.json()).then(data => {
				if (data.TrialOk === true) {
					showAlert("⚠️ Anda sudah menggunakan TRIAL hari ini.<br/>Silahkan kembali lagi besok!.");
				} else {
					window.location.href = `./trial.php?mac=${mac}`;
				}
			}).catch(error => {
				console.error('Gagal cek status trial:', error);
				showAlert("Terjadi kesalahan saat mengecek status trial.");
			});
		}

		function formatTime(seconds) {
			if (seconds == null || isNaN(seconds) || seconds <= 0) {
				return "Unlimited";
			}
			if (seconds < 60) {
				return `${seconds} detik`;
			} else if (seconds < 3600) {
				return `${Math.floor(seconds / 60)} menit`;
			} else if (seconds < 86400) {
				return `${Math.floor(seconds / 3600)} jam`;
			} else {
				return `${Math.floor(seconds / 86400)} hari`;
			}
		}
		// Load packages
		const adminNumber = "<?php echo $admin_number ?>"; // Nomor WhatsApp admin
		fetch('get_package.php').then(response => response.json()).then(data => {
			let ipAddress = "<?php echo $ip; ?>";
			let macAddress = "<?php echo $mac; ?>";
			let paketList = document.getElementById('paket-list');
			paketList.innerHTML = "";
			// Urutkan data berdasarkan harga
			data.sort((a, b) => parseInt(a.planCost) - parseInt(b.planCost));
			data.forEach(paket => {
				let hargaAsli = parseInt(paket.planCost);
				let hargaAcak = Math.floor(Math.random() * 100) + 1;
				let hargaTotal = hargaAsli + hargaAcak;
				let durasi = formatTime(parseInt(paket.value));
				let packageItem = `
        <div class="package-item">
            <div class="package-name">Paket : ${paket.planName}</div>
            <div class="package-details">Durasi: ${durasi}</div>
            <div class="package-price">Rp. ${hargaAsli.toLocaleString('id-ID')}</div>
            <button class="package-buy-btn" onClick="beliPaket('${paket.planName}', ${hargaTotal}, '${ipAddress}', '${macAddress}')">Beli</button>
            <button class="package-buy-btn" onClick="beliViaWhatsapp('${paket.planName}')">BELI VIA WHATSAPP</button>
        </div>
    `;
				paketList.innerHTML += packageItem;
			});
		}).catch(error => console.error('Gagal mengambil data:', error));
		// Status maintenance
		var isMaintenance = false;
		var maintenanceMsg = "";
		fetch('maintenance.php').then(response => response.json()).then(data => {
			isMaintenance = data.maintenance;
			if (isMaintenance) {
				maintenanceMsg = `⛔ ${data.pesan}<br>Estimasi: ${data.estimasi}`;
			}
		}).catch(error => {
			console.error('Gagal mengambil status maintenance:', error);
		});
		// Fungsi beli via WhatsApp dengan dialog
		function beliViaWhatsapp(namaPaket) {
			const message = `Beli ${namaPaket}`;
			showConfirmDialog(`Apakah Anda yakin ingin membeli paket ${namaPaket} via WhatsApp?`, function() {
				const whatsappUrl = `https://wa.me/${adminNumber}?text=${encodeURIComponent(message)}`;
				window.open(whatsappUrl, '_blank');
			});
		}
		// Fungsi beli paket
		function beliPaket(namaPaket, hargapaket, ip, mac) {
			if (isMaintenance) {
				showAlert(maintenanceMsg);
				return;
			}
			let message = `Apakah Anda yakin ingin membeli paket ${namaPaket} dengan harga Rp.${hargapaket.toLocaleString('id-ID')}?`;
			showConfirmDialog(message, function() {
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
		// Dialog konfirmasi custom
		function showConfirmDialog(message, callbackYes, callbackNo) {
			document.getElementById('confirmMessage').innerHTML = message;
			document.getElementById('confirmYes').style.display = 'inline-block';
			document.getElementById('confirmNo').style.display = 'inline-block';
			document.getElementById('confirmOk').style.display = 'none';
			document.getElementById('customConfirm').style.display = 'flex';
			document.getElementById('confirmYes').onclick = function() {
				document.getElementById('customConfirm').style.display = 'none';
				if (callbackYes) callbackYes();
			};
			document.getElementById('confirmNo').onclick = function() {
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
			document.getElementById('confirmOk').onclick = function() {
				document.getElementById('customConfirm').style.display = 'none';
				if (callbackOk) callbackOk();
			};
		}
		const macAddress = "<?php echo $mac; ?>";

		function cekStatus() {
			fetch(`cek_payment.php?mac=${encodeURIComponent(macAddress)}`).then(response => response.json()).then(data => {
				if (data.status === 'success') {
					const url = 'redirect_sukses.php?username=' + encodeURIComponent(data.username) + '&paket=' + encodeURIComponent(data.profile) + '&harga=' + encodeURIComponent(data.amount) + '&ref=' + encodeURIComponent(data.trx_id);
					window.location.href = url;
				} else {
					setTimeout(cekStatus, 1000);
				}
			}).catch(err => {
				console.error('Error cek status:', err);
				setTimeout(cekStatus, 1000);
			});
		}
		window.addEventListener('load', () => {
			cekStatus();
		});
	</script>
</body>

</html>