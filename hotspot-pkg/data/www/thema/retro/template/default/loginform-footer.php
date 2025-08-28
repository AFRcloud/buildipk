<?php
?>

<style>

:root {
  --primary-color: #ff2e63; /* Red/Pink */
  --secondary-color: #08d9d6; /* Cyan */
  --accent-color: #f9c80e; /* Yellow */
  --dark-bg: #1a1a2e; /* Dark Blue/Purple */
  --darker-bg: #16213e; /* Even darker Blue/Purple */
  --light-bg: #252a34; /* Slightly lighter dark grey */
  --light-text: #eaeaea; /* Light grey */
  --light-text-secondary: #b2b2b2; /* Medium grey */
  --dark-text: #1a1a2e; /* Same as dark-bg */

  /* RGB values for rgba() usage */
  --primary-color-rgb: 255, 46, 99;
  --secondary-color-rgb: 8, 217, 214;
  --light-text-secondary-rgb: 178, 178, 178;

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
  padding: 0;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
  position: relative;
}

/* FOOTER */
.footer {
  background: transparent;
  padding: 1rem;
  border-top: 2px solid var(--primary-color);
  box-shadow: 0 -3px 15px rgba(var(--primary-color-rgb), 0.2);
  position: relative;
  overflow: hidden;
  margin-top: auto;
}

.footer-decoration {
  position: absolute;
  top: 0;
  right: 0;
  width: 80px;
  height: 80px;
  background-color: var(--primary-color);
  opacity: 0.1;
  clip-path: polygon(100% 0, 0 0, 100% 100%);
  z-index: 0;
}

.footer-content {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  text-align: center;
  position: relative;
  z-index: 1;
}

@media (min-width: 768px) {
  .footer-content {
    flex-direction: column;
    align-items: center;
  }
}

.footer-grid {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  width: 100%;
}

@media (min-width: 768px) {
  .footer-grid {
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
  }
}

.footer-brand {
  display: flex;
  justify-content: center;
  width: 100%;
}

@media (min-width: 768px) {
  .footer-brand {
    justify-content: flex-start;
    width: auto;
  }
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--light-text);
  text-transform: uppercase;
  letter-spacing: 1px;
}

.footer-logo svg {
  width: 32px;
  height: 32px;
  filter: drop-shadow(0 0 5px var(--secondary-color)) drop-shadow(0 0 10px var(--secondary-color));
}

.footer-highlight {
  color: var(--primary-color);
}

.footer-info {
  display: flex;
  justify-content: center;
  width: 100%;
}

@media (min-width: 768px) {
  .footer-info {
    justify-content: flex-end;
    width: auto;
  }
}

.footer-status {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--light-text-secondary);
}

.status-dot {
  width: 8px;
  height: 8px;
  background-color: var(--secondary-color);
  border-radius: 50%;
  box-shadow: 0 0 5px var(--secondary-color);
}

.status-text {
  color: var(--secondary-color);
}

.footer-bottom {
  width: 100%;
  padding-top: 0.5rem;
  border-top: 1px solid rgba(var(--light-text-secondary-rgb), 0.1);
  margin-top: 0.5rem;
}

.footer-copyright {
  font-size: 0.75rem;
  color: var(--light-text-secondary);
  line-height: 1.4;
  text-align: center;
}

.footer-brand-link {
  color: var(--secondary-color);
  text-decoration: none;
  transition: color var(--transition-speed);
}

.footer-brand-link:hover {
  color: var(--primary-color);
}

.footer-made {
  display: block;
  margin-top: 0.25rem;
  font-size: 0.7em;
  color: var(--light-text-secondary);
}

/* Hapus semua keyframes animasi yang tidak digunakan di footer */
</style>

<footer class="footer">
    <div class="footer-decoration"></div>
    <div class="footer-content">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="footer-logo">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
                <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                <line x1="12" y1="20" x2="12.01" y2="20"></line>
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="var(--secondary-color)" />
                        <stop offset="100%" stop-color="var(--primary-color)" />
                    </linearGradient>
                </defs>
            </svg>
          <span class="logo-text">AFR-Cloud.NET</span>
          </div>
        </div>
        <div class="footer-info">
          <div class="footer-status">
            <span class="status-dot"></span>
            <span class="status-text">Online 24/7</span>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="footer-copyright"> © <span id="current-year"></span> <a href="https://t.me/afrcloud" class="footer-brand-link">AFR-Cloud.NET</a>
        </div>
      </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentYearSpan = document.getElementById('current-year');
    if (currentYearSpan) {
        currentYearSpan.textContent = new Date().getFullYear();
    }
});
</script>
