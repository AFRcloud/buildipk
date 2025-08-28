<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
?>
<!DOCTYPE html>
<html>
<head>
<title id="title"></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="theme-color" content="#3B5998" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<link rel="stylesheet" href="assets/style.css">
    <style>
        .frame img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
</br><br>
<div class="main">
<form action="http://10.10.10.1:3990/logoff" name="logout" onSubmit="return openLogout()">

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
                echo '<div style="margin-top:20px; text-align: center;"><h3>Welcome</h3><i style="font-size:50px;" class="icon icon-user-circle-o">&#xf2be;</i> <h2 id="user">' . $row['username'] . '</h2></div><br>';
                echo '<table class="table2">';
                echo '<tr><td align="right" style="width: 40%;">IP Address <i class="icon icon-sitemap">&#xf0e8;</i></td><td>' . $row['userIPAddress'] . '</td></tr>';
                echo '<tr><td align="right">MAC Address <i class="icon icon-barcode">&#xe80a;</i></td><td>' . $row['userMacAddress'] . '</td></tr>';
                echo '<tr><td align="right">Upload <i class="icon icon-upload">&#xe808;</i></td><td><div id="upload">' . $row['userUpload'] . '</td></tr>';
                echo '<tr><td align="right">Download <i class="icon icon-download">&#xe809;</i></td><td><div id="download">' . $row['userDownload'] . '</td></tr>';
                echo '<tr><td align="right">Total Traffic <i class="icon icon-exchange">&#xf0ec;</i></td><td><div id="traffic">' . $row['userTraffic'] . '</td></tr>';
                echo '<tr><td align="right">Terkoneksi <i class="icon icon-clock">&#xe805;</i></td><td><div id="aktif">' . $row['userOnlineTime'] . '</td></tr>';
if ($totalSession >= 1) {
                echo '<tr><td align="right">Sisa Waktu <i class="icon icon-clock">&#xe805;</i></td><td><div id="expired">' . $row['userExpired'] . '</td></tr>';
}
if ($totalKuota >= 1) {
                echo '<tr><td align="right">Sisa Kuota <i class="icon icon-clock">&#xf252;</i></td><td><div id="kuota">' . $row['userKuota'] . '</td></tr>';
}
                echo '</table>';
                echo '<button class="button2" type="submit"><i class="icon icon-logout">&#xe804;</i> Logout</button>';
                echo '</div>';
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
<br>
</form>
</div>
<script src="assets/js/jquery-3.6.3.min.js"></script>
<script>
    $(document).ready(function () {
        setInterval(function(){
            $("#download").load(window.location.href + " #download");
            $("#upload").load(window.location.href + " #upload");
            $("#traffic").load(window.location.href + " #traffic");
            $("#aktif").load(window.location.href + " #aktif");
            $("#expired").load(window.location.href + " #expired");
            $("#kuota").load(window.location.href + " #kuota");
        },1000);
    });
</script>
</body>
</html>