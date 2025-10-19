<?php
session_start();
include("db.php");
require('fpdf186/fpdf.php');
$sessionid = $_SESSION["j_username"];
$idsql = "SELECT * from judges INNER JOIN schedule_list ON judges.id = schedule_list.id where j_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$judgeid= $r["j_ID"];


$category_ID= $_GET['category_ID'];
$id = $_GET['id'];
$status = 3;

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',25);
$pdf->Cell(190,5,'Pangasinan State University',0,1,'C');
// $pdf->SetFont('Arial','',10);
// $pdf->Cell(190,5,'Address: Brgy. Palaris, San Carlos City Pangasinan',0,1,'C');
// $pdf->Cell(190,5,'Contact No: 0916 256 3687',0,1,'C');

$pdf->Cell(190,5,'',0,1,'C');
$pdf->SetFont('Arial','B',18);
$e = "SELECT * from schedule_list INNER JOIN event_category ON schedule_list.id = event_category.id where schedule_list.id = '$id' AND category_ID = '$category_ID' ";
$esql = mysqli_query($conn,$e);
$efetch = mysqli_fetch_assoc($esql);

$pdf->Cell(190,5,$efetch["title"],0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,5,"Best in ".$efetch["category_title"],0,1,'C');
$pdf->SetLeftMargin(7);
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'Rank',1,0,'C');
$pdf->Cell(50,10,'Name',1,0,'C');
$event = "SELECT * from criteria where id = '$id' AND category_ID = $category_ID ";
$eventsql = mysqli_query($conn,$event);
while($eventrow = mysqli_fetch_assoc($eventsql))
{
    $pdf->Cell(30,10,$eventrow["criteria_name"],1,0,'C');
}
$pdf->Cell(30,10,'Average',1,0,'C');
$pdf->Cell(30,10,"",0,1,'C');

$pdf->SetFont('Arial','',10);







$i=0;
// Prepare the SQL statement using prepared statements
// Assuming $category_ID, $id, and $judgeid are already defined

$rankQuery = "SELECT DISTINCT candidates.candidate_name, candidates.candidate_ID
              FROM candidates
              INNER JOIN schedule_list ON candidates.id = schedule_list.id
              WHERE schedule_list.id = '$id'
              ORDER BY (
                  SELECT critave_scores.critave_score
                  FROM critave_scores
                  WHERE critave_scores.id = '$id' AND critave_scores.category_ID = '$category_ID' AND critave_scores.j_ID = '$judgeid' AND critave_scores.candidate_ID = candidates.candidate_ID
                  LIMIT 1
              ) DESC";

$rankResult = mysqli_query($conn, $rankQuery);

$critcountQuery = "SELECT COUNT(criteria_ID) AS critcount
                   FROM criteria
                   WHERE category_ID = '$category_ID'";

$critcountResult = mysqli_query($conn, $critcountQuery);

if ($critcountResult) {
    $critcountRow = mysqli_fetch_assoc($critcountResult);
    $critcount = $critcountRow['critcount'];

    // Now $critcount contains the count of criteria for the specified category
} else {
    // Handle the query error if needed
    echo "Error: " . mysqli_error($conn);
}

if (mysqli_num_rows($rankResult) > 0) {
    while ($row = mysqli_fetch_assoc($rankResult)) {
        $i++;
        $pdf->Cell(10, 10, $i, 1, 0,'C');
        $pdf->Cell(50, 10, $row['candidate_name'], 1, 0,'C');

        // Retrieve scores for the current candidate
        $scoresQuery = "SELECT judge_scores.judge_score
                        FROM judge_scores
                        WHERE judge_scores.id = '$id' AND judge_scores.category_ID = '$category_ID' AND judge_scores.j_ID = '$judgeid' AND judge_scores.candidate_ID = '{$row['candidate_ID']}'";

        $scoresSql = mysqli_query($conn, $scoresQuery);

        if (mysqli_num_rows($scoresSql) > 0) {
            // Display the scores for the current candidate
            while ($scoreRow = mysqli_fetch_assoc($scoresSql)) {
                $pdf->Cell(30, 10, $scoreRow['judge_score'], 1, 0,'C');
            }
        } else {
            // No scores for the current candidate
            for ($j = 0; $j < $critcount; $j++) {
                $pdf->Cell(30, 10, "No score yet", 1, 0, 'C');
            }
        }

        // Retrieve critave_score for the current candidate
        $critaveQuery = "SELECT critave_scores.critave_score
                         FROM critave_scores
                         WHERE critave_scores.id = '$id' AND critave_scores.category_ID = '$category_ID' AND critave_scores.j_ID = '$judgeid' AND critave_scores.candidate_ID = '{$row['candidate_ID']}'";

        $critaveSql = mysqli_query($conn, $critaveQuery);

        if (mysqli_num_rows($critaveSql) > 0) {
            // Fetch the single critave_score for the current candidate
            $critaveRow = mysqli_fetch_assoc($critaveSql);
            $pdf->Cell(30, 10, $critaveRow['critave_score'], 1, 0,'C');
        } else {
            // No critave_score for the current candidate
            $pdf->Cell(30, 10, "No Score Yet", 1, 0,'C');
        }

        $pdf->Ln(); // Move to the next line for the next candidate
    }
}







else
{
    $pdf->SetFont('Arial','',20);
$pdf->Cell(194,100,'No Data Available',1,1,'C');
}
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,'_______________________',0,1,'R');
$pdf->SetFont('Arial','I',12);
$pdf->Cell(190,5,'Manager/Owner         ',0,1,'R');

$pdf->Output();
?>
