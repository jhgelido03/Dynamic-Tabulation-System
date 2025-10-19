<?php
include("db.php");
session_start();
$sessionid = $_SESSION["admin_username"];
$idsql = "SELECT * from login where admin_username = '$sessionid' ";
$result = mysqli_query($conn, $idsql);
$r = mysqli_fetch_assoc($result);
$eid = $_GET["id"];
$activePage = 'events';


    $category_ID = $_GET["category_ID"];
    $sql = "SELECT * from  event_category where category_ID = '$category_ID'";
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
<?php include("admin_sidenav.php"); ?>
  </div>

<div class="row border content justify-content-center mb-5" >
<div class="col-12 title-dashboard text-center mt-3">  <h2>Edit Event Category</h2></div>
    <div class="col-9 text-center">
<?php if(mysqli_num_rows($selectsql)>0)
{


while($rows = mysqli_fetch_assoc($selectsql))
{
 ?>
     <form action="admin_event_category_edit.php?id=<?php echo $eid; ?>&category_ID=<?php echo $category_ID; ?>" method="post">
<div class="col text-start mt-5">
<label for="cname" class="fw-bold">Event Category Title</label>
            <input type="text" class="form-control " name="cname" value="<?php echo $rows["category_title"]; ?>">
</div>
<div class="col text-start mt-2">
<label for="cuname" class="fw-bold">Event Category Description</label>
            <input type="text" class="form-control " name="cuname" value="<?php echo $rows["category_description"]; ?>">
</div>

</div>
<div class="col-4 mt-5 text-end">
<input type="submit" class="btn btn-primary" name="edit" value="Save Changes">
</div>
<div class="col-4 mt-5 text-start">
    <a href="admin_event_category_view.php?id=<?php echo $rows['id']; ?>" class="btn btn-danger">Cancel</a>
</div>
<input type="hidden" value="<?php echo $rows["category_ID"]; ?>" name="cid">
        </form>
        <?php
}
}

?>




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
$cuname= $_POST["cuname"];
$cid = $_POST["cid"];
$event = "UPDATE event_category SET category_title='$cname', category_description='$cuname' where category_ID = '$cid' ";
$sql = mysqli_query($conn ,$event);
if($sql)
{
    echo "<script>Swal.fire({
    position: 'center',
    iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
    title: 'Succesfully Updated',
    showConfirmButton: true,
   })
   document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_event_category_view.php?id=$eid'});
 
   </script>";
}
}

?>