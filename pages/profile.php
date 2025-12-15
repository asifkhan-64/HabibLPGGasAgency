<?php 
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }


    $selectUser = mysqli_query($connect, "SELECT * FROM login_user WHERE id = '1'");
    $fetch_selectUser = mysqli_fetch_assoc($selectUser);

    $userNotUpdated = '';

    if (isset($_POST['updateUser'])) {
        $name = $_POST['editName'];
        $email = $_POST['editEmail'];
        $password = $_POST['editPassword'];
        $contact = $_POST['edit_contact'];

        

            $editUserQuery = mysqli_query($connect, "UPDATE login_user SET name = '$name', password = '$password', email = '$email', contact = '$contact' WHERE id = '1'");
            if (!$editUserQuery) {
                $userNotUpdated = "Failed to update. Try Again!";
            }else {
                header("LOCATION:signout.php");
            }
        }
    // }

    include('../_partials/header.php');
?>
                <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-right page-breadcrumb">
                                    </div>
                                    <h5 class="page-title">Edit User</h5>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <!-- <h4 class="mt-0 header-title">Heading</h4> -->
                                            <!-- <p class="text-muted m-b-30 font-14">Example Text</p> -->
            								<form method="POST">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="editName" type="text" value="<?php echo $fetch_selectUser['name'] ?>" id="example-text-input">
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">

                                            <div class="form-group row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label">Contact</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" value="<?php echo $fetch_selectUser['contact'] ?>" name="edit_contact" placeholder="Contact" id="example-email-input">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="editEmail" value="<?php echo $fetch_selectUser['email'] ?>" type="email" placeholder="Name@example.com" id="example-email-input">
                                                </div>
                                            </div>

                                        
                                            <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="editPassword" value="<?php echo $fetch_selectUser['password'] ?>" id="pass2" class="form-control" required placeholder="Password"/>
                                                    </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-10">
                                            <?php include '../_partials/cancel.php'; ?>
                                             <button type="submit" name="updateUser" class="btn btn-primary waves-effect waves-light">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                        <h3 align="center"><?php echo $userNotUpdated ?></h3>
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
       

        <!-- App js -->
        <?php include('../_partials/app.php') ?>
        
        <script>
            $(document).ready(function() {
                $('form').parsley();
            });
        </script>
    </body>
</html>