<?php
include('../_stream/config.php');

session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$notAdded = '';

$id = $_GET['id'];
$bank_balance_management_query = mysqli_query($connect, "SELECT * FROM `bank_balance_management` WHERE id = '$id'");
$balanceData = mysqli_fetch_assoc($bank_balance_management_query);  


if (isset($_POST['addEntry'])) {
    $c_id = $_POST['c_id'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    if ($type == 'credit') {
        $credit = $amount;
        $debit = 0;
        $queryAddEntry = mysqli_query(
            $connect,
            "INSERT INTO `bank_balance_management`(
                `bank_id`,
                `credit`,
                `debit`,
                `amount`,
                `description`,
                `date`
            ) VALUES (
                '$c_id',
                '$credit',
                '$debit',
                '$amount',
                '$description',
                '$date'
            )"
        );
        $updateBankAmount = mysqli_query($connect, "UPDATE `bank_accounts` SET `total_amount` = total_amount + '$amount' WHERE bank_id = '$c_id'");
    } elseif ($type == 'debit') {
        $credit = 0;
        $debit = $amount;
        $queryAddEntry = mysqli_query(
            $connect,
            "INSERT INTO `bank_balance_management`(
                `bank_id`,
                `credit`,
                `debit`,
                `amount`,
                `description`,
                `date`
            ) VALUES (
                '$c_id',
                '$credit',
                '$debit',
                '$amount',
                '$description',
                '$date'
            )"
        );
        $updateBankAmount = mysqli_query($connect, "UPDATE `bank_accounts` SET `total_amount` = total_amount - '$amount' WHERE bank_id = '$c_id'");
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
                <h5 class="page-title">Bank Balance Management</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Account</label>
                                <div class="col-sm-4">
                                    <?php
                                    $getcustomers = mysqli_query($connect, "SELECT * FROM bank_accounts");

                                    echo '<select class="form-control comp" name="c_id" required>
                                    <option></option>';
                                    while ($row = mysqli_fetch_assoc($getcustomers)) {
                                        echo '<option value="' . $row['bank_id'] . '">' . $row['bank_name'] . ' - ' . $row['account_no'] . '</option>';
                                    }

                                    echo '</select>';
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Transaction Type</label>
                                <div class="col-sm-4">
                                    <?php

                                    echo '<select class="form-control comp" name="type" required>
                                    <option></option>';
                                    echo '<option value="credit">Credit</option>';
                                    echo '<option value="debit">Debit</option>';

                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="amount" placeholder="Transaction Amount" required="">
                                </div>

                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="description" placeholder="Transaction Description" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="date" placeholder="Transaction Date" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="addEntry" class="btn btn-primary waves-effect waves-light">Add Transaction</button>
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