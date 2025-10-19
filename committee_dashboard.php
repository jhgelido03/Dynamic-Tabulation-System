<?php
include("db.php");
$activePage = 'dashboard';
session_start();
$sessionid = $_SESSION["c_uname"];
$idsql = "SELECT * from committee where c_uname = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$id = $r["id"];
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
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="schedule/fullcalendar/lib/main.min.css">
    <script src="schedule/js/jquery-3.6.0.min.js"></script>
    <script src="schedule/fullcalendar/lib/main.min.js"></script>
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
<div class="row border content" style="margin-left:18% ;">
<div class="col title-dashboard text-center mt-3">  <h2>Dashboard</h2></div>
<div class=" col-12 mt-3 text-center ">

<div class="col d-flex">
<div class="card ms-3  cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
  <h5 class="card-title fs-1 ">Candidates:</h5>
<?php
     $eventCountQuery = "SELECT COUNT(*) AS candidateCount FROM candidates WHERE id = '$id'";
     $eventCountResult = mysqli_query($conn, $eventCountQuery);

     if ($eventCountResult) {
       $eventCountRow = mysqli_fetch_assoc($eventCountResult);
       $numberOfEvents = $eventCountRow['candidateCount'];
?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfEvents; } ?></p>

  </div>
</div><div class="card ms-3 cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
  <h5 class="card-title fs-1 ">Event Categories</h5>
<?php
     $eventCountQuery = "SELECT COUNT(*) AS categoryCount FROM event_category WHERE id = '$id'";
     $eventCountResult = mysqli_query($conn, $eventCountQuery);

     if ($eventCountResult) {
       $eventCountRow = mysqli_fetch_assoc($eventCountResult);
       $numberOfEvents = $eventCountRow['categoryCount'];
?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfEvents; } ?></p>
  </div>
</div><div class="card ms-3 cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
  <h5 class="card-title fs-1 ">Judges:</h5>
<?php
     $eventCountQuery = "SELECT COUNT(*) AS judgesCount FROM judges WHERE id = '$id'";
     $eventCountResult = mysqli_query($conn, $eventCountQuery);

     if ($eventCountResult) {
       $eventCountRow = mysqli_fetch_assoc($eventCountResult);
       $numberOfEvents = $eventCountRow['judgesCount'];
?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfEvents; } ?></p>
  
</div>
</div>

</div>
<div class="col text-center title-dashboard mt-5">
                <h2>Event Calendar</h2>

            </div>
<div class="col-12">

<?php include("committee_calendar.php"); ?>
</div>

</div>
</div>
</body>
</html>
    <?php
}



?>

