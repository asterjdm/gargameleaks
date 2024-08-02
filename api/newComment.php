<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

header('Content-type: application/json');

include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");

$db = new Database;

$content =  $db->escapeStrings(htmlspecialchars($_POST['content']));
$smurfsId = $db->escapeStrings($_POST['smurfsId']);

$clientIp = getClientIp();
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp /*. HASH_SECRET*/));

$bannRecords = $db->select("SELECT * FROM gargameleaks_bann WHERE IP = '$hashedIp'");

if (count($bannRecords) > 0) {
    echo json_encode(array("error" => "banned"));
    exit();
}

$db->query("INSERT INTO gargameleaks_comments (smurf_ID, IP, content) VALUES 
            ('$smurfsId', '$hashedIp', '$content')");
echo json_encode(array());

exit();
