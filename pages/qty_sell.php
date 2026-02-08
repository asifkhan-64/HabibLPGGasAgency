<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$c_id = $_GET['c_id'];

if (isset($_POST['makeInvoice'])) {
    $c_id = $_POST['c_id'];
    $products_arr = $_POST['platform'];

    if (empty($products_arr)) {
        header("Location: qty_sell.php?c_id=".$c_id."");
    }

    for ($i = 0; $i < sizeof($products_arr); $i++) {
        $product = $products_arr[$i];

        $checkingQuery = mysqli_query($connect, "SELECT * FROM cart_tbl_qty WHERE c_id='$c_id' AND product_id = '$product'");
        $deleteQuery = mysqli_query($connect, "DELETE FROM cart_tbl_qty WHERE c_id='$c_id' AND product_id = '$product'  AND sell_status = '0'");

        $insertCart = mysqli_query($connect, "INSERT INTO cart_tbl_qty(c_id, product_id)VALUES('$c_id', '$product')");

    }

    if ($insertCart) {
        header("LOCATION:amount_cash_qty.php?c_id=" . $c_id . "");
    }
}


include('../_partials/header.php');

?>
<style>
    /* * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
    } */

    body {
        font-family: "Roboto", sans-serif;
        background: #f5f5f5;
    }

    /* .container {
        position: absolute;
        top: 45%;
        left: 56%;
        transform: translate(-50%, -50%);
    } */

    .container h2 {
        font-size: 25px;
        color: #888;
        text-align: center;
    }

    .container .list {
        margin-top: 40px;
        margin-bottom: 40px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        /* gap: 1px; */
        max-width: 100%;
    }

    .form-element {
        position: relative;
        width: 50%;
        min-height: 50%;
    }

    .form-element input {
        display: none;
    }

    .form-element label {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        cursor: pointer;
        border: 2px solid #ddd;
        background: #fff;
        box-shadow: 0px 5px 20px 2px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 200ms ease-in-out;
        border-radius: 5px;
    }

    .form-element .icon {
        margin-top: 10px;
        font-size: 100%;
        size: 50%;
        ;
        color: #555;

        transition: all 200ms ease-in-out;
    }

    .form-element .title {
        font-size: 15px;
        color: #555;
        padding: 5px 0px;
        transition: all 200ms ease-in-out;
    }

    .form-element label:before {
        content: "✓";
        position: absolute;
        width: 18px;
        height: 18px;
        top: 8px;
        left: 8px;
        background: #0d0df1;
        color: #fff;
        text-align: center;
        line-height: 18px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 50%;
        opacity: 0;
        transform: scale(0.5);
        transition: all 200ms ease-in-out;
    }

    .form-element input:checked+label:before {
        opacity: 1;
        transform: scale(1);
    }

    .form-element input:checked+label .icon {
        color: #0d0df1 !important;
    }

    .form-element input:checked+label .title {
        color: #0d0df1;
    }

    .form-element input:checked+label {
        border: 2px solid #0d0df1;
    }
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Quantity Based Sell</h5>
            </div>
        </div>

        <form method="POST">
            <div class="form-group row">
                <div class="col-sm-12 text-right">
                    <?php //include('../_partials/cancel.php') 
                    ?>
                    <button type="submit" style="width: 40%" name="makeInvoice" class="btn btn-primary waves-effect waves-light btn-lg">Make Invoice</button>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-7" style="border-right: 1px solid grey">
                    <!-- <div class="row"> -->
                    <div class="container" id="defaultProducts">
                        <div class="list">

                            <input type="hidden" name="c_id" value="<?php echo $c_id ?>">
                            <?php

                            $getStock = mysqli_query($connect, "SELECT * FROM `categories` WHERE category_type = 'Qty' AND stock_available > 0");

                            while ($rowStock = mysqli_fetch_assoc($getStock)) {
                                echo '
                                <div class="form-element p-1">
                                <input type="checkbox" name="platform[]" value="' . $rowStock['id'] . '" id="' . $rowStock['category_name'] . '">
                                <label for="' . $rowStock['category_name'] . '">
                                    
                                    <div class="icon my-3">
                                        <i class="fa fa-cart-plus" style="font-size: 40px"></i>
                                    </div>

                                    <div class="title pt-5">
                                    ' . $rowStock['id'] . ' - ' . $rowStock['category_name'] . '
                                    </div>

                                    <p class="title">Price: ' . $rowStock['sell_price'] . '</p>
                                    
                                </label>
                                </div>
                            ';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-5">
                    <input type="text" class="form-control" style="border-radius: 50px" id="searchTags" placeholder="Please Search Product . . .">

                    <div class="container" id="ajaxProducts" style="display: none;">
                        <div class="list" id="products">

                        </div>
                    </div>
                </div>
                <br><br>
        </form>
    </div>
</div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include('../_partials/footer.php') ?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include('../_partials/jquery.php') ?>
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>

<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
    // ajaxProducts
    // defaultProducts
    $(document).ready(function() {
        $('#searchTags').keyup(function() {
            var searchTags = $(this).val();
            if (!$(this).val()) {
                $("#ajaxProducts").hide();
                // $("#defaultProducts").show();

            } else {
                $("#ajaxProducts").show();
                // $("#defaultProducts").hide();
            }

            $.ajax({
                url: "get_qty_products.php",
                method: "POST",
                data: {
                    searchTags: searchTags
                },
                dataType: "text",
                success: function(data) {
                    $('#products').html(data);
                    console.log(data);
                }
            });
        });
    });
</script>

</body>

</html>