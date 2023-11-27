<?php
require('../../Translate/lang.php');
include('../../Connection/Connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="stylesheet" href="../../../Mart_POS_System/Components/design.css?v=<?php echo time() ?>">
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="../AdminDashboard/Css/glide.theme.css">
</head>

<style>
    .text-move {
        animation: animes 0.5s ease;
    }

    @keyframes animes {
        0% {
            transform: translate(400px, 0);
        }
    }

    .title {
        animation: title 0.5s ease;
    }

    @keyframes title {
        0% {
            transform: translate(-500px, 0);
        }
    }
</style>

<body>
    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>
            <div class="container-fluid">
                <div class="d-flex justify-content-between">

                    <div class="h4" style="margin-top: 120px;">
                        <img style="height: 40px;" src="https://cdn4.iconfinder.com/data/icons/essentials-74/24/046_-_House-256.png" alt="">
                        <?= __('Statistic Summary Detail') ?> <br>
                    </div>

                    <!-- Show Last Seen -->
                    <div class="text-end text-secondary" style="margin-top: 120px;">
                        Last Seen:
                        <?php
                        $date1 = date_create('2023-06-15'); //old date
                        $date2 = date_create(date('Y-m-d')); //till now
                        $diff = date_diff($date1, $date2); //different date

                        echo  $show = $diff->format("%a") . ' ' . 'days ago';
                        ?>
                    </div>
                </div>


                <!-- Digital Clock -->
                <div class="text-center" style="margin-bottom: 20px">
                    <strong class="fs-4" id="day"></strong> <strong>/</strong>
                    <strong class="fs-4" id="month"></strong> -
                    <strong class="fs-4" id="day_num"></strong> <strong>/</strong>
                    <strong class="fs-4" id="year"></strong> <strong class="fs-4">~</strong>
                    <strong class="fs-4" id="hrs"></strong> <strong class="fs-4">:</strong>
                    <strong class="fs-4" id="min"></strong> <strong class="fs-4">:</strong>
                    <strong class="fs-4" id="sec"></strong> <strong class="fs-4" id="time"></strong>
                </div>
                <hr>


                <div class="row">

                    <!-- Purchase Overview -->
                    <div class="col-3">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                <?= __('Purchase Overview') ?>
                            </h3>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn1.iconfinder.com/data/icons/filled-outline-hobbies-1/64/hobby-shopping-bag-purchase-mall-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Purchase') ?>
                                    </h5>

                                    <!-- <div>
                                        <?php
                                        $sell_total = $con->query("SELECT * FROM invoice");
                                        $total = mysqli_num_rows($sell_total);
                                        if ($total > 0) {
                                        ?>
                                            <span class="text-white h6 fw-bold counter">
                                                <?= $total ?> <?= __('Times') ?>
                                            </span>
                                        <?php } ?>
                                    </div> -->
                                </div>
                            </div>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn0.iconfinder.com/data/icons/crisis-management-soft-fill/60/Financial-Crash-emergency-catastrophe-stock-market-bear-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Expense') ?>
                                    </h5>

                                    <!-- <div>
                                        <?php
                                        $income = $con->query("SELECT SUM(GrandTotal) AS grandTotal FROM payment");
                                        while ($incomeTotal = $income->fetch_assoc()) {
                                            $result = $incomeTotal['grandTotal']
                                        ?>
                                            <span class="text-white h6 fw-bold counter">
                                                <?= '$ ' . number_format($result, 2)  ?>
                                            </span>

                                        <?php  } ?>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Sell Overview  -->
                    <div class="col-3">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                <?= __('Sales Overview') ?>
                            </h3>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn4.iconfinder.com/data/icons/prettycons-shopping-flat/59/015-Dollar_Pin-shopping_commerce_buy_sale_sell-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Sales') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $sell_total = $con->query("SELECT * FROM invoice");
                                        if (mysqli_num_rows($sell_total) > 0) {
                                        ?>
                                            <div class="text-white h6 fw-bold">
                                                <span class="counter">
                                                    <?= mysqli_num_rows($sell_total) ?>
                                                </span>
                                                <span><?= __('Times') ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Income -->
                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn3.iconfinder.com/data/icons/shopping-financial-set-2-1/145/57-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Incomes') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $income = $con->query("SELECT SUM(GrandTotal) AS grandTotal FROM payment");
                                        while ($incomeTotal = $income->fetch_assoc()) {
                                            $result = $incomeTotal['grandTotal']
                                        ?>
                                            <div class="text-white h6 fw-bold">
                                                <span>$ </span>
                                                <span class="counter">
                                                    <?= number_format($result, 2)  ?>
                                                </span>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Product Overview -->
                    <div class="col-3">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                <?= __('Product Overview') ?>
                            </h3>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn0.iconfinder.com/data/icons/Aristocracy_WebDesignTuts/48/Download_Crate.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Product') ?>
                                    </h5>

                                    <div align=left>
                                        <?php
                                        $all_pro = $con->query("SELECT * FROM product");
                                        if (mysqli_num_rows($all_pro) > 0) {
                                        ?>
                                            <span class="h6 text-white fw-bold ">
                                                <?= mysqli_num_rows($all_pro) ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>


                            <!-- Total Category -->
                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn2.iconfinder.com/data/icons/e-commerce-534/64/Category-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Category') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $all_cate = $con->query("SELECT * FROM category");
                                        if (mysqli_num_rows($all_cate) > 0) {
                                        ?>
                                            <h6>
                                                <span class="text-white fw-bold ">
                                                    <?= mysqli_num_rows($all_cate) ?>
                                                </span>
                                            </h6>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>


                            <!-- Total Brand -->
                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn3.iconfinder.com/data/icons/branding-flat/512/cmyk-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Brand') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $all_brand = $con->query("SELECT * FROM brand");
                                        if (mysqli_num_rows($all_brand) > 0) {
                                        ?>
                                            <h6>
                                                <span class="text-white fw-bold ">
                                                    <?= mysqli_num_rows($all_brand) ?>
                                                </span>
                                            </h6>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>


                            <!-- Total Unit -->
                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn4.iconfinder.com/data/icons/app-menu-1/1001/Services-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Unit') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $all_unit = $con->query("SELECT * FROM unit");
                                        if (mysqli_num_rows($all_unit) > 0) {
                                        ?>
                                            <h6>
                                                <span class="text-white fw-bold ">
                                                    <?= mysqli_num_rows($all_unit) ?>
                                                </span>
                                            </h6>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Other Information overview -->
                    <div class="col-3">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                <?= __('Other Details') ?>
                            </h3>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn1.iconfinder.com/data/icons/march-8th-women-s-day-astute/512/Support-512.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Customer') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $customer_total = $con->query("SELECT * FROM customer");
                                        $total = mysqli_num_rows($customer_total);
                                        if ($total > 0) {
                                        ?>
                                            <span class="text-white h6 fw-bold">
                                                <?= $total ?> <?= __('members') ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn0.iconfinder.com/data/icons/supply-chain-dualine-flat/64/Supplier-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Supplier') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $getSupplier = $con->query("SELECT * FROM supplier");
                                        $Supplier_amount = mysqli_num_rows($getSupplier);
                                        if ($Supplier_amount > 0) {
                                        ?>
                                            <span class="text-white h6 fw-bold">
                                                <?= $Supplier_amount  ?> <?= __('members') ?>​
                                            </span>

                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 ps-3 mt-3">
                                <img style="width: 45px; height: 48px" src="https://cdn3.iconfinder.com/data/icons/human-resources-flat-3/48/107-256.png" alt="">

                                <div class="d-flex flex-column">
                                    <h5 class="text-white ">
                                        <?= __('Total Seller') ?>
                                    </h5>

                                    <div>
                                        <?php
                                        $getSeller = $con->query("SELECT * FROM Staff WHERE PositionID = 90");
                                        if (mysqli_num_rows($getSeller) > 0) {
                                        ?>
                                            <div class="text-white h6 fw-bold">
                                                <?= mysqli_num_rows($getSeller) ?> ​

                                                <span><?= __('members') ?></span>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-4">
                    <!-- Yearly Incomes -->
                    <div class="col-6">
                        <div class="border border-all d-flex flex-column gap-3 p-4 shadow" style="background: none;">
                            <b class="fs-3 text-style"> <i><?= __('Yearly Incomes') ?></i> </b>
                            <div id="year_sale" style="width: auto; height: 400px;"></div>
                        </div>
                    </div>

                    <!-- Stock Controll Management -->
                    <div class="col-6">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                <?= __('Stock Control') ?></h3>
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img src="../../Images/stockin.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Total Stock-IN') ?>:
                                    </h4>
                                </div>

                                <!-- Sum Stock-In-->
                                <?php
                                $sum_pro = $con->query("SELECT SUM(Qty) AS Qty FROM product");
                                while ($row_sum = $sum_pro->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white">
                                        <span class="px-5 text-white h4 fw-bold"> <?= $row_sum['Qty'] ?>
                                        </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <!-- Sum Near expiration product-->
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img style="width: 60px" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678136-shield-warning-256.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Nearly Expired') ?>:
                                    </h4>
                                </div>

                                <?php
                                $sum_proExpired = $con->query("SELECT COUNT(*) AS AMOUNT FROM product WHERE ProductName IN
                                (SELECT ProductName FROM product WHERE Expired_On BETWEEN CURDATE() AND CURDATE() + INTERVAL 3 DAY)");
                                while ($row_sum = $sum_proExpired->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white">
                                        <span class="px-5 text-white h4 fw-bold"> <?= $row_sum['AMOUNT'] ?>
                                        </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <!-- Sum Expired product-->
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img src="https://cdn0.iconfinder.com/data/icons/purple-set/512/calender_remove_minus_expired_wrong_cancel-64.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Expired Product') ?>:
                                    </h4>
                                </div>

                                <?php
                                $sum_proExpired = $con->query("SELECT COUNT(*) AS Qty FROM product WHERE StatusID = 4");
                                while ($row_sum = $sum_proExpired->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white">
                                        <span class="px-5 text-white h4 fw-bold"> <?= $row_sum['Qty'] ?>
                                        </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <!-- sum top sale product -->
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img src="../../Images/topsale.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Top Sale') ?>:
                                    </h4>
                                </div>


                                <?php
                                $count_top_product = $con->query(
                                    "SELECT COUNT(*) as TOTAL FROM product WHERE ProductID IN(
                                            SELECT p.ProductID FROM product p INNER JOIN invoice_detail OD ON p.ProductID = OD.ProductID GROUP BY p.ProductID 
                                            HAVING COUNT(*) > 5
                                        ) "
                                );
                                while ($row = $count_top_product->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white">
                                        <span class="px-5 text-white h4 fw-bold"><?= $row['TOTAL']  ?> </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <!-- Sum Sold Out product-->
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img src="../../Images/soldout.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Sold Out') ?>:
                                    </h4>
                                </div>

                                <?php
                                $sum_proOut = $con->query("SELECT Count(*) AS Qty FROM product WHERE StatusID = 3");
                                while ($row_sum = $sum_proOut->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white">
                                        <span class="px-5 text-white h4 fw-bold"> <?= $row_sum['Qty'] ?>
                                        </span>
                                    </h4>
                                <?php } ?>
                            </div>

                            <!-- sum Never Sold Out product -->
                            <div class="other-border d-flex justify-content-between gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <div class="d-flex gap-3">
                                    <img style="width: 60px;" src="https://cdn1.iconfinder.com/data/icons/supermarket-16/64/warehouse-storage-stocks-store-512.png" alt="">
                                    <h4 class="pt-3 text-white">
                                        <?= __('Never Sold Out') ?>:
                                    </h4>
                                </div>

                                <h4 class="pt-3 text-white">
                                    <?php
                                    $count_top_product = $con->query(
                                        "SELECT COUNT(*) as TOTAL FROM product WHERE StatusID NOT IN(2,3) AND ProductID NOT IN(
                                            SELECT ProductID FROM invoice_detail
                                        ) "
                                    );
                                    while ($row = $count_top_product->fetch_assoc()) {
                                    ?>
                                        <span class="px-5 text-white h4 fw-bold"><?= $row['TOTAL']  ?> </span>

                                    <?php } ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class=" mt-4">
                    <!-- Monthly Expense -->
                    <div class="row">
                        <div class="col-6">
                            <div class="border border-all d-flex flex-column gap-3 p-4 shadow" style="background: none;">
                                <b class="fs-3 text-style"> <i> <?= __('Monthly Expense') ?></i> </b>
                                <div id="monthly_expense" style="width: auto; height: 400px;"></div>
                            </div>
                        </div>

                        <!-- Annual Expense -->
                        <div class="col-6">
                            <div class="border border-all d-flex flex-column gap-3 p-4 shadow" style="background: none;">
                                <b class="text-start fs-3 text-style"> <i> <?= __('Annual Expense') ?></i> </b>
                                <div id="annual_expense" style="width: auto; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class=" mt-4">
                    <!-- Monthly Incomes -->
                    <div class="row">
                        <div class="col-6">
                            <div class="border border-all d-flex flex-column gap-3 p-4 shadow" style="background: none;">
                                <b class="fs-3 text-style"> <i> <?= __('Monthly Incomes') ?></i> </b>
                                <div id="month_sale" style="width: auto; height: 400px;"></div>
                            </div>
                        </div>

                        <!-- Daily Incomes -->
                        <div class="col-6">
                            <div class="border border-all d-flex flex-column gap-3 p-4 shadow" style="background: none;">
                                <b class="text-start fs-3 text-style"> <i> <?= __('Daily Incomes') ?></i> </b>
                                <div id="daily_sale" style="width: auto; height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Chart Overview -->
                <?php
                include('./NewChart.php');
                ?>


                <!-- Top Selling -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <div class="d-flex gap-2">
                                <img style="height: 40px;" src="../../Images/topsale.png" alt="">
                                <p class="fs-4"><?= __('Top Selling Product') ?></p> <br>
                            </div>

                            <div class="glide mt-3">
                                <div class="glide__track" data-glide-el="track">
                                    <ul class="glide__slides">
                                        <?php
                                        $top_pro = $con->query("SELECT DISTINCT OD.ProductID, p.ProductID, p.Image, p.Qty, p.ProductName, COUNT(*) AS Amount FROM invoice_detail OD 
                                            INNER JOIN Product p ON p.ProductID = OD.ProductID GROUP BY p.ProductID 
                                            HAVING Amount > 5
                                            ORDER BY Amount DESC");
                                        if (mysqli_num_rows($top_pro) > 0) {
                                            while ($top_pro_row = $top_pro->fetch_assoc()) {
                                        ?>

                                                <li class="glide__slide d-flex flex-column gap-2">
                                                    <?php
                                                    if ($top_pro_row['Image'] != null) {

                                                    ?>
                                                        <img src="../../Images/<?php echo $top_pro_row['Image'] ?>" class="w-100 h-75" alt="">

                                                    <?php } else { ?>
                                                        <div align=center>
                                                            <img class="w-50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                                        </div>

                                                    <?php } ?>
                                                    <span><?= $top_pro_row['ProductName'] ?></span>
                                                    <span><?= __('Qty') ?> : <?= $top_pro_row['Qty'] ?></span>
                                                </li>

                                            <?php }
                                        } else { ?>
                                    </ul>
                                    <div class="d-flex gap-3 mt-5 justify-content-center">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <h4><i><?= __('Nothing') ?> ...! </i></h4>
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>

                                <div class="glide__arrows" data-glide-el="controls">
                                    <i class="fa-solid fw-bold fa-chevron-left glide__arrow glide__arrow--left" data-glide-dir="<"></i>
                                    <i class="fa-solid fw-bold fa-chevron-right glide__arrow glide__arrow--right" data-glide-dir=">"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sold Out Product -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <div class="d-flex gap-2">
                                <img style="height: 40px;" src="../../Images/soldout.png" alt="">
                                <p class="fs-4"><?= __('Sold Out') ?></p> <br>
                            </div>

                            <div class="glide mt-3">
                                <div class="glide__track" data-glide-el="track">
                                    <ul class="glide__slides">
                                        <?php
                                        $sold_out = $con->query("SELECT ProductName, Image FROM product WHERE StatusID = 3");
                                        if (mysqli_num_rows($sold_out) > 0) {
                                            while ($sold_out_row = $sold_out->fetch_assoc()) {
                                        ?>

                                                <li class="glide__slide d-flex flex-column gap-2">
                                                    <?php
                                                    if ($sold_out_row['Image'] != null) {

                                                    ?>
                                                        <img src="../../Images/<?php echo $sold_out_row['Image'] ?>" class="w-100 h-75" alt="">

                                                    <?php } else { ?>
                                                        <div align=center>
                                                            <img class="w-50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                                        </div>

                                                    <?php } ?>
                                                    <span><?= $sold_out_row['ProductName'] ?></span>
                                                </li>

                                            <?php }
                                        } else { ?>
                                    </ul>
                                    <div class="d-flex gap-3 mt-5 justify-content-center">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <h4><i><?= __('Nothing') ?> ...! </i></h4>
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>

                                <div class="glide__arrows" data-glide-el="controls">
                                    <i class="fa-solid fw-bold fa-chevron-left glide__arrow glide__arrow--left" data-glide-dir="<"></i>
                                    <i class="fa-solid fw-bold fa-chevron-right glide__arrow glide__arrow--right" data-glide-dir=">"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nearly Expired Product -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <div class="d-flex gap-2">
                                <img style="height: 40px;" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678136-shield-warning-256.png" alt="">
                                <p class="fs-4">
                                    <?= __('Nearly Expired') ?>
                                </p>
                            </div>


                            <div class="mt-3 glide">
                                <div class="glide__track" data-glide-el="track">
                                    <ul class="glide__slides">
                                        <?php
                                        $near_expired_pro = $con->query("SELECT * FROM product WHERE Expired_On BETWEEN CURDATE() AND CURDATE() + INTERVAL 3 DAY");
                                        if (mysqli_num_rows($near_expired_pro) > 0) {
                                            while ($near_expired_pro_row = $near_expired_pro->fetch_assoc()) {
                                        ?>

                                                <li class="glide__slide d-flex flex-column gap-2">
                                                    <?php
                                                    if ($near_expired_pro_row['Image'] != null) {

                                                    ?>
                                                        <img src="../../Images/<?php echo $near_expired_pro_row['Image'] ?>" class="w-100 h-75" alt="">

                                                    <?php } else { ?>
                                                        <div align=center>
                                                            <img class="w-50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                                        </div>

                                                    <?php } ?>
                                                    <span><?= $near_expired_pro_row['ProductName'] ?></span>
                                                    <span><?= __('Qty') ?> : <?= $near_expired_pro_row['Qty'] ?></span>
                                                </li>

                                            <?php }
                                        } else { ?>
                                    </ul>
                                    <div class="d-flex gap-3 mt-5 justify-content-center">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <h4><i><?= __('Nothing') ?> ...! </i></h4>
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>

                                <div class="glide__arrows" data-glide-el="controls">
                                    <i class="fa-solid fw-bold fa-chevron-left glide__arrow glide__arrow--left" data-glide-dir="<"></i>
                                    <i class="fa-solid fw-bold fa-chevron-right glide__arrow glide__arrow--right" data-glide-dir=">"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Expired Product -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <div class="d-flex gap-2">
                                <img style="height: 40px;" src="https://cdn0.iconfinder.com/data/icons/purple-set/512/calender_remove_minus_expired_wrong_cancel-64.png" alt="">
                                <p class="fs-4">
                                    <?= __('Expired Product') ?>
                                </p>
                            </div>

                            <table class="mt-3 table table-hover">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                        <td> <?= __('ProductID') ?></td>
                                        <td> <?= __('Product Name') ?></td>
                                        <td> <?= __('Qty in Stock') ?></td>
                                        <td> <?= __('Image') ?></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $qry_expire = $con->query("SELECT * FROM product WHERE StatusID = 4 LIMIT 5");
                                    while ($row_proExpire = $qry_expire->fetch_assoc()) {
                                    ?>
                                        <tr class="text-center h6" style="line-height: 50px;">
                                            <td> <?= $row_proExpire['ProductID'] ?></td>
                                            <td> <?= $row_proExpire['ProductName'] ?></td>
                                            <td> <?= $row_proExpire['Qty'] ?></td>
                                            <td>
                                                <?php
                                                if ($row_proExpire['Image'] != null) {

                                                ?>
                                                    <img src="../../Images/<?php echo $row_proExpire['Image'] ?>" width="50px" height="50px" alt="">
                                                <?php } else { ?>
                                                    <div align=center>
                                                        <img class="w-50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="fs-5 p-2 mb-0" style="float: right;">
                                <a href="#expired" data-bs-toggle="offcanvas" aria-controls="expired">
                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Product that never sold -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <div class="d-flex gap-2">
                                <img style="height: 40px;" src="https://cdn1.iconfinder.com/data/icons/supermarket-16/64/warehouse-storage-stocks-store-512.png" alt="">
                                <p class="fs-4">
                                    <?= __('Never Sold Out') ?>
                                </p>
                            </div>


                            <table class="mt-3 table table-hover">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                        <td> <?= __('ProductID') ?></td>
                                        <td> <?= __('Product Name') ?></td>
                                        <td> <?= __('Qty in Stock') ?></td>
                                        <td> <?= __('Image') ?></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $never = $con->query("SELECT * FROM product WHERE StatusID NOT IN (2, 3) AND ProductID NOT IN(SELECT ProductID FROM invoice_detail) LIMIT 5 ");
                                    while ($never_row = $never->fetch_assoc()) {
                                    ?>
                                        <tr class="text-center h6" style="line-height: 50px;">
                                            <td><?= $never_row['ProductID'] ?> </td>
                                            <td><?= $never_row['ProductName'] ?> </td>
                                            <td><?= $never_row['Qty'] ?> </td>
                                            <?php
                                            if ($never_row['Image'] != null) {

                                            ?>
                                                <td> <img src="../../Images/<?= $never_row['Image'] ?>" width="50px" height="50px" alt=""> </td>

                                            <?php } else { ?>
                                                <td align=center>
                                                    <img width="50px" height="50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                            <div class="fs-5 p-2 mb-0" style="float: right;">
                                <a href="#never" data-bs-toggle="offcanvas" aria-controls="never">
                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- offcanvas Expired product -->
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="expired" aria-labelledby="expiredLabel" style="transition: 0.8s ease;">
        <div class="offcanvas-header">
            <img data-bs-dismiss="offcanvas" aria-label="Close" src="../../Images/gobackicon.png" style="cursor: grab;" width="80px" height="80px">
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-4 pb-5" style="border-radius: 20px;">
                        <p class="fs-4">
                            <?= __('Expired Product') ?>
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                    <td> <?= __('ProductID') ?></td>
                                    <td> <?= __('Product Name') ?></td>
                                    <td> <?= __('Qty in Stock') ?></td>
                                    <td> <?= __('Image') ?></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $qry_expire = $con->query("SELECT * FROM product WHERE StatusID = 4");
                                while ($row_proExpire = $qry_expire->fetch_assoc()) {
                                ?>
                                    <tr class="text-center h6" style="line-height: 50px;">
                                        <td> <?= $row_proExpire['ProductID'] ?></td>
                                        <td> <?= $row_proExpire['ProductName'] ?></td>
                                        <td> <?= $row_proExpire['Qty'] ?></td>
                                        <?php
                                        if ($row_proExpire['Image'] != null) {

                                        ?>
                                            <td>
                                                <img src="../../Images/<?php echo $row_proExpire['Image'] ?>" width="50px" height="50px" alt="">
                                            </td>
                                        <?php } else { ?>
                                            <td align=center>
                                                <img width="50px" height="50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- offcanvas never sold product -->
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="never" aria-labelledby="neverLabel" style="transition: 0.8s ease;">
        <div class="offcanvas-header">
            <img data-bs-dismiss="offcanvas" aria-label="Close" src="../../Images/gobackicon.png" style="cursor: grab;" width="80px" height="80px">
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-4 pb-5" style="border-radius: 20px;">
                        <p class="fs-4">
                            <?= __('Never Sold Out') ?>
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                    <td> <?= __('ProductID') ?></td>
                                    <td> <?= __('Product Name') ?></td>
                                    <td> <?= __('Qty in Stock') ?></td>
                                    <td> <?= __('Image') ?></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $never = $con->query("SELECT * FROM product WHERE StatusID NOT IN (2, 3) AND ProductID NOT IN(SELECT ProductID FROM invoice_detail) ");
                                while ($never_row = $never->fetch_assoc()) {
                                ?>
                                    <tr class="text-center h6" style="line-height: 50px;">
                                        <td><?= $never_row['ProductID'] ?> </td>
                                        <td><?= $never_row['ProductName'] ?> </td>
                                        <td><?= $never_row['Qty'] ?> </td>
                                        <?php
                                        if ($never_row['Image'] != null) {

                                        ?>
                                            <td> <img src="../../Images/<?= $never_row['Image'] ?>" width="50px" height="50px" alt=""> </td>

                                        <?php } else { ?>
                                            <td align=center>
                                                <img width="50px" height="50px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="../../../Mart_POS_System/Action.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js"></script>

<!-- link of slider -->
<!-- <script src="/js/swiper-bundle.min.js"></script>
<script src="js/swiper-bundle.min.js"></script> -->


<!-- Counting Number Animation -->
<script type="text/javascript">
    $('.counter').counterUp({
        // delay: 20,
        time: 3000
    });
</script>







<!-- Google-Chartjs -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Yearly Incomes -->
<script>
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Yearly Income'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, YEAR(O.InvoiceDate) AS YEAR , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY YEAR");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['YEAR'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            colors: ['green'],
        };
        // ('year_sale')
        var chart = new google.charts.Bar(document.getElementById('year_sale'));

        chart.draw(datas, google.charts.Bar.convertOptions(options));
    }
</script>


<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Daily Incomes'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, Date(O.InvoiceDate) AS Day , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY Day");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['Day'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            curveType: 'function',
            legend: {
                position: 'bottom'
            },
            pointSize: 10
        };

        var chart = new google.charts.Bar(document.getElementById('annual_expense'));

        chart.draw(datas, options);
    }
</script>


<!-- Monthly Incomes -->
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Monthly Incomes'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, DATE_FORMAT(O.InvoiceDate,  '%M / %Y') AS MONTH , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY MONTH ORDER BY O.InvoiceDate");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['MONTH'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            curveType: 'function',
            colors: ['red'],
            legend: {
                position: 'bottom'
            },
            pointSize: 10,
        };

        var chart = new google.visualization.LineChart(document.getElementById('month_sale'));

        chart.draw(datas, options);
    }
</script>


<!-- Monthly Expense -->
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Monthly Incomes'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, DATE_FORMAT(O.InvoiceDate,  '%M / %Y') AS MONTH , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY MONTH ORDER BY O.InvoiceDate");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['MONTH'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            curveType: 'function',
            colors: ['red'],
            legend: {
                position: 'bottom'
            },
            pointSize: 10,
        };

        var chart = new google.visualization.LineChart(document.getElementById('monthly_expense'));

        chart.draw(datas, options);
    }
</script>





<!-- Daily Incomes -->
<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Daily Incomes'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, Date(O.InvoiceDate) AS Day , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY Day");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['Day'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            curveType: 'function',
            colors: ['blue'],
            legend: {
                position: 'bottom'
            },
            pointSize: 10
        };

        var chart = new google.visualization.AreaChart(document.getElementById('daily_sale'));

        chart.draw(datas, options);
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>

<script>
    const slide = document.querySelectorAll('.glide');
    for (var i = 0; i < slide.length; i++) {
        new Glide(slide[i], {
            type: 'carousel',
            focusAt: 'center',
            startAt: 0, // Starting slide index
            perView: 5, // Number of slides visible at a time
            gap: 50, // Gap between slides
            autoplay: 3000
        }).mount();
    }
</script>