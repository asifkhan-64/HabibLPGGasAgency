<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';


if (isset($_POST['addCustomer'])) {

    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];
    $customer_dues = $_POST['customer_dues'];

    $countQuery = mysqli_query($connect, "SELECT COUNT(*) AS customers FROM `customer_add` WHERE customer_contact = '$customer_contact'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

    if ($fetch_countQuery['customers'] < 1) {
        $queryAddCustomer = mysqli_query(
            $connect,
            "INSERT INTO `customer_add`(
                `customer_name`,
                 `customer_contact`,
                   `customer_address`,
                    `total_dues`
                ) VALUES (
                    '$customer_name',
                     '$customer_contact',
                        '$customer_address',
                            '$customer_dues'
            )
           "
        );

        if (!$queryAddCustomer) {
            $notAdded = '
                <div class="alert alert-danger text-center">
                    Customer Not added!
                </div>
                ';
        } else {
            header("LOCATION: customers_list.php");
        }
    } else {
        $notAdded = '
            <div class="alert alert-danger text-center">
                Customer Contact already added!
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
                <h5 class="page-title">Add Customer</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <h4 class="mb-4 page-title"><u>Customer Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="customer_name" placeholder="Name" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="customer_contact" placeholder="Contact" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="customer_address" placeholder="Address" required="">
                                </div>
                                
                                <label class="col-sm-2 col-form-label">Dues</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="customer_dues" placeholder="Dues" required="">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addCustomer" class="btn btn-primary waves-effect waves-light">Add Customer</button>
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