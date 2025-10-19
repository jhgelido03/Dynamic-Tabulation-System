<?php
include("db.php");
session_start();
$activePage = 'dashboard';
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
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
<?php include("admin_sidenav.php"); ?>
  </div>
<div class="row border content" style="margin-left:18% ;">
<div class="col title-dashboard text-center mt-3">  <h2>Dashboard</h2></div>
<div class=" col-12 mt-3 text-center ">

<div class="col d-flex">
<div class="card ms-3  cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
    <h5 class="card-title fs-1 ">Active Events:</h5>
<?php
     $eventCountQuery = "SELECT COUNT(*) AS eventCount FROM schedule_list WHERE status = 0 OR status = 1";
     $eventCountResult = mysqli_query($conn, $eventCountQuery);

     if ($eventCountResult) {
       $eventCountRow = mysqli_fetch_assoc($eventCountResult);
       $numberOfEvents = $eventCountRow['eventCount'];
?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfEvents; } ?></p>

  </div>
</div>
<div class="card ms-3 cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
    <h5 class="card-title fs-1">Active Committees:</h5>
        <?php 
           $committeeCountQuery = "SELECT COUNT(*) AS committeeCount
           FROM committee
           INNER JOIN schedule_list ON committee.id = schedule_list.id
           WHERE schedule_list.status = 0 OR schedule_list.status = 1";
$committeeCountResult = mysqli_query($conn, $committeeCountQuery);

if ($committeeCountResult) {
$committeeCountRow = mysqli_fetch_assoc($committeeCountResult);
$numberOfCommittees = $committeeCountRow['committeeCount'];
        ?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfCommittees ; }?></p>
  </div>
</div>
<div class="card ms-3 cbody" style="width: 24rem;height:12rem;">
  <div class="card-body">
    <h5 class="card-title fs-1">Active Judges:</h5>
    <?php 
           $judgeCountQuery = "SELECT COUNT(*) AS judgeCount
           FROM judges
           INNER JOIN schedule_list ON judges.id = schedule_list.id
           WHERE schedule_list.status = 0 OR schedule_list.status = 1";
$judgeCountResult = mysqli_query($conn, $judgeCountQuery);

if ($judgeCountResult) {
$judgeCountRow = mysqli_fetch_assoc($judgeCountResult);
$numberOfJudges = $judgeCountRow['judgeCount'];
        ?>
    <p class="card-text fs-1 fw-bold"><?php echo $numberOfJudges;}  ?></p>
  </div>
  
</div>
</div>

</div>
<div class="col text-center title-dashboard mt-5">
                <h2>Event Calendar</h2>

            </div>
<div class="col-12">

<?php include("admin_calendar.php"); ?>
</div>

</div>
</div>
</body>
</html>
    <?php
}



?>



