<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['updateDetails'])) {
        $shop_name = $_POST['shop_name'];
        $shop_contact = $_POST['shop_contact'];
        $shop_address = $_POST['shop_address'];
        $shop_title = $_POST['shop_title'];
        $shop_contact_two = $_POST['shop_contact_two'];

        $updateQuery = mysqli_query($connect, "UPDATE shop_info SET shop_contact_two = '$shop_contact_two', shop_title = '$shop_title', shop_name = '$shop_name', shop_contact = '$shop_contact', shop_address = '$shop_address' WHERE id = '1'");

        if (!$updateQuery) {
            $error = 'Details Not Updated! Try agian!';
        }else {
            $added = '
            <div class="alert alert-primary" role="alert">
                Details  Updated!
            </div>';
        }
        
    }

    $get = mysqli_query($connect, "SELECT * FROM shop_info WHERE id= '1'");
    $fetch = mysqli_fetch_assoc($get);


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Shop Details</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Shop Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Shop Title" type="text" value="<?php echo $fetch['shop_title'] ?>" id="example-text-input" name="shop_title" required=""> 
                                </div>
                            </div>


                            <div class="form-group row">    
                                <label for="example-text-input" class="col-sm-4 col-form-label"> Title</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Shop Name" type="text" value="<?php echo $fetch['shop_name'] ?>" id="example-text-input" name="shop_name" required=""> 
                                </div>
                            </div>

                            
                            
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Contact # 1</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Contact Number # 1" type="number" value="<?php echo "0".$fetch['shop_contact'] ?>" id="example-text-input" name="shop_contact" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Contact # 2</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Contact Number # 2" type="number" value="<?php echo "0".$fetch['shop_contact_two'] ?>" id="example-text-input" name="shop_contact_two" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Address</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="Shop Address" type="text" value="<?php echo $fetch['shop_address'] ?>" id="example-text-input" name="shop_address" required="">
                                </div>
                            </div>
                            
                            <hr>
                            <div class="form-group row">
                                <!-- <label for="example-password-input" class="col-sm-2 col-form-label"></label> -->
                                <div class="col-sm-12" align="right">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateDetails">Update Details!</button>
                                </div>
                            </div>
                        </form>
                        <h5 align="center"><?php echo $error ?></h5>
                        <h5 align="center"><?php echo $added ?></h5>
                        <h5 align="center"><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
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
$('.comp').select2({
  placeholder: 'Select an option',
  allowClear:true
  
});
</script>

</body>

</html>