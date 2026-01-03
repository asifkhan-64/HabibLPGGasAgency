<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$billNo = $_POST["billNo"];
$query = mysqli_query($connect, "SELECT remaining_amount FROM vendor_summary");

while ($row = mysqli_fetch_array($query)) {
    print_r($row['remaining_amount']);
}

echo $output;
