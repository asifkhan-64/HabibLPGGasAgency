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
    $cylinder_id = $_POST['cylinder_id'];
    $rec_rem_cylinders = $_POST['rec_rem_cylinders'];
    $remaining_cylinders = $_POST['remaining_cylinders'];

    $getCylinderType = mysqli_query($connect, "SELECT * FROM `cylinder_types` WHERE cylinder_id = '$cylinder_id'");
    $fetchType = mysqli_fetch_assoc($getCylinderType);
    $cylinder_type = $fetchType['cylinder_type'];

    $column_name = strtolower(str_replace(' ', '_', $cylinder_type));
    $column_name_db = preg_replace('/[^a-z0-9_]/', '', $column_name);

    $getQty = mysqli_query($connect, "SELECT `$column_name`, other_cylinders FROM `customer_add` WHERE c_id = '$c_id'");
    $fetchQty = mysqli_fetch_assoc($getQty);
    $qty = $fetchQty[$column_name_db];
    $other = $fetchQty['other_cylinders'];

    

    if ($remaining_cylinders < 0) {
        $notAdded = "
            <div class='alert alert-danger text-center'>
                Recovery Not Added! Remaining Qty can't be negative! 
            </div>";
    } else {

        $updateCustomerAdd = mysqli_query($connect, "UPDATE `customer_add` SET `$column_name_db` = '$qty' + '$rec_rem_cylinders', other_cylinders = '$other' - '$rec_rem_cylinders' WHERE c_id = '$c_id'");

        $queryAddPayment = mysqli_query(
            $connect,
            "INSERT INTO `cylinder_type_add`(
                `c_id`,
                 `cylinder_type`,
                  `qty`
                ) VALUES (
                    '$c_id',
                     '$cylinder_id',
                      '$rec_rem_cylinders'
            )");

        if (!$queryAddPayment) {

            $notAdded = '
            <div class="alert alert-danger text-center">
                Payment Not Added!
            </div>';
        } else {
        //     $queryUpdateCustomerTblBalance = mysqli_query($connect, "UPDATE customer_add SET remaining_cylinders = (remaining_cylinders - $rec_rem_cylinders) WHERE c_id = '$c_id'");


            // if (!$queryUpdateCustomerTblBalance) {
                $notAdded = '
                <div class="alert alert-danger text-center">
                    Customer Record Not Updated!
                </div>';
            // } else {
                header("LOCATION: cylinders_list_customers.php");
            // }
        }
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
                <h5 class="page-title">Add Rem Cylinder (Customer)</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer</label>
                                <?php 
                                ?>
                                <div class="col-sm-4">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM customer_add WHERE other_cylinders > 0 ");

                                    // <select class="form-control comp" id="customer_selection vendorId" name="v_id" required>
                                    echo '
                                    <select class="form-control comp" id="customerId" name="c_id" required>
                                    <option></option>
                                    ';

                                    while ($row = mysqli_fetch_assoc($getVendors)) {
                                        echo '<option value="' . $row['c_id'] . '">' . $row['customer_name'] . ' - 0' . $row['customer_contact'] . '</option>';
                                    }

                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Uncategorized Cylinders</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="total_rem_cylinders" id="rem_dues" readonly placeholder="Total Cylinders" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cylinder Type</label>
                                <div class="col-sm-4">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM `cylinder_types`");

                                    // <select class="form-control comp" id="customer_selection vendorId" name="v_id" required>
                                    echo '
                                    <select class="form-control compe" name="cylinder_id" required>
                                    <option></option>
                                    ';

                                    while ($row = mysqli_fetch_assoc($getVendors)) {
                                        echo '<option value="' . $row['cylinder_id'] . '">' . $row['cylinder_type'] . '</option>';
                                    }

                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Rem Quantity</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="paid_amount" name="rec_rem_cylinders" placeholder="Receive Cylinders" required="">
                                </div>

                                
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Rem Uncategorized</label>
                                <div class="col-sm-4">
                                    <input type="number" readonly class="form-control" name="remaining_cylinders" id="remaining_amount" placeholder="Remaining Cylinder" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addRecovery" class="btn btn-primary waves-effect waves-light">Add Rem Cylinder</button>
                                </div>
                            </div>

                        </form>
                        <h3><?php echo $notAdded; ?></h3>
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
    // $('.comp').select2({
    //     placeholder: 'Select an option',
    //     allowClear: true

    // });

    $(document).ready(function() {
        $selectElement = $('.comp').select2({
            placeholder: "Please select an option",
            allowClear: true
        });
    });
    $(document).ready(function() {
        $selectElement = $('.compe').select2({
            placeholder: "Please select an option",
            allowClear: true
        });
    });

    $(document).ready(function() {
        $selectElement = $('.select3').select2({
            placeholder: "Please select an option",
            allowClear: true
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = $('#customerId').val()
        console.log($('#customerId').val())
        $('#customerId').change(function() {
            var customerId = $(this).val()
            $.ajax({
                url: "get_customer_other_cylinders.php",
                method: "POST",
                data: {
                    customerId: customerId
                },
                dataType: "text",
                success: function(response) {
                    // console.log(response)
                    $('#rem_dues').val(response)
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });
    });



    $(document).ready(function() {
        $('#paid_amount').val('0')
        $('#remaining_amount').val('0')

        $('#paid_amount').keyup(function() {
            if (isNaN($(this).val()))
                return
            var paidAmount = parseFloat($(this).val())
            var oldDues = parseInt($('#rem_dues').val())
            console.log(paidAmount)
            var remainingAmount = oldDues - paidAmount
            $('#remaining_amount').val(remainingAmount)
            $('#remainingAmount').keyup(function() {
                $(this).val("")
                $('#remaining_amount').val("")
            });
        });
    });
</script>



</body>

</html>