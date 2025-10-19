<?php
include "db.php";
$candidateCount = 2;
$eventid = 36;
$query = "SELECT COUNT(j_ID)* $candidateCount AS overallCount FROM judges WHERE id = '$eventid'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $overallCount = $row['overallCount'];
    echo "Overall Number of Judge * Candidate <br>";
    echo $overallCount."<br>";
}
$query = "SELECT COUNT(totaljudge_average) AS overallrate FROM judgescores_ave WHERE id = '$eventid' AND totaljudge_average IS NOT NULL";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $overallrate = $row['overallrate'];
    echo "Overall Number of judge total existing <br>";
    echo $overallrate."<br>";
}



?>

