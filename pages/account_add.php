<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['addAccount'])) {

    $account_title = $_POST['account_title'];
    $bank_name = $_POST['bank_name'];
    $account_no = $_POST['account_no'];

    $countQuery = mysqli_query($connect, "SELECT COUNT(*) AS Account FROM `bank_accounts` WHERE bank_name = '$bank_name' AND account_no = '$account_no'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

    if ($fetch_countQuery['Account'] < 1) {
        $queryAddCustomer = mysqli_query(
            $connect,
            "INSERT INTO `bank_accounts`(
                `account_title`,
                 `bank_name`,
                   `account_no`
                ) VALUES (
                    '$account_title',
                     '$bank_name',
                        '$account_no'
            )
           "
        );

        if (!$queryAddCustomer) {
            $notAdded = '
                <div class="alert alert-danger text-center">
                    Account Not added!
                </div>
                ';
        } else {
            header("LOCATION: account_list.php");
        }
    } else {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Account already added!
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
                <h5 class="page-title">Add Account</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <h4 class="mb-4 page-title"><u>Account Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account Title</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="account_title" placeholder="Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name: UBL, Easy Paisa" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account No</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="account_no" placeholder="Account Number" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addAccount" class="btn btn-primary waves-effect waves-light">Add Account</button>
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