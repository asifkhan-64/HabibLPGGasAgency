<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$v_id = $_POST["vendor"];

$query = mysqli_query($connect, "SELECT total_dues FROM `vendor_tbl` WHERE v_id = '$v_id'");
$row = mysqli_fetch_array($query);

echo $done = $row['total_dues'];

