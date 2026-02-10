<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$id = $_GET['id'];
$getCustomer = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE c_id = '$id'");
$rowCustomer = mysqli_fetch_assoc($getCustomer);

if (isset($_POST['delete_customer'])) {
    $customer_id = $_POST['customer_id'];
    $updateQuery = mysqli_query($connect, "UPDATE `customer_add` SET customer_status = '1' WHERE c_id = '$customer_id'");
    
    if ($updateQuery) {
        header("LOCATION: customers_list.php");
    }
    
}

include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Re-Add Customer</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center">Are you sure you want to re-add this customer?</h4> <hr />
                                <p><b>Name: </b><?php echo $rowCustomer['customer_name'] ?></p>
                                <p><b>Contact: </b>0<?php echo $rowCustomer['customer_contact'] ?></p>
                                <p><b>Address: </b><?php echo $rowCustomer['customer_address'] ?></p>
                                <p><b>Remaining Cylinders: </b><?php echo $rowCustomer['remaining_cylinders'] ?></p>
                                <p><b>Dues: </b><?php echo $rowCustomer['total_dues'] ?></p>
                                <hr />
                            </div>
                        </div>
                        <form method="POST">
                        <input type="hidden" name="customer_id" value="<?php echo $id ?>">
                        <div class="form-group row">
                            <div class="col-sm-6 text-right">
                                <a class="btn btn-secondary waves-effect waves-light btn-lg " name="cancel" type="submit" style="font-size: 24px; color: white" onclick="history.back(-1)">Cancel</a>
                            </div>

                            <div class="col-sm-6 text-left">
                                <button class="btn btn-primary waves-effect waves-light btn-lg  " style="font-size: 24px" name="delete_customer">Re-Add</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div> <!-- end col -->
            <div class="col-3"></div>
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
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>
</body>

</html>