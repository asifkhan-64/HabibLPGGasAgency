<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['addPayment'])) {
    $c_id = $_POST['c_id'];
    $total_amount = $_POST['total_amount'];
    $paid_amount = $_POST['pay_amount'];
    $remaining_amount = $_POST['remaining_amount'];
    $pay_date = $_POST['pay_date'];

    if ($remaining_amount < 0) {
        $notAdded = "
            <div class='alert alert-danger text-center'>
                Payment Not Added! Remaining Amount can't be negative! 
            </div>";
    } else {
        $queryAddPayment = mysqli_query(
            $connect,
            "INSERT INTO `customer_pay`(
                `customer_id`,
                 `total_amount`,
                  `paid_amount`,
                   `remaining_amount`,
                     `pay_date`
                ) VALUES (
                    '$c_id',
                     '$total_amount',
                      '$paid_amount',
                       '$remaining_amount',
                         '$pay_date'
            )
           "
        );



        if (!$queryAddPayment) {

            $notAdded = '
            <div class="alert alert-danger text-center">
                Payment Not Added!
            </div>';
        } else {
            $queryUpdateCustomerTblBalance = mysqli_query($connect, "UPDATE customer_add SET total_paid = (total_paid + $paid_amount), total_dues = (total_dues - $paid_amount) WHERE c_id = '$c_id'");
            // $updateCustomerSummary = mysqli_query($connect, "UPDATE vendor_summary SET paid_amount = (paid_amount + $paid_amount), remaining_amount = (remaining_amount - $paid_amount) WHERE v_id = '$v_id' AND bill_no = '$bill_no'");


            if (!$queryUpdateCustomerTblBalance) {
                $notAdded = '
                <div class="alert alert-danger text-center">
                    Customer Table Balance Not Updated!
                </div>';
            } else {
                header("LOCATION: customer_pay_list.php");
            }
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
                <h5 class="page-title">Customer Recovery</h5>
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
                                <div class="col-sm-4">
                                    <?php
                                    $getVendors = mysqli_query($connect, "SELECT * FROM customer_add");

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


                            </div>

                            <hr />

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Total Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="total_amount" id="rem_dues" readonly placeholder="Total Amount" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Pay Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="paid_amount" name="pay_amount" placeholder="Pay Amount" required="">
                                </div>


                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Remaining Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" readonly class="form-control" name="remaining_amount" id="remaining_amount" placeholder="Remaining Amount" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="pay_date" placeholder="Date" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addPayment" class="btn btn-primary waves-effect waves-light">Add Payment</button>
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
        $('#customerId').change(function() {
            var customerId = $(this).val()
            $.ajax({
                url: "get_customer_data.php",
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
        var a = $('#customerId').val()
        $('#customerId').change(function() {
            var customerId = $(this).val()
            $.ajax({
                url: "get_customer_data.php",
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



<script type="text/javascript">
    $(document).ready(function() {
        $('#vendorId').change(function() {
            var vendorId = $(this).val();
            $.ajax({
                url: "get_amount.php",
                method: "POST",
                data: {
                    vendor: vendorId
                },
                dataType: "text",
                success: function(data) {
                    $('#billNo').html(data);
                    console.log(data);
                    // $('#phone_model').html(data);
                }
            });
        });
    });
</script>
</body>

</html>