<?php
include("db.php");

$cname = $_GET["cname"];

$sql = "SELECT * FROM event_category WHERE category_title = '$cname'";
$result = mysqli_query($conn, $sql);

$response = array("duplicate" => mysqli_num_rows($result) > 0);

echo json_encode($response);
?>