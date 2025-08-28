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
            <p>' . htmlspecialchars($message, ENT_QUOTES) . '</p>
            <div class="confirm-actions">
                <button class="btn-confirm" onclick="closeAlert()">OK</button>
            </div>
        </div>
    </div>

    <script>
    function closeAlert() {
        const alertBox = document.getElementById("customAlert");
        if (alertBox) alertBox.remove();
    }
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
