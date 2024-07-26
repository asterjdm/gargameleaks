<?php
header('Content-type: application/json');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once(dirname(__FILE__) . "/database.php");
$db = new Database;

$searchQuery = isset($_GET["searchQuery"]) ? $db->escapeStrings($_GET["searchQuery"]) : '';
$sort = isset($_GET["sort"]) ? $db->escapeStrings($_GET["sort"]) : 'best_score';

function compareSmurfs($a, $b, $sort)
{
    if ($sort == "best_score") {
        return ($b["intelligence"] + $b["utility"] + $b["beauty"]) - ($a["intelligence"] + $a["utility"] + $a["beauty"]);
    } elseif ($sort == "most_votes") {
        return $b["votes_count"] - $a["votes_count"];
    } elseif ($sort == "least_votes") {
        return $a["votes_count"] - $b["votes_count"];
    } elseif ($sort == "worst_score") {
        return ($a["intelligence"] + $a["utility"] + $a["beauty"]) - ($b["intelligence"] + $b["utility"] + $b["beauty"]);
    }
}

$query = "SELECT * FROM gargameleaks_smurfs";
if ($searchQuery) {
    $query .= " WHERE name LIKE '%$searchQuery%'";
}
$query .= " ORDER BY name";

$smurfs = $db->select($query);

foreach ($smurfs as &$smurf) {
    $comments = $db->select("SELECT * FROM gargameleaks_comments WHERE smurf_ID = '{$smurf["ID"]}'");
    $votesData = $db->select("SELECT * FROM gargameleaks_votes WHERE smurf_ID = '{$smurf["ID"]}'");
    $votesCount = count($votesData);

    $intelligenceTotal = 0;
    $utilityTotal = 0;
    $beautyTotal = 0;

    foreach ($votesData as $vote) {
        $intelligenceTotal += $vote["intelligence"];
        $utilityTotal += $vote["utility"];
        $beautyTotal += $vote["beauty"];
    }

    $smurf["comments_count"] = count($comments);
    $smurf["votes_count"] = $votesCount;
    $smurf["intelligence"] = ($votesCount > 0) ? $intelligenceTotal / $votesCount : 0;
    $smurf["utility"] = ($votesCount > 0) ? $utilityTotal / $votesCount : 0;
    $smurf["beauty"] = ($votesCount > 0) ? $beautyTotal / $votesCount : 0;
}

if (!empty($smurfs)) {
    usort($smurfs, function ($a, $b) use ($sort) {
        return compareSmurfs($a, $b, $sort);
    });
}

echo json_encode($smurfs);
?>
