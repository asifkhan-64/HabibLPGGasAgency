<?php
include '../_stream/config.php';
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


$userAlreadyinDatabase = '';
$expenseNotAdded = '';

if (isset($_POST["addExpense"])) {
	$expenseCategory = $_POST['expenseCategory'];
	$expenseAmount = $_POST['expenseAmount'];
	$expenseDate = $_POST['expenseDate'];
	$expenseDescription = $_POST['expenseDescription'];
    $paymentBy = $_POST['paymentBy'];

	$createUser = mysqli_query($connect, "INSERT INTO expense(cat_id, expense_amount, expense_date, expense_description, payment_by)VALUES('$expenseCategory', '$expenseAmount', '$expenseDate', '$expenseDescription', '$paymentBy')");

	if (!$createUser) {
		$expenseNotAdded = "Expense not added! Try Again.";
	} else {
		header("LOCATION:expense_list.php");
	}
}

include '../_partials/header.php'
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Expenses</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Add Expenses</h4>
                        <form method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-4">
                                <?php
                                $selectExpenseCat = mysqli_query($connect, "SELECT * FROM expense_category");
                                    $optionsCategory = '<select class="form-control designation" name="expenseCategory" required="" style="width:100%">';
                                      while ($rowCat = mysqli_fetch_assoc($selectExpenseCat)) {
                                        $optionsCategory.= '<option value='.$rowCat['id'].'>'.$rowCat['expense_name'].'</option>';
                                      }
                                    $optionsCategory.= "</select>";
                                echo $optionsCategory;
                                ?>
                                </div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="number" placeholder="Amount" name="expenseAmount" id="example-text-input" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input class="form-control " type="date" name="expenseDate" placeholder="dd/mm/yyyy-hh:mm" required="">
                                        <!-- <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div> -->
                                    </div>
                                </div>

                               
                                <label for="example-text-input" class="col-sm-2 col-form-label">Payment By</label>
                                <div class="col-sm-4">
                                    <?php
                                    

                                    echo '<select class="form-control payment" name="paymentBy" required>
                                    <option></option>';
                                    echo '<option value="Cash">Cash</option>';
                                    echo '<option value="Online">Online</option>';

                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                           

                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea id="textarea" class="form-control" maxlength="225" rows="3" name="expenseDescription" placeholder="Expense Description" required=""></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" name="addExpense" class="btn btn-primary waves-effect waves-light">Add Expense</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h3 align="center">
                    <?php echo $userAlreadyinDatabase; ?>
                </h3>
                <h3 align="center">
                    <?php echo $expenseNotAdded; ?>
                </h3>
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
<!-- App js -->
<?php include '../_partials/app.php'?>
<?php include '../_partials/datetimepicker.php'?>
<script type="text/javascript">
$(".form_datetime").datetimepicker({
    format: "yyyy-mm-dd hh:ii"
});
</script>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.designation').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.attendant').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.payment').select2({
        placeholder: 'Select an option',
        allowClear: true

    });
</script>
<script type="text/javascript">
function checkDoctor() {
    let desg = document.querySelector('#designation');
    if (desg.value.toLowerCase() == 'doctor') {

        document.querySelector('#visitcharges').style.display = '';
    } else {
        document.querySelector('#visitcharges').style.display = 'none';


    }

}
</script>
</body>

</html>