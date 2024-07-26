<?php
include_once(dirname(__FILE__) . "/secrets.php");

include_once(dirname(__FILE__) . "/utils/getClientIp.php");

$userMsg = $_GET['msg'];
$clientIP = getClientIp();
$msg = "Le message: $userMsg\n Son IP (on sais jamais) $clientIP";

for ($i = 0; $i < count(EMAILS); $i++) {
    mail(EMAILS[$i], "gargameleaks: message", $msg);
}

if (isset($_GET["return"])) {
    header("location: ../{$_GET['return']}");
    exit();
}
header("location: ../about.html");
