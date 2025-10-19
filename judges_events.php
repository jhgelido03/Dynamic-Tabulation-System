<?php
include("db.php");
session_start();
$sessionid = $_SESSION["j_username"];
$eventid = $_SESSION["id"];
$idsql = "SELECT * from judges INNER JOIN schedule_list ON judges.id = schedule_list.id where j_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$judgeid= $r["j_ID"];
$eventid= $r["id"];

$catsql = "SELECT * from event_category where id = '$eventid' ";
$result = mysqli_query($conn, $catsql);
$res = mysqli_fetch_assoc($result);
$categoryid= $res["category_ID"];

$crisql = "SELECT * from criteria where category_ID = '$categoryid' ";
$resultcri = mysqli_query($conn, $crisql);
$rescri = mysqli_fetch_assoc($resultcri);
$criteriaid= $rescri["criteria_ID"];

include("functions.php");
$activePage = 'events';
// $sql = "SELECT DISTINCT schedule_list.*, judges.*, event_category.id,event_category.category_ID FROM schedule_list INNER JOIN judges ON schedule_list.id = judges.id INNER JOIN event_category ON schedule_list.id = event_category.id where schedule_list.status='0' AND judges.j_ID = '$judgeid'  ";
// $selectsql = mysqli_query($conn, $sql);
$sql = "SELECT * from schedule_list INNER JOIN judges ON schedule_list.id = judges.id where (schedule_list.status='0' OR schedule_list.status='1') AND judges.j_ID = '$judgeid' ";
$selectsql = mysqli_query($conn, $sql);

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
<div class="row">
<?php include("judges_history_sidenav.php"); ?>
  </div>

<div class="row border content" >
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
<div class="col-12 title-dashboard text-center mt-3">  <h2>Events</h2></div>

<div class="col mt-3">



<table id="example" class="table table-striped" style="width:90%;margin:auto;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>


            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($selectsql) > 0) {
            while ($row = mysqli_fetch_assoc($selectsql)) {
        ?>
        <tr>
        <form action="admin_events.php" method="post">
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['description'] ?></td>
            <td><?php echo $row['start_datetime'] ?></td>
            <td><?php echo $row['end_datetime'] ?></td>
            <td><?php if($row["status"]== 0) { echo "Setting Up";} else if($row["status"]==1) {echo "On Going";} else if($row["status"]==2) {echo "Completed";} ?></td>
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid">
            <td><a href="judges_tabulate_new.php?id=<?php echo $row['id']; ?>&category_ID=<?php echo $res["category_ID"];?>" class="btn btn-primary">Rate</a>   
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

<?php

if(isset($_POST["submit"]))
{
    $status = 0;
    $title = $_POST["etitle"];
$desc = $_POST["edesc"];
$sdate = $_POST["sdate"];
$edate = $_POST["edate"];


$sql = "SELECT * from schedule_list where title = '$title'";
$selectsql = mysqli_query($conn, $sql);

if(mysqli_num_rows($selectsql)>0)
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Event Already Exists',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
     
       </script>";
}
else if(empty($title) || empty($desc) || empty($sdate)|| empty($edate))
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Please fill up all the fields',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
     
       </script>";
}
else
{
    $event = "INSERT into schedule_list(title,description,start_datetime,end_datetime) VALUES ('$title','$desc','$sdate','$edate')";
$sql = mysqli_query($conn ,$event);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Added',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
 
   </script>";
}
}

}
if(isset($_POST["delete"]))
{
    $eid =$_POST["eid"];
    $event = "DELETE from schedule_list where id='$eid'";
    $sql = mysqli_query($conn ,$event);
    
    if($sql)
    {
        echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
        title: 'Succesfully Deleted',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
     
       </script>";
    }
}

if(isset($_POST["status"]))
{
    $status = 1;
    $eid =$_POST["eid"];
    $event = "UPDATE schedule_list SET status='$status' where id = '$eid' ";
    $sql = mysqli_query($conn ,$event);
    
    if($sql)
    {
        echo "<script>Swal.fire({
            position: 'center',
            iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
            title: 'Succesfully Updated',
            showConfirmButton: true,
           })
           document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
         
           </script>";
    }
}



?>