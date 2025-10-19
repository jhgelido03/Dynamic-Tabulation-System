<?php
include("db.php");
session_start();
include("functions.php");
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);

    $id = $_GET["id"];
    $sql = "SELECT * from  candidates where id = '$id'";
    $csql = mysqli_query($conn, $sql);

    $msql = "SELECT * from  schedule_list where id = '$id'";
    $modalsql = mysqli_query($conn, $msql);
    $type = mysqli_fetch_assoc($modalsql);
$activePage = 'candidates';


$title ="";
$desc = "";
$sdate = "";
$edate = "";


  $cnum = "SELECT * from schedule_list where id = '$id'";
  $cnumsql = mysqli_query($conn,$cnum);
  $cnumrow = mysqli_fetch_assoc($cnumsql);

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
<a href="admin_candidates.php" class="btn btn-primary back">Back</a>
</div>
    <div class="col-6 text-end p-3 ">
        <!-- Button trigger modal -->
<button type="button" class="btn mbutton" data-bs-toggle="modal" data-bs-target="<?php if($type['event_type']=='0'){ echo '#individual'; } else if($type['event_type']=='1'){ echo '#group'; }?>" >
  Add Candidates +
</button>
</div>


<!-- Modal -->
<div class="modal fade" id="group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Candidate</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_candidates_view.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<div class="col text-start">
<label for="gcame" class="fw-bold">Group Name</label>
            <input type="text" class="form-control " name="gcname" required>
</div>
<div class="col text-start">

<label for="gcnum" class="fw-bold">Group No.</label>
            <input type="number" class="form-control " name="gcnum" min= 1 max=<?php echo $cnumrow["no_of_candidates"];  ?> required>
</div>
<div class="col text-start mt-2">
<label for="gcdept" class="fw-bold">Group Department</label>
<select class="form-select" aria-label="Default select example" name="gcdept" id="gcdept" required>
  <option selected>Choose one from the list</option>
  <option value="BSBA - Bachelor of Science in Business Administration">BSBA - Bachelor of Science in Business Administration</option>
  <option value="BSIT - Bachelor of Science in Information Technology">BSIT - Bachelor of Science in Information Technology</option>
  <option value="BSOA - Bachelor of Science in Office Administration">BSOA - Bachelor of Science in Office Administration</option>
  <option value="BSHM - Bachelor of Science in Hospitality Management">BSHM - Bachelor of Science in Hospitality Management</option>
</select>
</div>
<div class="col text-start mt-2">
<label for="gccontact" class="fw-bold">Group Contact No.</label>
            <input type="tel" class="form-control " name="gccontact" pattern="[0-9]{11}" required>
</div>  <small>Format: 09xxxxxxxxx</small><br>

<div class="col text-start mt-2">
<label for="gcimage" class="fw-bold">Group Image</label>
            <input type="file" class="form-control " name="gcimage" accept=".jpg,.png,.jpeg" required>
</div>
<input type="hidden" value="<?php   echo $id     ?>" name="eid">
<!-- <div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate">
</div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submitgroup" value="Save">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="individual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Candidate</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_candidates_view.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<div class="col text-start">
<label for="icname" class="fw-bold">Candidate Name</label>
            <input type="text" class="form-control " name="icname" required>
</div>


<div class="col text-start">

<label for="icnum" class="fw-bold">Candidate No.</label>
            <input type="number" class="form-control " name="icnum" min= 1 max=<?php echo $cnumrow["no_of_candidates"];  ?> required >
</div>
<div class="col text-start mt-2">
<label for="icdept" class="fw-bold">Candidate Department</label>
<select class="form-select" aria-label="Default select example" name="icdept" id="cdept" required>
  <option selected>Choose one from the list</option>
  <option value="BSBA - Bachelor of Science in Business Administration">BSBA - Bachelor of Science in Business Administration</option>
  <option value="BSIT - Bachelor of Science in Information Technology">BSIT - Bachelor of Science in Information Technology</option>
  <option value="BSOA - Bachelor of Science in Office Administration">BSOA - Bachelor of Science in Office Administration</option>
  <option value="BSHM - Bachelor of Science in Hospitality Management">BSHM - Bachelor of Science in Hospitality Management</option>
</select>
</div>
<div class="col text-start mt-2">
<label for="icys" class="fw-bold">Candidate Year and Section</label>
            <input type="text" class="form-control " name="icys" required>
</div>
<div class="col text-start mt-2">
<label for="icsex" class="fw-bold">Candidate Sex</label>
<select class="form-select" aria-label="Default select example" name="icsex" id="icsex" required>
  <option selected>Choose one from the list</option>
  <option value="Male">Male</option>
  <option value="Female">Female</option>
</select>
</div>
<div class="col text-start mt-2">
<label for="icbday" class="fw-bold">Candidate Bday</label>
            <input type="date" class="form-control " name="icbday" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required>
</div>
<div class="col text-start mt-2">
<label for="iccontact" class="fw-bold">Candidate Contact No.</label>
            <input type="tel" class="form-control " name="iccontact" pattern="[0-9]{11}" required>
</div>  <small>Format: 09xxxxxxxxx</small><br>
<div class="col text-start mt-2">
<label for="icimage" class="fw-bold">Candidate Image</label>
            <input type="file" class="form-control " name="icimage" accept=".jpg,.png,.jpeg" required>
</div>
<input type="hidden" value="<?php   echo $id     ?>" name="eid">
<!-- <div class="col text-start mt-2">
<label for="edate" class="fw-bold">End Date</label>
            <input type="datetime-local" class="form-control " name="edate">
</div> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submitindividual" value="Save">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="col-12 title-dashboard text-center mt-3">  <h2>Candidates</h2></div>


<div class="col mt-3">
<table id="example" class="table table-striped" style="width:90%;margin:auto">
        <thead>
            <tr>
            <th>Candidate No.</th>
                <th>Name</th>
                <th>Department</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($csql) > 0) {
            while ($row = mysqli_fetch_assoc($csql)) {
        ?>
        <tr>
        <form action="admin_candidates_view.php?id=<?php echo $row["id"]; ?>" method="post">
        <td><?php echo $row['candidate_no'] ?></td>
            <td><?php echo $row['candidate_name'] ?></td>
            <td><?php echo $row['candidate_dept'] ?></td>
            <input type="hidden" value="<?php echo $row['candidate_ID'] ?>" name="cid" id="cid">
            <input type="hidden" value="<?php echo $row['id'] ?>" name="eid" id="eid">
            <td><a href="admin_candidates_viewall.php?candidate_ID=<?php echo $row['candidate_ID']; ?>" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a> 
            <a href="<?php 
    if ($type["event_type"] == '0') {
        echo 'admin_candidates_individual_view_edit.php?candidate_ID=' . $row['candidate_ID'] . '&id=' . $row["id"];
    } elseif ($type["event_type"] == '1') {
        echo 'admin_candidates_group_view_edit.php?candidate_ID=' . $row['candidate_ID'] . '&id=' . $row["id"];
    }
?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
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
if(isset($_POST["submitgroup"]))
{
    $eid = $_POST["eid"];
    $gcname = $_POST["gcname"];
    $gcnum = $_POST["gcnum"];
$gcdept= $_POST["gcdept"];
$gcys = "Not Applicable";
$gcsex = "Not Applicable";
$gcbday = "Not Applicable";
$gccontact = $_POST["gccontact"];
$gcimage = $_FILES["gcimage"]["name"];
$filesize = $_FILES['gcimage']['size'];
$tempname = $_FILES["gcimage"]["tmp_name"];
$folder = "candidateimage/";
move_uploaded_file($tempname ,$folder.$gcimage);


$sql = "SELECT * from  candidates where candidate_name = '$gcname' AND candidate_bday='$gcbday' OR candidate_no = '$gcnum' AND id= '$eid'";
$csql = mysqli_query($conn, $sql);

if(mysqli_num_rows($csql)>0)
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Candidate Already Exists',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
     
       </script>";
}
else if(empty($gcname) || empty($gcdept) || empty($gcys) || empty($gcsex) || empty($gcbday) || empty($gccontact) || empty($gcimage) || empty($gcnum)   )
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Please fill up all the fields',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
     
       </script>";
}
else
{
  $candidates = "INSERT into candidates(candidate_name,candidate_dept,candidate_no, candidate_ys,candidate_sex,candidate_bday,candidate_contact,candidate_image,id) VALUES ('$gcname','$gcdept','$gcnum','$gcys','$gcsex','$gcbday','$gccontact','$gcimage','$eid')";
$sql = mysqli_query($conn ,$candidates);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Added',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
 
   </script>";
}
}

}

if(isset($_POST["submitindividual"]))
{
    $eid = $_POST["eid"];
    $icname = $_POST["icname"];
    $icnum = $_POST["icnum"];
$icdept= $_POST["icdept"];
$icys = $_POST["icys"];
$icsex = $_POST["icsex"];
$icbday = $_POST["icbday"];
$iccontact = $_POST["iccontact"];
$icimage = $_FILES["icimage"]["name"];
$filesize = $_FILES['icimage']['size'];
$tempname = $_FILES["icimage"]["tmp_name"];
$folder = "candidateimage/";
move_uploaded_file($tempname ,$folder.$icimage);


$sql = "SELECT * from  candidates where candidate_name = '$icname' AND candidate_bday='$icbday' OR candidate_no = '$icnum' AND id= '$eid'";
$csql = mysqli_query($conn, $sql);

if(mysqli_num_rows($csql)>0)
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Candidate Already Exists',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
     
       </script>";
}
else if(empty($icname) || empty($icdept) || empty($icys) || empty($icsex) || empty($icbday) || empty($iccontact) || empty($icimage) || empty($icnum) )
{
    echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-xmark\" style=\"color: red ;\"></i>',
        title: 'Please fill up all the fields',
        showConfirmButton: true,
       })
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
     
       </script>";
}
else
{
  $candidates = "INSERT into candidates(candidate_name,candidate_no,candidate_dept,candidate_ys,candidate_sex,candidate_bday,candidate_contact,candidate_image,id) VALUES ('$icname','$icnum','$icdept','$icys','$icsex','$icbday','$iccontact','$icimage','$eid')";
$sql = mysqli_query($conn ,$candidates);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Added',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
 
   </script>";
}
}

}
if(isset($_POST["delete"]))
{
    $eid = $_POST["eid"];
    $cid =$_POST["cid"];
    $event = "DELETE from candidates where candidate_ID='$cid'";
    $sql = mysqli_query($conn ,$event);
    
    if($sql)
    {
        echo "<script>Swal.fire({
            position: 'center',
            iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
            title: 'Succesfully Deleted',
            showConfirmButton: true,
           })
           document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_candidates_view.php?id=$eid'});
         
           </script>";
    }
}

?>










