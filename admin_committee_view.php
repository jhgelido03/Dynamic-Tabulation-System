<?php
include("db.php");
session_start();
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
include("functions.php");

    $id = $_GET["id"];
    $sql = "SELECT * from  committee where id = '$id'";
    $csql = mysqli_query($conn, $sql);


$activePage = 'committee';


$title ="";
$desc = "";
$sdate = "";
$edate = "";

if(isset($_POST["submit"]))
{
    $cname = $_POST["cname"];
$cuname= $_POST["cuname"];
$cpass = $_POST["cpass"];
$eid = $_POST["eid"];

$sql = "SELECT * from  committee where c_uname = '$cuname'";
$csql = mysqli_query($conn, $sql);

if(mysqli_num_rows($csql)>0)
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Username Already Exists',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_committee_view.php?id=$eid'});
     
       </script>";
}
else if(empty($cname) || empty($cuname) || empty($cpass))
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Please fill up all the fields',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_committee_view.php?id=$eid'});
     
       </script>";
}
else
{
    $committee = "INSERT into committee(c_name,c_uname,c_password,id) VALUES ('$cname','$cuname','$cpass','$eid')";
$sql = mysqli_query($conn ,$committee);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Added',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_committee_view.php?id=$eid'});
 
   </script>";
}
}


}
if(isset($_POST["delete"]))
{
    $eid = $_POST["eid"];
    $cid =$_POST["cid"];
    $event = "DELETE from committee where c_ID='$cid'";
    $sql = mysqli_query($conn ,$event);
    
    if($sql)
    {
        echo "<script>Swal.fire({
            position: 'center',
            iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
            title: 'Succesfully Deleted',
            showConfirmButton: true,
           })
           document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_committee_view.php?id=$eid'});
         
           </script>";
    }
}
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
<div class=" ps-5 col-6 text-start p-3 ">
<a href="admin_committee.php" class="btn btn-primary back">Back</a>
</div>
    <div class="col-6 text-end p-3 ">
        <!-- Button trigger modal -->
<button type="button" class="btn mbutton" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add Committee +
</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_committee_view.php?id=<?php echo $id;?>" method="post">
<div class="col text-start">
<label for="cname" class="fw-bold">Committee Name</label>
            <input type="text" class="form-control " name="cname" required>
</div>
<div class="col text-start mt-2">
<label for="cuname" class="fw-bold">Committee Username</label>
            <input type="text" class="form-control " name="cuname" required>
</div>
<div class="col text-start mt-2">
<label for="cpass" class="fw-bold">Commitee Password</label>
            <input type="password" class="form-control " name="cpass" required>
</div>
<input type="hidden" value="<?php   echo $id     ?>" name="eid">
<!-- <div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate">
</div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Save">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-12 title-dashboard text-center mt-3">  <h2>Committee</h2></div>


<div class="col mt-3">
<table id="example" class="table table-striped" style="width:90%;margin:auto">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($csql) > 0) {
            while ($row = mysqli_fetch_assoc($csql)) {
        ?>
        <tr>
        <form action="admin_committee_view.php?id=<?php  echo $row["id"]  ?>" method="post">
            <td><?php echo $row['c_name'] ?></td>
            <td><?php echo $row['c_uname'] ?></td>
            <td><?php echo $row['c_password'] ?></td>
            <input type="hidden" value="<?php echo $row['c_ID'] ?>" name="cid" id="cid">
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid" id="eid">
            <td><a href="admin_committee_edit.php?c_ID=<?php echo $row['c_ID']; ?>&id=<?php  echo $row["id"]  ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>   
            <button type="submit" name="delete" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></td>
            </form>

        </tr>
        <?php
            }
        } 
    
        ?>
    </tbody>
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


?>










