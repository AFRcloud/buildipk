<?php
/*
 *********************************************************************************************************
 * Hotspotlogin RadMon by Maizil https://t.me/maizil41
 * This program is free and not for sale. If you want to sell one, make your own, don't take someone else's work.
 * Don't change what doesn't need to be changed, please respect others' work
 * Copyright (C) 2024 - Mutiara-Wrt by <@maizi41>. 
 *********************************************************************************************************
*/ 
function generateRandomString($length = 4) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function insertRadcheck($username, $mac_address) {
    
    require './config/mysqli_db.php';
    $plan_name = "TRIAL";
    
    try {

        $stmt = $conn->prepare("INSERT INTO radcheck (username, attribute, op, value) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $attribute, $op, $value);
        $attribute = "Auth-Type";
        $op = ":=";
        $value = "Accept";
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO radusergroup (username, groupname, priority) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $plan_name, $priority);
        $priority = "0";
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO userinfo (username, firstname, lastname, email, department, company, workphone, homephone, mobilephone, address, city, state, country, zip, notes, changeuserinfo, portalloginpassword, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssss", $username, $mac_address, $lastname, $email, $department, $company, $workphone, $homephone, $mobilephone, $address, $city, $state, $country, $zip, $notes, $changeuserinfo, $portalloginpassword, $now, $creationby);
        $firstname = '';
        $lastname = '';
        $email = '';
        $department = '';
        $company = '';
        $workphone = '';
        $homephone = '';
        $mobilephone = '';
        $address = '';
        $city = '';
        $state = '';
        $country = '';
        $zip = '';
        $notes = '';
        $changeuserinfo = '0';
        $portalloginpassword = '';
        $now = date('Y-m-d H:i:s');
        $creationby = 'administrator';
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO userbillinfo (username, planName, contactperson, company, email, phone, address, city, state, country, zip, paymentmethod, cash, creditcardname, creditcardnumber, creditcardverification, creditcardtype, creditcardexp, notes, changeuserbillinfo, lead, coupon, ordertaker, billstatus, nextinvoicedue, billdue, postalinvoice, faxinvoice, emailinvoice, creationdate, creationby) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssssssssssssssss", $username, $plan_name, $mac_address, $company, $email, $phone, $address, $city, $state, $country, $zip, $paymentmethod, $cash, $creditcardname, $creditcardnumber, $creditcardverification, $creditcardtype, $creditcardexp, $notes, $changeuserbillinfo, $lead, $coupon, $ordertaker, $billstatus, $nextinvoicedue, $billdue, $postalinvoice, $faxinvoice, $emailinvoice, $now, $creationby);
        $contactperson = '';
        $company = '';
        $email = '';
        $phone = '';
        $address = '';
        $city = '';
        $state = '';
        $country = '';
        $zip = '';
        $paymentmethod = '';
        $cash = '';
        $creditcardname = '';
        $creditcardnumber = '';
        $creditcardverification = '';
        $creditcardtype = '';
        $creditcardexp = '';
        $notes = '';
        $changeuserbillinfo = '0';
        $lead = '';
        $coupon = '';
        $ordertaker = '';
        $billstatus = '';
        $nextinvoicedue = '0';
        $billdue = '0';
        $postalinvoice = '';
        $faxinvoice = '';
        $emailinvoice = '';
        $creationby = 'administrator';
        $stmt->execute();
        $stmt->close();

        $conn->close();
    } catch (mysqli_sql_exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

$randomUsername = generateRandomString();
$mac_address = $_GET['mac'];

insertRadcheck($randomUsername, $mac_address);

header("Location: http://10.10.10.1:3990/login?username={$randomUsername}&password=Accept");
exit();
?>
