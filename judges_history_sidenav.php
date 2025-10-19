<?php
if(isset($_POST['logout']))
{
  session_destroy();
  header("location: index.php");
}
// Fetch categories from the database

$query = "SELECT * FROM event_category where id='$eventid'";
$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="schedule/fullcalendar/lib/main.min.css">
    <script src="schedule/js/jquery-3.6.0.min.js"></script>
    <script src="schedule/fullcalendar/lib/main.min.js"></script> -->
<link rel="stylesheet" href="style.css" >
<title>Document</title>
</head>
<body>
<!-- <div class="container-fluid shadow sticky-top"id="navbar">
        <div class="row d-flex  text-center ">
        <div class="col-12 ps-2 d-flex ">
                <img  src="image_resource/Pangasinan_State_University_logo-removebg-preview_1.png" alt="" width="70px">
                <h3 id="title" class="pt-3 ps-1">Pangasinan State University Tabulation System</h3>
            </div>

        </div>
    </div> -->


<!-- <div class="container-fluid  " > -->
  <div class="row " >



    <div id="sbar"  class="d-flex flex-column flex-shrink-0 p-3 " style="width: 280px; height:89vh;">
<span class="fs-4"><?php echo $r['title'];?></span>


     <hr>
    <ul class="nav nav-pills flex-column mb-auto">

    <li class="nav-item">
        <a href="judges_events.php" class="nav-link <?php if ($activePage === 'events') {echo ' active';} else{echo 'text-white';}  ?> " aria-current="page" >
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Active Events
        </a>
      </li>
      <li class="nav-item">
        <a href="judges_history.php" class="nav-link <?php if ($activePage === 'history') {echo ' active';} else{echo 'text-white';}  ?> " aria-current="page" >
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          History
        </a>
      </li>

    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?php   echo $r["j_username"];        ?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
      <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">
        <li><input type="submit" name="logout" value="Log Out" class="dropdown-item"></li>
        </form>
      </ul>
    </div>
  </div>

  <?php

    ?>

  </div>

  <!-- <div class="row border content" >
<div class="col title-dashboard text-center mt-3">  <h2>Dashboard</h2></div>
<div class=" col-12 mt-3 text-center ">

<div class="col d-flex">
<div class="card ms-3  cbody" style="width: 24rem;">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div><div class="card ms-3 cbody" style="width: 24rem;">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div><div class="card ms-3 cbody" style="width: 24rem;">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
  
</div>
</div>

</div>
<div class="col text-center title-dashboard mt-5">
                <h2>Event Calendar</h2>

            </div>
<div class="col-12">


</div>

</div>  -->
 <!-- </div> -->

</body>
</html>



