<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $date = date_default_timezone_set('Asia/Karachi');
    $currentDate = date('Y-m-d h:i:s A');
    $date = date('Y-m-d');

    $c_id   = $_GET['v_id'];
    $start  = $_GET['start'];
    $end    = $_GET['end'];

    
    
    $Query = mysqli_query($connect, "SELECT customer_summary_weight.*, customer_add.* FROM `customer_summary_weight`
    INNER JOIN customer_add ON customer_add.c_id = customer_summary_weight.c_id
    WHERE customer_summary_weight.c_id = '$c_id' AND date(customer_summary_weight.auto_date) BETWEEN '$start' AND '$end' 
    ORDER BY customer_summary_weight.s_id ASC");

    $QuerySecond = mysqli_query($connect, "SELECT customer_summary_qty.*, customer_add.* FROM `customer_summary_qty`
    INNER JOIN customer_add ON customer_add.c_id = customer_summary_qty.c_id
    WHERE customer_summary_qty.c_id = '$c_id' AND date(customer_summary_qty.auto_date) BETWEEN '$start' AND '$end' 
    ORDER BY customer_summary_qty.s_id ASC");

    $oneLineQuery = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE c_id = '$c_id'");
    $fetch_oneLine = mysqli_fetch_assoc($oneLineQuery);



include '../_partials/header.php';
?>
<style>

    body, td {
        color: black;
    }
    
    table {
        font-size: 12px !important;
    }

    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    
    .custom {
        font-size: 12px;
        color: black;
    }
</style>
<!-- Top Bar End -->
<br>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline">Customer Sell Report</h5>
                <!-- <a href="<?php echo 'report_expense_daily_print_confirm.php?fromDate='.$fromDate.''?>" rel="noopener" target="_blank" class="btn btn-success float-right btn-lg mb-3"><i class="fas fa-print"></i> Print</a> -->
            </div>
        </div>
        <!-- end row -->
        <div class="row custom">
            <div class="col-12">
                <!-- <div class="card m-b-30" > -->
                    <!-- <div class="card-body"> -->
                        <div class="row" id="printElement">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="invoice-title">
                                            <h3 class="m-t-0 text-center">
                                                <h3 align="center" style="font-size: 90%; line-height: 1px; font-family: Lucida Handwriting "><u><?php echo $fet['shop_title'] ?></u></h3>
                                                <p class="text-center font-16" style="font-size: 70%;  line-height: 5px;"><?php echo $fet['shop_address'] ?></p>
                                                <br>
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th> NAME</th>
                                                        <th> CONTACT</th>
                                                        <th> CYLINDERS</th>
                                                        <th> TOTAL SALE</th>
                                                        <th> TOTAL PAID</th>
                                                        <th> TOTAL DUES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        echo '
                                                        <tr class="table-success">
                                                            <td>'.$fetch_oneLine['customer_name'].'</td>
                                                            <td>0'.$fetch_oneLine['customer_contact'].'</td>
                                                            <td><b>'.$fetch_oneLine['remaining_cylinders'].'</b></td>
                                                            <td><b>Rs. '.$fetch_oneLine['total_sale'].'</b></td>
                                                            <td><b>Rs. '.$fetch_oneLine['total_paid'].'</b></td>
                                                            <td><b>Rs. '.$fetch_oneLine['total_dues'].'</b></td>
                                                        </tr>
                                                        ';
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <!-- <h6>Current Patients</h6> -->
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th> #            </th>
                                                        <th> Invoice No.  </th>
                                                        <th> Date         </th>
                                                        <th> Total        </th>
                                                        <th> Paid         </th>
                                                        <th> Remaining    </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $itrCurrent = 1;

                                                    $total = 0;
                                                    $totalSecond = 0;
                                                    while ($row = mysqli_fetch_assoc($Query)) {
                                                        echo '
                                                        <tr>
                                                            <td>'.$itrCurrent++.'.</td>
                                                            <td><a href="print_invoice_weight.php?id='.$row['c_id'].'&invoiceNo='.$row['invoice_id'].'">WT-00'.$row['invoice_id'].'</a></td>
                                                            <td>'.$row['custom_date'].'</td>
                                                            <td><b>Rs. '.$row['net_amount'].'</b></td>
                                                            <td><b>Rs. '.$row['paid_amount'].'</b></td>
                                                            <td><b>Rs. '.$row['remaining_amount'].'</b></td>
                                                        </tr>
                                                        ';
                                                    }

                                                    while ($row = mysqli_fetch_assoc($QuerySecond)) {
                                                        echo '
                                                        <tr>
                                                            <td>'.$itrCurrent++.'.</td>
                                                            <td><a href="print_invoice_qty.php?id='.$row['c_id'].'&invoiceNo='.$row['invoice_id'].'">QT-00'.$row['invoice_id'].'</a></td>
                                                            <td>'.$row['custom_date'].'</td>
                                                            <td><b>Rs. '.$row['net_amount'].'</b></td>
                                                            <td><b>Rs. '.$row['paid_amount'].'</b></td>
                                                            <td><b>Rs. '.$row['remaining_amount'].'</b></td>
                                                        </tr>
                                                        ';
                                                    }

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
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript" src="../assets/print.js"></script>

<script type="text/javascript">

    // function printReport() {
    //     console.log('print');

    //      var printContents = document.getElementsByClassName('card')[0].innerH‌​TML;
    //  var originalContents = document.body.innerHTML;

    //  document.body.innerHTML = printContents;

    //  window.print();

    //  document.body.innerHTML = originalContents;

        // w = window.open();
        // w.document.write(document.getElementsByClassName('card')[0].innerH‌​TML);
        // w.print();
        // w.close();

    // }
    function print() {
    printJS({
    printable: 'printElement',
    type: 'html',
    targetStyles: ['*']
 })
}

document.getElementById('printButton').addEventListener ("click", print)

//     function printDiv(divName) {
//      var printContents = document.getElementById(divName).innerHTML;
//      var originalContents = document.body.innerHTML;

//      document.body.innerHTML = printContents;

//      window.print();

//      document.body.innerHTML = originalContents;
// }

</script>
</body>

</html>