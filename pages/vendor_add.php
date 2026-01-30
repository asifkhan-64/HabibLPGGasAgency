<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['addVendor'])) {
    $vendor_name = $_POST['vendor_name'];
    $vendor_contact = $_POST['vendor_contact'];
    $vendor_address = $_POST['vendor_address'];
    $vendor_bank = $_POST['vendor_bank'];
    $vendor_account = $_POST['vendor_account'];
    $vendor_dues = $_POST['vendor_dues'];


    $countQuery = mysqli_query($connect, "SELECT COUNT(*) AS Vendors FROM `vendor_tbl` WHERE vendor_contact = '$vendor_contact'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

    if ($fetch_countQuery['Vendors'] < 1) {
        $queryAddVendor = mysqli_query(
            $connect,
            "INSERT INTO `vendor_tbl`(
                `vendor_name`,
                 `vendor_contact`,
                  `vendor_address`,
                   `vendor_bank`,
                    `vendor_account`,
                     `total_dues`,
                      `total_sale`
                ) VALUES (
                    '$vendor_name',
                     '$vendor_contact',
                      '$vendor_address',
                        '$vendor_bank',
                         '$vendor_account',
                            total_dues + '$vendor_dues',
                            total_sale + '$vendor_dues'
            )
           "
        );

        if (!$queryAddVendor) {
            $notAdded = '
                <div class="alert alert-danger text-center">
                    Vendor Not added!
                </div>
                ';
        } else {
            header("LOCATION: vendors_list.php");
        }
    } else {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Vendor Contact already added!
            </div>
            ';
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
                <h5 class="page-title">Add Vendor</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <h4 class="mb-4 page-title"><u>Vendor Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="vendor_name" placeholder="Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="vendor_contact" placeholder="Contact" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="vendor_address" placeholder="Address" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Bank</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="vendor_bank" placeholder="Bank: UBL, MCB etc." required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Account No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="vendor_account" placeholder="Account Number" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Dues</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="vendor_dues" placeholder="Dues" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addVendor" class="btn btn-primary waves-effect waves-light">Add Vendor</button>
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