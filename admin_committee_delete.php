
<?php
include("db.php");
include("functions.php");
include("admin_committee_view.php");



    $cid =$_POST["cid"];
    $eid =$_GET["eid"];
    $event = "DELETE from committee where id='$cid'";
    $sql = mysqli_query($conn ,$event);
    
    if($sql)
    {
        echo "<script>Swal.fire({
        position: 'center',
        iconHtml:'<i class=\"fa-solid fa-circle-check\" style=\"color: #38289c ;\"></i>',
        title: 'Succesfully Deleted',
        showConfirmButton: true,
       })
       var eid = document.getElementById('eid');
       var inputValue = eid.value;
       document.querySelectorAll('button.swal2-confirm').forEach(a=>a.onclick=function(){window.parent.location='admin_committee_view.php?id=' + inputValue);
     
       </script>";
    }


?>