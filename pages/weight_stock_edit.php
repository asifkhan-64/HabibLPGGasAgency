<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';

$id = $_GET['id'];
$getProduct = mysqli_query($connect, "SELECT * FROM weight_stock_purchase WHERE id = '$id'");
$fetchGetProducts = mysqli_fetch_assoc($getProduct);

if (isset($_POST['updateStock'])) {
    $v_id = $_POST['v_id'];
    $c_id = $_POST['c_id'];
    $product_qty = $_POST['product_qty'];
    $total_purchase_amount = $_POST['total_purchase_amount'];
    $cost_price = $_POST['cost_price'];
    $retail_price = $_POST['retail_price'];
    $purchase_date = $_POST['purchase_date'];


    $getOldData = mysqli_query($connect, "SELECT * FROM weight_stock_purchase WHERE id = '$id'");
    $fetchOldData = mysqli_fetch_assoc($getOldData);

    

    if ($fetchOldData['product_qty'] < $product_qty) {
        $oldQty = $fetchOldData['product_qty'];
        $differenceQty = $product_qty - $oldQty;


        $updateQuery = mysqli_query(
            $connect,
            "UPDATE weight_stock_purchase SET 
                v_id = '$v_id',
                c_id = '$c_id',
                product_qty = product_qty + '$differenceQty',
                total_purchase_amount = '$total_purchase_amount',
                cost_price = '$cost_price',
                retail_price = '$retail_price',
                purchase_date = '$purchase_date'
             WHERE id = '$id'"
        );

        $updateCategoryTbl = mysqli_query($connect, "UPDATE categories SET stock_available = stock_available + '$differenceQty' WHERE id = '$c_id'");
        
    }else {
        $oldQty = $fetchOldData['product_qty'];
        $differenceQty =  $oldQty - $product_qty;

        $updateQuery = mysqli_query(
            $connect,
            "UPDATE weight_stock_purchase SET 
                v_id = '$v_id',
                c_id = '$c_id',
                product_qty = product_qty - '$differenceQty',
                total_purchase_amount = '$total_purchase_amount',
                cost_price = '$cost_price',
                retail_price = '$retail_price',
                purchase_date = '$purchase_date'
             WHERE id = '$id'"
        );

        $updateCategoryTbl = mysqli_query($connect, "UPDATE categories SET stock_available = stock_available - '$differenceQty' WHERE id = '$c_id'");
    }

   

    if (!$updateQuery) {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Stock Not added!
            </div>';
    } else {
        header("LOCATION: weight_stock_list.php");
    }
}


include('../_partials/header.php');
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Edit Stock (Weight Based)</h5>
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
                                        if ($fetchGetProducts['v_id'] === $row['v_id']) {
                                            echo '<option value="' . $row['v_id'] . '" selected>' . $row['vendor_name'] . ' - 0' . $row['vendor_contact'] . '</option>';
                                        } else {
                                            echo '<option value="' . $row['v_id'] . '">' . $row['vendor_name'] . ' - 0' . $row['vendor_contact'] . '</option>';
                                        }
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
                                    $getCats = mysqli_query($connect, "SELECT * FROM categories WHERE category_type = 'Weight'");

                                    echo '<select class="form-control comp" name="c_id" required>';
                                    while ($row = mysqli_fetch_assoc($getCats)) {
                                        if ($row['id'] === $fetchGetProducts['c_id']) {
                                            echo '<option value="' . $row['id'] . '" selected>' . $row['category_name'] . '</option>';
                                        } else {
                                            echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Weight/Liters</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="<?php echo $fetchGetProducts['product_qty']; ?>" id="total_quantity" name="product_qty" placeholder="Product Qty" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="total_purchase_amount" value="<?php echo $fetchGetProducts['total_purchase_amount']; ?>" id="total_purchase_amount" placeholder="Total Purchase Amount" required="">
                                </div>
                                

                                <label class="col-sm-2 col-form-label">Cost Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="cost_price" value="<?php echo $fetchGetProducts['cost_price']; ?>" id="unit_cost_price" readonly placeholder="Cost Price" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Retail Price</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="retail_price" value="<?php echo $fetchGetProducts['retail_price']; ?>" placeholder="Retail Price" required="">
                                </div>

                                
                                <label class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="purchase_date" value="<?php echo $fetchGetProducts['purchase_date']; ?>" placeholder="Purchase Date" required="">
                                </div>
                            </div>


                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="updateStock" class="btn btn-primary waves-effect waves-light">Update Stock</button>
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

    // Selecting the relevant input fields
    const quantityInput = document.querySelector('input[placeholder="Product Qty"]');
    // Assuming the first "Cost Price" field is where you enter the total 50,000
    // and the second one is where you want the unit price to appear.
    // I will use IDs for clarity in the logic below:

    const totalAmountInput = document.getElementById('total_purchase_amount'); // The 50,000 field
    const qtyInput = document.getElementById('total_quantity');               // The 50 field
    const costPriceInput = document.getElementById('unit_cost_price');         // The result field

    const calculateUnitCost = () => {
        const totalAmount = parseFloat(totalAmountInput.value);
        const quantity = parseFloat(qtyInput.value);

        if (totalAmount > 0 && quantity > 0) {
            // Calculation: Total / Quantity
            const unitCost = totalAmount / quantity;
            
            // Display with 2 decimal places
            costPriceInput.value = unitCost.toFixed(2);
        } else {
            costPriceInput.value = '';
        }
    };

    // Adding the event listeners for real-time calculation
    totalAmountInput.addEventListener('keyup', calculateUnitCost);
    qtyInput.addEventListener('keyup', calculateUnitCost);
</script>


</body>

</html>