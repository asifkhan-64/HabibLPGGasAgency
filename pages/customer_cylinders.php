<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';

if (isset($_POST['addRecovery'])) {
    $c_id = $_POST['c_id'];
    $total_rem_cylinders = $_POST['total_rem_cylinders'];
    $rec_rem_cylinders = $_POST['rec_rem_cylinders'];
    $remaining_cylinders = $_POST['remaining_cylinders'];
    $recover_date = $_POST['recover_date'];
    $cylinder_id = $_POST['cylinder_id'];

    $getCylinderType = mysqli_query($connect, "SELECT * FROM `cylinder_types` WHERE cylinder_id = '$cylinder_id'");
    $fetchType = mysqli_fetch_assoc($getCylinderType);
    $cylinder_type = $fetchType['cylinder_type'];

    $column_name = strtolower(str_replace(' ', '_', $cylinder_type));
    $column_name_db = preg_replace('/[^a-z0-9_]/', '', $column_name);

    $getQty = mysqli_query($connect, "SELECT `$column_name`, other_cylinders FROM `customer_add` WHERE c_id = '$c_id'");
    $fetchQty = mysqli_fetch_assoc($getQty);
    $qty = $fetchQty[$column_name_db];
    $other = $fetchQty['other_cylinders'];
    
    // Safety check for negative values on server side
    if ($remaining_cylinders < 0) {
        $notAdded = "
            <div class='alert alert-danger text-center'>
                Recovery Not Added! Remaining Qty can't be negative! 
            </div>";
    } else {
        $queryAddPayment = mysqli_query(
            $connect,
            "INSERT INTO `cylinder_recovery`(
                `customer_id`,
                 `total_cylinders`,
                  `recovered_cylinders`,
                   `remaining_cylinders`,
                     `recover_date`,
                      `cylinder_id`
                ) VALUES (
                    '$c_id',
                     '$total_rem_cylinders',
                      '$rec_rem_cylinders',
                       '$remaining_cylinders',
                         '$recover_date',
                            '$cylinder_id'
            )"
        );

        if (!$queryAddPayment) {
            $notAdded = '
            <div class="alert alert-danger text-center">
                Recovery Not Added!
            </div>';
        } else {
            $queryUpdateCustomerTblBalance = mysqli_query($connect, "UPDATE customer_add SET remaining_cylinders = (remaining_cylinders - $rec_rem_cylinders), `$column_name_db` = '$qty' - '$rec_rem_cylinders' WHERE c_id = '$c_id'");

            if (!$queryUpdateCustomerTblBalance) {
                $notAdded = '
                <div class="alert alert-danger text-center">
                    Customer Record Not Updated!
                </div>';
            } else {
                header("LOCATION: customer_cylinder_list.php");
            }
        }
    }
}

include('../_partials/header.php')
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Customer Recovery (Cylinders)</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer</label>
                                <div class="col-sm-4">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM customer_add WHERE remaining_cylinders > 0");
                                    echo '<select class="form-control comp" id="customerId" name="c_id" required>
                                    <option></option>';
                                    while ($row = mysqli_fetch_assoc($getVendors)) {
                                        echo '<option value="' . $row['c_id'] . '">' . $row['customer_name'] . ' - 0' . $row['customer_contact'] . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Cylinder Type</label>
                                <div class="col-sm-4">
                                    <?php
                                    $getTypes = mysqli_query($connect, "SELECT * FROM `cylinder_types`");
                                    echo '<select class="form-control compe" id="cylinderId" name="cylinder_id" required>
                                    <option></option>';
                                    while ($row = mysqli_fetch_assoc($getTypes)) {
                                        echo '<option value="' . $row['cylinder_id'] . '">' . $row['cylinder_type'] . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cylinders (Dues)</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="total_rem_cylinders" id="rem_dues" readonly placeholder="Total Cylinders" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Receive Cylinders</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="paid_amount" name="rec_rem_cylinders" placeholder="Receive Cylinders" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Remaining Cylinders</label>
                                <div class="col-sm-4">
                                    <input type="number" readonly class="form-control" name="remaining_cylinders" id="remaining_amount" placeholder="Remaining Cylinder" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="recover_date" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" id="submitBtn" name="addRecovery" class="btn btn-primary waves-effect waves-light">Recover Cylinder</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h3><?php echo $notAdded; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../_partials/footer.php') ?>
<?php include('../_partials/jquery.php') ?>
<?php include('../_partials/app.php') ?>
<?php include('../_partials/datetimepicker.php') ?>

<script type="text/javascript" src="../assets/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2
        $('.comp').select2({ placeholder: "Select Customer", allowClear: true });
        $('.compe').select2({ placeholder: "Select Cylinder Type", allowClear: true });

        // Helper function to handle button state
        function checkDuesAndDisable() {
            var dues = parseFloat($('#rem_dues').val()) || 0;
            if (dues <= 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        }

        // 1. When Customer changes, reset Cylinder Type and disable button
        $('#customerId').on('select2:select', function (e) {
            $('#cylinderId').val(null).trigger('change');
            $('#rem_dues').val('');
            $('#paid_amount').val('0');
            $('#remaining_amount').val('0');
            $('#submitBtn').prop('disabled', true);
        });

        // 2. When Cylinder Type changes, fetch dues via AJAX
        $('#cylinderId').change(function() {
            var cylinderId = $(this).val();
            var customerId = $('#customerId').val();
            
            if(cylinderId && customerId) {
                $.ajax({
                    url: "get_customer_cylinders.php",
                    method: "POST",
                    data: { customerId: customerId, cylinderId: cylinderId },
                    dataType: "text",
                    success: function(response) {
                        $('#rem_dues').val(response);
                        $('#paid_amount').val('0');
                        $('#remaining_amount').val(response);
                        checkDuesAndDisable(); // Check if we should disable button
                    }
                });
            }
        });

        // 3. Math calculation for remaining amount
        $('#paid_amount').on('keyup change', function() {
            var oldDues = parseFloat($('#rem_dues').val()) || 0;
            var paidAmount = parseFloat($(this).val()) || 0;
            
            var remaining = oldDues - paidAmount;
            $('#remaining_amount').val(remaining);

            // Additional check: disable if they try to recover more than they have
            if (remaining < 0 || oldDues <= 0) {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        });

        // Run once on load
        checkDuesAndDisable();
    });
</script>
</body>
</html>