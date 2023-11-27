<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.css">
</head>

<body>
    <!-- Category -->
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
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold fs-5"> <?= __('Purchase Management') ?> /
                                <a class="text-decoration-none" href="Purchase.php"><?= __('Purchase') ?></a>
                            </div>
                            <button type="submit" class="btn btn-1 text-white"><?= __("Save") ?></button>
                        </div>

                        <div class="bg-white  mt-3 p-4 shadow border" style="border-radius: 20px;">
                            <div class="row">
                                <div class="col-4">
                                    <small><?= __('Supplier Name') ?>:</small><br>
                                    <div style="width: 100%">
                                        <div id="supplier_selection"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small><?= __('Status') ?>:</small> <br>
                                    <div style="width: 100%">
                                        <div id="status_selection"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small><?= __('Purchase Date') ?>:</small>
                                    <input type="date" id="pro_expired" name="pro_expired" class="form-control expired">
                                </div>


                            </div>
                            <div class="col-12 mt-4">
                                <small><?= __('Product Name') ?>:</small> <br>
                                <div style="width: 100%">
                                    <div id="product_selection"></div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                            <th><?= __("Action") ?></th>
                                            <th><?= __("Product Name") ?></th>
                                            <th><?= __("Qty") ?></th>
                                            <th><?= __("Price") ?></th>
                                            <th><?= __("Discount") ?></th>
                                            <th><?= __("Sub Total") ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="col-12 mt-5">
                                <small><?= __('Description') ?>: </small>
                                <textarea name="" class="form-control" rows="10"></textarea>
                            </div>
                            <div class="text-end mt-5">
                                <h6><?= __("Total Price") ?>: </h6>
                                <h6><?= __("Total Discount") ?>: </h6>
                                <h6><?= __("Grand Total") ?>: </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="../../Action.js"></script>
<script src="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.js"></script>
<script>
    VirtualSelect.init({
        ele: '#supplier_selection',
        search: true,
        maxWidth: '100%',
        placeholder: ' Select Supplier',
        selectAllOnlyVisible: true,

        options: [
            <?php
            $result = $con->query("SELECT * FROM supplier");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['SupplierName'] ?>',
                    value: <?= $row['SupplierID'] ?>
                },

            <?php } ?>
        ],
    });


    VirtualSelect.init({
        ele: '#status_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Status',
        selectAllOnlyVisible: true,

        options: [
            <?php
            $result = $con->query("SELECT * FROM status");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['StatusName'] ?>',
                    value: <?= $row['StatusID'] ?>
                },

            <?php } ?>
        ],
    });


    VirtualSelect.init({
        ele: '#product_selection',
        search: true,
        maxWidth: '100%',
        placeholder: ' Select Product',
        selectAllOnlyVisible: true,

        options: [
            <?php
            $result = $con->query("SELECT * FROM product");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['ProductName'] ?>',
                    value: <?= $row['ProductID'] ?>
                },

            <?php } ?>
        ],
    });
</script>

</html>