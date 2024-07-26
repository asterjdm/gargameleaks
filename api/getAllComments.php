<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json');
include_once(dirname(__FILE__) . "/database.php");

$db = new Database;


<<<<<<< HEAD
$comments = $db->select("SELECT * FROM gargameleaks_comments_comments");
=======
$comments = $db->select("SELECT * FROM gargameleaks_comments");
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f

echo json_encode($comments);
