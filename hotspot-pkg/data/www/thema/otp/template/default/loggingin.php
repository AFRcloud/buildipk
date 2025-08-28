<?php


?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <title id="title"></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="theme-color" content="#1a202c" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
  <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
  <style>
      /* CSS Variables for Theming */
      :root {
          /* Primary Color - Dark */
          --primary-dark: #1a202c;
          --primary-dark-lighter: #2d3748;
          
          /* Neutrals */
          --neutral-white: #ffffff;
          --neutral-light: #f7fafc;
          --neutral-medium: #718096;
          
          /* Accents */
          --accent-blue: #3182ce;
          --accent-green: #38a169;
          
          /* Set dark theme as default root variables */
          --bg-color: var(--primary-dark);
          --container-bg: var(--primary-dark-lighter);
          --text-color: var(--neutral-light);
          --header-bg: var(--primary-dark-lighter);
          --header-text: var(--neutral-white);
          --tab-border: var(--neutral-medium);
          --tab-button-color: var(--neutral-medium);
          --tab-button-active-color: var(--accent-blue);
          --tab-button-active-bg: var(--primary-dark-lighter);
          --tab-button-hover-bg: var(--neutral-medium);
          --otp-border: var(--neutral-medium);
          --otp-focus-border: var(--accent-blue);
          --otp-filled-border: var(--accent-green);
          --otp-filled-bg: rgba(56, 161, 105, 0.1);
          --table-header-bg: var(--primary-dark-lighter);
          --table-border: var(--neutral-medium);
          --table-row-border: var(--primary-dark-lighter);
          --modal-overlay-bg: rgba(26, 32, 44, 0.8);
          --modal-bg: var(--primary-dark-lighter);
          --modal-text: var(--neutral-light);
          --whatsapp-color: var(--accent-green);
          --qr-button-bg: #e53e3e;
          --qr-button-hover-bg: #c53030;
          --btn-primary-bg: var(--accent-blue);
          --btn-primary-hover-bg: #2c5aa0;
          --btn-secondary-bg: var(--accent-green);
          --btn-secondary-hover-bg: #2f855a;
          --btn-outline-border: var(--accent-blue);
          --btn-outline-text: var(--accent-blue);
          --btn-outline-hover-bg: var(--accent-blue);
          --btn-outline-hover-text: var(--neutral-white);
          --scrollbar-track: var(--primary-dark-lighter);
          --scrollbar-thumb: var(--neutral-medium);
          --scrollbar-thumb-hover: #a0aec0;
      }

      /* Dark theme as primary theme */
      [data-theme="dark"] {
          --bg-color: var(--primary-dark);
          --container-bg: var(--primary-dark-lighter);
          --text-color: var(--neutral-light);
          --header-bg: var(--primary-dark-lighter);
          --header-text: var(--neutral-white);
          --tab-border: var(--neutral-medium);
          --tab-button-color: var(--neutral-medium);
          --tab-button-active-color: var(--accent-blue);
          --tab-button-active-bg: var(--primary-dark-lighter);
          --tab-button-hover-bg: var(--neutral-medium);
          --otp-border: var(--neutral-medium);
          --otp-focus-border: var(--accent-blue);
          --otp-filled-border: var(--accent-green);
          --otp-filled-bg: rgba(56, 161, 105, 0.1);
          --table-header-bg: var(--primary-dark-lighter);
          --table-border: var(--neutral-medium);
          --table-row-border: var(--primary-dark-lighter);
          --modal-overlay-bg: rgba(26, 32, 44, 0.8);
          --modal-bg: var(--primary-dark-lighter);
          --modal-text: var(--neutral-light);
          --whatsapp-color: var(--accent-green);
          --qr-button-bg: #e53e3e;
          --qr-button-hover-bg: #c53030;
          --btn-primary-bg: var(--accent-blue);
          --btn-primary-hover-bg: #2c5aa0;
          --btn-secondary-bg: var(--accent-green);
          --btn-secondary-hover-bg: #2f855a;
          --btn-outline-border: var(--accent-blue);
          --btn-outline-text: var(--accent-blue);
          --btn-outline-hover-bg: var(--accent-blue);
          --btn-outline-hover-text: var(--neutral-white);
          --scrollbar-track: var(--primary-dark-lighter);
          --scrollbar-thumb: var(--neutral-medium);
          --scrollbar-thumb-hover: #a0aec0;
      }

      /* Added local theme as alternative to light theme */
      [data-theme="local"] {
          --bg-color: #0f172a;
          --container-bg: #1e293b;
          --text-color: #e2e8f0;
          --header-bg: #334155;
          --header-text: var(--neutral-white);
          --tab-border: #475569;
          --tab-button-color: #94a3b8;
          --tab-button-active-color: #22d3ee;
          --tab-button-active-bg: #1e293b;
          --tab-button-hover-bg: #475569;
          --otp-border: #475569;
          --otp-focus-border: #22d3ee;
          --otp-filled-border: #10b981;
          --otp-filled-bg: rgba(16, 185, 129, 0.1);
          --table-header-bg: #1e293b;
          --table-border: #475569;
          --table-row-border: #1e293b;
          --modal-overlay-bg: rgba(15, 23, 42, 0.8);
          --modal-bg: #1e293b;
          --modal-text: #e2e8f0;
          --whatsapp-color: #10b981;
          --qr-button-bg: #dc2626;
          --qr-button-hover-bg: #b91c1c;
          --btn-primary-bg: #22d3ee;
          --btn-primary-hover-bg: #0891b2;
          --btn-secondary-bg: #10b981;
          --btn-secondary-hover-bg: #059669;
          --btn-outline-border: #22d3ee;
          --btn-outline-text: #22d3ee;
          --btn-outline-hover-bg: #22d3ee;
          --btn-outline-hover-text: var(--neutral-white);
          --scrollbar-track: #1e293b;
          --scrollbar-thumb: #475569;
          --scrollbar-thumb-hover: #64748b;
      }

      /* Reset and Base Styles */
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
      /* Main Container */
      .container {
          max-width: 400px;
          margin: 0 auto;
          background: var(--container-bg);
          min-height: 100vh;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
          display: flex;
          flex-direction: column;
      }
      /* Header */
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
      .theme-toggle-button svg {
          width: 20px;
          height: 20px;
      }
      /* Tab Navigation */
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
      /* Tab Content (used as general content padding) */
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
      /* Login Content (general info text) */
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
      /* Buttons */
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
      /* Hidden inputs */
      .hidden-input {
          position: absolute;
          left: -9999px;
          opacity: 0;
      }
      /* Package Table */
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
      /* QR Code Button */
      .qr-button {
          background: var(--qr-button-bg);
          color: white;
          border: none;
          padding: 12px 20px;
          border-radius: 8px;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.2s ease;
          margin-bottom: 20px;
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
      }
      .qr-button:hover {
          background: var(--qr-button-hover-bg);
          transform: translateY(-1px);
      }
      /* Modal Styles */
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
          box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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
      /* Loading Screen */
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
      /* Responsive Design */
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
      /* Custom Scrollbar */
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

      /* Specific styles for loggingin.php */
      .main-content {
          flex-grow: 1;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          padding: 20px;
          text-align: center;
      }
      .main-content .logo-img {
          width: 50px;
          height: 50px;
          margin-bottom: 20px;
      }
      .main-content .redirect-text {
          font-size: 16px;
          color: var(--tab-button-color);
          display: flex;
          align-items: center;
          gap: 8px;
      }
      .main-content .spinner-img {
          height: 20px;
          width: 20px;
      }
  </style>
</head>
<body>
  <div class="container">
      <div class="header">
          <div class="header-left">
              <img src="assets/images/radmon.png" alt="RadMon Logo" class="header-logo-img">
              <div class="header-title">RadMon WiFi</div>
          </div>
          <button id="theme-toggle" class="theme-toggle-button">
              <!-- Icon will be set by JavaScript -->
          </button>
      </div>

      <div class="main-content">
          <a href="#" onclick="javascript:return redirect();">
              <img src="assets/images/radmon.png" alt="RadMon Logo" class="logo-img"/>
          </a>
          <p class="redirect-text"> redirecting...
          </p>
      </div>
  </div>

  <script type="text/javascript">
      // Theme Toggle Logic
      document.addEventListener('DOMContentLoaded', () => {
          const htmlElement = document.documentElement;
          const themeToggleBtn = document.getElementById('theme-toggle');

          // Function to set theme
          const setTheme = (theme) => {
              htmlElement.setAttribute('data-theme', theme);
              localStorage.setItem('theme', theme);
              updateThemeIcon(theme);
          };

          // Function to update icon
          const updateThemeIcon = (theme) => {
              if (themeToggleBtn) {
                  themeToggleBtn.innerHTML = theme === 'dark'
                      ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M4.93 19.07l1.41-1.41"/><path d="M17.66 6.34l1.41-1.41"/></svg>'
                      : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>';
              }
          };

          const savedTheme = localStorage.getItem('theme') || 'dark';
          setTheme(savedTheme);

          // Add event listener to toggle button
          if (themeToggleBtn) {
              themeToggleBtn.addEventListener('click', () => {
                  const currentTheme = htmlElement.getAttribute('data-theme');
                  const newTheme = currentTheme === 'local' ? 'dark' : 'local';
                  setTheme(newTheme);
              });
          }
      });

      // Mengatur judul halaman
      var hostname = window.location.hostname;
      document.getElementById('title').innerHTML = hostname + " > AFRCloud-NET";

      // Fungsi untuk mendapatkan parameter URL
      function getURLParam(name) {
          var params = new URLSearchParams(window.location.search);
          return params.get(name);
      }

      var loginUrl = 'http://10.10.10.1:3990/prelogin'; // Default URL

      function redirect() {
          if (loginUrl) {
              window.location = loginUrl;
          } else {
              console.error('Login URL is not defined.');
          }
          return false;
      }

      window.onload = function() {
          var paramUrl = getURLParam("loginurl");
          if (paramUrl) {
              loginUrl = paramUrl;
          }
          setTimeout(redirect, 5000); // Redirect setelah 5 detik
      }
  </script>
</body>
</html>
