<?php
include("db.php");
include("functions.php");
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css" >
    <title>Document</title>
</head>
<body >
<div class="container-fluid shadow sticky-top"id="navbar">
        <div class="row d-flex  text-center ">
        <div class="col-12 ps-2 d-flex ">
                <img  src="image_resource/Pangasinan_State_University_logo-removebg-preview_1.png" alt="" width="70px">
                <h3 id="title" class="pt-3 ps-1">Pangasinan State University Event Tabulation System</h3>
            </div>

        </div>
    </div>


    <br><br><br>

    <div class="container  text-center col-5 mt-5  shadow-lg roundboard " id="licon">
        <div class="row justify-content-center  ">
                        <h3 class="fw-bold  pt-2 pb-2  roundboard" id="li" >Log In</h3>
            <div class=" pb-3 text-center   ">

                    <br><br>
<form action="index.php" method="post">
<div class="row justify-content-center mb-5">
    <div class="col-7 ">
    <div class=" form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="uname">
  <label for="floatingInput">Username</label>
</div>
<div class="form-floating">
  <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
  <label for="floatingPassword">Password</label>
</div>
    </div>
</div>
                    <input type="submit" value= "Log In" class="btn fs-5 mb-3 sbmt" name="login">

</form>
              
            </div>
        </div>
    </div>
</body>
</html>
<?php

if(isset($_POST["login"]))
{
    $uname = $_POST["uname"];
    $password = $_POST["password"];
login($conn, $uname,$password);
}



?>