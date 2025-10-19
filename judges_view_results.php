<?php
include("db.php");
session_start();
$sessionid = $_SESSION["j_username"];
$eventid = $_SESSION["id"];
$idsql = "SELECT * from judges INNER JOIN schedule_list ON judges.id = schedule_list.id where j_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);

include("functions.php");


    $id = $_GET["id"];
    $sql = "SELECT * from  candidates INNER JOIN overall_score ON candidates.candidate_ID = overall_score.candidate_ID INNER JOIN schedule_list ON candidates.id = schedule_list.id where schedule_list.id = '$id' ORDER BY overall_score DESC";
$csql = mysqli_query($conn, $sql);



$activePage = 'history';




?>
<?php
if(!isset($sessionid))
{
    echo '<script>alert("Please Log In first!!")</script>';
    ?><script>window.parent.location="index.php"</script><?php
}
else
{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://kit.fontawesome.com/bb4ba0889c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css" >
    <title>Document</title>
</head>
<body>
<div class="container-fluid shadow sticky-top" id="navbar">
        <div class="row d-flex  text-center ">
        <div class="col-12 ps-2 d-flex ">
                <img  src="image_resource/Pangasinan_State_University_logo-removebg-preview_1.png" alt="" width="70px">
                <h3 id="title" class="pt-3 ps-1">Pangasinan State University Event Tabulation System</h3>
            </div>

        </div>
    </div>

<div class="container-fluid">

  <div class="row">
<?php include("judges_history_sidenav.php"); ?>
  </div>

<div class="row border content" >
<div class=" ps-5 col-6 text-start p-3 ">
<a href="judges_history.php?id=<?php  echo $id;     ?>" class="btn btn-primary back">Back</a>
</div>
    <div class="col-6 text-end p-3 ">
    <form action="admin_view_results_report.php?id=<?php echo $id ?>" method="post" target="_blank">

    <input type="hidden" value="<?php echo $id ?>" name="eid">
    <input type="submit" name="generateReport" value="Generate Report" class="btn btn-primary back">
</form>
</div>



<div class="col-12 title-dashboard text-center mt-3">  <h2>Overall Score</h2></div>


<div class="col mt-3">
<table id="example" class="table table-striped" style="width:90%;margin:auto">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Candidate No.</th>
                <th>Candidate Name</th>
                <th>Overall Score</th>

            </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        if (mysqli_num_rows($csql) > 0) {
            while ($row = mysqli_fetch_assoc($csql)) {
                $i++;
        ?>
        <tr>
        <td><?php echo $i;?></td>
            <td><?php echo $row['candidate_no'] ?></td>
            <td><?php echo $row['candidate_name'] ?></td>
            <td><?php echo $row['overall_score'] ?>%</td>

            <!-- <input type="hidden" value="<?php echo $row['category_ID'] ?>" name="cid" id="cid">
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid" id="eid"> -->
          
         

        </tr>
        <?php
            }
        } 
    
        ?>
    </tbody>
    </table>
</div>






</div>


</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
    <?php
}



?>
<?php

?>










