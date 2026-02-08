<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


$c_id = $_GET['c_id'];

$getCartItems = mysqli_query($connect, "SELECT cart_tbl_qty.*,cart_tbl_qty.id AS cartID, qty_stock_purchase.id AS stockId, categories.category_name, categories.stock_available, categories.sell_price, qty_stock_purchase.* FROM `cart_tbl_qty`
INNER JOIN qty_stock_purchase ON qty_stock_purchase.c_id = cart_tbl_qty.product_id
INNER JOIN categories ON categories.id = qty_stock_purchase.c_id
WHERE cart_tbl_qty.c_id = '$c_id' AND cart_tbl_qty.sell_status = '0' GROUP BY cart_tbl_qty.product_id");

$count = mysqli_num_rows($getCartItems);

if (isset($_POST['makeInvoice'])) {
    $c_id = $_POST['c_id'];
    $arr_cart_id = $_POST['cart_id'];
    $arr_product_qty = $_POST['product_qty'];
    $arr_product_id = $_POST['product_id'];
    $arr_price = $_POST['price'];
    $arr_stockid = $_POST['stock_id'];
    // $arr_discount = $_POST['discount'];

    for ($i = 0; $i < sizeof($arr_cart_id); $i++) {
        $cart_id = $arr_cart_id[$i];
        $product_qty = $arr_product_qty[$i];
        $product_id = $arr_product_id[$i];
        $price = $arr_price[$i];

        $checkQuery = mysqli_query($connect, "SELECT * FROM qty_stock_purchase WHERE product_qty >= $product_qty AND c_id = '$product_id'");
        $fetch_checkQuery = mysqli_fetch_assoc($checkQuery);
        $StockIdUpdated = $fetch_checkQuery['id'];

        $stock_id = $StockIdUpdated;

        $updateQuery = mysqli_query($connect, "UPDATE cart_tbl_qty SET product_qty = '$product_qty', stock_id = '$stock_id', price = '$price' WHERE product_id = '$product_id' AND c_id = '$c_id' AND id = '$cart_id'");
    }

    if ($updateQuery) {
        // header("LOCATION: discount_page_cash_qty.php?c_id=" . $c_id . "");
        header("LOCATION: total_cash_qty.php?c_id=" . $c_id . "");
    }
}


include('../_partials/header.php');
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .form-control[readonly] {
        background-color: #ffffffff;
        opacity: 1;
    }
</style>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Products List (Quantity Based Sell)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <form method="POST">
                            <div class="row text-right">
                                <?php
                                if ($count < 1) {
                                    echo '<div class="col-12 mb-4">
                                    <a href="qty_sell.php?c_id='.$c_id.'" type="submit" style="width: 30%" class="btn btn-primary waves-effect waves-light btn-lg">Go Back</a>';
                                }else {
                                ?>
                                <div class="col-12 mb-4">
                                    <button type="submit" style="width: 30%" name="makeInvoice" class="btn btn-primary waves-effect waves-light btn-lg">Make Invoice</button>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 20%">Product</th>
                                        <th style="width: 20%">Price</th>
                                        <th style="width: 10%"></th>
                                        <th style="width: 25%">Qty</th>
                                        <th style="width: 10%" class="text-center"><i class="fa fa-trash"></i></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $iteration = 1;

                                    while ($rowCartItems = mysqli_fetch_assoc($getCartItems)) {
                                        echo '
                                        <tr class="rowCustom' . $iteration . '">
                                        <input type="hidden" name="cart_id[]" value="' . $rowCartItems['cartID'] . '" class="form-control" required>
                                        <input type="hidden" name="c_id" value="' . $c_id . '" class="form-control" required>
                                        <input type="hidden" name="stock_id[]" value="' . $rowCartItems['stockId'] . '" class="form-control" required>
                                        <input type="hidden" name="product_id[]" value="' . $rowCartItems['product_id'] . '" class="form-control" required>
                                            <td style="width: 5%">' . $iteration++ . '</td>

                                            <td style="width: 20%"><b>' . $rowCartItems['category_name'] . '</b></td>

                                            <td style="width: 20%">
                                                <input style="width: 120%; border: none; border-bottom: 2px solid green" value="' . $rowCartItems['sell_price'] . '" name="price[]" placeholder="Cost: ' . number_format($rowCartItems['cost_price']) . '" type="number" class="form-control" />
                                            </td>

                                            <td style="width: 10%"></td>

                                            <td style="width: 25%">
                                                <input style="width: 100%; border: none; border-bottom: 2px solid green" type="number" placeholder="Available in Stock: ' . $rowCartItems['stock_available'] . '"  class="form-control"  max="' . $rowCartItems['stock_available'] . '" min="1" id="product_qty" name="product_qty[]" onkeyup="if(this.value > ' . $rowCartItems['stock_available'] . ') this.value = null;" required>
                                            </td>

                                            <td style="width: 10%" class="text-center">
                                                <a href="delete_product_qty.php?c_id=' . $c_id . '&p_id=' . $rowCartItems['product_id'] . '&cart_id=' . $rowCartItems['cartID'] . '" class="btn btn-danger waves-effect waves-light"> Item <i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        ';
                                    }
                                                                                // <td style="width: 20%"><input style="width: 50%;border: none; border-bottom: 2px solid green" value="0" name="discount[]" placeholder="Discount" type="number" class="form-control" ></td>

                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
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

</body>

</html>