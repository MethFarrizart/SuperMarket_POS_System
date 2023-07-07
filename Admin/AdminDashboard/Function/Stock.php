<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Stock -->
    <div class="row mt-3">
        <div class="col-12" id="slide3">
            <div class="bg-white p-4 shadow border" style="border-radius: 20px;">
                <h3 style="font-weight: bold;">
                    Stock Control
                </h3>

                <table class="table table-hover mt-5">
                    <thead>
                        <tr id="anim" class=" mt-4 text-white text-center h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 50px;">
                            <td>ProductID</td>
                            <td>Product Name</td>
                            <td>Stock-Out</td>
                            <td>Balance</td>
                            <td>Image</td>
                        </tr>
                    </thead>

                    <?php
                    $stock = $con->query("SELECT DISTINCT OD.ProductID, P.ProductID, P.ProductName, P.Image, P.Qty, SUM(Amount) AS Count FROM invoice_detail OD
                        INNER JOIN product P ON P.ProductID = OD.ProductID GROUP BY OD.ProductID");
                    while ($stock_row = $stock->fetch_assoc()) {
                    ?>
                        <tbody class="text-center h6" style="line-height: 50px;">
                            <tr>
                                <td><?= $stock_row['ProductID'] ?></td>
                                <td><?= $stock_row['ProductName'] ?></td>
                                <td><?= $stock_row['Count'] ?> Items</td>
                                <td><?= $stock_row['Qty'] ?> Items</td>
                                <td><img src="../AdminDashboard/Images/<?= $stock_row['Image'] ?>" width="50px" height="50px" alt=""> </td>
                            </tr>

                        </tbody>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
</body>

</html>