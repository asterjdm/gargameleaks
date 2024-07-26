<?php
header('Content-type: application/json');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


include_once(dirname(__FILE__) . "/database.php");
$db = new Database;

$searchQuery = $db->escapeStrings($_GET["searchQuery"]);
$sort = $db->escapeStrings($_GET["sort"]);

function compareSmurfs($a, $b, $sort)
{
    if ($sort == "best_score") {
        return $b["intelligence"] + $b["utility"] + $b["beauty"] - $a["intelligence"] - $a["utility"]  - $a["beauty"];
    } elseif ($sort == "most_votes") {
        return $b["votes_count"] - $a["votes_count"];
    } elseif ($sort  == "least_votes") {
        return $a["votes_count"] - $b["votes_count"];
    } elseif ($sort == "worst_score") {
        return $a["intelligence"] + $a["utility"]  + $a["beauty"] - $b["intelligence"] - $b["utility"]  - $b["beauty"];
    }
}


if (isset($searchQuery)) {
    $smurfs = $db->select("SELECT * FROM gargameleaks_smurfs WHERE name LIKE '%$searchQuery%' ORDER BY name");
} else {
    $smurfs = $db->select("SELECT * FROM gargameleaks_smurfs ORDER BY name");
}

foreach ($smurfs as &$smurfs) {
    $comments = $db->select("SELECT * FROM gargameleaks_comments WHERE smurf_ID = '{$smurfs["ID"]}'");
    $votesData = $db->select("SELECT * FROM gargameleaks_votes WHERE smurf_ID = '{$smurfs["ID"]}'");
    $votesCount = count($votesData);

    $intelligenceTotal = 0;
    $utilityTotal = 0;
    $beautyTotal = 0;

    $votesCount = 0;
    foreach ($votesData as $vote) {
        $votesCount++;
        $intelligenceTotal += $vote["intelligence"];
        $utilityTotal += $vote["utility"];
        $beautyTotal += $vote["beauty"];
    }

    $smurfs["comments_count"] = count($comments);
    $smurfs["votes_count"] = $votesCount;
    $smurfs["intelligence"] = ($votesCount > 0) ? $intelligenceTotal / $votesCount : 0;
    $smurfs["utility"] = ($votesCount > 0) ? $utilityTotal / $votesCount : 0;
    $smurfs["beauty"] = ($votesCount > 0) ? $beautyTotal / $votesCount : 0;
}

usort($Smurfs, function ($a, $b) use ($sort) {
    return compareSmurfs($a, $b, $sort);
});

echo json_encode($Smurfs);
