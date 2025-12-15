<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';

$customer = $_GET['id'];

$retCustomers = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE c_id = '$customer'");
$fetch_retCustomers = mysqli_fetch_assoc($retCustomers);


if (isset($_POST['updateCustomer'])) {
    $id = $_POST['id'];

    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_address = $_POST['customer_address'];

    $countQuery = mysqli_query($connect, "SELECT COUNT(*) AS customers FROM `customer_add` WHERE customer_contact = '$customer_contact'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

    if ($fetch_countQuery['customers'] < 1) {
        $queryUpdateCustomer = mysqli_query(
            $connect,
            "UPDATE `customer_add` SET `customer_name` = '$customer_name', `customer_contact` = '$customer_contact', `customer_address` = '$customer_address' WHERE c_id = '$id'
           "
        );

        if (!$queryUpdateCustomer) {
            $notAdded = '
                <div class="alert alert-danger text-center">
                    Customer Not Updated!
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
                <h5 class="page-title">Edit Customer</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">

                            <input type="hidden" name="id" value="<?php echo $customer ?>">
                            <h4 class="mb-4 page-title"><u>Customer Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="customer_name" placeholder="Name" required="" value="<?php echo $fetch_retCustomers['customer_name'] ?>">
                                </div>

                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="customer_contact" placeholder="Contact" required="" value="<?php echo "0" . $fetch_retCustomers['customer_contact'] ?>">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Shop Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="customer_address" placeholder="Shop Address" required="" value="<?php echo $fetch_retCustomers['customer_address'] ?>">
                                </div>
                            </div>

                            <hr />

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="updateCustomer" class="btn btn-primary waves-effect waves-light">Update Customer</button>
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