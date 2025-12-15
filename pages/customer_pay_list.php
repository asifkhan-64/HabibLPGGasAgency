<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Customer Recovery</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Recovery List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Dues</th>
                                    <th>Date</th>
                                    <th class="text-center">
                                        <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retCustomers = mysqli_query($connect, "SELECT customer_pay.*, customer_add.* FROM `customer_pay`
                                INNER JOIN customer_add ON customer_add.c_id = customer_pay.customer_id
                                ORDER BY customer_pay.p_id DESC");

                                $iteration = 1;

                                while ($rowCustomers = mysqli_fetch_assoc($retCustomers)) {
                                    $total = number_format($rowCustomers['total_amount']);
                                    $paid = number_format($rowCustomers['paid_amount']);
                                    $remaining = number_format($rowCustomers['remaining_amount']);
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowCustomers['customer_name'] . '</td>
                                        <td>0' . $rowCustomers['customer_contact'] . '</td>
                                        <td>Rs. ' . $total . '</td>
                                        <td>Rs. ' . $paid . '</td>
                                        <td>Rs. ' . $remaining . '</td>
                                        <td>' . $rowCustomers['pay_date'] . '</td>
                                        <td class="text-center">
                                            <a href="customer_pay_edit.php?id=' . $rowCustomers['p_id'] . '" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
                                        </td>
                                    </tr>
                                    ';
                                }


                                ?>

                            </tbody>
                        </table>
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

<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
    $('.comp').select2({
        placeholder: 'Select an option',
        allowClear: true

    });
</script>

</body>

</html>