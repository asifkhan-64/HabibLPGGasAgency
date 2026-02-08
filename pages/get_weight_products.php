<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$output = '';
$no_models = '';

$searchTags = $_POST["searchTags"];
$modified = "%$searchTags%";

$query = mysqli_query($connect, "SELECT * FROM `categories` WHERE category_type = 'Weight' AND stock_available > 0 AND category_name LIKE '$modified' OR id LIKE '$modified'");
$rowcount = mysqli_num_rows($query);
if ($rowcount < 1) {
    $output .= '
        <h3>No Product Found!</h3>
    ';
} else {
    while ($rowStock = mysqli_fetch_array($query)) {
        $output .= '
            <div class="form-element p-1">
            <input type="checkbox" name="platform[]" value="' . $rowStock['category_name'] . '" id="' . $rowStock['category_name'] . '">
            <label for="' . $rowStock['category_name'] . '">
                

                <div class="title pt-5">
                ' . $rowStock['id'] . ' - ' . $rowStock['category_name'] . '
                </div>

                <p class="title">Price: ' . $rowStock['sell_price'] . '</p>
                
            </label>
            </div>
        ';
    }
}


echo $output;
