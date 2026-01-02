<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


$c_id = $_GET['c_id'];
$p_id = $_GET['p_id'];
$cart_id = $_GET['cart_id'];

$getCartItems = mysqli_query($connect, "SELECT cart_tbl_qty.*,cart_tbl_qty.id AS cartID, qty_stock_purchase.*, categories.category_name FROM `cart_tbl_qty`
INNER JOIN qty_stock_purchase ON qty_stock_purchase.c_id = cart_tbl_qty.product_id
INNER JOIN categories ON categories.id = qty_stock_purchase.c_id
WHERE cart_tbl_qty.c_id = '$c_id' AND cart_tbl_qty.product_id = '$p_id' AND cart_tbl_qty.sell_status = '0'");


$rowCartItems = mysqli_fetch_assoc($getCartItems);

if (isset($_POST['delete'])) {
    $product_id = $_POST['product_id'];
    $cart_id = $_POST['cart_id'];
    $c_id = $_POST['c_id'];


    $deleteQuery = mysqli_query($connect, "DELETE FROM `cart_tbl_qty` WHERE id = '$cart_id' AND product_id = '$product_id'");
    if (!$deleteQuery) {
        $error = 'Not Removed! Try again!';
    } else {
        header("LOCATION: amount_cash_qty.php?c_id=" . $c_id . "");
    }
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Delete Product From Cart!</h5>
            </div>
        </div>

        <form method="POST">
            <input type="hidden" value="<?php echo $p_id ?>" name="product_id">
            <input type="hidden" value="<?php echo $cart_id ?>" name="cart_id">
            <input type="hidden" value="<?php echo $c_id ?>" name="c_id">
            <div class="row ">
                <div class="col-12 p-5">
                    <div class="card m-b-30">
                        <div class="card-body text-center">
                            <h3>Delete Product!</h3>
                            <hr>
                            <p>Are you sure want to delete this item from cart!</p>
                            <p><b>Item: <?php echo $rowCartItems['category_name']; ?></b></p>
                            <hr>
                            <button type="submit" name="delete" class="btn btn-danger waves-effect waves-light">Delete Item</button>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </form>
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