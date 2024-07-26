<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json');
include_once(dirname(__FILE__) . "/database.php");

$db = new Database;


$comments = $db->select("SELECT * FROM gargameleaks_comments_comments");

echo json_encode($comments);
