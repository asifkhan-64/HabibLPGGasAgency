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
                <h5 class="page-title">Bank Account Management</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Bank Transaction List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Account</th>
                                    <th class="text-center">Credit</th>
                                    <th class="text-center">Debit</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <!-- <th class="text-center"> <i class="fa fa-edit"></i></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectTRansaction = mysqli_query($connect, "SELECT bank_balance_management.*, bank_accounts.* FROM `bank_balance_management`
                                INNER JOIN bank_accounts ON bank_accounts.bank_id = bank_balance_management.bank_id");
                                $iteration = 1;

                                while ($rowTransaction = mysqli_fetch_assoc($selectTRansaction)) {
                                    echo '
                                        <tr>
                                            <td>'.$iteration++.'</td>
                                            <td>'.$rowTransaction['bank_name'].' - '.$rowTransaction['account_no'].'</td>';
                                            
                                            if ($rowTransaction['credit'] > 0) {
                                                echo '<td><span class="badge badge-success" style="font-size: 16px">' . $rowTransaction['credit'] . '</span></td>';
                                            } else {
                                                echo '<td class="text-center">***</td>';
                                            }

                                            if ($rowTransaction['debit'] > 0) {
                                                echo '<td><span class="badge badge-danger" style="font-size: 16px">' . $rowTransaction['debit'] . '</span></td>';
                                            } else {
                                                echo '<td class="text-center">***</td>';
                                            }

                                            
                                            
                                            echo '
                                            <td>'.$rowTransaction['date'].'</td>
                                            <td>'.$rowTransaction['description'].'</td>

                                            
                                            
                                            ';
                                            // <td class="text-center">
                                            //     <a href="bank_in_balance_edit.php?id='.$rowTransaction['id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light btn-sm">Edit</a>
                                            // </td>

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