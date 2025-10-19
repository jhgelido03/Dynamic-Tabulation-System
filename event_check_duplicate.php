<?php
include("db.php");

$etitle = $_GET["etitle"];

$sql = "SELECT * FROM schedule_list WHERE title = '$etitle'";
$result = mysqli_query($conn, $sql);

$response = array("duplicate" => mysqli_num_rows($result) > 0);

echo json_encode($response);
?>