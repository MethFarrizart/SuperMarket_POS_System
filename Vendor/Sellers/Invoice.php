<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
session_start();
if ($_SESSION['StaffID']) {
    echo '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../Mart_POS_System/Components/design.css">
    <link rel="stylesheet" href="../../Vendor/Components/design.css">

</head>
<style>
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 1cm;
        margin: 3cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        position: sticky;
    }

    table thead td {
        font-weight: bold;
    }

    body {
        background-color: black !important;
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

            <form>
                <?php
                if (isset($_SESSION['StaffID']) && !empty($_SESSION['StaffID'])) {
                    $staffID = $_SESSION['StaffID'];
                    $select = $con->query("SELECT C.CustomerName, O.InvoiceID, O.InvoiceDate, O.Seller, O.CustomerID FROM invoice O 
                    LEFT JOIN Customer C ON O.CustomerID = C.CustomerID
                    WHERE O.Seller = $staffID ORDER BY O.InvoiceID DESC");
                    if (mysqli_num_rows($select) > 0) {
                        while ($row = $select->fetch_assoc()) {
                            $match = $row['InvoiceID'];
                ?>
                            <div class="page">
                                <div class="d-flex justify-content-between">
                                    <b class="fs-3"><?= __('Invoice') ?></b>
                                    <div class="d-flex text-end">
                                        <div class="d-flex flex-column">
                                            <b class="fs-4"><?= __('Phoenix Super-Fresh') ?></b>
                                            <b>#2370, Keo Chenda Street, Chhroy Changva Commune</b>
                                        </div>
                                    </div>
                                </div>
                                <div style="border: 2px solid black" class="mt-3 mb-3"></div>


                                <div class="d-flex justify-content-between">
                                    <div>
                                        <b class="fs-5"><?= __('Invoice-ID') ?>: #<?= $row['InvoiceID'] ?> </b> <br>
                                        <b class="fs-5"><?= __('Order-Date') ?>: <?= $row['InvoiceDate'] ?> </b> <br>
                                        <b class="fs-5"><?= __('Customer') ?>: <?= $row['CustomerName'] ?> </b> <br><br>

                                    </div>
                                    <div>
                                        <!-- <button type="button" onclick="printPDF()" class="btn btn-primary p-2 fw-bold" style="width: 130px;"> <?= __('Print') ?> </button> -->

                                    </div>
                                </div>

                                <b class="fs-3"><?= __('Order Summary') ?> * </b>
                                <div class="table-responsive mt-5">
                                    <table class="table ">
                                        <thead align=center>
                                            <tr>
                                                <td class="fs-5 text-start"><?= __('Name') ?> </td>
                                                <td class="fs-5 text-end"><?= __('Qty') ?> </td>
                                                <td class="fs-5 text-end"><?= __('Price') ?> </td>
                                                <td class="fs-5 text-end"><?= __('Amount') ?> </td>
                                            </tr>
                                        </thead>

                                        <?php
                                        $pro_detail = $con->query("SELECT  OD.ProductID, OD.Price, U.UnitName, OD.Amount, OD.Price, OD.TotalCash, P.ProductID, P.ProductName FROM invoice_detail OD
                                                        INNER JOIN product P ON OD.ProductID = P.ProductID 
                                                        INNER JOIN unit U ON U.UnitID = P.UnitID
                                                        WHERE OD.InvoiceID = $match");
                                        while ($detail = $pro_detail->fetch_assoc()) {
                                        ?>
                                            <tbody style="line-height: 50px;">
                                                <tr>
                                                    <td align="left"><?= $detail['ProductName'] ?></td>
                                                    <td align="right"><?= $detail['Amount'] . ' ' . $detail['UnitName'] ?></td>
                                                    <td align=right>$ <?= number_format($detail['Price'], 2) ?></td>
                                                    <td class="text-end"> $ <?= number_format($detail['TotalCash'], 2) ?></td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>


                                        <?php
                                        $pay_detail = $con->query("SELECT * FROM payment WHERE InvoiceID = $match");
                                        while ($payment = $pay_detail->fetch_assoc()) {
                                        ?>
                                            <tfoot style=" line-height: 50px">
                                                <tr>
                                                    <?php
                                                    $count = $con->query("SELECT SUM(Amount) AS Count FROM invoice_detail WHERE InvoiceID = $match");
                                                    while ($qty = $count->fetch_assoc()) {
                                                    ?>
                                                        <td colspan="2" class="text-end fs-5"> <b><?= __('Total Order') ?>: <?= $qty['Count'] ?> </b> </td>

                                                    <?php } ?>
                                                    <td colspan="2" class="text-end fs-5">
                                                        <b><?= __('Sub Total') ?>: &nbsp; $ <?= number_format($payment['BeforeDiscount'], 2) ?></b> <br>
                                                        <b><?= __('Discount') ?>: &nbsp; <?= $payment['Discount'] ?> % </b> <br>
                                                        <b><?= __('After Discount') ?>: &nbsp; $ <?= number_format($payment['AfterDiscount'], 2) ?></b> <br>
                                                        <b><?= __('Total Paid') ?>: &nbsp; $ <?= number_format($payment['TotalPaid'], 2) ?></b> <br>

                                                        <?php
                                                        if ($payment['TotalDebt'] != 0) {
                                                        ?>
                                                            <b><?= __('Total Debt') ?>: &nbsp; $ <?= number_format($payment['TotalDebt'], 2) ?></b> <br>

                                                        <?php } ?>

                                                        <b><?= __('Khmer Total') ?>: &nbsp; <?= '<b class="h4 fw-bold"> &#6107 </b>' .  number_format($payment['KhmerTotal'], 2)  ?></b>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php } ?>

                                    </table>
                                </div>


                                <div class="text-center font-weight-bold mt-4 pt-3">
                                    <h5> Thank you for your shopping ! <br> Enjoy with your product ordering</h5> <br><br>

                                    <h5>Contact: 081 411 553 / 010 37 37 55 <br> Facebook: PhoenixShopping</h5>
                                </div>
                                <div align=center class="pt-3 w-25 mb-5" style="border-bottom: 4px solid black; margin-left: 38%;"></div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="loadingio-spinner-spinner-qn1vzcvkchk d-flex justify-content-center w-100" style="margin-top: 20%; background: none; color: yellow;">
                            <div class="ldio-clilj3a1frv">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <h4 class="pb-4 mt-5 pt-5 text-white" align=center><i><?= __('None Ordering to make invoice') ?> !</i> </h4>
                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <div class="loadingio-spinner-spinner-qn1vzcvkchk d-flex justify-content-center w-100" style="margin-top: 20%; background: none; color: yellow;">
                        <div class="ldio-clilj3a1frv">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <h4 class="pb-4 mt-5 pt-5 text-white" align=center><i><?= __('None Ordering to make invoice') ?>!</i> </h4>
                        </div>
                    </div>
                <?php } ?>
            </form>


</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="../../../Mart_POS_System/Action.js"></script>