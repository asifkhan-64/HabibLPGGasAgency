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
                <h5 class="page-title">Customer Recovery</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Recovery List</h4>

                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Dues</th>
                                    <th>Date</th>
                                    <th class="text-center">
                                        <i class="fa fa-edit"></i>
                                    </th>

                                    <th class="text-center">
                                        Whatsapp
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $retCustomers = mysqli_query($connect, "SELECT customer_pay.*, customer_add.* FROM `customer_pay`
                                INNER JOIN customer_add ON customer_add.c_id = customer_pay.customer_id
                                ORDER BY customer_pay.p_id DESC");

                                $iteration = 1;

                                while ($rowCustomers = mysqli_fetch_assoc($retCustomers)) {
                                    $total = number_format($rowCustomers['total_amount']);
                                    $paid = number_format($rowCustomers['paid_amount']);
                                    $remaining = number_format($rowCustomers['remaining_amount']);
                                    echo '
                                    <tr>
                                        <td>' . $iteration++ . '</td>
                                        <td>' . $rowCustomers['customer_name'] . '</td>
                                        <td>0' . $rowCustomers['customer_contact'] . '</td>
                                        <td>Rs. ' . $total . '</td>
                                        <td>Rs. ' . $paid . '</td>
                                        <td>Rs. ' . $remaining . '</td>
                                        <td>' . $rowCustomers['pay_date'] . '</td>
                                        <td class="text-center">
                                            <a href="customer_pay_edit.php?id=' . $rowCustomers['p_id'] . '" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
                                        </td>';

                                            $getCompanyDEtails = mysqli_query($connect, "SELECT * FROM `shop_info`");
                                            $rowCompanyDetails = mysqli_fetch_assoc($getCompanyDEtails);
                                            $phone_number = $rowCustomers['customer_contact']; // Concatenate country code and rest of the number


                                            // 2. Construct the payment details message string
                                            $message = "Hello " . $rowCustomers['customer_name'] . ",%0A%0AYour payment details are as follows:";
                                            
                                            // Package Details
                                            $message .= "%0ATotal Dues: PKR " .$total;

                                            // Payment Date
                                            $message .= "%0APaid Amount: PKR " . $paid;
                                            $message .= "%0ARemaining Amount: PKR " . $remaining;

                                            // $message .= "%0A%0AKindly clear your dues and return cylinders as soon as possible!";
                                           
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