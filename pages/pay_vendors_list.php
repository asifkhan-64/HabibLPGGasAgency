<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }


    include('../_partials/header.php');
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Vendor Pay</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Vendor Pay List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Remaining Amount</th>
                                    <th>Date</th>
                                    <!-- <th>Expense Status</th> -->
                                    <!-- <th class="text-center"><i class="mdi mdi-eye"></i></th> -->
                                    <!-- <th class="text-center"> <i class="fa fa-edit"></i></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectVendorPay = mysqli_query($connect, "SELECT vendor_pay.*, vendor_tbl.* FROM `vendor_pay`
                                INNER JOIN vendor_tbl ON vendor_tbl.v_id = vendor_pay.v_id");
                                $iteration = 1;

                                while ($rowExpense = mysqli_fetch_assoc($selectVendorPay)) {
                                    echo '
                                        <tr>
                                            <td>'.$iteration++.'</td>
                                            <td>'.$rowExpense['vendor_name'].'</td>
                                            <td> <span class="badge badge-info" style="font-size: 16px">'.$rowExpense['total_amount'].'</span></td>
                                            <td> <span class="badge badge-primary" style="font-size: 16px">'.$rowExpense['paid_amount'].'</span></td>
                                            <td> <span class="badge badge-secondary" style="font-size: 16px">'.$rowExpense['remaining_amount'].'</span></td>
                                            <td>'.substr($rowExpense['pay_date'], 0, 10) .'</td>
                                            
                                            ';
                                            

                                            echo '
                                        </tr>
                                    ';
                                }

                                ';

                                            
                                            // echo '
                                            // <td class="text-center">
                                                // <a href="expense_edit.php?id='.$rowExpense['id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light btn-sm">Edit</a>
                                            // </td>
                                            // <td class="text-center"><a href="./user_edit.php" type="button" class="btn text-white btn-warning waves-effect 
                                            //waves-light">Edit</a></td>
                                ?>
                                
                                    
                            </tbody>
                        </table>
                        <script type="text/javascript">
        function deleteme(delid){
          if (confirm("Do you want to discharge patient?")) {
            window.location.href = 'temporary_disable.php?del_id=' + delid +'';
            return true;
          }
        }
      </script>
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
<!-- jQuery  -->
        <?php include('../_partials/jquery.php') ?>

<!-- Required datatable js -->
        <?php include('../_partials/datatable.php') ?>

<!-- Buttons examples -->
        <?php include('../_partials/buttons.php') ?>

<!-- Responsive examples -->
        <?php include('../_partials/responsive.php') ?>

<!-- Datatable init js -->
        <?php include('../_partials/datatableInit.php') ?>


<!-- Sweet-Alert  -->
        <?php include('../_partials/sweetalert.php') ?>


<!-- App js -->
        <?php include('../_partials/app.php') ?>
</body>

</html>