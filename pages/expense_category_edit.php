<?php
include '../_stream/config.php';
session_start();
if (empty($_SESSION["user"])) {
	header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

$id = $_GET['id'];
$retExpenseCat = mysqli_query($connect, "SELECT * FROM expense_category WHERE id = '$id'");
$fetch_retData = mysqli_fetch_assoc($retExpenseCat);
$expenseCat = $fetch_retData['expense_name'];

if (isset($_POST['updateExpense'])) {
	$id = $_POST['id'];
	$nameCategory = $_POST['nameCategory'];

	$countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedExpenseCat FROM expense_category WHERE expense_name = '$nameCategory'");
	$fetch_countQuery = mysqli_fetch_assoc($countQuery);

	if ($fetch_countQuery['countedExpenseCat'] == 0) {
		$updateQuery = mysqli_query($connect, "UPDATE expense_category SET expense_name = '$nameCategory' WHERE id = '$id'");
		if (!$updateQuery) {
			$error = 'Not Added! Try agian!';
		} else {
			header("LOCATION:expense_category_new.php");
		}
	} else {
		$alreadyAdded = '<div class="alert alert-dark" role="alert">
                                Already Added!
                             </div>';
	}
}

include '../_partials/header.php';
?>
<style type="text/css">
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css"rel="stylesheet"type="text/css">
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Expense Category</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" value="<?php echo $expenseCat ?>" placeholder="Category" type="text" id="example-text-input"  name="nameCategory"  required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateExpense">Update Category</button>
                                </div>
                            </div>
                        </form>
                        <h5><?php echo $error ?></h5>
                        <h5><?php echo $added ?></h5>
                        <h5><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>

            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- Required datatable js -->
<?php include '../_partials/datatable.php'?>
<!-- Datatable init js -->
<?php include '../_partials/datatableInit.php'?>
<!-- Buttons examples -->
<?php include '../_partials/buttons.php'?>
<!-- App js -->
<?php include '../_partials/app.php'?>
<!-- Responsive examples -->
<?php include '../_partials/responsive.php'?>
<!-- Sweet-Alert  -->
<?php include '../_partials/sweetalert.php'?>
</body>

</html>