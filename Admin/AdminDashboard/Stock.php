<?php
require('../../Translate/lang.php');
include('../../Connection/Connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">

</head>

<body>
    <!-- Stock -->
    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>

            <div class="container-fluid">
                <div class="row" style="margin-top: 120px;">

                    <div class="col-12">
                        <div class="bg-white p-4 shadow border" style="border-radius: 20px;">

                            <div class="d-flex justify-content-between">
                                <div class="d-flex gap-2">
                                    <img style="height: 30px;" src="https://cdn1.iconfinder.com/data/icons/fs-icons-ubuntu-by-franksouza-/256/stock_search.png" alt="">
                                    <p style="font-weight: bold;" class="fs-5">
                                        <?= __('Stock Control') ?>
                                    </p>
                                </div>

                                <div class="col-3 gap-5" style="margin-top: -20px;">
                                    <input type="text" class="form-control p-3 search" placeholder="Search..." id="search_proStock" style="border-radius:15px;">
                                </div>

                            </div>


                            <table id="filterResult" class="table table-hover mt-5">
                                <thead>
                                    <tr class=" mt-4 text-white h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 40px;">
                                        <td><?= __('ProductID') ?></td>
                                        <td><?= __('Product Name') ?></td>
                                        <td class="text-center"><?= __('Stock-Out') ?></td>
                                        <td class="text-center"><?= __('Balance') ?></td>
                                        <td class="text-center"><?= __('Stability') ?></td>
                                        <td class="text-center"><?= __('Image') ?></td>
                                    </tr>
                                </thead>

                                <?php
                                // Reload data by pagination
                                $record_per_page = 5;

                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                $start_page = ($page - 1) * 5;

                                $stock = $con->query("SELECT OD.ProductID, P.ProductID, P.ProductName, P.Image, P.Qty, SUM(Amount) AS Count FROM invoice_detail OD
                                                    INNER JOIN product P ON P.ProductID = OD.ProductID GROUP BY OD.ProductID");
                                while ($stock_row = $stock->fetch_assoc()) {
                                ?>
                                    <tbody class=" h6" style="line-height: 30px;">
                                        <tr>
                                            <td class="text-start"><?= $stock_row['ProductID'] ?></td>
                                            <td class="text-start"><?= $stock_row['ProductName'] ?></td>
                                            <td class="text-center"><?= $stock_row['Count'] ?> <?= __('Items') ?> </td>
                                            <td class="text-center"><?= $stock_row['Qty'] ?> <?= __('Items') ?></td>
                                            <td class="text-center"><?= $stock_row['Qty'] + $stock_row['Count'] ?> <?= __('Items') ?></td>
                                            <td align="center"><img src="../../Images/<?= $stock_row['Image'] ?>" width="30px" height="30px" alt=""> </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#search_proStock').keyup(function() {
            var search_proStock = $(this).val();
            $.ajax({
                url: 'API/SearchStockProduct.php',
                method: 'POST',
                data: {
                    search_proStock: search_proStock
                },
                // beforeSend: function() {
                //     $('#filterResult').html('Working ...');
                // },

                success: function(data) {
                    $('#filterResult').html(data)
                }
            })
        })
    })
</script>

</html>