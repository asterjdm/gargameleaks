<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-type: application/json');

include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");

$db = new Database;
$teachingQualityRating = $db->escapeStrings($_POST["teachingQuality"]);
$kindnessRating =  $db->escapeStrings($_POST["kindness"]);
$humorRating = $db->escapeStrings($_POST["humor"]);

$smurfsId = $db->escapeStrings($_POST["smurfsId"]);

$clientIp = getClientIp();
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp . HASH_SECRET));

if (
    $teachingQualityRating > 10 || $teachingQualityRating <= 0 ||
    $kindnessRating > 10 || $kindnessRating <= 0 ||
    $humorRating > 10 || $humorRating <= 0
) {
    echo "invalid values";
    exit();
}

$sameUserVotes = $db->select("SELECT * FROM gargameleaks_votes WHERE smurfs_ID = '$smurfsId' AND IP = '$hashedIp'");
if (count($sameUserVotes) >= 1) {
    $db->query("UPDATE gargameleaks_votes 
                SET teaching_quality = '$teachingQualityRating', 
                    kindness = '$kindnessRating', 
                    humor = '$humorRating' 
                WHERE smurfs_ID = '$smurfsId' AND IP = '$hashedIp'
    ");

    echo json_encode(array("info" => "vote updated"));
    exit();
}

$db->query("INSERT INTO gargameleaks_votes (smurfs_ID, IP, teaching_quality, kindness, humor) VALUES 
            ('$smurfsId', '$hashedIp', '$teachingQualityRating', '$kindnessRating', '$humorRating')");

echo json_encode(array());
exit(); // we never know
