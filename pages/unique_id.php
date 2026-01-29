<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

$alreadyAdded = '';
$added = '';
$error = '';

$id = $_GET['id'];
$gteCategoryData = mysqli_query($connect, "SELECT * FROM categories WHERE id='$id'");
$rowCategoryData = mysqli_fetch_assoc($gteCategoryData);

if ($rowCategoryData['category_type'] === 'Qty') {
    $textToShow = "Piece";
}else {
    $textToShow = "Kg/Ltr";
}


include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Categories</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5  class="text-center" >Tracking ID</h5><hr>
                        <h1 class="text-center p-5" style="font-size:80px; font-family: Lucida Handwriting"><?php echo $rowCategoryData['id']; ?></h1>
                        <hr>
                        <h5  class="text-center" ><?php echo $rowCategoryData['category_name']; ?></h5>
                        <h5  class="text-center" >Price: <?php echo $rowCategoryData['sell_price']." / ".$textToShow; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
            </div>
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