<?php
include("db.php");
session_start();
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);

include("functions.php");
$activePage = 'events';
$sql = "SELECT * from schedule_list where status = '0' OR status ='1'";
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
<?php include("admin_sidenav.php"); ?>
  </div>

<div class="row border content" >
    <div class="col text-end p-3 ">
        <!-- Button trigger modal -->
<button type="button" class="btn mbutton" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add Event +
</button>

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
            <input type="text" class="form-control " name="etitle" required>
</div>
<div class="col text-start mt-2">
<label for="edesc" class="fw-bold">Event Description</label>
            <input type="text" class="form-control " name="edesc" required>
</div>
<div class="col text-start mt-2">
<label for="edesc" class="fw-bold">Number of Candidates</label>
            <input type="number" class="form-control " name="noc" min=1 max = 100 required>
</div>
<div class="col text-start mt-2">
<label for="etype" class="fw-bold">Event Type</label>
<select class="form-select" aria-label="Default select example" name="etype" id="etype" required> 
  <option selected>Choose one from the list</option>
  <option value="0">Individual</option>
  <option value="1">Group</option>
</select>
</div>
<div class="col text-start mt-2">
<label for="sdate" class="fw-bold">Start Date</label>
            <input type="datetime-local" class="form-control " name="sdate" id="date"  min="<?php echo date('Y-m-d\TH:i'); ?>" required>
</div>
<div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate" id="date"  min="<?php echo date('Y-m-d\TH:i'); ?>" required>
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
<small><b>Note: Add Candidates, Category and Judges to Enable On Going Button</b></small><br>
<div class="col mt-3">



<table id="example" class="table table-striped" style="width:95%;margin:auto;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Event Type</th>
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
                $eventId = $row['id'];

                // Check if there are event categories for the current event
                $eventCategoriesQuery = "SELECT * FROM event_category WHERE id = '$eventId'";
                $eventCategoriesResult = mysqli_query($conn, $eventCategoriesQuery);
                $hasEventCategories = mysqli_num_rows($eventCategoriesResult) > 0;
        
                // Check if there are criteria for the current event
                $criteriaQuery = "SELECT * FROM criteria WHERE id= '$eventId'";
                $criteriaResult = mysqli_query($conn, $criteriaQuery);
                $hasCriteria = mysqli_num_rows($criteriaResult) > 0;
        
                // Check if there are candidates for the current event
                $candidatesQuery = "SELECT * FROM candidates WHERE id= '$eventId'";
                $candidatesResult = mysqli_query($conn, $candidatesQuery);
                $hasCandidates = mysqli_num_rows($candidatesResult) > 0;

                $judgesQuery = "SELECT * FROM judges WHERE id= '$eventId'";
                $judgesResult = mysqli_query($conn, $judgesQuery);
                $hasJudges = mysqli_num_rows($judgesResult) > 0;
        
                // Determine whether the "Ongoing" button should be disabled
                $disableOngoingButton = !($hasEventCategories && $hasCriteria && $hasCandidates && $hasJudges);
        ?>
        <tr>
        <form action="admin_events.php" method="post">
            <td><?php echo $row['title'] ?></td>
            <td><?php if($row['event_type']=='0'){echo 'Individual';} else if($row['event_type']=='1'){echo 'Group';} ?></td>
            <td><?php echo $row['start_datetime'] ?></td>
            <td><?php echo $row['end_datetime'] ?></td>
            <td><?php if($row["status"]== 0) { echo "Setting Up";} else if($row["status"]==1) {echo "On Going";} else if($row["status"]==2) {echo "Completed";} ?></td>
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid">
            <td><a href="admin_events_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
            <button type="submit" name="delete" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>   
        <?php
        $id = $row['id'];
    $statusquery = "SELECT * from schedule_list where id= '$id'";
    $statussql = mysqli_query($conn,$statusquery);
    if(mysqli_num_rows($statussql))
    {
        while($rows= mysqli_fetch_assoc($statussql))
        {
            if($rows['status']==0)
            {
                ?>                 <?php if ($disableOngoingButton) { ?>
                    <!-- Disable the "Ongoing" button if conditions are not met -->
                    <button type="button" class="btn btn-warning" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                            <polyline points="23 4 23 10 17 10" />
                            <polyline points="1 20 1 14 7 14" />
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
                        </svg>
                    </button>
                <?php } else { ?>
                    <!-- Enable the "Ongoing" button if conditions are met -->
                    <button type="submit" name="ongoing" class="btn btn-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                            <polyline points="23 4 23 10 17 10" />
                            <polyline points="1 20 1 14 7 14" />
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
                        </svg>
                    </button>
                <?php } ?>
            </td>
        </tr>
    <?php
    

?> <?php
            }
            else if($rows['status']==1)
            {
                ?> <button type="submit" name="completed" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></button>  <?php
            }
        }
    }
        ?>
        </td>
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
$noc = $_POST["noc"];
$sdate = $_POST["sdate"];
$edate = $_POST["edate"];
$etype = $_POST["etype"];

$sql = "SELECT * from schedule_list where title = '$title' AND (status = 0 OR status =1)";
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
else if(empty($title) || empty($desc) || empty($sdate)|| empty($edate) || !isset($etype) || empty($noc))
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
    $event = "INSERT into schedule_list(title,description,no_of_candidates,event_type,start_datetime,end_datetime) VALUES ('$title','$desc','$noc','$etype','$sdate','$edate')";
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

if(isset($_POST["ongoing"]))
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

if(isset($_POST["completed"]))
{
    $status = 2;
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