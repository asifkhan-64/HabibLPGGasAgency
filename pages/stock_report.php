<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $date = date_default_timezone_set('Asia/Karachi');
    $currentDate = date('Y-m-d h:i:s A');
    $date = date('Y-m-d');

    // $v_id   = $_GET['v_id'];
    // $start  = $_GET['start'];
    // $end    = $_GET['end'];

    
    
    // $Query = mysqli_query($connect, "SELECT qty_stock_purchase.*, vendor_tbl.*, categories.* FROM `qty_stock_purchase`
    // INNER JOIN vendor_tbl ON vendor_tbl.v_id = qty_stock_purchase.v_id
    // INNER JOIN categories ON categories.id = qty_stock_purchase.c_id
    // WHERE qty_stock_purchase.purchase_date BETWEEN '$start' AND '$end' ORDER BY qty_stock_purchase.id ASC");

    // $QuerySecond = mysqli_query($connect, "SELECT weight_stock_purchase.*, vendor_tbl.*, categories.* FROM `weight_stock_purchase`
    // INNER JOIN vendor_tbl ON vendor_tbl.v_id = weight_stock_purchase.v_id
    // INNER JOIN categories ON categories.id = weight_stock_purchase.c_id
    // WHERE weight_stock_purchase.purchase_date BETWEEN '$start' AND '$end' ORDER BY weight_stock_purchase.id ASC");


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
                <h5 class="page-title d-inline">Stock Report</h5>
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
                                        <!-- <h6>Current Patients</h6> -->
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Category Name</th>
                                                        <th>Unique ID</th>
                                                        <th>Remaining Qty</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $retCats = mysqli_query($connect, "SELECT * FROM categories ORDER BY stock_available ASC");
                                                    $iteration = 1;

                                                    while ($rowCats = mysqli_fetch_assoc($retCats)) {
                                                        echo '
                                                        <tr>
                                                            <td>' . $iteration++ . '</td>
                                                            <td>' . $rowCats['category_name'] . '</td>
                                                            <td>' . $rowCats['id'] . '</td>
                                                            <td>' . $rowCats['stock_available'] . '</td>
                                                            ';

                                                            if ($rowCats['category_type'] == 'Qty') {
                                                                echo '<td><b>Pkr. ' . $rowCats['sell_price'] . '</b> : Per Piece</td>';
                                                            }else {
                                                                echo '<td><b>Pkr. ' . $rowCats['sell_price'] . '</b> : KG/Ltr</td>';
                                                            }
                                                            echo '
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