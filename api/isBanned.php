<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json');
include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");


$db =  new Database;
$clientIp = getClientIp();
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp /*. HASH_SECRET*/));

$bannRecords = $db->select("SELECT * FROM gargameleaks_bann WHERE IP = '$hashedIp'");

if (count($bannRecords) >= 1) {
    // echo time();
    // echo $bannRecords[0]["end_time"];
    if ($bannRecords[0]["end_time"] <= time()) {
        $db->query("DELETE FROM gargameleaks_bann WHERE IP = '$hashedIp'");
        echo json_encode(array(
            "banned" => false,
            "ip" => $hashedIp,
        ));
        exit();
    }
    echo json_encode(array(
        "banned" => true,
        "end_date" => (int)$bannRecords[0]["end_time"],
        "ip" => $bannRecords[0]["IP"],
    ));
} else {
    echo json_encode(array(
        "banned" => false,
        "ip" => $hashedIp,
    ));
}
