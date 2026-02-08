<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) { header("LOCATION:../index.php"); }

    date_default_timezone_set("Asia/Karachi");
    $currentDate = date('Y-m-d h:i:s A');

    $id = $_GET['id'];
    $invoiceNo = $_GET['invoiceNo'];

    // --- Database Queries ---
    $getInvoiceItems = mysqli_query($connect, "SELECT customer_weight_invoice.*, customer_weight_invoice.prod_qty AS qty, weight_stock_purchase.*, categories.category_name, categories.stock_available FROM `customer_weight_invoice`
    INNER JOIN weight_stock_purchase ON weight_stock_purchase.c_id = customer_weight_invoice.prod_id
    INNER JOIN categories ON categories.id = weight_stock_purchase.c_id
    WHERE customer_weight_invoice.cus_id = '$id'  AND customer_weight_invoice.invoice_no = '$invoiceNo' GROUP BY customer_weight_invoice.prod_id");

    $getCustomerDetails = mysqli_query($connect, "SELECT * FROM `customer_add` WHERE c_id = '$id'");
    $fetch_getCustomerDetails = mysqli_fetch_assoc($getCustomerDetails);

    $getTotals = mysqli_query($connect, "SELECT * FROM `customer_summary_weight` WHERE c_id = '$id' AND invoice_id = '$invoiceNo'");
    $fetch_getTotals = mysqli_fetch_assoc($getTotals);

    $timeFromDB = $fetch_getTotals['auto_date']; 
    $time = date("H:i:s A", strtotime($timeFromDB));

    $getShop = mysqli_query($connect, "SELECT * FROM `shop_info`");
    $fet = mysqli_fetch_assoc($getShop);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice_<?php echo $invoiceNo; ?></title>
    <style>
        /* 1. Hardware Specific Reset */
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        @page {
            size: 80mm auto; /* Force the printer to recognize 80mm width */
            margin: 0;       /* Remove Browser Default Margins */
        }

        body { 
            margin: 0; 
            padding: 0; 
            /* font-family: 'Courier New', Courier, monospace;  */
            font-family: 'Segoe UI', Roboto, sans-serif;
            background: #fff;
            /* font-weight: bold; */
            width: 80mm; /* Match paper width */
        }

        /* 2. Content Container - Narrowed for SP-200U Safe Zone */
        #thermal-receipt {
            width: 70mm; /* Content is narrower than paper to avoid clipping */
            margin-left: 2mm; /* Small left buffer */
            padding: 0;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        
        .header-title { font-size: 18px; font-weight: bold; margin-bottom: 2px; }
        .header-subtitle { font-size: 14px; margin-bottom: 5px; }
        
        .dashed-line { border-top: 1px dashed #000; margin: 5px 0; width: 100%; }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; 
        }

        th { 
            font-size: 12px; 
            border-bottom: 1px solid #000; 
            padding: 4px 0; 
            text-align: left;
        }

        td { 
            font-size: 12px; 
            padding: 4px 0; 
            word-wrap: break-word; 
            vertical-align: top;
        }

        /* Column Ratios */
        .item-col { width: 35%; }
        .qty-col  { width: 15%; text-align: center; }
        .price-col { width: 22%; text-align: right; }
        .total-col { width: 28%; text-align: right; }

        .summary-label { width: 60%; text-align: right; padding-right: 5px; }
        .summary-value { width: 40%; text-align: right; }

        /* 3. Printing Overrides */
        @media print {
            body { width: 80mm; }
            #thermal-receipt { width: 70mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div id="thermal-receipt">
    <div class="text-center">
        <div class="header-title"><?php echo strtoupper($fet['shop_title']); ?></div>
        <div class="header-subtitle"><?php echo $fet['shop_name']; ?></div>
        <div style="font-size: 11px;"><?php echo $fet['shop_address']; ?></div>
        <div style="font-size: 11px;">Contact: 0<?php echo $fet['shop_contact']; ?>, 0<?php echo $fet['shop_contact_two']; ?></div>
    </div>

    <div class="dashed-line"></div>

    <div style="font-size: 12px;">
        <table>
            <tr><td style="width:30%"><b>Invoice:</b></td><td class="text-right">WT-00<?php echo $invoiceNo; ?></td></tr>
            <tr><td><b>Date:</b></td><td class="text-right"><?php echo substr($fetch_getTotals['auto_date'], 0, 10); ?></td></tr>
            <tr><td><b>Time:</b></td><td class="text-right"><?php echo $time; ?></td></tr>
            <tr><td><b>Customer:</b></td><td class="text-right"><?php echo $fetch_getCustomerDetails['customer_name']; ?></td></tr>
        </table>
    </div>

    <div class="dashed-line"></div>

    <table>
        <thead>
            <tr>
                <th class="item-col">Item</th>
                <th class="qty-col">Qty</th>
                <th class="price-col">Price</th>
                <th class="total-col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($getInvoiceItems, 0); 
            while ($row = mysqli_fetch_assoc($getInvoiceItems)) {
                $line_total = $row['prod_qty'] * $row['prod_price'];
                echo "<tr>
                        <td class='item-col'>".substr($row['category_name'], 0, 12)."</td>
                        <td class='qty-col'>".$row['prod_qty']."</td>
                        <td class='price-col'>".$row['prod_price']."</td>
                        <td class='total-col'>".$line_total."</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="dashed-line"></div>

    <table>
        <tr>
            <td class="summary-label">Sub Total:</td>
            <td class="summary-value bold"><?php echo $fetch_getTotals['net_amount']; ?></td>
        </tr>
        <tr>
            <td class="summary-label">Paid Amount:</td>
            <td class="summary-value"><?php echo $fetch_getTotals['paid_amount']; ?></td>
        </tr>
        <tr>
            <td class="summary-label">Current Bal:</td>
            <td class="summary-value bold"><?php echo $fetch_getTotals['remaining_amount']; ?></td>
        </tr>
        <tr>
            <td class="summary-label">Prev. Dues:</td>
            <td class="summary-value"><?php echo $fetch_getCustomerDetails['total_dues'] - $fetch_getTotals['remaining_amount']; ?></td>
        </tr>
        <tr style="font-size: 14px;">
            <td class="summary-label bold">TOTAL DUE:</td>
            <td class="summary-value bold"><?php echo $fetch_getCustomerDetails['total_dues']; ?></td>
        </tr>
    </table>

    <div class="dashed-line"></div>
    
    <?php
    if ($fetch_getCustomerDetails['total_dues'] > 0) {
        echo '
        <div class="text-center" style="font-size: 11px;">
            <div class="bold"><strong>Please clear your dues. Thank you!</strong></div>
            <div class="dashed-line"></div>
        </div>
        '; 
    }
    ?>

    <div class="text-center" style="font-size: 11px;">
         <?php
        if ($fetch_getCustomerDetails['remaining_cylinders'] > 0) {
        ?>
        <div>Remaining Cylinders: <b><?php echo $fetch_getCustomerDetails['remaining_cylinders']; ?></b></div>
        <br>
        <?php } ?>
        <div class="bold">Software by Pixelium Tech</div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
        // Optional: window.close(); // Close tab after printing
    };
</script>
</body>
</html>