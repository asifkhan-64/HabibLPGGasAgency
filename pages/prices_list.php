<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';



include('../_partials/header.php');
?>


<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Products</h5>
            </div>
        </div>
        <!-- end row -->
         <div class="row py-2">
            
         </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row pb-3">
                            <div class="col-8">
                                <h4 class="mt-0 header-title">Products List With Prices</h4>
                            </div>
                            <div class="col-4 text-right ">
                                <a href="update_prices.php" class="btn btn-lg p-3 btn-primary" style="font-size: 18px">Update Prices</a>
                            </div>
                        </div>
                        

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retCats = mysqli_query($connect, "SELECT * FROM categories");
                                $iteration = 1;

                                while ($rowCats = mysqli_fetch_assoc($retCats)) {
                                    echo '
                                    <tr>
                                        <td>' . $rowCats['id'] . '</td>
                                        <td>' . $rowCats['category_name'] . '</td>
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
</body>

</html>