<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['getVId'])) {
    $v_id = $_POST['v_id'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    header("LOCATION: vendor_report_print.php?v_id=$v_id&start=$start&end=$end");
    
}


include('../_partials/header.php')
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Vendor Report</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
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

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date Range</label>
                                <div class="col-sm-10">
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="date" class="form-control" name="start" placeholder="Start Date" />
                                        <input type="date" class="form-control" name="end" placeholder="End Date" />
                                    </div>
                                </div>
                            </div>



                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="getVId" class="btn btn-primary waves-effect waves-light">Generate Report</button>
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