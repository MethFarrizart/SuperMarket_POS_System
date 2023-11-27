<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
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

        $session_array_id = array_column($_SESSION['cart'], 'p_id');
        if (!in_array($_POST['p_id'], $session_array_id)) {

            // Check if one of product has already added or not
            if ($_POST['p_amount'] > $_POST['p_originQty']) {
                echo "<script>confirm('More than Origin stock. Please select in average quantity!')</script>";
            }
            // Input other product with the diffrent code
            else {
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
        } else {
            echo '';
        }
    }

    // Input other product with the diffrent code
    else {
        if ($_POST['p_amount'] > $_POST['p_originQty']) {
            echo "<script>confirm('More than Origin stock. Please select in average quantity!')</script>";
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
}


?>

<!-- Clear all order -->
<?php
if (isset($_GET['removeAll'])) {
    unset($_SESSION['cart']);
}

// Remove which product that has ordered
if (isset($_GET['remove'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['p_id'] == $_GET['remove']) {
            unset($_SESSION['cart'][$key]);
        }
    }
}
?>


<?php
// Buy Product after adding to cart
if (isset($_POST['placeOrder'])) {

    // Insert one staff who has a seller position
    $staffId = $_SESSION['StaffID'];
    $ins = $con->query("INSERT INTO `invoice`(`Seller`) VALUE($staffId)");


    // Match ID of invoice : One invoiceID has many order products
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

        // Update product Stock quantity which sold out
        $left = (-1) * ($pro_amount - $qty);
        $upd_stock = $con->query("UPDATE `product` SET `Qty` = '$left' WHERE `ProductID` = '$pro_id'");

        //Match invoiceID
        $invoice_detail = $match;

        // Insert information for order product
        $detail = $con->query("INSERT INTO `invoice_detail`(`InvoiceID`,`ProductID`, `CategoryID`, `Price`, `Amount`, `TotalCash`)VALUES('$invoice_detail','$pro_id', '$pro_cate', '$pro_price', '$pro_amount', '$p_total')");
        unset($_SESSION['cart']);
    }


    //Match invoiceID
    $invoice_detail = $match;

    // Store cash as Dollar and Riel currency 
    $grandTotal = $_POST['grandTotal'];
    $khTotal = $_POST['khTotal'];
    $pro_discount = $_POST['p_discount'];


    // Insert to payment details
    $payment = $con->query("INSERT INTO `payment`(`InvoiceID`, `SubTotal`, `Discount`, `GrandTotal`, `KhmerTotal`) VALUES('$invoice_detail', '$cash', '$pro_discount', '$grandTotal', '$khTotal')");
    header('location: Invoice.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Super-Fresh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Components/design.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="../../../Mart_POS_System/Components/design.css?v=<?php echo time() ?>">
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">

</head>

<style>
    .label-price {
        position: absolute;
        top: 0;
        left: 0;
        width: 100px;
        height: 35px;
        border-radius: 15px 0px 15px 0;
        background-color: blueviolet;
        color: white;
    }


    .rotate-img img {
        animation: anime 2s linear infinite;
    }

    .tab_category {
        background: linear-gradient(to top, rgb(54, 54, 175), dodgerblue);
        transition: 0.3s ease
    }

    @keyframes anime {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .scroll-container {
        overflow-y: scroll;
        height: 80%;
        position: fixed;
    }

    .scroll-container::-webkit-scrollbar {
        width: 15px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background-color: blue;
    }

    .scroll-container::-webkit-scrollbar-track {
        border-radius: 10px;
    }

    .scroll-container::-webkit-scrollbar-thumb:hover {
        background-color: darkblue;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        border-radius: 10px;
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
                <!-- Digital Clock -->
                <div class="text-end" style="margin-bottom: 20px">
                    <strong class="fs-5" id="day"></strong> <strong>/</strong>
                    <strong class="fs-5" id="month"></strong> -
                    <strong class="fs-5" id="day_num"></strong> <strong>/</strong>
                    <strong class="fs-5" id="year"></strong> <strong class="fs-5">~</strong>
                    <strong class="fs-5" id="hrs"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="min"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="sec"></strong> <strong class="fs-5" id="time"></strong>
                </div>
                <div class="row">
                    <div class="col-2" style="margin-top: -60px;">

                        <!-- List Category to display the product -->
                        <div class="list-group list-tab scroll-container " style="width: 13%;" role="tablist">
                            <h5 class="pt-2"><?= __('Categories') ?> </h5>

                            <?php
                            $category = $con->query("SELECT * FROM Category WHERE CategoryID = 1");
                            while ($cate_row = $category->fetch_assoc()) {
                            ?>
                                <a class="tab_category text-white pt-3 fs-5 list-group-item list-group-item-action active" id="list-<?= $cate_row['CategoryID'] ?>-list" data-toggle="list" href="#list-<?= $cate_row['CategoryID'] ?>" role="tab" aria-controls="<?= $cate_row['CategoryID'] ?>"><?= $cate_row['CategoryName'] ?></a>
                            <?php } ?>

                            <?php
                            $category = $con->query("SELECT * FROM Category WHERE CategoryID > 1");
                            while ($cate_row = $category->fetch_assoc()) {
                            ?>
                                <a class="tab_category text-white pt-3 fs-5 list-group-item list-group-item-action" id="list-<?= $cate_row['CategoryID'] ?>-list" data-toggle="list" href="#list-<?= $cate_row['CategoryID'] ?>" role="tab" aria-controls="<?= $cate_row['CategoryID'] ?>"><?= $cate_row['CategoryName'] ?></a>
                            <?php } ?>
                        </div>

                    </div>

                    <!-- Display product through category -->
                    <div class="col-10 ">
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


    <!-- Show Modal order detail -->
    <div class="offcanvas offcanvas-end w-25 shadow" data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1" id="order" aria-labelledby="orderLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="orderLabel"> <i class="fa-solid fa-cart-plus fs-4"></i> &nbsp;<?= __("Order Detail") ?> </h3>
            <div class="rotate-img">
                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
            </div>
        </div>
        <div class="offcanvas-body">
            <?php
            if (!empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $value) {

                    //subtotal for each item price
                    $subtotal = intval($value['p_amount']) * floatval($value['p_price']);

                    //total amount as $ currency after subtotal for each item price
                    $total +=  $subtotal;

                    //total amount as Riel Currency symbol 
                    $totalKhmer =  $total * 4100;
            ?>
                    <div class="d-flex mt-5 justify-content-between">
                        <div class="d-flex gap-3">
                            <img style="border-radius: 20px; width: 100px; height: 100px" src="../../Images/<?= $value['p_img'] ?>" alt="">

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
                        <button class=" btn btn-outline-danger px-4" style="margin-top: -25px;"><?= __('Clear') ?> </button>
                    </a>
                </div>
                <hr>

                <div class="d-flex justify-content-between mt-4">
                    <h5><?= __('Sub-Total') ?>:</h5>
                    <form action="" method="post">
                        <input id="subtotal" name="totalSub" type="hidden" readonly value="<?= $total ?>">
                    </form>
                    <h5>$<?= number_format($total, 2) ?></h5>
                </div>


                <!-- Discount Price -->
                <div class="d-flex justify-content-between mt-4">
                    <h5><?= __("Discount") ?>:</h5>
                    <form action="" method="post" class="d-flex gap-3 justify-content-end">
                        <input type="text" class="discount form-control input-disc w-50" name="p_discount"> <label for="" class="pt-2">%</label>
                    </form>
                </div>


                <!-- Dynamic total currency -->
                <div class="d-flex justify-content-between mt-4">
                    <h5><?= __('Dollar Total') ?>:</h5>
                    <form action="" method="post">
                        <input class="discount_price" type="hidden" class="form-control" style="width: 30%;">
                    </form>
                    <h5 id="show_dollar_currency"> <?= '$ ' . number_format($total, 2)  ?></h5>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <h5><?= __('Khmer Total') ?>:</h5>
                    <form action="" method="post">
                        <input class="kh_currency" type="hidden" class="form-control" style="width: 30%;">
                    </form>
                    <h5 id="show_kh_currency"> <?= '<b class="fw-bold"> &#6107 </b>' . number_format($totalKhmer, 2)   ?></h5>
                </div>
                <hr>


                <form action="" method="post" align=center>
                    <input class="discount_price form-control" name="grandTotal" value="<?= $total ?>" type="hidden" style="width: 30%;">
                    <input class="kh_currency form-control" name="khTotal" value="<?= $totalKhmer ?>" type="hidden" style="width: 100%;">
                    <button type="submit" name="placeOrder" class="btn btn-outline-success w-75 p-3 fs-5"><?= __('Place order') ?> </button>
                </form>


            <?php } else { ?>
                <div align=center style="opacity: 0.5; margin-top: 50%">
                    <h2><?= __('Nothing in Cart') ?> </h2>
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
        $('.input-disc').keyup(function() {

            var subtotal = $('#subtotal').val();
            var discount_num = $(this).val();

            var result = subtotal * discount_num / 100;
            var discount_price = subtotal - result;

            var result2 = subtotal * discount_num / 100;
            var discount_price2 = subtotal - result;

            var kh_currency = discount_price * 4100

            $('.discount_price').val(discount_price)
            $('.kh_currency').val(kh_currency)

            $('#show_dollar_currency').html('$' + (discount_price2).toFixed(2));

            $('#show_kh_currency').html(kh_currency.toFixed(2).toString().split(",") + '<b class="h2"> &#6107 </b>');

        })

    })
</script>



<script>
    var container = document.querySelector('.scroll-container');

    // Scroll to the bottom of the container
    container.scrollTop = container.scrollHeight;

    $('.list-tab a').on('click', function(e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>