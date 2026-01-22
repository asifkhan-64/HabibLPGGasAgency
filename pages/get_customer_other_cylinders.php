<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$customerId = $_POST["customerId"];
$query = mysqli_query($connect, "SELECT other_cylinders FROM customer_add WHERE c_id = '$customerId'");

while ($row = mysqli_fetch_array($query)) {
    print_r($row['other_cylinders']);
}

echo $output;
