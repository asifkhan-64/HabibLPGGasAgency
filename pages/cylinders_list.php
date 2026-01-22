<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

if (isset($_POST['addCylinder'])) {
    $cylinderName = $_POST['cylinderName'];
    $price = $_POST['price'];

    $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedTypes FROM cylinder_types WHERE cylinder_type = '$cylinderName' AND price = '$price'");
    $fetch_countQuery = mysqli_fetch_assoc($countQuery);


    if ($fetch_countQuery['countedTypes'] == 0) {
        $insertQuery = mysqli_query($connect, "INSERT INTO cylinder_types(cylinder_type, price)VALUES('$cylinderName', '$price')");
        if (!$insertQuery) {
            $error = '<div class="alert alert-dark" role="alert">Not Added! Try again!</div>';
        } else {
            $column_name = strtolower(str_replace(' ', '_', $cylinderName));
            $column_name = preg_replace('/[^a-z0-9_]/', '', $column_name);
            $sqlNewColumnQuery = mysqli_query($connect, "ALTER TABLE customer_add ADD COLUMN `$column_name` INT DEFAULT 0");
            $added = '
                <div class="alert alert-primary" role="alert">
                                Cylinder Type Added!
                             </div>';
        }
    } else {
        $alreadyAdded = '<div class="alert alert-dark" role="alert">
                                Cylinder Type Already Added!
                             </div>';
    }
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Cylinder Types</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Cylinder Name" type="text" value="" id="example-text-input" name="cylinderName" required="">
                                </div>

                                <label for="example-text-input" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-4">
                                    <input class="form-control" placeholder="Cylinder Price" type="text" value="" id="example-text-input" name="price" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addCylinder">Add Type</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Cylinder Types List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cylinder Type</th>
                                    <th>Price</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retCats = mysqli_query($connect, "SELECT * FROM cylinder_types");
                                $iteration = 1;

                                while ($rowCats = mysqli_fetch_assoc($retCats)) {
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowCats['cylinder_type'] . '</td>
                                        <td>' . $rowCats['price'] . '</td>
                                        <td class="text-center"><a href="cylinder_edit.php?id=' . $rowCats['cylinder_id'] . '" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
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