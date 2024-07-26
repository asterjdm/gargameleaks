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
    $Smurfs = $db->select("SELECT * FROM cescoleaks_teachers WHERE name LIKE '%$searchQuery%' ORDER BY name");
} else {
    $Smurfs = $db->select("SELECT * FROM cescoleaks_teachers ORDER BY name");
}

foreach ($Smurfs as &$teacher) {
    $comments = $db->select("SELECT * FROM cescoleaks_comments WHERE teacher_ID = '{$teacher["ID"]}'");
    $votesData = $db->select("SELECT * FROM cescoleaks_votes WHERE teacher_ID = '{$teacher["ID"]}'");
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

    $teacher["comments_count"] = count($comments);
    $teacher["votes_count"] = $votesCount;
    $teacher["teaching_quality"] = ($votesCount > 0) ? $teachingQualityTotal / $votesCount : 0;
    $teacher["kindness"] = ($votesCount > 0) ? $kindnessTotal / $votesCount : 0;
    $teacher["humor"] = ($votesCount > 0) ? $humorTotal / $votesCount : 0;
}

usort($Smurfs, function ($a, $b) use ($sort) {
    return compareSmurfs($a, $b, $sort);
});

echo json_encode($Smurfs);
