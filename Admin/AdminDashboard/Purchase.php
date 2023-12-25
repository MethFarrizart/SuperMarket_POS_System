<?php
sleep(2);
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>

<?php
// Delete Purchase
if (isset($_GET['deletePurchaseID'])) {
    $id = $_GET['del_purchaseID'];

    $delPurchase = "DELETE FROM `purchasepayment` WHERE PurchaseID = $id";
    $con->query($delPurchase);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%">
        <h5 class="pt-3 text-white"> <?= __('This Purchase on ID =') . ' PUR' . $id  . ' ' . __("has deleted") ?></h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
</head>

<style>
    #loading-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        display: none;
        /* Initially hide the loading container */
    }
</style>

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
                        <div class="col-4">
                            <input type="text" class="form-control p-3 search" placeholder="Search..." id="search_purchase" style="border-radius:15px;">
                        </div>
                        <div class="bg-white mt-3 p-4 shadow border" style="border-radius: 20px;">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold fs-5">
                                    <?= __('Purchase List') ?>
                                </p>
                                <p class="fw-bold fs-5 mx-5 px-5">
                                    <?= __('Filter') ?> &nbsp; <i class="fa-solid fa-filter"></i>
                                </p>
                            </div>

                            <div class="d-flex gap-2 justify-content-between">
                                <div class="d-flex gap-2">
                                    <button onclick="purchase_detail()" type="button" class="btn p-3 btn-1 text-white"><?= __('Add Purchase') ?></button> &nbsp;
                                </div>
                            </div>

                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                        <td class="text-center"><?= __('Action') ?> </td>
                                        <td><?= __("Purchase Date") ?></td>
                                        <td><?= __("PurchaseID") ?></td>
                                        <td><?= __("Supplier") ?></td>
                                        <td><?= __("Before Discount") ?></td>
                                        <td><?= __("After Discount") ?></td>
                                        <td><?= __("Grand Total") ?></td>
                                        <td><?= __("Status") ?></td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // Reload data by pagination
                                    $record_per_page = 5;

                                    if (isset($_GET['page'])) {
                                        $page = $_GET['page'];
                                    } else {
                                        $page = 1;
                                    }
                                    $start_page = ($page - 1) * 5;
                                    $purchase = $con->query(
                                        "SELECT p.*, s.SupplierID, s.SupplierName, st.StatusName, SUM(pu.BeforeDiscount) as BeforeDiscount, SUM(pu.AfterDiscount) as AfterDiscount, pay.Grand_total FROM purchase p 
                                        INNER JOIN supplier s ON p.SupplierID = s.SupplierID
                                        INNER JOIN purchase_detail pu ON pu.PurchaseID = p.PurchaseID
                                        INNER JOIN status st ON p.StatusID = st.StatusID
                                        INNER JOIN purchasepayment pay ON p.PurchaseID = pay.PurchaseID
                                        GROUP BY p.PurchaseID 
                                        ORDER BY p.PurchaseID DESC LIMIT $start_page, $record_per_page"
                                    );
                                    while ($row = $purchase->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <button style="background-color: dodgerblue; border-radius: 25px" align="center" class="show-details-btn btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-gear"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="modal" data-bs-target="#viewPurchase-<?= $row['PurchaseID'] ?>" aria-controls="viewPurchase">
                                                            <i style="color: purple;" class="fa fa-eye" aria-hidden="true"></i> &nbsp;
                                                            <?= __('View') ?>
                                                        </button>
                                                        <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="offcanvas" data-bs-target="#editPurchase-<?= $row['PurchaseID'] ?>" aria-controls="editPurchase">
                                                            <i style="color: green;" class="fa-solid fa-pen-to-square"></i> &nbsp;
                                                            <?= __('Edit') ?>
                                                        </button>

                                                        <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="modal" data-bs-target="#deletePurchase-<?= $row['PurchaseID'] ?>" aria-controls="deletePurchase">
                                                            <i style="color: red;" class="fa-sharp fa-solid fa-trash"></i> &nbsp;
                                                            <?= __('Delete') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $row['PurchaseDate'] ?></td>
                                            <td><?= "PUR" . $row['PurchaseID'] ?></td>
                                            <td><?= $row['SupplierName'] ?></td>
                                            <td><?= '$ ' . number_format($row['BeforeDiscount'], 2) ?></td>
                                            <td><?= '$ ' . number_format($row['AfterDiscount'], 2) ?></td>
                                            <td><?= '$ ' . number_format($row['Grand_total'], 2) ?></td>
                                            <td><?= $row['StatusName'] ?></td>
                                        </tr>

                                        <!-- Delete Purchase -->
                                        <div class="modal fade" id="deletePurchase-<?= $row['PurchaseID'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color:crimson">
                                                        <h3 class="modal-title text-warning" id="deleteLabel"><?= __('Are You Sure ?') ?></h3>
                                                        <div class="rotate-img">
                                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="get">
                                                            <p class="mt-5 text-center"><?= __('Do you want to delete this Purchase Invoice =') . ' ' . $row['PurchaseID'] . ' ?' ?></p>

                                                            <div class="col-12">
                                                                <input type="hidden" class="form-control" name="del_purchaseID" value="<?= $row['PurchaseID'] ?>" readonly>
                                                            </div>

                                                            <div class="modal-footer mt-5">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('Leave') ?></button>
                                                                <button type="submit" name="deletePurchaseID" class="btn btn-outline-danger"><?= __('Delete') ?></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal View Purchase -->
                                        <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.685);" id="viewPurchase-<?= $row['PurchaseID'] ?>" tabindex="-1" aria-labelledby="viewPurchaseLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-center modal-xl" role="document">
                                                <div class="modal-content content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5 text-white" id="viewPurchaseLabel"><?= __('Purchase Control') ?></h1>
                                                        <div class="rotate-img">
                                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        eargegf
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- Show the record row by clicking page -->
                            <div class="d-flex gap-2 mt-3">
                                <?php
                                $select_all = $con->query("SELECT * FROM purchase");

                                $total_record = mysqli_num_rows($select_all);
                                $total_pages = ceil($total_record / $record_per_page);

                                // Release button Previous with left-angle icon
                                if ($page > 1) {
                                    echo "<a href='Purchase.php?page=" . ($page - 1) . "' class='btn btn-outline-success px-3'> <i class='fa-solid fa-angles-left'></i> </a>";
                                }

                                // Release the possible nth page to record data
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<a href='Purchase.php?page= " . $i . "' class='btn btn-outline-success px-4'> $i </a>";
                                }

                                // Release button Next with right-angle icon
                                if ($i > ($page + 1)) {
                                    echo "<a href='Purchase.php?page=" . ($page + 1) . "' class='btn btn-outline-success'> <i class='fa-solid fa-angles-right'></i> </a>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading to next page -->
        <div id="loading-container"></div>


    </div>


</body>
<script src="../../Action.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>

<script>
    function purchase_detail() {
        let options = {
            lines: 15, // The number of lines to draw
            length: 40, // The length of each line
            width: 15, // The line thickness
            radius: 45, // The radius of the inner circle
            scale: 1, // Scales overall size of the spinner
            corners: 1, // Corner roundness (0..1)
            speed: 0.5, // Rounds per second
            rotate: 0, // The rotation offset
            animation: 'spinner-line-fade-quick', // The CSS animation name for the lines
            direction: 1, // 1: clockwise, -1: counterclockwise
            color: 'blue', // CSS color or array of colors
            fadeColor: 'transparent', // CSS color or array of colors
            top: '50%', // Top position relative to parent
            left: '50%', // Left position relative to parent
            shadow: '0 0 1px transparent', // Box-shadow for the lines
            zIndex: 2000000000, // The z-index (defaults to 2e9)
            className: 'spinner', // The CSS class to assign to the spinner
            position: 'absolute', // Element positioning
        }

        // Show the loading container and start the spinner
        document.getElementById('loading-container').style.display = 'flex';
        let spinner = new Spinner(options).spin();
        document.getElementById('loading-container').appendChild(spinner.el);


        // Simulate an asynchronous task (e.g., AJAX request)
        setTimeout(function() {
            // Stop the spinner and hide the loading container when the task is complete
            spinner.stop();
            document.getElementById('loading-container').style.display = 'none';
            document.body.style.background = 'none';
            window.location.href = "PurchaseDetail.php";
        }, 2000);
    };
</script>

</html>