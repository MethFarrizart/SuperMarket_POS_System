<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
</head>
<style>
    .text-move {
        animation: anime 0.5s ease;
    }

    @keyframes anime {
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

            <div class="container-fluid" style="margin-top: 130px;">
                <h4 style="text-decoration:overline 3px solid blue" class="title"><b>Report Last Updated</b> </h4>


                <!-- Digital Clock -->
                <div class="text-end text-move" style="margin-bottom: 20px">
                    <strong class="fs-5" id="day"></strong> <strong>/</strong>
                    <strong class="fs-5" id="month"></strong> <strong>/</strong>
                    <!-- <strong class="fs-5" id="nth"></strong> <sup><b id="th"></b></sup> <strong>/</strong> -->
                    <strong class="fs-5" id="year"></strong> <strong class="fs-5">~</strong>
                    <strong class="fs-5" id="hrs"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="min"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="sec"></strong> <strong class="fs-5" id="time"></strong>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="border border-all gap-3 p-4 shadow " style="border-radius: 20px; background: none">
                            <div style="column-count: 2; column-rule: 1px solid; ">

                                <!-- Category Report -->
                                <div>
                                    <h3 align="center">
                                        <b>Top Categories</b>
                                    </h3>
                                    <div class="mt-4" id="category" style="width: 740px; height: 400px; margin-top: -10px;"></div>

                                </div>


                                <!-- Stock Report -->
                                <div align="center">
                                    <h3>
                                        <b>Stock Control</b>
                                    </h3>
                                    <div class="mt-4" id="columnchart1" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                                </div>
                                <a href="#stock" align="right" data-bs-toggle="offcanvas" aria-controls="stock">
                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                </a>
                            </div>


                            <!-- Status Report -->
                            <div>
                                <h3 class="mx-5 px-5" style="transform: translate(13%, 0)">
                                    <b>Status Percentage</b>
                                </h3>
                                <div class="mt-4" id="status" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Sale Report -->
                    <div class="col-12 mt-4">
                        <div class="border border-all d-flex flex-column gap-3 p-4 shadow;" style="border-radius: 20px; background: none">
                            <h3>
                                <b style="color: rgb(192, 170, 48);">Top Sale</b>
                            </h3>
                            <table class="table table-hover">
                                <thead>
                                    <tr class=" mt-4 text-white text-center h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 50px;">
                                        <td>ProductID</td>
                                        <td> Product Name</td>
                                        <td> Qty in Stock</td>
                                        <td> Image </td>
                                    </tr>
                                </thead>

                                <tbody class="text-center h6" style="line-height: 50px;">
                                    <?php
                                    $top_pro = $con->query("SELECT DISTINCT OD.ProductID, p.ProductID, p.Image, p.Qty, p.ProductName, COUNT(*) AS Amount FROM invoice_detail OD 
                                            INNER JOIN Product p ON p.ProductID = OD.ProductID GROUP BY p.ProductID 
                                            HAVING Amount > 100
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
            </div>
        </div>
    </div>



    <!-- offcanvas stock -->
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="stock" aria-labelledby="stockLabel" style="transition: 0.8s ease;">
        <div class="offcanvas-header">
            <img data-bs-dismiss="offcanvas" aria-label="Close" src="../../Images/gobackicon.png" style="cursor: grab;" width="80px" height="80px">
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-4" style="border-radius: 20px;">
                        <h2 class="text-center"> Stock Control </h2>
                        <div class="mt-5 pt-3 w-100" id="columnchart2" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Piechart category-->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['CateName', 'TotalAmount'],
            <?php
            $cate = $con->query("SELECT DISTINCT C.CategoryID, C.CategoryName, COUNT(C.CategoryID) AS TotalAmount FROM invoice_detail OD 
            INNER JOIN category C ON C.CategoryID = OD.CategoryID GROUP BY C.CategoryID");
            while ($cate_row = $cate->fetch_assoc()) {
                $cateName = $cate_row['CategoryName'];
                $countCate = $cate_row['TotalAmount'];
            ?>['<?= $cateName ?>', <?= $countCate ?>],
            <?php } ?>
        ]);

        var options = {
            is3D: true,
            title: 'The Statistic shows about the trending category',
            fontSize: 15,
        };

        var chart = new google.visualization.PieChart(document.getElementById('category'));

        chart.draw(data, options);
    }
</script>


<!-- Piechart status -->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Names', 'Qtys'],
            <?php
            $each_status = $con->query("SELECT DISTINCT s.StatusID, s.StatusName, Count(*) As Total FROM product p INNER JOIN Status s ON s.StatusID = p.StatusID GROUP BY p.StatusID");
            while ($row_each_status = $each_status->fetch_assoc()) {
                $status = $row_each_status['StatusName'];
                $count = $row_each_status['Total'];
            ?>['<?= $status ?>', <?= $count ?>],
            <?php } ?>
        ]);

        var options = {
            is3D: true,
            title: 'The Statistic shows about the changeble percentage of status ',
            colors: ['green', 'goldenrod', 'crimson', 'blue'],
            fontSize: 15,
        };

        var chart = new google.visualization.PieChart(document.getElementById('status'));

        chart.draw(data, options);
    }
</script>



<!-- Stock ColumnChart1 -->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            [
                'Product Name', 'Stock-Out', 'Balance'
            ],
            <?php
            $stock = $con->query("SELECT DISTINCT OD.ProductID, P.ProductID, P.ProductName, P.Qty, SUM(Amount) AS Count FROM invoice_detail OD
                INNER JOIN product P ON P.ProductID = OD.ProductID GROUP BY OD.ProductID LIMIT 5");
            while ($stock_row = $stock->fetch_assoc()) {
            ?>['<?= $stock_row['ProductName'] ?>', <?= $stock_row['Count'] ?>, <?= $stock_row['Qty'] ?>],
            <?php } ?>

        ]);

        var options = {
            chart: {
                subtitle: 'The Statistic of each product stock'
            },
            colors: ['crimson', 'green'],
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>




<!-- Stock ColumnChart2 -->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            [
                'Product Name', 'Stock-Out', 'Balance'
            ],
            <?php
            $stock = $con->query("SELECT DISTINCT OD.ProductID, P.ProductID, P.ProductName, P.Qty, SUM(Amount) AS Count FROM invoice_detail OD
                INNER JOIN product P ON P.ProductID = OD.ProductID GROUP BY OD.ProductID");
            while ($stock_row = $stock->fetch_assoc()) {
            ?>['<?= $stock_row['ProductName'] ?>', <?= $stock_row['Count'] ?>, <?= $stock_row['Qty'] ?>],
            <?php } ?>

        ]);

        var options = {
            chart: {
                subtitle: 'The Statistic of each product stock'
            },
            colors: ['crimson', 'green'],
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart2'));

        if (columnchart1 != null) {
            columnchart1.destroyed
        }

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>