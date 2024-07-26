<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json');

include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");

$db = new Database;

$adminPassword = $_POST["password"];
if ($adminPassword != ADMIN_PASSWORD) {
    echo json_encode(array("error" => "wrong password"));
    exit();
}

$commentId = $db->escapeStrings($_POST['comment_id']);
$duration = $_POST['duration'];
$endDate = $db->escapeStrings(time() + $duration);
<<<<<<< HEAD
$comment = $db->select("SELECT * FROM gargameleaks_comments_comments WHERE ID = '$commentId'");

$authorIp = $db->escapeStrings($comment[0]["IP"]);
$db->query("DELETE FROM gargameleaks_comments_comments WHERE ID = '$commentId'");

$db->query("INSERT INTO gargameleaks_comments_bann (IP, end_time) VALUES ('$authorIp', '$endDate')");
=======
$comment = $db->select("SELECT * FROM gargameleaks_comments WHERE ID = '$commentId'");

$authorIp = $db->escapeStrings($comment[0]["IP"]);
$db->query("DELETE FROM gargameleaks_comments WHERE ID = '$commentId'");

$db->query("INSERT INTO gargameleaks_bann (IP, end_time) VALUES ('$authorIp', '$endDate')");
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f
