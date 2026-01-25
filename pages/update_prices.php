<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

if (isset($_POST['updatePrices'])) {
    $ids = $_POST['id'];
    $prices = $_POST['price'];

    for ($i = 0; $i < count($ids); $i++) {
        $id = mysqli_real_escape_string($connect, $ids[$i]);
        $price = mysqli_real_escape_string($connect, $prices[$i]);

        if ($price != '') {
            $updateQuery = mysqli_query($connect, "UPDATE categories SET sell_price='$price' WHERE id='$id'");
            if($updateQuery) {
                $added = header("LOCATION:prices_list.php");
            } else {
                $error = "Error updating price.";
            }
        }
    }

    echo "<script>alert('Prices Updated Successfully');</script>";
}



include('../_partials/header.php');
?>


<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Update Products</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary" name="updatePrices">Update Prices</button>
                                </div>
                            </div>
                            
                            <table id="datatasble" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                            <input type="hidden" class="form-control" name="id[]" value="' . $rowCats['id'] . '">
                                            <td>' . $rowCats['id'] . '</td>
                                            <td>' . $rowCats['category_name'] . '</td>
                                            <td>' . $rowCats['stock_available'] . '</td>
                                            ';

                                            if ($rowCats['category_type'] == 'Qty') {
                                                echo '<td><input type="number" class="form-control" name="price[]" value="' . $rowCats['sell_price'] . '"><b>Pkr. ' . $rowCats['sell_price'] . '</b> : Per Piece</td>';
                                            }else {
                                                echo '<td><input type="number" class="form-control" name="price[]" value="' . $rowCats['sell_price'] . '"><b>Pkr. ' . $rowCats['sell_price'] . '</b> : KG/Ltr</td>';
                                            }
                                            echo '
                                        </tr>
                                        ';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
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