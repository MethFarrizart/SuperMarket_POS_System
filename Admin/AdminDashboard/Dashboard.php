<?php
include('../../Connection/Connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="stylesheet" href="../../../Mart_POS_System/Components/design.css">
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
</head>

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

                    <div class="h4 " style="margin-top: 120px;">
                        Statistic Summary Detail
                    </div>

                    <!-- Show Last Seen -->
                    <div class="text-end text-secondary" style="margin-top: 120px;">
                        Last Seen:
                        <?php
                        $date1 = date_create('2023-06-15'); //old
                        $date2 = date_create(date('Y-m-d')); //new
                        $diff = date_diff($date1, $date2);

                        echo  $show = $diff->format("%a") . ' ' . 'days ago';
                        ?>
                    </div>
                </div>
                <!-- Digital Clock -->
                <div class="text-center" style="margin-bottom: 20px">
                    <strong class="fs-4" id="day"></strong> <strong>/</strong>
                    <strong class="fs-4" id="month"></strong> <strong>/</strong>
                    <!-- <strong class="fs-4" id="nth"></strong> <sup><b id="th"></b></sup> <strong>/</strong> -->
                    <strong class="fs-4" id="year"></strong> <strong class="fs-4">~</strong>
                    <strong class="fs-4" id="hrs"></strong> <strong class="fs-4">:</strong>
                    <strong class="fs-4" id="min"></strong> <strong class="fs-4">:</strong>
                    <strong class="fs-4" id="sec"></strong> <strong class="fs-4" id="time"></strong>
                </div>
                <hr>


                <div class="row">
                    <div class="col-8">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                Sales Overview</h3>
                            <div class="other-border d-flex gap-3 p-2 ps-3">
                                <img src="../../Images/up.png" alt="">
                                <h4 class="pt-3 text-white ">
                                    Total Sales:
                                    <?php
                                    $sell_total = $con->query("SELECT * FROM invoice");
                                    $total = mysqli_num_rows($sell_total);
                                    if ($total > 0) {
                                    ?>
                                        <h4 class="pt-3 text-white mx-5">
                                            <?= $total ?>
                                            <span class="mx-1"> Times</span>
                                        </h4>

                                    <?php } ?>

                                </h4>
                            </div>
                            <div class="other-border d-flex gap-3 p-2 ps-3">
                                <img src="../../Images/income.png" alt="">
                                <h4 class="pt-3 text-white ">
                                    Total Incomes:
                                    <?php
                                    $income = $con->query("SELECT SUM(GrandTotal) AS grandTotal FROM payment");
                                    while ($incomeTotal = $income->fetch_assoc()) {
                                        $result = $incomeTotal['grandTotal']
                                    ?>
                                        <h4 class="pt-3 text-white">
                                            &nbsp;&nbsp;&nbsp; $<?= ' ' . number_format($result, 2)  ?>
                                        </h4>

                                    <?php  } ?>

                                </h4>
                            </div>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                Product Overview</h3>
                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/producttotal.png" alt="">

                                <!-- Count Product -->
                                <?php
                                $all_pro = $con->query("SELECT * FROM product");
                                if (mysqli_num_rows($all_pro) > 0) {
                                ?>
                                    <h4 class="pt-3 text-white" data-count="<?php echo mysqli_num_rows($all_pro) ?>">
                                        Total Product: &nbsp;&nbsp;&nbsp; <span class="mx-5"> 0 </span>
                                    </h4>
                                <?php } ?>
                            </div>

                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/category.png" alt="">

                                <!-- Count Category -->
                                <?php
                                $all_cate = $con->query("SELECT * FROM category");
                                if (mysqli_num_rows($all_cate) > 0) {
                                ?>
                                    <h4 class="pt-3 text-white" data-count="<?php echo mysqli_num_rows($all_cate) ?>">
                                        Total Category: &nbsp; <span class="mx-5"> 0 </span>
                                    </h4>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-8">
                        <div class="border border-all d-flex flex-column gap-3 p-4" style="background: none;">
                            <div id="curve_chart" style="width: auto; height: 500px;"></div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="border border-all d-flex flex-column gap-3 p-4">
                            <h3 class="text-white">
                                Stock Control</h3>
                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/stockin.png" alt="">

                                <!-- Sum Stock-In-->
                                <?php
                                $sum_pro = $con->query("SELECT SUM(Qty) AS Qty FROM product");
                                while ($row_sum = $sum_pro->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white" data-count="<?= $row_sum['Qty'] ?>">
                                        Total Stock-IN: &nbsp;&nbsp; <span class="mx-5"> </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/expired.png" alt="">

                                <!-- Sum Expired product-->
                                <?php
                                $sum_proExpired = $con->query("SELECT SUM(Qty) AS Qty FROM product WHERE StatusID = 4");
                                while ($row_sum = $sum_proExpired->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white" data-count="<?= $row_sum['Qty'] ?>">
                                        Expired Product: <span class=" mx-5"> </span>
                                    </h4>
                                <?php } ?>
                            </div>


                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/topsale.png" alt="">
                                <h4 class="pt-3 text-white ">
                                    Top Sale: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <h4 class="pt-3 text-white mx-4" data-count="5">
                                        <span class="mx-5"> 0 </span>
                                    </h4>
                                </h4>
                            </div>
                            <div class="other-border d-flex gap-3 p-2 ps-3" style="border-radius: 20px;">
                                <img src="../../Images/soldout.png" alt="">
                                <!-- Sum Sold Out product-->
                                <?php
                                $sum_proOut = $con->query("SELECT Count(*) AS Qty FROM product WHERE StatusID = 3");
                                while ($row_sum = $sum_proOut->fetch_assoc()) {
                                ?>
                                    <h4 class="pt-3 text-white" data-count="<?= $row_sum['Qty'] ?>">
                                        Sold Out: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="mx-5"> 0 </span>
                                    </h4>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Top Selling -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <p class="fs-4">
                                Top Selling Product
                            </p>

                            <table class="table table-hover">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                        <td>ProductID</td>
                                        <td> Product Name</td>
                                        <td> Qty in Stock</td>
                                        <td> Image </td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $top_pro = $con->query("SELECT DISTINCT OD.ProductID, p.ProductID, p.Image, p.Qty, p.ProductName, COUNT(*) AS Amount FROM invoice_detail OD 
                                            INNER JOIN Product p ON p.ProductID = OD.ProductID GROUP BY p.ProductID 
                                            HAVING Amount > 10
                                            ORDER BY Amount DESC LIMIT 5");
                                    if (mysqli_num_rows($top_pro) > 0) {
                                        while ($top_pro_row = $top_pro->fetch_assoc()) {
                                    ?>
                                            <tr class="text-center h6" style="line-height: 50px;">
                                                <td><?= $top_pro_row['ProductID'] ?></td>
                                                <td><?= $top_pro_row['ProductName'] ?></td>
                                                <td><?= $top_pro_row['Qty'] ?></td>
                                                <td><img src="../AdminDashboard/Images/<?= $top_pro_row['Image'] ?>" width="50" height="50" alt=""></td>
                                            </tr>

                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="4" align=center>
                                                <div class="d-flex gap-3 mt-5 justify-content-center">
                                                    <div class="lds-ellipsis">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                    <h4><i>Nothing ...! </i></h4>
                                                    <div class="lds-ellipsis">
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                        <div></div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>


                <!-- Expired Product -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <p class="fs-4">
                                Expired Product
                            </p>

                            <table class="table table-hover">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                        <td>
                                            ProductID</td>
                                        <td>
                                            Product Name</td>
                                        <td>
                                            Qty in Stock</td>
                                        <td>
                                            Image
                                        </td>
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
                                            <td> <img src="../../Images/<?php echo $row_proExpire['Image'] ?>" width="50px" height="50px" alt=""> </td>
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
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="bg-white p-4 pb-5 shadow" style="border-radius: 20px;">
                            <p class="fs-4">
                                Never Sold Out
                            </p>

                            <table class="table table-hover">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                        <td>
                                            ProductID</td>
                                        <td>
                                            Product Name</td>
                                        <td>
                                            Qty in Stock</td>
                                        <td>
                                            Image
                                        </td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $never = $con->query("SELECT * FROM product WHERE StatusID NOT IN (2) AND ProductID NOT IN(SELECT ProductID FROM invoice_detail) LIMIT 5 ");
                                    while ($never_row = $never->fetch_assoc()) {
                                    ?>
                                        <tr class="text-center h6" style="line-height: 50px;">
                                            <td><?= $never_row['ProductID'] ?> </td>
                                            <td><?= $never_row['ProductName'] ?> </td>
                                            <td><?= $never_row['Qty'] ?> </td>
                                            <td> <img src="../AdminDashboard/Images/<?= $never_row['Image'] ?>" width="50px" height="50px" alt=""> </td>
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
                            Expired Product
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                    <td>
                                        ProductID</td>
                                    <td>
                                        Product Name</td>
                                    <td>
                                        Qty in Stock</td>
                                    <td>
                                        Image
                                    </td>
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
                                        <td> <img src="../../Images/<?php echo $row_proExpire['Image'] ?>" width="50px" height="50px" alt=""> </td>
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
                            Never Sold Out
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr class="mt-4 text-white text-center h5" style="background-color: #198531; line-height: 50px;">
                                    <td>
                                        ProductID</td>
                                    <td>
                                        Product Name</td>
                                    <td>
                                        Qty in Stock</td>
                                    <td>
                                        Image
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $never = $con->query("SELECT * FROM product WHERE StatusID NOT IN (2) AND ProductID NOT IN(SELECT ProductID FROM invoice_detail) ");
                                while ($never_row = $never->fetch_assoc()) {
                                ?>
                                    <tr class="text-center h6" style="line-height: 50px;">
                                        <td><?= $never_row['ProductID'] ?> </td>
                                        <td><?= $never_row['ProductName'] ?> </td>
                                        <td><?= $never_row['Qty'] ?> </td>
                                        <td> <img src="../AdminDashboard/Images/<?= $never_row['Image'] ?>" width="50px" height="50px" alt=""> </td>
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

<!-- Google-Chartjs -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var datas = google.visualization.arrayToDataTable([
            ['Year', 'Day Income From Sale'],
            <?php
            $select = $con->query("SELECT O.InvoiceID, Date_Format(O.InvoiceDate, '%D') AS Day , SUM(P.GrandTotal) AS Total , P.InvoiceID FROM payment P
            INNER JOIN invoice O ON O.InvoiceID = P.InvoiceID GROUP BY Day");

            while ($select_row = $select->fetch_assoc()) {
                $day = $select_row['Day'];
                $total = $select_row['Total'];
            ?>['<?= $day ?>', <?= $total ?>],

            <?php  } ?>
        ]);

        var options = {
            title: 'The Curve of Selling',
            curveType: 'function',
            colors: ['red'],
            legend: {
                position: 'bottom'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(datas, options);
    }
</script>