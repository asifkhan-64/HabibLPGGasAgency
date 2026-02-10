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
                <h5 class="page-title">Customers</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Deleted Customers List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Dues</th>
                                    <th>Paid</th>
                                    <th>Total</th>
                                    <th>Cylinders</th>
                                    <th class="text-center"> <i class="fa fa-refresh"></i></th>
                                    <th class="text-center"> Whatsapp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retCustomers = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE customer_status = '0' ORDER BY c_id DESC");
                                $iteration = 1;

                                $price = 0;

                                while ($rowCustomers = mysqli_fetch_assoc($retCustomers)) {
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowCustomers['customer_name'] . '</td>
                                        <td>0' . $rowCustomers['customer_contact'] . '</td>
                                        <td>' . $rowCustomers['customer_address'] . '</td>
                                        <td>Rs. ' . $rowCustomers['total_dues'] . '</td>
                                        <td>Rs. ' . $rowCustomers['total_paid'] . '</td>
                                        <td>Rs. ' . $rowCustomers['total_sale'] . '</td>
                                        <td class="text-center">' . $rowCustomers['remaining_cylinders'] . '</td>';
                                            
                                            $getCompanyDEtails = mysqli_query($connect, "SELECT * FROM `shop_info`");
                                            $rowCompanyDetails = mysqli_fetch_assoc($getCompanyDEtails);
                                            $phone_number = $rowCustomers['customer_contact']; // Concatenate country code and rest of the number


                                            // 2. Construct the payment details message string
                                            $message = "Hello " . $rowCustomers['customer_name'] . ",%0A%0AYour dues details are as follows:";
                                            
                                            // Package Details
                                            $message .= "%0ATotal Dues: PKR " . number_format($rowCustomers['total_dues']);

                                            // Payment Date
                                            $message .= "%0ARemaining Cylinders: " . number_format($rowCustomers['remaining_cylinders']);

                                            $message .= "%0A%0AKindly clear your dues and return cylinders as soon as possible!";
                                           
                                            // Add Closing Message
                                            $message .= "%0A%0AThank you for your business!";

                                            // Company Info
                                            $message .= "%0A%0ARegards,%0A" . $rowCompanyDetails['shop_title']. ", ".$rowCompanyDetails['shop_name'];
                                            $message .= "%0AAddress: " . $rowCompanyDetails['shop_address'];
                                            $message .= "%0AContact: 0" . $rowCompanyDetails['shop_contact'];
                                            
                                            // NOTE: The message is already URL-encoded enough using %0A for new lines. 
                                            // You could wrap the whole $message in urlencode() for maximum safety.
                                            // $encoded_message = urlencode($message);

                                            // 3. Construct the full WhatsApp URL
                                            $whatsapp_url = "https://wa.me/92{$phone_number}?text={$message}";

                                            echo '
                                            <td class="text-center"><a href="customer_re_add.php?id=' . $rowCustomers['c_id'] . '" type="button" class="btn text-white btn-info waves-effect waves-light">Re-Add</a></td>

                                            <td>
                                                <a href="'.$whatsapp_url.'" 
                                                    class="btn btn-success" 
                                                    target="_blank" 
                                                    rel="noopener noreferrer"
                                                    style="background-color: #25D366; border-color: #25D366;">
                                                        
                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                </a>
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