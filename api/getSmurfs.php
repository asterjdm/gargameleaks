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
        return $b["teaching_quality"] + $b["kindness"] + $b["humor"] - $a["teaching_quality"] - $a["kindness"]  - $a["humor"];
    } elseif ($sort == "most_votes") {
        return $b["votes_count"] - $a["votes_count"];
    } elseif ($sort  == "least_votes") {
        return $a["votes_count"] - $b["votes_count"];
    } elseif ($sort == "worst_score") {
        return $a["teaching_quality"] + $a["kindness"]  + $a["humor"] - $b["teaching_quality"] - $b["kindness"]  - $b["humor"];
    }
}


if (isset($searchQuery)) {
    $smurfs = $db->select("SELECT * FROM gargameleaks_smurfs WHERE name LIKE '%$searchQuery%' ORDER BY name");
} else {
    $smurfs = $db->select("SELECT * FROM gargameleaks_smurfs ORDER BY name");
}

foreach ($smurfs as &$smurfs) {
    $comments = $db->select("SELECT * FROM gargameleaks_comments WHERE smurfs_ID = '{$smurfs["ID"]}'");
    $votesData = $db->select("SELECT * FROM gargameleaks_votes WHERE smurfs_ID = '{$smurfs["ID"]}'");
    $votesCount = count($votesData);

    $teachingQualityTotal = 0;
    $kindnessTotal = 0;
    $humorTotal = 0;

    $votesCount = 0;
    foreach ($votesData as $vote) {
        $votesCount++;
        $teachingQualityTotal += $vote["teaching_quality"];
        $kindnessTotal += $vote["kindness"];
        $humorTotal += $vote["humor"];
    }

    $smurfs["comments_count"] = count($comments);
    $smurfs["votes_count"] = $votesCount;
    $smurfs["teaching_quality"] = ($votesCount > 0) ? $teachingQualityTotal / $votesCount : 0;
    $smurfs["kindness"] = ($votesCount > 0) ? $kindnessTotal / $votesCount : 0;
    $smurfs["humor"] = ($votesCount > 0) ? $humorTotal / $votesCount : 0;
}

usort($Smurfs, function ($a, $b) use ($sort) {
    return compareSmurfs($a, $b, $sort);
});

echo json_encode($Smurfs);
