<?php
include("db.php");
session_start();
$sessionid = $_SESSION["c_uname"];
$idsql = "SELECT * from committee where c_uname = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$eid = $_GET["id"];


  $cid = $_GET["candidate_ID"];
  $sql = "SELECT * from candidates where candidate_ID = '$cid'";
  $selectsql = mysqli_query($conn, $sql);




$activePage = 'candidates';


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

<div class="row border content justify-content-center mb-5" >
<div class="col-12 title-dashboard text-center mt-3">  <h2>Candidate Information</h2></div>
    <div class="col-9  mt-5">
<?php if(mysqli_num_rows($selectsql)>0)
{


while($rows = mysqli_fetch_assoc($selectsql))
{
 ?>
     <form action="committee_candidates_group_view_edit.php?id=<?php echo $eid;?>&candidate_ID=<?php echo $cid; ?>" method="post" enctype="multipart/form-data">
<div class="row d-flex">
<div class="col-md-2">
 <img src="candidateimage/<?php  echo $rows["candidate_image"];?>" alt="" height="100px" width="100px">
  </div>
<div class="col-md-8">
    <label for="cname" class="form-label">Group Name</label>
    <input type="text" class="form-control" id="cname" name="cname" value="<?php  echo $rows["candidate_name"];     ?>">
  </div>
  <div class="col-10 text-start mt-2">
<label for="cnum" class="fw-bold">Group No.</label>
            <input type="number" class="form-control " name="cnum" value="<?php  echo $rows["candidate_no"];?>">
</div>
</div>
<div class="col-10 text-start mt-2">
<label for="cdept" class="fw-bold">Department</label>
            <select class="form-select" aria-label="Default select example" name="cdept" id="cdept">
  <option selected>Choose one from the list</option>
  <option value="BSBA - Bachelor of Science in Business Administration" <?php if ($rows['candidate_dept'] == "BSBA - Bachelor of Science in Business Administration") echo ' selected="selected"'; ?>>BSBA - Bachelor of Science in Business Administration</option>
  <option value="BSIT - Bachelor of Science in Information Technology" <?php if ($rows['candidate_dept'] == "BSIT - Bachelor of Science in Information Technology") echo ' selected="selected"'; ?>>BSIT - Bachelor of Science in Information Technology</option>
  <option value="BSOA - Bachelor of Science in Office Administration" <?php if ($rows['candidate_dept'] == "BSOA - Bachelor of Science in Office Administration") echo ' selected="selected"'; ?>>BSOA - Bachelor of Science in Office Administration</option>
  <option value="BSHM - Bachelor of Science in Hospitality Management" <?php if ($rows['candidate_dept'] == "BSHM - Bachelor of Science in Hospitality Management") echo ' selected="selected"'; ?>>BSHM - Bachelor of Science in Hospitality Management</option>
</select>
</div>
<!-- <div class="col-10 text-start mt-2">
<label for="cys" class="fw-bold">Year and Section</label>
            <input type="text" class="form-control " name="cys" value="<?php  echo $rows["candidate_ys"];     ?>">
</div> -->
<!-- <div class="col-10 text-start mt-2">
<label for="csex" class="fw-bold">Sex</label>
<select class="form-select" aria-label="Default select example" name="csex" id="csex">
  <option selected>Choose one from the list</option>
  <option value="Male"  <?php if ($rows['candidate_sex'] == "Male") echo ' selected="selected"'; ?>>Male</option>
  <option value="Female" <?php if ($rows['candidate_sex'] == "Female") echo ' selected="selected"'; ?>>Female</option>
</select>
</div> -->

<!-- <div class="col-10 text-start mt-2">
<label for="cbday" class="fw-bold">Birthdate</label>
            <input type="date" class="form-control " name="cbday" value="<?php  echo $rows["candidate_bday"];?>">
</div> -->

<div class="col text-start mt-2">
<label for="iccontact" class="fw-bold">Candidate Contact No.</label>
            <input type="tel" class="form-control " name="iccontact" pattern="[0-9]{11}" value="<?php  echo $rows["candidate_contact"];     ?>" >
</div>  <small>Format: 09xxxxxxxxx</small><br>


<div class="col-10 text-start mt-2">
<label for="cimage" class="fw-bold">Candidate Image</label>
            <input type="file" class="form-control " name="cimage" accept=".jpg,.png,.jpeg">
</div>

</div>
<div class="col-4 mt-5 text-end">
<input type="submit" class="btn btn-primary" name="edit" value="Save Changes">
</div>
<div class="col-4 mt-5 text-start">
    <a href="committee_candidates_view.php?id=<?php echo $rows["id"]?>" class="btn btn-danger">Close</a>
</div>
<input type="hidden" name="oldimage" value="<?php echo $rows["candidate_image"]?>">
<input type="hidden" value="<?php echo $rows["candidate_ID"]; ?>" name="cid">
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
    
    $cname = $_POST["cname"];
    $cnum = $_POST["cnum"]; 
$cdept = $_POST["cdept"];
$ccontact = $_POST["ccontact"];
$cimage = $_FILES["cimage"]["name"];
$oldimage = $_POST["oldimage"];
$cid = $_POST["cid"];

// $sql = "SELECT * from  candidates where candidate_name = '$cname' AND candidate_bday='$cbday'";
// $csql = mysqli_query($conn, $sql);

// if(mysqli_num_rows($csql)>0)
// {
//     echo "<script>Swal.fire({
//         position: 'center',
//         iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
//         title: 'Candidate Already Exists',
//         showConfirmButton: true,
//        })
//        document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='committee_candidates.php'});
     
//        </script>";
// }
$sql = "SELECT * from candidates where candidate_name = '$cname'";
$name = mysqli_query($conn , $sql);
if($_FILES["cimage"]["name"]=="" || $cimage===$oldimage)
{
  $event = "UPDATE candidates SET candidate_name='$cname',candidate_no='$cnum', candidate_dept='$cdept', candidate_contact = '$ccontact' where candidate_ID = '$cid' ";
  $sql = mysqli_query($conn ,$event);
  if($sql)
  {
      echo "<script>Swal.fire({
      position: 'center',
      iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
      title: 'Succesfully Updated',
      showConfirmButton: true,
     })
     document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='committee_candidates_view.php?id=$eid'});
   
     </script>";
  }
}
else
{
  $filesize = $_FILES['cimage']['size'];
$tempname = $_FILES["cimage"]["tmp_name"];
$folder = "candidateimage/";
unlink($folder.$oldimage);
move_uploaded_file($tempname ,$folder.$cimage);
    $event = "UPDATE candidates SET candidate_name='$cname',candidate_no='$cnum', candidate_dept='$cdept', candidate_contact = '$ccontact',candidate_image = '$cimage' where candidate_ID = '$cid' ";
$sql = mysqli_query($conn ,$event);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Updated',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='committee_candidates_view.php?id=$eid'});
 
   </script>";
}
}
}
?>