<?php
// include("db.php");

// if (isset($_POST["rate"])) {
//     $judgeid = $_POST["judgeid"];
//     $eventid = $_POST["eid"];
//     $categoryid = $_POST["categoryid"];
//     $candidateid = $_POST["cid"];

//     // Validate and sanitize the input values
//     $judgeid = mysqli_real_escape_string($conn, $judgeid);
//     $eventid = mysqli_real_escape_string($conn, $eventid);
//     $categoryid = mysqli_real_escape_string($conn, $categoryid);
//     $candidateid = mysqli_real_escape_string($conn, $candidateid);

//     // Prepare the insert statement outside the loop
//     $insertSql = "INSERT INTO judge_scores (id, candidate_ID, category_ID, j_ID, criteria_ID, judge_score) VALUES (?, ?, ?, ?, ?, ?)";
//     $stmt = mysqli_prepare($conn, $insertSql);

//     // Bind parameters outside the loop
//     mysqli_stmt_bind_param($stmt, "ssssss", $eventid, $candidateid, $categoryid, $judgeid, $criteriaID, $score);

//     // Loop through the submitted scores and insert them into the database
//     foreach ($_POST['scores'][$candidateid] as $criteriaID => $score) {
//         // Validate and sanitize the score
//         $score = mysqli_real_escape_string($conn, $score);

//         // Execute the statement inside the loop
//         mysqli_stmt_execute($stmt);
//     }

//     // Close the statement after the loop
//     mysqli_stmt_close($stmt);

//     // Redirect back to the judging page with the event ID
//     header("location: judges_tabulate_new.php?category_ID=". $categoryid."&id=". $eventid);
//     exit();
// } else {
//     // Handle the case when the form is not submitted
//     echo "Form not submitted.";
// }

include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventid = $_POST["eid"];
    $judgeid = $_POST["judgeid"];
    $categoryid = $_POST["categoryid"];
    $candidateid = $_POST["cid"];
    
    // Retrieve scores from POST data
    $scores = $_POST["scores"][$candidateid];
    
    // Calculate the total score
    $totalScore = 0;
    
    $criteriaQuery = "SELECT DISTINCT criteria_ID, criteria_percentage FROM criteria WHERE category_ID = '$categoryid'";
    $criteriaResult = mysqli_query($conn, $criteriaQuery);
    
    while ($criteria = mysqli_fetch_assoc($criteriaResult)) {
        $criteriaID = $criteria["criteria_ID"];
        $criteriapercent = $criteria["criteria_percentage"];
    
        // Check if the criteriaID exists in the submitted scores
        if (isset($scores[$criteriaID])) {
            $score = $scores[$criteriaID];
            echo $score . '<br>';
            $weightedScore = $score * ($criteriapercent / 100);
            $totalScore += $weightedScore;
        }
    }
    
    echo $totalScore . '<br>';
    




    // Calculate the average score
    // $averageScore = $totalScore / $numberOfCriteria;

    // Insert total score into critave_scores table
    $insertTotalScoreQuery = "INSERT INTO critave_scores (id, j_ID, category_ID, candidate_ID, critave_score) VALUES (?, ?, ?, ?, ?)";
    $insertTotalScoreStmt = mysqli_prepare($conn, $insertTotalScoreQuery);
    mysqli_stmt_bind_param($insertTotalScoreStmt, "sssss", $eventid, $judgeid, $categoryid, $candidateid, $totalScore);
    mysqli_stmt_execute($insertTotalScoreStmt);

    // Insert individual scores into judge_scores table
    foreach ($scores as $criteriaID => $score) {
        $insertScoreQuery = "INSERT INTO judge_scores (id, j_ID, category_ID, candidate_ID, criteria_ID, judge_score) VALUES (?, ?, ?, ?, ?, ?)";
        $insertScoreStmt = mysqli_prepare($conn, $insertScoreQuery);
        mysqli_stmt_bind_param($insertScoreStmt, "ssssss", $eventid, $judgeid, $categoryid, $candidateid, $criteriaID, $score);
        mysqli_stmt_execute($insertScoreStmt);
    }

    // Close prepared statements
    mysqli_stmt_close($insertTotalScoreStmt);
    mysqli_stmt_close($insertScoreStmt);

    $query = "SELECT COUNT(candidate_ID) AS candidateCount FROM candidates WHERE id = '$eventid' ";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $candidateCount = $row['candidateCount'];
        echo $candidateCount."<br>";
    }

    $query = "SELECT COUNT(category_ID)*$candidateCount AS categoryCount FROM event_category WHERE id = '$eventid'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $categoryCount = $row['categoryCount'];
        echo $categoryCount."<br>";
    }
    
    $query = "SELECT COUNT(critave_ID) AS critaveCount FROM critave_scores WHERE id = '$eventid' AND critave_score IS NOT NULL AND j_ID = '$judgeid'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $critaveCount = $row['critaveCount'];
        echo $critaveCount."<br>";
    }
    

    if($categoryCount == $critaveCount)
    {
        $candidatesQuery = "SELECT DISTINCT candidate_ID FROM critave_scores WHERE id = ?";
        $candidatesStmt = mysqli_prepare($conn, $candidatesQuery);
        mysqli_stmt_bind_param($candidatesStmt, "s", $eventid);
        mysqli_stmt_execute($candidatesStmt);
        $candidatesResult = mysqli_stmt_get_result($candidatesStmt);
    
        while ($candidateRow = mysqli_fetch_assoc($candidatesResult)) {
            $currentCandidateID = $candidateRow['candidate_ID'];
    
            // Calculate average score for the current candidate
            $averageQuery = "SELECT AVG(critave_score) AS avg_score FROM critave_scores WHERE id = ? AND candidate_ID = ?  AND j_ID = ?";
            $averageStmt = mysqli_prepare($conn, $averageQuery);
            mysqli_stmt_bind_param($averageStmt, "sss", $eventid, $currentCandidateID,$judgeid);
            mysqli_stmt_execute($averageStmt);
            $averageResult = mysqli_stmt_get_result($averageStmt);
            $averageRow = mysqli_fetch_assoc($averageResult);
            $averageScore = $averageRow["avg_score"];
            echo $averageScore."<br>";
    
            // Insert average score into judgescores_ave table for the current candidate
            $insert_average_Query = "INSERT INTO judgescores_ave (id, j_ID, candidate_ID, totaljudge_average) VALUES (?, ?, ?, ?)";
            $insert_average_Stmt = mysqli_prepare($conn, $insert_average_Query);
            mysqli_stmt_bind_param($insert_average_Stmt, "sssd", $eventid, $judgeid, $currentCandidateID, $averageScore);
            mysqli_stmt_execute($insert_average_Stmt);
    
            // Close prepared statements
            mysqli_stmt_close($averageStmt);
            mysqli_stmt_close($insert_average_Stmt);


        }
    }

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
    
    if($overallCount == $overallrate)
    {
        $candidatesQuery = "SELECT DISTINCT candidate_ID FROM judgescores_ave WHERE id = ?";
        $candidatesStmt = mysqli_prepare($conn, $candidatesQuery);
        mysqli_stmt_bind_param($candidatesStmt, "s", $eventid);
        mysqli_stmt_execute($candidatesStmt);
        $candidatesResult = mysqli_stmt_get_result($candidatesStmt);
    
        while ($candidateRow = mysqli_fetch_assoc($candidatesResult)) {
            $currentCandidateID = $candidateRow['candidate_ID'];
    
            // Calculate average score for the current candidate
            $averageQuery = "SELECT AVG(totaljudge_average) AS avg_score FROM judgescores_ave WHERE id = ? AND candidate_ID = ?  ";
            $averageStmt = mysqli_prepare($conn, $averageQuery);
            mysqli_stmt_bind_param($averageStmt, "ss", $eventid, $currentCandidateID);
            mysqli_stmt_execute($averageStmt);
            $averageResult = mysqli_stmt_get_result($averageStmt);
            $averageRow = mysqli_fetch_assoc($averageResult);
            $overallScore = $averageRow["avg_score"];
            echo "Overall Score<br>";
            echo $overallScore."<br>";
    
            // Insert average score into judgescores_ave table for the current candidate
            $insertAverageQuery = "INSERT INTO overall_score (id, candidate_ID, overall_score) VALUES ( ?, ?, ?)";
            $insertAverageStmt = mysqli_prepare($conn, $insertAverageQuery);
            mysqli_stmt_bind_param($insertAverageStmt, "ssd", $eventid, $currentCandidateID, $overallScore);
            mysqli_stmt_execute($insertAverageStmt);
    
            // Close prepared statements
            mysqli_stmt_close($averageStmt);
            mysqli_stmt_close($insertAverageStmt);


  
        }
        $candidatesQuery = "SELECT DISTINCT candidate_ID,category_ID FROM critave_scores WHERE id = ?";
        $candidatesStmt = mysqli_prepare($conn, $candidatesQuery);
        mysqli_stmt_bind_param($candidatesStmt, "s", $eventid);
        mysqli_stmt_execute($candidatesStmt);
        $candidatesResult = mysqli_stmt_get_result($candidatesStmt);
    
        while ($candidateRow = mysqli_fetch_assoc($candidatesResult)) {
            $currentCandidateID = $candidateRow['candidate_ID'];
            $catid = $candidateRow['category_ID'];

                                  // Calculate average score for the current candidate
                                  $overallQuery = "SELECT AVG(critave_score) AS avg_score FROM critave_scores WHERE id = ? AND candidate_ID = ?  AND category_ID= ?";
                                  $overallStmt = mysqli_prepare($conn, $overallQuery);
                                  mysqli_stmt_bind_param($overallStmt, "sss", $eventid, $currentCandidateID,$catid);
                                  mysqli_stmt_execute($overallStmt);
                                  $overallResult = mysqli_stmt_get_result($overallStmt);
                                  $overallRow = mysqli_fetch_assoc($overallResult);
                                  $overallScore = $overallRow["avg_score"];
                                  echo $overallScore."<br>";
                          
                                  // Insert average score into judgescores_ave table for the current candidate
                                  $insert_average_Query = "INSERT INTO totalcategory_ave(id, category_ID, candidate_ID, category_overall) VALUES (?, ?, ?, ?)";
                                  $insert_average_Stmt = mysqli_prepare($conn, $insert_average_Query);
                                  mysqli_stmt_bind_param($insert_average_Stmt, "sssd", $eventid, $catid, $currentCandidateID, $overallScore);
                                  mysqli_stmt_execute($insert_average_Stmt);
                          
                                  // Close prepared statements
                                  mysqli_stmt_close($overallStmt);
                                  mysqli_stmt_close($insert_average_Stmt);


        }
        $status = 2;
        $eid =$_POST["eid"];
        $event = "UPDATE schedule_list SET status='$status' where id = '$eid' ";
        $sql = mysqli_query($conn ,$event);
          if($sql)
          {
              header("location:judges_history.php");
              exit();
          }
    }



    // Redirect or perform any additional actions
    header("location: judges_tabulate_new.php?category_ID=". $categoryid."&id=". $eventid);
    exit();
} else {
    // Handle invalid request method
    echo "Invalid request method";
}





?>








