<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-type: application/json');
include_once(dirname(__FILE__) . "/database.php");

$db = new Database;

$teacherId = $db->escapeStrings($_POST['teacherID']);

<<<<<<< HEAD
$comments = $db->select("SELECT * FROM gargameleaks_comments_comments WHERE teacher_ID = '$teacherId'");

echo json_encode($comments);
=======
$comments = $db->select("SELECT * FROM gargameleaks_comments WHERE teacher_ID = '$teacherId'");
print_r(json_encode($comments));
>>>>>>> 1a56928bc55611875d70be6a628d0a91516e988f
