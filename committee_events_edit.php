<?php
include("db.php");
session_start();
$sessionid = $_SESSION["c_uname"];
$idsql = "SELECT * from committee where c_uname = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$eid = $_GET["id"];
$activePage = 'eventcategory';
$sql = "SELECT * from schedule_list where id = '$eid'";
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
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
<?php include("committee_sidenav.php"); ?>
  </div>

<div class="row border content justify-content-center" >
<div class="col-12 title-dashboard text-center mt-3">  <h2>Edit Event</h2></div>
    <div class="col-9 text-center">
<?php if(mysqli_num_rows($selectsql)>0)
{


while($rows = mysqli_fetch_assoc($selectsql))
{
 ?>
     <form action="committee_events_edit.php" method="post">
<div class="col text-start mt-5">
<label for="etitle" class="fw-bold">Event Title</label>
            <input type="text" class="form-control " name="etitle" value="<?php echo $rows["title"]; ?>">
</div>
<div class="col text-start mt-2">
<label for="edesc" class="fw-bold">Event Description</label>
            <input type="text" class="form-control " name="edesc" value="<?php echo $rows["description"]; ?>">
</div>
<div class="col text-start mt-2">
<label for="sdate" class="fw-bold">Start Date</label>
            <input type="datetime-local" class="form-control " name="sdate" value="<?php echo $rows["start_datetime"]; ?>" min="<?php echo date('Y-m-d\TH:i'); ?>">
</div>
<div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate" value="<?php echo $rows["end_datetime"]; ?>" min="<?php echo date('Y-m-d\TH:i'); ?>">
</div>
</div>
<div class="col-4 mt-5 text-end">
<input type="submit" class="btn btn-primary" name="edit" value="Save Changes">
</div>
<div class="col-4 mt-5 text-start">
    <a href="committee_events.php" class="btn btn-danger">Cancel</a>
</div>
<input type="hidden" value="<?php echo $rows["id"]; ?>" name="eid">
        </form>
        <?php
}
}

?>




</div>


</div>

</div>

</body>
</html>
    <?php
}



?>


<?php
if(isset($_POST["edit"]))
{
    
    $title = $_POST["etitle"];
$desc = $_POST["edesc"];
$sdate = $_POST["sdate"];
$edate = $_POST["edate"];
$eid = $_POST["eid"];
$event = "UPDATE schedule_list SET title='$title', description='$desc',start_datetime = '$sdate', end_datetime = '$edate' where id = '$eid' ";
$sql = mysqli_query($conn ,$event);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Updated',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='committee_events.php'});
 
   </script>";
}
}

?>