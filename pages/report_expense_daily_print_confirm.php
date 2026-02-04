<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $date = date_default_timezone_set("Europe/London");
    $currentDate = date('Y-m-d h:i:s A');
    $date = date('Y-m-d');

    $fromDate = $_GET['fromDate'];
    
    
    $expensesQuery = mysqli_query($connect, "SELECT expense.*, expense_category.expense_name FROM `expense`
    INNER JOIN expense_category ON expense_category.id = expense.cat_id
    WHERE date(expense.expense_date) = '$fromDate' ORDER BY expense.id ASC
    ");


$get = mysqli_query($connect, "SELECT * FROM `shop_info`");
$fet = mysqli_fetch_assoc($get);

// include '../_partials/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $fet['shop_title']; ?></title>
    <meta content="<?php echo $fet['shop_title']; ?>" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <link rel="shortcut icon" href="../assets/LogoFinal.png"> -->
    <link rel="shortcut icon" href="../assets/logo.svg">
    <!--Morris Chart CSS -->

    <!-- DataTables -->
    <!-- Responsive datatable examples -->

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <script src='../assets/kit.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>

    body, td {
        color: black;
    }
    
    table {
        font-size: 14px !important;
    }

    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    
    .custom {
        font-size: 14px;
        color: black;
    }
</style>
<!-- Top Bar End -->

<br>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        
        <!-- end row -->
        <div class="row custom">
            <div class="col-12">
                <!-- <div class="card m-b-30" > -->
                    <!-- <div class="card-body"> -->
                        <div class="row" id="printElement">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <div class="page-title-box d-flex align-items-center justify-content-between">
                                            <img src="../assets/logo1.png" alt="Logo" height="150" width="150">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="invoice-title">
                                            <h3 class="m-t-0 text-right">
                                                <h3 align="right" style="font-size: 150%; line-height: 1px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_title'] ?></u></h3>
                                                <br > <!-- <h3 align="center" style="font-size: 100% ;  line-height: 15px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_name'] ?></u></h3> -->
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;"><?php echo $fet['shop_address'] ?></p>
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;">Printed on: <?php echo date("Y-m-d h:i A") ?></p>
                                                <p class="text-right font-16" style="font-size: 100%;  line-height: 5px;"><b>(Expense Report) </b></p>
                                                <br>
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <!-- <h6>Current Patients</h6> -->
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> Name</th>
                                                        <th> Date</th>
                                                        <th> Description</th>
                                                        <th> Payment By</th>
                                                        <th> Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $itrCurrent = 1;

                                                    $cash = 0;
                                                    $card = 0;  

                                                    $total = 0;
                                                    while ($row = mysqli_fetch_assoc($expensesQuery)) {
                                                        $newExpense = $row['expense_amount'];
                                                        $total = $total + $newExpense;
                                                        echo '
                                                        <tr>
                                                            <td>'.$itrCurrent++.'.</td>
                                                            <td>'.$row['expense_name'].'</td>
                                                            <td>'.substr($row['expense_date'], 0, 10).'</td>
                                                            <td>'.$row['expense_description'].'</td>';
                                                            if ($row['payment_by'] == 'Cash') {
                                                                $cash += $row['expense_amount'];
                                                            } else {
                                                                $card += $row['expense_amount'];
                                                            }
                                                            echo '
                                                            <td>'.$row['payment_by'].'</td>
                                                            <td> '.$row['expense_amount'].'</td>
                                                        </tr>
                                                        ';
                                                    }

                                                        echo '
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><b>Total: </b></td>
                                                            <td><b> '.$total.'</b></td>
                                                        </tr>
                                                        ';
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                

                               

                               

                            </div>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
</div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php // include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- App js -->
<script type="text/javascript" src="../assets/print.js"></script>


<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
  window.addEventListener("load", window.print());
</script>
</body>

</html>