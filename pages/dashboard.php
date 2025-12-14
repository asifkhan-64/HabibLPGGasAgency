<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}


// $getCountofExpenseOfToday = mysqli_query($connect, "SELECT SUM(expense_amount) AS totalExpenseToday FROM expense WHERE DATE(expense_date) = CURDATE()");
// $fetchExpenseToday = mysqli_fetch_assoc($getCountofExpenseOfToday);
// $today = $fetchExpenseToday['totalExpenseToday'];

// $getTotalOfGrocesotyTOday = mysqli_query($connect, "SELECT SUM(item_price) AS totalGrocesotyToday FROM grocessory WHERE DATE(item_date) = CURDATE()");
// $fetchGrocesotyToday = mysqli_fetch_assoc($getTotalOfGrocesotyTOday);
// $todayGrocesoty = $fetchGrocesotyToday['totalGrocesotyToday'];

// $todayExpense = $today + $todayGrocesoty;

// $getCountOfTotalWorkers = mysqli_query($connect, "SELECT COUNT(*) AS totalWorkers FROM workers");
// $fetchTotalWorkers = mysqli_fetch_assoc($getCountOfTotalWorkers);
// $workers = $fetchTotalWorkers['totalWorkers'];

// $getDailySalesFromTillOne = mysqli_query($connect, "SELECT SUM(total_amount) AS totalSalesToday FROM till_one_reports WHERE DATE(report_date) = CURDATE()");
// $fetchDailySalesFromTillOne = mysqli_fetch_assoc($getDailySalesFromTillOne);
// $tillOneSale = $fetchDailySalesFromTillOne['totalSalesToday'];

// $getDailySalesFromTillTwo = mysqli_query($connect, "SELECT SUM(total_amount) AS totalSalesToday FROM till_two_reports WHERE DATE(report_date) = CURDATE()");
// $fetchDailySalesFromTillTwo = mysqli_fetch_assoc($getDailySalesFromTillTwo);
// $tillTwoSale = $fetchDailySalesFromTillTwo['totalSalesToday'];

include('../_partials/header.php');

?>

<link rel="stylesheet" type="text/css" href="./timeline.css">





<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title"></h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-timeline2" id="addUserForm">
                    <div class="timeline animate__animated animate__bounce" id="timeline">
                        <span class="icon fa fa-globe"></span>
                        <a class="timeline-content" style="box-shadow: 3px 3px 3px 3px #ccc">
                            <h3 class="title" align="center"><?php echo $fet['shop_title'] ?></h3>
                            <h3 class="title" align="center"><?php echo $fet['shop_name'] ?></h3>
                            <hr>
                            <p class="description" align="center">
                                <?php echo $fet['shop_address'] ?>
                            </p>
                        </a>
                    </div>
                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-calendar"></span>
                        <a class="timeline-content" style="box-shadow: 3px 3px 3px 3px #ccc">
                            <h3 class="title" align="center">Daily Expense</h3>
                            <hr>
                            <p class="description" align="center">
                                 
                                <?php
                                if (empty($todayExpense)) {
                                    echo "0";
                                } else {
                                    echo $todayExpense;
                                }
                                ?>
                            </p>
                        </a>
                    </div>

                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-window-close"></span>
                        <a class="timeline-content" style="box-shadow: 3px 3px 3px 3px #ccc">
                            <h3 class="title" align="center">Users</h3>
                            <hr>
                            <p class="description" align="center">
                                 <?php
                                    if (empty($workers)) {
                                        echo "0";
                                    } else {
                                        echo number_format($workers);
                                    }
                                    ?>
                            </p>
                        </a>
                    </div>

                    <div class="timeline animate__animated animate__bounce">
                        <span class="icon fa fa-calendar"></span>
                        <a class="timeline-content" style="box-shadow: 3px 3px 3px 3px #ccc">
                            <h3 class="title" align="center">Clients</h3>
                            <hr>
                            <p class="description" align="center">
                                 
                                <?php
                                if (empty($tillOneSale)) {
                                    echo "0";
                                } else {
                                    echo number_format($tillOneSale);
                                }
                                ?>
                            </p>
                        </a>
                    </div>

                </div>
            </div>

            <!-- <div class="col-4">
                <h1 class="text-center mt-5  verText" align="center">
                    Welcome to Zaryab 
                </h1>
            </div> -->
        </div>
        <br>
    </div>
</div>
</div>
<?php include '../_partials/footer.php'; ?>

</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.slimscroll.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/waves.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/skycons/skycons.min.js"></script>

<!-- skycons -->
<script src="../assets/plugins/peity/jquery.peity.min.js"></script>

<!--Morris Chart-->
<script src="../assets/plugins/morris/morris.min.js"></script>
<script src="../assets/plugins/raphael/raphael-min.js"></script>

<!-- dashboard -->
<script src="../assets/pages/dashboard.js"></script>

<!-- App js -->
<script src="../assets/js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


// All animations will take twice the time to accomplish
document.documentElement.style.setProperty('--animate-duration', '2s');

// All animations will take half the time to accomplish
document.documentElement.style.setProperty('--animate-duration', '.5s');
</script>

</body>

</html>