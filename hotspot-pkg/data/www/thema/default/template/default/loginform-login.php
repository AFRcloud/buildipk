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
<!doctype html>
<html lang="en">

<head>
    <title id="title"></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="#3B5998" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link rel="icon" type="image" href="assets/images/favicon.svg" sizes="32x32">
    <link rel="stylesheet" href="assets/style.css">
    <style> 
        .frame img {width: 100%; height: auto;}
        .container {
            width: 100%;
            margin: auto;
            height: 240px;
            overflow-y: auto;
        }
        .confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .confirm-box {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            text-align: center;
            max-width: 250px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            animation: fadeIn 0.3s ease;
        }

        .confirm-box p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .failed-box {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            text-align: center;
            max-width: 250px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            animation: fadeIn 0.3s ease;
        }
        
        .failed-box p {
            font-size: 16px;
            margin-bottom: 20px;
            color: red;
        }

        .confirm-actions button {
            margin: 0 10px;
            padding: 8px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-confirm {
            background-color: #28a745;
            color: white;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

</head>
<body style="margin: 0 auto; height: 100%;">
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
    <div id="main" class="main">
        <div class="box">
            <div class="frame">
                <img src="/RadMonv2/img/logo/radmon-logo.png" alt="logo"><br>
            </div>
            <div class="box">
                <button id="qr" class="small-button" onclick="window.location='https://maizil41.github.io/scanner';">
                    <i class="icon icon-qrcode">&#xe801;</i> Scan QR Code
                </button>
            </div>
            <div class="box" id="infologin"></div>
            <form autocomplete="off" name="login" action="<?php echo $loginpath; ?>" method="post" class="animated-input">
                <input type="hidden" name="dst" value="$(link-orig)" />
                <input type="hidden" name="popup" value="true" />
                <input class="username" name="username" type="hidden" value="$(username)" />

                <input type="hidden" name="challenge" value="<?php echo $challenge; ?>">
                <input type="hidden" name="uamip" value="<?php echo $uamip; ?>">
                <input type="hidden" name="uamport" value="<?php echo $uamport; ?>">
                <input type="hidden" name="userurl" value="<?php echo $userurl; ?>">

                <input class="username" name="UserName" type="text" id="user" class="form-use" placeholder="Kode Voucher" required autofocus />
                <input type="hidden" id="pass" class="password" name="Password" placeholder="Password" required />
                
                <input type="hidden" name="button" value="Login">
                <button class="login-button" onClick='javascript:popUp("$loginpath?res=popup1&uamip=$uamip&uamport=$uamport")'>
                    <i class="icon icon-login">&#xe807;</i> MASUK
                </button>
                <button type="button" class="login-button" onclick="handleTrial()" id="trialButton">
                    <i class="icon icon-login">&#xe803;</i> GRATIS
                </button>
            </form>

            <b>
            <div style="max-height: 243px; overflow-y: auto;">
              <table border="1" width="100%">
                <thead style="position: sticky; top: 0; background: #fff; z-index: 1;">
                  <tr>
                    <th>Paket</th>
                    <th>Durasi</th>
                    <th>Harga</th>
                    <th>Beli</th>
                  </tr>
                </thead>
                <tbody id="paket-list">
                </tbody>
              </table>
            </div>
            <br/>
            <div class="frame">
                Voucher bisa dibeli melalui<br>
                Whatsapp: <a href="https://wa.me/<?php echo $admin_number ?>" style="text-decoration: underline; color:#000;"><?php echo $formatted ?></a>
            </div>
        </div>
    </div>

    <div id="pleaseWait" style="display:none; text-align: center; padding-top: 50%;">
        <img src="assets/images/mutiara.png" alt="" border="0" height="50" width="150"/>
      </a><br>
      <small><img src="assets/images/wait.gif"/> redirecting...</small>
    </p>
    <br><br>
    </div>

    <script type="text/javascript">
        var hostname = window.location.hostname;
        document.getElementById('title').innerHTML = hostname + " > login";

        document.login.username.focus();

        var infologin = document.getElementById('infologin');
        infologin.innerHTML = "Masukkan Kode Voucher<br>kemudian klik login.";

        var username = document.login.username;
        var password = document.getElementById('pass');

        function setpass() {
            var user = username.value.toLowerCase();
            username.value = user;
            password.value = user;
        }

        function voucher() {
            username.focus();
            username.onkeyup = setpass;
            username.placeholder = "Kode Voucher";
            username.style.borderRadius = "3px";
            password.type = "hidden";
            infologin.innerHTML = "Masukkan Kode Voucher<br>kemudian klik login.";
        }

        function handleTrial() {
            const mac = "<?php echo $mac; ?>";

            fetch(`cek_trial.php?mac=${mac}`)
                .then(response => response.json())
                .then(data => {
                    if (data.TrialOk === true) {
                        showAlert("⚠️ Anda sudah menggunakan TRIAL hari ini.<br/>Silahkan kembali lagi besok!.");
                    } else {
                        window.location.href = `./trial.php?mac=${mac}`;
                    }
                })
                .catch(error => {
                    console.error('Gagal cek status trial:', error);
                    showAlert("Terjadi kesalahan saat mengecek status trial.");
                });
        }

        function formatTime(seconds) {
            if (seconds < 60) {
                return `${seconds} detik`;
            } else if (seconds < 3600) {
                let minutes = Math.floor(seconds / 60);
                return `${minutes} menit`;
            } else if (seconds < 86400) {
                let hours = Math.floor(seconds / 3600);
                let minutes = Math.floor((seconds % 3600) / 60);
                return `${hours} jam`;
            } else {
                let days = Math.floor(seconds / 86400);
                let hours = Math.floor((seconds % 86400) / 3600);
                return `${days} hari`;
            }
        }

        function getNextHargaAcak() {
            let step = parseInt(localStorage.getItem('hargaAcakStep')) || 0;
            let base = Math.floor(step / 50);
            let index = step % 50;

            let hargaAcak;
            if (base === 0) {
                hargaAcak = 1 + (index * 2);
            } else {
                hargaAcak = 2 + (index * 2);
            }
        
            step++;
            if (step >= 100) step = 0; // ulang ke 0 kalau sudah lewat 100
            localStorage.setItem('hargaAcakStep', step);
        
            return hargaAcak;
        }

        fetch('get_package.php')
            .then(response => response.json())
            .then(data => {
                let ipAddress = "<?php echo $ip; ?>"; 
                let macAddress = "<?php echo $mac; ?>"; 
                let paketList = document.getElementById('paket-list');
                paketList.innerHTML = ""; 
        
                data.forEach(paket => {
                    let hargaAsli = parseInt(paket.planCost);
                    let hargaAcak = getNextHargaAcak();
                    let hargaTotal = hargaAsli + hargaAcak;
        
                    let row = `
                        <tr>
                            <td><center>${paket.planName}</center></td>
                            <td><center>${formatTime(paket.value)}</center></td>
                            <td><center>Rp.${hargaAsli.toLocaleString('id-ID')}</center></td>
                            <td><center>
                                <button class="beli-button" onClick="beliPaket('${paket.planName}', ${hargaTotal}, '${ipAddress}', '${macAddress}')">Beli</button>
                            </center></td>
                        </tr>
                    `;
                    paketList.innerHTML += row;
                });
            })
            .catch(error => console.error('Gagal mengambil data:', error));
            
        var isMaintenance = false;
        var maintenanceMsg = "";

        fetch('maintenance.php')
            .then(response => response.json())
            .then(data => {
                isMaintenance = data.maintenance;
                if (isMaintenance) {
                    maintenanceMsg = `⛔ ${data.pesan}<br>Estimasi: ${data.estimasi}`;
                }
            })
            .catch(error => {
                console.error('Gagal mengambil status maintenance:', error);
            });
            
        function beliPaket(namaPaket, hargapaket, ip, mac) {
            if (isMaintenance) {
                showAlert(maintenanceMsg);
                return;
            }
            
            let message = `Apakah Anda yakin ingin membeli paket ${namaPaket} dengan harga Rp.${hargapaket.toLocaleString('id-ID')}?`;
            showConfirmDialog(message, function () {
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

        function showConfirmDialog(message, callbackYes, callbackNo) {
            document.getElementById('confirmMessage').textContent = message;

            document.getElementById('confirmYes').style.display = 'inline-block';
            document.getElementById('confirmNo').style.display = 'inline-block';
            document.getElementById('confirmOk').style.display = 'none';

            document.getElementById('customConfirm').style.display = 'flex';

            document.getElementById('confirmYes').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                callbackYes();
            };
            document.getElementById('confirmNo').onclick = function () {
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

            document.getElementById('confirmOk').onclick = function () {
                document.getElementById('customConfirm').style.display = 'none';
                if (callbackOk) callbackOk();
            };
        }
        
        const macAddress = "<?php echo $mac; ?>";
        
        function cekStatus() {
            fetch(`cek_payment.php?mac=${encodeURIComponent(macAddress)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const url = 'redirect_sukses.php?username=' + encodeURIComponent(data.username) +
                                    '&paket=' + encodeURIComponent(data.profile) +
                                    '&harga=' + encodeURIComponent(data.amount) +
                                    '&ref=' + encodeURIComponent(data.trx_id);
                        window.location.href = url;
                    } else {
                        setTimeout(cekStatus, 1000);
                    }
                })
                .catch(err => {
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