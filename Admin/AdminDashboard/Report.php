<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../Components/design.css">
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

            <div class="container-fluid" style="margin-top: 120px;">
                <div class="row">
                    <div class="col-12">
                        <div class="border border-all gap-3 p-4 shadow " style="border-radius: 20px">
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
                        <div class="border border-all d-flex flex-column gap-3 p-4 shadow;" style="border-radius: 20px">
                            <h3>
                                <b style="color: rgb(192, 170, 48);">Top Sale</b>
                            </h3>
                            <table class="table table-hover">
                                <thead>
                                    <tr id="anim" class=" mt-4 text-white text-center h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 50px;">
                                        <td>ProductID</td>
                                        <td>Product Name</td>
                                        <td>Stock-Out</td>
                                        <td>Balance</td>
                                        <td>Image</td>
                                    </tr>
                                </thead>

                                <tbody class="text-center h6" style="line-height: 50px;">
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="border border-all d-flex flex-column gap-3 p-4 shadow;" style="border-radius: 20px">
                            <h3>
                                <b style="color: crimson;">Low Sale</b>
                            </h3>
                            <table class="table table-hover">
                                <thead>
                                    <tr id="anim" class=" mt-4 text-white text-center h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 50px;">
                                        <td>ProductID</td>
                                        <td>Product Name</td>
                                        <td>Stock-Out</td>
                                        <td>Balance</td>
                                        <td>Image</td>
                                    </tr>
                                </thead>

                                <tbody class="text-center h6" style="line-height: 50px;">
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>

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
            ['Name', 'Qty'],
            [
                'Work', 11
            ],
            [
                'Eat', 2
            ],
            [
                'Commute', 2
            ],
            [
                'Watch TV', 2
            ],
            [
                'Sleep', 7
            ]


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
            ?>  ['<?= $status ?>', <?= $count ?>],
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
            [
                '2014', 1000, 400
            ],
            [
                '2015', 1170, 460
            ],
            [
                '2016', 660, 1120
            ],
            [
                '2017', 1030, 540
            ],
            [
                '2018', 1030, 540
            ],

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
            [
                '2014', 1000, 400
            ],
            [
                '2015', 1170, 460
            ],
            [
                '2016', 660, 1120
            ],
            [
                '2017', 1030, 540
            ],
            [
                '2018', 1030, 540
            ],

            [
                '2019', 1030, 540
            ],

            [
                '2020', 1030, 540
            ],

            [
                '2021', 1030, 540
            ],

            [
                '2022', 1030, 540
            ],



        ]);

        var options = {
            chart: {
                subtitle: 'The Statistic of each product stock'
            },
            colors: ['crimson', 'green']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<script src="../../Action.js"></script>