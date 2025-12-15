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
                <h5 class="page-title">Expenses</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Expenses List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date-Time</th>
                                    <th>Description</th>
                                    <th>Payment By</th>
                                    <!-- <th>Expense Status</th> -->
                                    <!-- <th class="text-center"><i class="mdi mdi-eye"></i></th> -->
                                    <th class="text-center"> <i class="fa fa-edit"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectExpense = mysqli_query($connect, "SELECT expense.*, expense_category.expense_name FROM expense
                                    INNER JOIN expense_category ON expense_category.id = expense.cat_id ORDER BY expense.id DESC");
                                $iteration = 1;

                                while ($rowExpense = mysqli_fetch_assoc($selectExpense)) {
                                    echo '
                                        <tr>
                                            <td>'.$iteration++.'</td>
                                            <td>'.$rowExpense['expense_name'].'</td>
                                            <td> <span class="badge badge-info" style="font-size: 16px">'.$rowExpense['expense_amount'].'</span></td>
                                            <td>'.substr($rowExpense['expense_date'], 0, 10) .'</td>
                                            <td>'.$rowExpense['expense_description'].'</td>';

                                            if ($rowExpense['payment_by'] == 'Cash') {
                                                echo '<td><span class="badge badge-success" style="font-size: 16px">' . $rowExpense['payment_by'] . '</span></td>';
                                            } else {
                                                echo '<td><span class="badge badge-primary" style="font-size: 16px">' . $rowExpense['payment_by'] . '</span></td>';
                                            }
                                            echo '
                                            <td class="text-center">
                                                <a href="expense_edit.php?id='.$rowExpense['id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light btn-sm">Edit</a>
                                            </td>
                                            ';
                                            

                                            echo '
                                        </tr>
                                    ';
                                }
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