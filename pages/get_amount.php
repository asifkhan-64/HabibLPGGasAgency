<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$v_id = $_POST["vendor"];

$query = mysqli_query($connect, "SELECT bill_no, remaining_amount FROM `vendor_summary` WHERE v_id = '$v_id'");
$output = '<option></option>';
while ($row = mysqli_fetch_array($query)) {
    if ($row['remaining_amount'] > 0) {
        $output .= '<option value=' . $row['bill_no'] . '>' . $row['bill_no'] . '</option>';
    }
}
echo $output;
