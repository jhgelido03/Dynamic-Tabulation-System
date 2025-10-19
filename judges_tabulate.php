<?php
include("db.php");
session_start();
$sessionid = $_SESSION["j_username"];
$idsql = "SELECT * from judges where j_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$judgeid= $r["j_ID"];

include("functions.php");
$activePage = 'events';
// $sql = "SELECT * from schedule_list INNER JOIN judges ON schedule_list.id = judges.id where schedule_list.status='0' AND judges.j_ID = '$judgeid' ";
// $selectsql = mysqli_query($conn, $sql);

if(isset($_GET["id"]))
{
    $id = $_GET["id"];
    $sql = "SELECT DISTINCT candidates.id, candidates.candidate_name,candidates.candidate_ID,judges.j_ID from candidates  INNER JOIN schedule_list ON candidates.id = schedule_list.id INNER JOIN event_category ON candidates.id = event_category.id INNER JOIN judges ON candidates.id = judges.id where schedule_list.status='0' AND schedule_list.id = '$id'";
    $selectsql = mysqli_query($conn, $sql);
    $tql = "SELECT * from  schedule_list INNER JOIN candidates ON schedule_list.id = candidates.id  where schedule_list.status='0' AND candidates.id = '$id'";
    $tsql = mysqli_query($conn, $tql);
}
else
{
    $id="";
    $sql = "SELECT * from  judges ";
    $selectsql = mysqli_query($conn, $sql);
}
$title ="";
$desc = "";
$sdate = "";
$edate = "";


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


<div class="row border " >
    <div class="col text-end p-3 ">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_events.php" method="post">
<div class="col text-start">
<label for="etitle" class="fw-bold">Event Title</label>
            <input type="text" class="form-control " name="etitle">
</div>
<div class="col text-start mt-2">
<label for="edesc" class="fw-bold">Event Description</label>
            <input type="text" class="form-control " name="edesc">
</div>
<div class="col text-start mt-2">
<label for="sdate" class="fw-bold">Start Date</label>
            <input type="datetime-local" class="form-control " name="sdate" id="date"  min="<?php echo date('Y-m-d\TH:i'); ?>">
</div>
<div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate" id="date"  min="<?php echo date('Y-m-d\TH:i'); ?>">
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Save">
        </form>
      </div>
    </div>
  </div>
</div>
    </div>
<div class="col-12 title-dashboard text-center mt-3">  <h2> <?php
        if (mysqli_num_rows($tsql) > 0) {
        $rows = mysqli_fetch_assoc($tsql) ;
        echo $rows["title"];
 
            }?></h2></div>

<div class="col mt-3">



<table id="example" class="table table-striped" style="width:90%;margin:auto;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Candidate</th>
                <?php
   $categoryQuery = "SELECT DISTINCT category_title FROM event_category where id= '$id'";
   $categoryResult = mysqli_query($conn, $categoryQuery);

                
   while ($category = mysqli_fetch_assoc($categoryResult)) {
    $categoryTitle = $category['category_title'];
    echo "<th> $categoryTitle</th>";
}?>
                <th>Actions</th>


            </tr>
        </thead>
        <tbody>
        <?php
                    // $ccount= "SELECT COUNT(candidate_ID) AS candidatecount FROM candidates WHERE id = $id;";
                    // $candidatesql = mysqli_query($conn,$ccount);
                    // $canrow = mysqli_fetch_assoc($candidatesql);     
                    // $candidatecount = $canrow["candidatecount"];
                    
                    // $catcount= "SELECT COUNT(category_ID) AS categorycount FROM event_category WHERE id = $id;";
                    // $categorysql = mysqli_query($conn,$catcount);




        if (mysqli_num_rows($selectsql) > 0) {
            while ($row = mysqli_fetch_assoc($selectsql)) {


        ?>
        <tr>
        <form action="insert_tabulate.php" method="post">
    <td><?php echo $row['candidate_ID'] ?></td>
    <td><?php echo $row['candidate_name'] ?></td>

    <?php
    $categoryQuery = "SELECT DISTINCT category_ID FROM event_category where id= '$id'";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    while ($category = mysqli_fetch_assoc($categoryResult)) {
        $categoryID = $category['category_ID'];
        echo "<td><input type='number' min=75 max=100 class='form-control' name='scores[{$row['candidate_ID']}][$categoryID]'></td>";
    }
    ?>

    <input type="hidden" value="<?php echo $row['id'] ?>" name="eid">
    <input type="hidden" value="<?php echo $row['candidate_ID'] ?>" name="cid">
    <input type="hidden" value="<?php echo $row['j_ID'] ?>" name="judgeid">
    <td><input type="submit" name="rate" id="rate" value="Rate" class="btn btn-primary"></td>
</form>

            <!-- <td></td> -->
            <!-- <td><a href="adminsidenavfixed-venue-confirmed-view.php?vr_ID=<?php echo $row['vr_ID'] ?>" class="btn btn-primary">View</a></td> -->
            <!-- <td>
                <form action="adminsidenavfixed-table-confirmed.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['vr_ID'] ?>">
                    <input type="submit" class="btn btn-danger" name="reject" value="Reject">
                    <input type="submit" name="confirm" class="btn btn-success" value="Confirm">
                </form>
            </td> -->
        </tr>
        <?php
            }
        } 
        ?>
    </tbody>
        <!-- <tfoot>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </tfoot> -->
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


// $candidateID = $row["candidate_ID"];
                //     $selecttotal = "SELECT * from judge_scores where id = '$id' AND category_ID = '$categoryid' AND candidate_ID ='$candidateID'";
                //     $selecttotalsql = mysqli_query($conn,$selecttotal);
                //     if(mysqli_num_rows($selecttotalsql)>0)
                //     {
                //         $total = "SELECT AVG(judge_score) AS ave_score FROM judge_scores where candidate_ID = '$candidateID' AND category_ID = '$categoryid' AND id = '$id'";
                //         $totalsql = mysqli_query($conn, $total);
                //         $totalfetch = mysqli_fetch_assoc($totalsql);
                //         $critave = $totalfetch["ave_score"];
                //         ?>
                //                         <td><?php echo $critave?></td>
                //         <?php
                //     }
                //     else
                //     {
                //         ?>
                //         <td> </td>
                //         <?php
                //     }
                    