<?php
include("db.php");
session_start();
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);

include("functions.php");
$activePage = 'judges';
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
<div class="col-12 title-dashboard text-center mt-3">  <h2>Events</h2></div>

<div class="col mt-3">



<table id="example" class="table table-striped" style="width:90%;margin:auto;">
        <thead>
            <tr>
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
        <form action="admin_judges.php" method="post">
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['description'] ?></td>
            <td><?php echo $row['start_datetime'] ?></td>
            <td><?php echo $row['end_datetime'] ?></td>
            <td><?php if($row["status"]== 0) { echo "Setting Up";} else if($row["status"]==1) {echo "On Going";} else if($row["status"]==2) {echo "Completed";} ?></td>
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid">
            <td><a href="admin_judges_view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></a></td>
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