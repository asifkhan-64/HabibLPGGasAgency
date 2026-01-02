<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$c_id = $_GET['c_id'];


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Sell Stock</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-6 text-right">
                                <a href="cash_sell.php?c_id=<?php echo $c_id ?>" class="btn btn-primary waves-effect waves-light btn-lg p-5 my-5" style="font-size: 24px">Weight Sell</a>
                            </div>
                            <div class="col-sm-6 text-left">
                                <!-- <a href="cash_sell.php" class="btn btn-primary waves-effect waves-light btn-lg p-5" style="font-size: 24px">Cash Sell</a> -->
                                <a href="installement_sell.php?c_id=<?php echo $c_id ?>" class="btn btn-secondary waves-effect waves-light btn-lg p-5 my-5" style="font-size: 24px">Quantity Sell</a>
                            </div>
                        </div>
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