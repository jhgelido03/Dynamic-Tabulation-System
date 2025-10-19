<?php
session_start();
include("db.php");
require('fpdf186/fpdf.php');
// $idsql = "SELECT * from judges INNER JOIN schedule_list ON judges.id = schedule_list.id where j_username = '$sessionid' ";
// $result = mysqli_query($conn, $idsql);
// $r = mysqli_fetch_assoc($result);
// $judgeid= $r["j_ID"];


$id = $_GET["id"];
$sql = "SELECT * from  candidates INNER JOIN overall_score ON candidates.candidate_ID = overall_score.candidate_ID INNER JOIN schedule_list ON candidates.id = schedule_list.id where schedule_list.id = '$id' ORDER BY overall_score DESC";
$csql = mysqli_query($conn, $sql);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',25);
$pdf->Cell(190,5,'Pangasinan State University',0,1,'C');
// $pdf->SetFont('Arial','',10);
// $pdf->Cell(190,5,'Address: Brgy. Palaris, San Carlos City Pangasinan',0,1,'C');
// $pdf->Cell(190,5,'Contact No: 0916 256 3687',0,1,'C');

$pdf->Cell(190,5,'',0,1,'C');
$pdf->SetFont('Arial','B',18);
$e = "SELECT * from schedule_list INNER JOIN event_category ON schedule_list.id = event_category.id where schedule_list.id = '$id' ";
$esql = mysqli_query($conn,$e);
$efetch = mysqli_fetch_assoc($esql);

$pdf->Cell(190,5,$efetch["title"],0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->SetFont('Arial','B',18);
$pdf->Cell(190,5,"Overall Score Ranking",0,1,'C');
$pdf->SetLeftMargin(7);
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'Rank',1,0,'C');
$pdf->Cell(25,10,'Candidate No.',1,0,'C');
$pdf->Cell(40,10,'Name',1,0,'C');
$pdf->Cell(90,10,'Department',1,0,'C');
// $event = "SELECT * from criteria where id = '$id' AND category_ID = $category_ID ";
// $eventsql = mysqli_query($conn,$event);
// while($eventrow = mysqli_fetch_assoc($eventsql))
// {
//     $pdf->Cell(30,10,$eventrow["criteria_name"],1,0,'C');
// }
$pdf->Cell(30,10,'Overall Average',1,0,'C');
$pdf->Cell(30,10,"",0,1,'C');

$pdf->SetFont('Arial','',10);

if(mysqli_num_rows($csql)>0)
{
    $i = 0;
    while($row = mysqli_fetch_assoc($csql))
    {
        $i++;
        $pdf->Cell(10,10, $i,1,0,'C');
        $pdf->Cell(25,10, $row["candidate_no"],1,0,'C');
        $pdf->Cell(40,10, $row["candidate_name"],1,0,'C');
        $pdf->Cell(90,10, $row["candidate_dept"],1,0,'C');
        $pdf->Cell(30,10, $row["overall_score"]."%",1,1,'C');
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
$pdf->Cell(190,5,'      Chief Executive Director   ',0,1,'R');

$pdf->Output();
?>
