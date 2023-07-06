<?php
include('../../Connection/Connect.php');
session_start();
if (!isset($_SESSION['FirstName']) && !isset($_SESSION['LastName'])) {
    header('location: ../../../Mart_POS_System/index.php');
} else {
    if (isset($_SESSION['PositionID']) == 90) {
        echo '';
    }
}


if (isset($_POST['add-to-cart'])) {

    if (isset($_SESSION['cart'])) {

        // Check if one of product has already added or not
        $session_array_id = array_column($_SESSION['cart'], 'p_id');
        if (!in_array($_POST['p_id'], $session_array_id)) {

            $item_array = array(
                'p_id' => $_POST['p_id'],
                'p_name' => $_POST['p_name'],
                'p_cate' => $_POST['p_cate'],
                'p_price' => $_POST['p_price'],
                'p_img' => $_POST['p_img'],
                'p_amount' => $_POST['p_amount'],
                'p_originQty' => $_POST['p_originQty']
            );
            if ($_POST['p_amount'] > $_POST['p_originQty']) {
                echo "<script>confirm('More than Origin stock. Please select in average quantity!')</script>";
            } else {
                $_SESSION['cart'][] = $item_array;
            }
        } else {
            echo '';
        }
    } else {
        $item_array = array(
            'p_id' => $_POST['p_id'],
            'p_name' => $_POST['p_name'],
            'p_cate' => $_POST['p_cate'],
            'p_price' => $_POST['p_price'],
            'p_img' => $_POST['p_img'],
            'p_amount' => $_POST['p_amount'],
            'p_originQty' => $_POST['p_originQty']
        );
        $_SESSION['cart'][] = $item_array;
    }
}


?>

<!-- Clear order -->
<?php
if (isset($_GET['removeAll'])) {
    unset($_SESSION['cart']);
}

// Remove each order
if (isset($_GET['remove'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['p_id'] == $_GET['remove']) {
            unset($_SESSION['cart'][$key]);
        }
    }
}
?>


<?php
// Insert order
if (isset($_POST['placeOrder'])) {

    $staffId = $_SESSION['StaffID'];
    $ins = $con->query("INSERT INTO `invoice`(`Seller`) VALUE($staffId)");

    $select = $con->query("SELECT * FROM invoice");
    while ($row = $select->fetch_assoc()) {
        $match = $row['InvoiceID'];
    }

    $cash = 0;
    $item_array = $_SESSION['cart'];
    foreach ($item_array as $item) {
        $pro_id = $item['p_id'];
        $pro_cate = $item['p_cate'];
        $pro_price = $item['p_price'];
        $pro_amount = $item['p_amount'];
        $qty = $item['p_originQty'];

        // Calculate price for each product
        $p_total = $pro_price * $pro_amount;
        // Calculate Subtotal
        $cash += $p_total;

        // Update Stock which sold out
        $left = (-1) * ($pro_amount - $qty);
        $upd_stock = $con->query("UPDATE `product` SET `Qty` = '$left' WHERE `ProductID` = '$pro_id'");

        $invoice_detail = $match;

        // Insert information for order product
        $detail = $con->query("INSERT INTO `invoice_detail`(`InvoiceID`,`ProductID`, `CategoryID`, `Price`, `Amount`, `TotalCash`)VALUES('$invoice_detail','$pro_id', '$pro_cate', '$pro_price', '$pro_amount', '$p_total')");
        unset($_SESSION['cart']);
    }


    // Insert to payment details
    $invoice_detail = $match;

    $grandTotal = $_POST['grandTotal'];

    $payment = $con->query("INSERT INTO `payment`(`InvoiceID`, `SubTotal`, `GrandTotal`) VALUES('$invoice_detail', '$cash', '$grandTotal')");
    header('location: Invoice.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../Vendor/Components/design.css">
    <link rel="stylesheet" href="../../../Mart_POS_System/Components/design.css">
</head>

<style>
    .rotate-img img {
        animation: anime 2s linear infinite;
    }

    @keyframes anime {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>
    <div class="d-flex overflow-hidden">
        <?php
        include('../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../Components/Navbar.php');
            ?>
            <div class="container-fluid" style="margin-top: 140px;">
                <div class="row">
                    <div class="col-2">
                        <div class="list-group list-tab position-fixed" style="width: 13%;" role="tablist">
                            <div class="d-flex gap-3">
                                <h5> Categories</h5>

                            </div>

                            <?php
                            $category = $con->query("SELECT * FROM Category WHERE CategoryID = 1");
                            while ($cate_row = $category->fetch_assoc()) {
                            ?>
                                <a class="list-group-item list-group-item-action active" id="list-<?= $cate_row['CategoryID'] ?>-list" data-toggle="list" href="#list-<?= $cate_row['CategoryID'] ?>" role="tab" aria-controls="<?= $cate_row['CategoryID'] ?>"><?= $cate_row['CategoryName'] ?></a>
                            <?php } ?>

                            <?php
                            $category = $con->query("SELECT * FROM Category WHERE CategoryID > 1");
                            while ($cate_row = $category->fetch_assoc()) {
                            ?>
                                <a class="list-group-item list-group-item-action" id="list-<?= $cate_row['CategoryID'] ?>-list" data-toggle="list" href="#list-<?= $cate_row['CategoryID'] ?>" role="tab" aria-controls="<?= $cate_row['CategoryID'] ?>"><?= $cate_row['CategoryName'] ?></a>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="col-10">
                        <div class="tab-content" id="nav-tabContent">
                            <?php
                            include('../Components/CategoryOne.php');
                            ?>

                            <?php
                            include('../Components/OtherCategory.php');

                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Show order detail -->

    <div class="offcanvas offcanvas-end w-25 shadow" data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1" id="order" aria-labelledby="orderLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="orderLabel"> <i class="fa-solid fa-cart-plus fs-4"></i> Order Detail </h3>

            <div class="rotate-img">
                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
            </div>
        </div>
        <div class="offcanvas-body">
            <?php
            if (!empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $value) {
                    $subtotal = intval($value['p_amount']) * floatval($value['p_price']);
                    $total +=  $subtotal;
            ?>
                    <div class="d-flex mt-5 justify-content-between">
                        <div class="d-flex gap-3">
                            <img style="border-radius: 20px; width: 100px; height: 100px" src="../../Admin/AdminDashboard/Images/<?= $value['p_img'] ?>" alt="">

                            <div class="d-flex flex-column gap-3">
                                <h5> <?= $value['p_name'] ?> </h5>
                                <div class="d-flex gap-4">
                                    <!-- <div align=center class="plus shadow fs-4" style="cursor: grab; border-radius: 50%; width: 35px; height: 35px">
                                        &plus;
                                    </div> -->

                                    <h5 class="inc_qty pt-2"> X <?= intval($value['p_amount']) ?> </h5>
                                    <!-- <div align=center class="minus shadow fs-4" style="cursor: grab; border-radius: 50%; width: 35px; height: 35px">
                                        &minus;
                                    </div> -->
                                </div>
                                <h5 class="inc_price"> $ <?= number_format($subtotal, 2) ?> </h5>
                            </div>
                        </div>

                        <!-- Remove item selected -->
                        <a href="Order.php?remove=<?= $value['p_id'] ?>">
                            <img src="../../Images/trash.png" width="35px" height="35px" style="cursor: grab;">
                        </a>
                    </div>
                <?php }
                ?>
                <hr>
                <!-- Clear all item -->
                <div class="d-flex justify-content-end">
                    <a href="Order.php?removeAll" style="text-decoration: none;">
                        <button class=" btn btn-outline-danger px-4" style="margin-top: -25px;"> Clear </button>
                    </a>
                </div>
                <hr>

                <div class="d-flex justify-content-between mt-4">
                    <h5>Sub-Total:</h5>
                    <form action="" method="post">
                        <input id="subtotal" name="totalSub" type="hidden" readonly value="<?= $total ?>">
                    </form>
                    <h5>$<?= number_format($total, 2) ?></h5>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <h5>Discount:</h5>
                    <form action="" method="post">
                        <select class="input-disc p-2 custom-select discount">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                            <option value="70">70</option>
                            <option value="80">80</option>
                            <option value="90">90</option>
                            <option value="100">100</option>
                        </select>
                    </form>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <h5>Grand-Total:</h5>
                    <form action="" method="post">
                        <input class="discount_price" type="hidden" class="form-control" style="width: 30%;">
                    </form>
                    <h5 id="show"> <?= '$' . number_format($total, 2)  ?></h5>
                </div>
                <hr>


                <form action="" method="post" align=center>
                    <input class="discount_price form-control" name="grandTotal" value="<?= $total ?>" type="hidden" style="width: 30%;">
                    <button type="submit" name="placeOrder" class="btn btn-outline-success w-75 p-3 fs-5"> Place order </button>
                </form>


            <?php } else { ?>
                <div align=center style="opacity: 0.5; margin-top: 50%">
                    <h2> Nothing in Cart </h2>
                    <div class="loadingio-spinner-magnify-dwv4kblnb9q">
                        <div class="ldio-4guv2kbqa9d">
                            <div>
                                <div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="../../../Mart_POS_System/Action.js"></script>

<script>
    $(document).ready(function() {
        $('.input-disc').change(function() {

            var subtotal = $('#subtotal').val();
            var discount_num = $(this).val();

            var result = subtotal * discount_num / 100;
            var discount_price = subtotal - result;

            var result2 = subtotal * discount_num / 100;
            var discount_price2 = subtotal - result;

            $('.discount_price').val(discount_price)
            $('#show').html('$' + (discount_price2).toFixed(2));

        })

    })
</script>


<script>
    $('.list-tab a').on('click', function(e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>