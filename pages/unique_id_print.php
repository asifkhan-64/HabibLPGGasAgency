<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];
    $gteCategoryData = mysqli_query($connect, "SELECT * FROM categories WHERE id='$id'");
    $rowCategoryData = mysqli_fetch_assoc($gteCategoryData);

    if ($rowCategoryData['category_type'] === 'Qty') {
        $textToShow = "Piece";
    } else {
        $textToShow = "Kg/Ltr";
    }

    $get = mysqli_query($connect, "SELECT * FROM `shop_info`");
    $fet = mysqli_fetch_assoc($get);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../assets/logo.png">
    <title>Print Unique ID - <?php echo $id; ?></title>
    <style>
        /* Thermal Printer Optimization */
        @page {
            size: auto;
            margin: 0mm; /* Removes default browser headers/footers */
        }

        body {
            font-family: Times; /* Monospace prints better on thermal */
            /* width: 100%; */
            margin: 0;
            padding: 5px;
            color: black;
            background-color: white;
        }

        .ticket-container {
            width: 100%;
            max-width: 300px; /* Standard 80mm width roughly */
            text-align: center;
            margin: 0 auto;
            margin-bottom: 0px !important

        }

        .shop-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .label-title {
            font-size: 12px;
            margin: 5px 0;
            border-top: 1px dashed #000;
            padding-top: 5px;
             font-weight: bold;
        }

        .tracking-id {
            font-size: 48px; /* Reduced from 80px to prevent overflow */
            font-weight: bold;
            margin: 10px 0;
            display: block;
            font-family: "Lucida Handwriting", cursive;
        }

        .category-name {
            font-size: 22px;
            font-weight: bold;
        }

        .price {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer-line {
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
        }

        /* Auto-hide non-printing elements if any */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="shop-name"><?php echo $fet['shop_title']; ?></div>
        <br>
        <div class="label-title">TRACKING ID</div>
        
        <div class="tracking-id">
            <?php echo $rowCategoryData['id']; ?>
        </div>
        
        <div class="footer-line"></div>
        
        <div class="category-name">
            <?php echo $rowCategoryData['category_name']; ?>
        </div>

        <br>
        
        <div class="price">
            Price: <?php echo $rowCategoryData['sell_price']." / ".$textToShow; ?>
        </div>

        <div class="footer-line"></div>
    </div>

<script>
    window.onload = function() {
        window.print();
        // Optional: Close window after printing
        //window.onafterprint = function() { window.close(); }
    }
</script>

</body>
</html>