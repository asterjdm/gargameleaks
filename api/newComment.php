<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-type: application/json');

include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");

$db = new Database;

$content =  $db->escapeStrings(htmlspecialchars($_POST['content']));
$teacherId = $db->escapeStrings($_POST['teacherId']);

$clientIp = getClientIp();
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp . HASH_SECRET));

<<<<<<< HEAD
$bannRecords = $db->select("SELECT * FROM gargameleaks_comments_bann WHERE IP = '$hashedIp'");
=======
$bannRecords = $db->select("SELECT * FROM gargameleaks_bann WHERE IP = '$hashedIp'");
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f

if (count($bannRecords) > 0) {
    echo json_encode(array("error" => "banned"));
    exit();
}

<<<<<<< HEAD
$db->query("INSERT INTO gargameleaks_comments_comments (teacher_ID, IP, content) VALUES 
=======
$db->query("INSERT INTO gargameleaks_comments (teacher_ID, IP, content) VALUES 
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f
            ('$teacherId', '$hashedIp', '$content')");
echo json_encode(array());

exit();
