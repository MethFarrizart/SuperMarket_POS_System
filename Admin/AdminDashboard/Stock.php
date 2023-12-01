<?php
sleep(2);
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

                                <div class="col-3 gap-5" style="margin-top: -5px;">
                                    <input type="text" class="form-control p-3 search" placeholder="Search..." id="search_proStock" style="border-radius:15px;">
                                </div>

                            </div>


                            <table id="filterResult" class="table table-hover mt-3">
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
                                                    INNER JOIN product P ON P.ProductID = OD.ProductID GROUP BY OD.ProductID LIMIT $start_page, $record_per_page");
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


                            <div class="d-flex justify-content-between">

                                <!-- Show the record row by clicking page -->
                                <div class="d-flex gap-2 mt-3">
                                    <?php
                                    $select_all = $con->query("SELECT * FROM product");

                                    $total_record = mysqli_num_rows($select_all);
                                    $total_pages = ceil($total_record / $record_per_page);

                                    // Release button Previous with left-angle icon
                                    if ($page > 1) {
                                        echo "<a href='Stock.php?page=" . ($page - 1) . "' class='btn btn-outline-success px-3'> <i class='fa-solid fa-angles-left'></i> </a>";
                                    }

                                    // Release the possible nth page to record data
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        echo "<a href='Stock.php?page= " . $i . "' class='btn btn-outline-success px-4'> $i </a>";
                                    }

                                    // Release button Next with right-angle icon
                                    if ($i > ($page + 1)) {
                                        echo "<a href='Stock.php?page=" . ($page + 1) . "' class='btn btn-outline-success'> <i class='fa-solid fa-angles-right'></i> </a>";
                                    }
                                    ?>
                                </div>

                                <!-- Show Last Seen -->
                                <div class="mt-3" style="color: grey">
                                    Last Seen:
                                    <?php
                                    $date1 = date_create('2023-06-15'); //old
                                    $date2 = date_create(date('Y-m-d')); //new
                                    $diff = date_diff($date1, $date2);

                                    echo  $show = $diff->format("%a") . ' ' . 'days ago';
                                    ?>
                                </div>
                            </div>
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