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
                <h5 class="page-title">Vendors</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Vendors List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Bank</th>
                                    <th>Dues</th>
                                    <th>Paid</th>
                                    <th>Total</th>
                                    <th class="text-center">
                                        <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retVendors = mysqli_query($connect, "SELECT * FROM `vendor_tbl`");

                                $iteration = 1;

                                while ($rowVendors = mysqli_fetch_assoc($retVendors)) {
                                    $total = number_format($rowVendors['total_sale']);
                                    $paid = number_format($rowVendors['total_paid']);
                                    $remaining = number_format($rowVendors['total_dues']);
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowVendors['vendor_name'] . '</td>
                                        <td>0' . $rowVendors['vendor_contact'] . '</td>
                                        <td>' . $rowVendors['vendor_address'] . '</td>
                                        <td>' . $rowVendors['vendor_bank'] . ': ' . $rowVendors['vendor_account'] . '</td>
                                        <td>Rs. ' . $remaining . '</td>
                                        <td>Rs. ' . $paid . '</td>
                                        <td>Rs. ' . $total . '</td>
                                        <td class="text-center">
                                            <a href="vendor_edit.php?id=' . $rowVendors['v_id'] . '" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
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