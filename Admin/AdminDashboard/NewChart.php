<div class="row mt-4">
    <div class="col-12">
        <div class="border border-all gap-3 p-4 shadow " style="border-radius: 20px; background: none">
            <div style="column-count: 2; column-rule: 1px solid; ">

                <!-- Category Report -->
                <div>
                    <h3 align="center">
                        <b><?= __('Top Categories') ?></b>
                    </h3>
                    <div class="mt-4" id="category" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                </div>


                <!-- Stock Report -->
                <div align="center">
                    <h3>
                        <b><?= __('Stock Control') ?></b>
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
                    <b><?= __('Status Percentage') ?></b>
                </h3>
                <div class="mt-4" id="status" style="width: 740px; height: 400px; margin-top: -10px;"></div>
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
                    <h2 class="text-center"><?= __('Stock Control') ?> </h2>
                    <div class="mt-5 pt-3 w-100" id="columnchart2" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>



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