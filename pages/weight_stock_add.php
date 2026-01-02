<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['addStock'])) {

    $v_id = $_POST['v_id'];
    $c_id = $_POST['c_id'];
    $product_qty = $_POST['product_qty'];
    $purchase_date = $_POST['purchase_date'];
    $cost_price = $_POST['cost_price'];
    $cash_price = $_POST['cash_price'];
    $installment_price = $_POST['installment_price'];
    $bill_no = $_POST['bill_no'];

    $queryAddStock = mysqli_query(
        $connect,
        "INSERT INTO `stock_purchase`(
                `v_id`,
                 `c_id`,
                  `product_qty`,
                   `purchase_date`,
                    `cost_price`,
                     `cash_price`,
                      `installment_price`,
                       `bill_no`
                ) VALUES (
                    '$v_id',
                     '$c_id',
                      '$product_qty',
                       '$purchase_date',
                        '$cost_price',
                         '$cash_price',
                          '$installment_price',
                           '$bill_no'
            )
           "
    );

    if (!$queryAddStock) {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Stock Not added!
            </div>';
    } else {
        header("LOCATION: stock_list.php");
    }
}


include('../_partials/header.php')
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Add Stock</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <h4 class="mb-4 page-title"><u>Purchase Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Vendor</label>
                                <div class="col-sm-10">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM vendor_tbl");

                                    echo '<select class="form-control comp" name="v_id" required>';
                                    while ($row = mysqli_fetch_assoc($getVendors)) {
                                        echo '<option value="' . $row['v_id'] . '">' . $row['vendor_name'] . ' - 0' . $row['vendor_contact'] . '</option>';
                                    }

                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product</label>
                                <div class="col-sm-4">
                                    <?php
                                    $getCats = mysqli_query($connect, "SELECT * FROM categories");

                                    echo '<select class="form-control comp" name="c_id" required>';
                                    while ($row = mysqli_fetch_assoc($getCats)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="product_qty" placeholder="Product Qty" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="purchase_date" placeholder="Purshase Date" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Cost Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="cost_price" placeholder="Cost Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cash Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="cash_price" placeholder="Cash Price" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Installment / M</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="installment_price" placeholder="Installment / Monthly" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bill No.</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="bill_no" placeholder="Bill No" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addStock" class="btn btn-primary waves-effect waves-light">Add Stock</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <h3>
                        <?php echo $notAdded; ?>
                    </h3>
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
<!-- App js -->
<?php include('../_partials/app.php') ?>
<?php include('../_partials/datetimepicker.php') ?>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });
</script>

<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
    $('.comp').select2({
        placeholder: 'Select an option',
        allowClear: true

    });
</script>
</body>

</html>