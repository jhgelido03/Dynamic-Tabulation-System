<?php
include("db.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/bb4ba0889c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>


<?php



function login($conn, $uname, $pass)
{
    $loginc = "SELECT * from login where admin_username ='$uname' AND admin_pass = '$pass'";
    $asql = mysqli_query($conn, $loginc);

 $logina = "SELECT * from committee where c_uname ='$uname' AND c_password = '$pass'";
 $csql = mysqli_query($conn, $logina);
 $loginj = "SELECT * from judges where j_username ='$uname' AND j_password = '$pass'";
 $jsql = mysqli_query($conn, $loginj);

 if(mysqli_num_rows($asql)>0)
 {
    $row = mysqli_fetch_assoc($asql);
    $admin_username = $row['admin_username'];
       $_SESSION['admin_username'] = $admin_username;
    echo "<script>Swal.fire({
       position: 'center',
       iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
       title: 'Log In Succesfully',
       showConfirmButton: true,
      })
      document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_dashboard.php'});
    
      </script>";

 }
 else if(mysqli_num_rows($csql)>0 )
 {
   $row = mysqli_fetch_assoc($csql);
   $committee_username = $row['c_uname'];
   $_SESSION['c_uname'] = $committee_username;
    echo "<script>Swal.fire({
       position: 'center',
       iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
       title: 'Log In Succesfully',
       showConfirmButton: true,
      })
      document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='committee_dashboard.php'});
    
      </script>";

 }
 else if(mysqli_num_rows($jsql)>0 )
 {
   // $row = mysqli_fetch_assoc($jsql);
   // $judge_username = $row['j_username'];
   // $judge_eventid = $row["id"];
   // $_SESSION['j_username'] = $judge_username;
   // $_SESSION["id"] = $judge_eventid;
   //  echo "<script>Swal.fire({
   //     position: 'center',
   //     iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
   //     title: 'Log In Succesfully',
   //     showConfirmButton: true,
   //    })
   //    document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='judges_events.php'});
    
   //    </script>";
   $row = mysqli_fetch_assoc($jsql);
   $judge_username = $row['j_username'];
   $judge_eventid = $row["id"];
   $_SESSION['j_username'] = $judge_username;
   $_SESSION["id"] = $judge_eventid;
$j_ID = $row['j_ID'];
   $judgesql = "SELECT judges.j_username, judges.id, schedule_list.status
         FROM judges
         INNER JOIN schedule_list ON judges.id = schedule_list.id
         WHERE schedule_list.status IN (1, 2) AND j_ID = '$j_ID'";

$result = mysqli_query($conn, $judgesql);

if (mysqli_num_rows($result) >0 ) {


    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
        title: 'Log In Successfully',
        showConfirmButton: true,
    })
    document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='judges_events.php'});
    
    </script>";
} else {
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'The Event Set Up Is Not Yet Done!',
        showConfirmButton: true,
    })
    document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='index.php'});
    
    </script>";
}

 }
 else if(empty($uname) || empty($pass))
 {
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Please fill up all the fields',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='index.php?error=InvalidInformation'});
     
       </script>";
}
else
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Invalid Information',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='index.php?error=InvalidInformation'});
     
       </script>";
}
 

}



// function deleteevent($eid)
// {
// $event = "DELETE from schedule_list where id='$eid'";
// $sql = mysqli_query($conn ,$event);

// if($sql)
// {
//     echo "<script>Swal.fire({
//     position: 'center',
//     iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
//     title: 'Succesfully Deleted',
//     showConfirmButton: true,
//    })
//    document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_events.php'});
 
//    </script>";
// }
// }
