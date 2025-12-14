
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Swat Fiber</title>
        <meta content="Swat Fiber" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/logo.png">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style1.css" rel="stylesheet" type="text/css">

        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

        <style>

        /* 1. Define the Keyframes for the Animation */
            @keyframes float {
            0% {
                transform: translateY(0); /* Start position */
            }
            50% {
                transform: translateY(-10px); /* Move up 5 pixels */
            }
            100% {
                transform: translateY(0); /* Return to start */
            }
            }

            /* 2. Apply the Animation to the Cards */
            .timeline-content {
            /* ... existing styles like box-shadow ... */
            animation: float 4s ease-in-out infinite !important; /* Apply the animation */
            zoon: 0.5 !important;
            }

            .timeline  {
                animation-delay: 1s !important; /* Start half a second later */
            }

            .main-timeline2 .timeline:nth-child(2) .timeline-content {
            animation-delay: 0.5s !important; /* Start half a second later */
            }

            .main-timeline2 .timeline:nth-child(3) .timeline-content {
            animation-delay: 0.5s !important; /* Start one second later */
            }

            body {
                font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
            }

            .my-element {
                display: inline-block;
                margin: 0 0.5rem;

                animation: bounce; /* referring directly to the animation's @keyframe declaration */
                animation-duration: 2s; /* don't forget to set a duration! */
            }

                /* This only changes this particular animation duration */
            .animate__animated.animate__bounce {
                --animate-duration: 2s;
            }

                /* This changes all the animations globally */
            :root {
                --animate-duration: 800ms;
                --animate-delay: 0.9s;
            }
        </style>

    </head>

<?php
  include("_stream/config.php");
  
  $valid_login = "";
  if (isset($_POST["log_in_session"])) {
    $user_email = $_POST["user_email"];
    $user_password = $_POST["user_password"];

    $result_query = mysqli_query($connect, "SELECT * FROM login_user WHERE email='$user_email' AND password='$user_password'");
    //  = mysqli_query($connect, $select_user_query);
    
    $fetch_userQuery = mysqli_fetch_assoc($result_query);

    if (empty($fetch_userQuery)) {
        $valid_login = '<div class="alert alert-danger" style="background:#D52520; color:white" role="alert">Enter a valid Login</div>';
    } else {
        $user_status = $fetch_userQuery['status'];
        $user_role = $fetch_userQuery['user_role'];
        $id = $fetch_userQuery['id'];

            if ($user_status == 1) {
                session_start();
                $_SESSION["user"] = $user_email;
                $_SESSION["id"] = $id;
                header("LOCATION:pages/dashboard.php");
            } else {
                $valid_login = ' <div class="alert alert-danger animate__animated animate__bounce" style="background:#D52520; color:white" role="alert">
                <h4 class="animate__animated animate__bounce">Access Denied. You have been restricted. </h4></div>';
            }
        }
    }
?>
    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div class="accountbg">
            
            <div class="content-center">
                <div class="content-desc-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-8">
                                <div class="card " style="box-shadow: 3px 3px 15px 3px #E7EAED; opacity: 0.95 !important;">
                                    <div class="card-body">
                                        <h3 class="text-center mt-0 m-b-15 animate__animated animate__bounce">
                                            <a  class="logo logo-admin"><img src="assets/logo.png" width="18%" height="20%"> <h3 style="font-family: Lucida Handwriting">Swat Fiber</h3></a>
                                        </h3>
                
                                        <!-- <h4 class="text-muted text-center font-18"><b>Sign In</b></h4> -->
                                        <hr>
                
                                        <div class="p-2">
                                            <form class="form-horizontal m-t-20" method="POST">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <input class="form-control animate__animated animate__bounce" name="user_email" type="text" required="" placeholder="E-Mail">
                                                    </div>
                                                </div>
                
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <input class="form-control animate__animated animate__bounce" name="user_password" type="password" required="" placeholder="Password">
                                                    </div>
                                                </div>                
                                                <div class="form-group text-center row m-t-20 mt-5">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary btn-block waves-effect waves-light animate__animated animate__bounce" type="submit" name="log_in_session">Log In</button>
                                                    </div>
                                                </div>
                
                                                <div class="form-group m-t-10 mb-0 row">
                                                   
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <h5 align="center"><?php echo $valid_login ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

         <!-- Alertify js -->
        <script src="assets/plugins/alertify/js/alertify.js"></script>
         <script src="assets/pages/alertify-init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // All animations will take twice the time to accomplish
            document.documentElement.style.setProperty('--animate-duration', '2s');

            // All animations will take half the time to accomplish
            document.documentElement.style.setProperty('--animate-duration', '.5s');
        </script>
        

    </body>
</html>