<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';

$p_id = $_GET['id'];
$getQuery = mysqli_query($connect, "SELECT * FROM `customer_pay` WHERE p_id = '$p_id'");
$fetchGetQuery = mysqli_fetch_assoc($getQuery);


if (isset($_POST['updatePayment'])) {
    $c_id = $_POST['c_id'];
    $paid_amount = $_POST['pay_amount'];
    $pay_date = $_POST['pay_date'];
    $p_id = $_POST['p_id'];
    $bill_no = $_POST['bill_no'];

    $getQueryUpdation = mysqli_query($connect, "SELECT * FROM `customer_pay` WHERE p_id = '$p_id'");
    $fetchGetQueryUpdation = mysqli_fetch_assoc($getQueryUpdation);

    $Oldtotal = $fetchGetQueryUpdation['total_amount'];
    $Oldpaid = $fetchGetQueryUpdation['paid_amount'];
    $Oldrem = $fetchGetQueryUpdation['remaining_amount'];

    $findDifference = $Oldpaid - $paid_amount;

    if ($findDifference > 0) {
        $updateCustomersPay = mysqli_query($connect, "UPDATE customer_pay SET paid_amount = (paid_amount - $findDifference), remaining_amount = (remaining_amount + $findDifference), pay_date = '$pay_date' WHERE p_id = '$p_id'");
        $updateCustomerTbl = mysqli_query($connect, "UPDATE customer_add SET total_paid = (total_paid - $findDifference), total_dues = (total_dues + $findDifference) WHERE v_id = '$v_id'");
        // $updateVendorSummary = mysqli_query($connect, "UPDATE vendor_summary SET paid_amount = (paid_amount - $findDifference), remaining_amount = (remaining_amount + $findDifference) WHERE v_id = '$v_id'");
    } else {
        if ($Oldpaid === $paid_amount) {
            $updateCustomersPay = mysqli_query($connect, "UPDATE customer_pay SET pay_date = '$pay_date' WHERE p_id = '$p_id' AND bill_no = '$bill_no'");
        } else {
            $findDifferenceAbs = abs($findDifference);
            $updateCustomersPay = mysqli_query($connect, "UPDATE customer_pay SET paid_amount = (paid_amount + $findDifferenceAbs), remaining_amount = (remaining_amount - $findDifferenceAbs), pay_date = '$pay_date' WHERE p_id = '$p_id'");
            $updateCustomerTbl = mysqli_query($connect, "UPDATE customer_add SET total_paid = (total_paid + $findDifferenceAbs), total_dues = (total_dues - $findDifferenceAbs) WHERE v_id = '$v_id'");
            // $updateVendorSummary = mysqli_query($connect, "UPDATE vendor_summary SET paid_amount = (paid_amount + $findDifferenceAbs), remaining_amount = (remaining_amount - $findDifferenceAbs) WHERE v_id = '$v_id'");
        }
    }

    if (!$updateCustomersPay) {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Payment Not Updated!
            </div>';
    } else {
        header("LOCATION: customer_pay_list.php");
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
                <h5 class="page-title">Customer Recovery (Edit)</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <input type="hidden" name="p_id" value="<?php echo $p_id ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $fetchGetQuery['customer_id'] ?>">

                                <label class="col-sm-2 col-form-label">Customer</label>
                                <div class="col-sm-10">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM customer_add");

                                    echo '<select class="form-control comp" id="customer_selection" name="c_id" required disabled>
                                    <option></option>
                                    ';

                                    while ($row = mysqli_fetch_assoc($getVendors)) {
                                        if ($fetchGetQuery['v_id'] === $row['v_id']) {
                                            echo '<option value="' . $row['c_id'] . '" selected>' . $row['customer_name'] . ' - 0' . $row['customer_contact'] . '</option>';
                                        } else {
                                            echo '<option value="' . $row['c_id'] . '">' . $row['customer_name'] . ' - 0' . $row['customer_contact'] . '</option>';
                                        }
                                    }

                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pay Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="<?php echo $fetchGetQuery['paid_amount'] ?>" id="paid_amount" name="pay_amount" placeholder="Pay Amount" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="pay_date" value="<?php echo $fetchGetQuery['pay_date'] ?>" placeholder="Date" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="updatePayment" class="btn btn-primary waves-effect waves-light">Edit Payment</button>
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
    // $('.comp').select2({
    //     placeholder: 'Select an option',
    //     allowClear: true

    // });

    $(document).ready(function() {
        $selectElement = $('.comp').select2({
            placeholder: "Please select vendor",
            allowClear: true
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var a = $('#customer_selection').val()
        $('#customer_selection').change(function() {
            var customer_selection = $(this).val()
            $.ajax({
                url: "get_vendor_data.php",
                method: "POST",
                data: {
                    customer: customer_selection
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