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
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp . HASH_SECRET));

<<<<<<< HEAD
$bannRecords = $db->select("SELECT * FROM gargameleaks_comments_bann WHERE IP = '$hashedIp'");
=======
$bannRecords = $db->select("SELECT * FROM gargameleaks_bann WHERE IP = '$hashedIp'");
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f

if (count($bannRecords) >= 1) {
    // echo time();
    // echo $bannRecords[0]["end_time"];
    if ($bannRecords[0]["end_time"] <= time()) {
<<<<<<< HEAD
        $db->query("DELETE FROM gargameleaks_comments_bann WHERE IP = '$hashedIp'");
=======
        $db->query("DELETE FROM gargameleaks_bann WHERE IP = '$hashedIp'");
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f
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
