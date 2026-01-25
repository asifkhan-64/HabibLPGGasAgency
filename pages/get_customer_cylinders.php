<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$customerId = $_POST["customerId"];
$cylinderId = $_POST["cylinderId"];

$selectCylinderType = mysqli_query($connect, "SELECT * FROM `cylinder_types` WHERE cylinder_id = '$cylinderId'");
$rowCylinderType = mysqli_fetch_assoc($selectCylinderType);
$cylinder_type = $rowCylinderType['cylinder_type'];


$column_name = strtolower(str_replace(' ', '_', $cylinder_type));
$column_name_db = preg_replace('/[^a-z0-9_]/', '', $column_name);

$query = mysqli_query($connect, "SELECT `$column_name_db` FROM customer_add WHERE c_id = '$customerId'");

while ($row = mysqli_fetch_array($query)) {
    print_r($row[$column_name_db]);
}

echo $output;
