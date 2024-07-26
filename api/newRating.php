<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-type: application/json');

include_once(dirname(__FILE__) . "/database.php");
include_once(dirname(__FILE__) . "/utils/getClientIp.php");
include_once(dirname(__FILE__) . "/secrets.php");

$db = new Database;
$intelligenceRating = $db->escapeStrings($_POST["intelligence"]);
$utilityRating =  $db->escapeStrings($_POST["utility"]);
$beautyRating = $db->escapeStrings($_POST["beauty"]);

$smurfsId = $db->escapeStrings($_POST["smurfsId"]);

$clientIp = getClientIp();
$hashedIp = $db->escapeStrings(hash("sha256", $clientIp . HASH_SECRET));

if (
    $intelligenceRating > 10 || $intelligenceRating <= 0 ||
    $utilityRating > 10 || $utilityRating <= 0 ||
    $beautyRating > 10 || $beautyRating <= 0
) {
    echo "invalid values";
    exit();
}

$sameUserVotes = $db->select("SELECT * FROM gargameleaks_votes WHERE smurf_ID = '$smurfsId' AND IP = '$hashedIp'");
if (count($sameUserVotes) >= 1) {
    $db->query("UPDATE gargameleaks_votes 
                SET intelligence = '$intelligenceRating', 
                    utility = '$utilityRating', 
                    beauty = '$beautyRating' 
                WHERE smurf_ID = '$smurfsId' AND IP = '$hashedIp'
    ");

    echo json_encode(array("info" => "vote updated"));
    exit();
}

$db->query("INSERT INTO gargameleaks_votes (smurf_ID, IP, intelligence, utility, beauty) VALUES 
            ('$smurfsId', '$hashedIp', '$intelligenceRating', '$utilityRating', '$beautyRating')");

echo json_encode(array());
exit(); // we never know
