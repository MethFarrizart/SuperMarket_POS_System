<?php
include('../../Connection/Connect.php');
include('../../Translate/lang.php');
$con = new mysqli('localhost', 'root', '', 'pos_system') or die(mysqli_error($con));

function matchSeller($con)
{
    $query_seller = $con->query("SELECT S.StaffID, S.FirstName, S.LastName, OD.invoiceID, OD.ProductID, OD.Price, OD.Amount, OD.TotalCash, 
    pro.ProductName, O.*, 
    P.SubTotal, P.GrandTotal, P.KhmerTotal FROM invoice O 
    INNER JOIN invoice_detail OD ON OD.InvoiceID = O.InvoiceID 
    INNER JOIN product pro ON OD.ProductID = pro.ProductID
    INNER JOIN payment P ON P.InvoiceID = O.InvoiceID
    INNER JOIN Staff S ON O.Seller = S.StaffID
    ");

    // Your processing logic here

    // Return true or false based on your filtering condition
    return /* Your filtering condition */;
}

// Assuming $con is a valid MySQLi connection object
global $con;

$select_seller = $con->query("SELECT * FROM staff WHERE PositionID = 90");
$sellers = [];

while ($row = $select_seller->fetch_assoc()) {
    $sellers[] = $row;
}

// Use array_filter to filter the array based on the condition in matchSeller function
$filtered_sellers = array_filter($sellers, function ($seller) use ($con) {
    return matchSeller($con);
});

print_r($filtered_sellers);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
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
</style>

<body>


    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>

            <div class="container-fluid" style="margin-top: 130px;">
                <h4 style="3px solid blue" class="title"><b><?= __('Report Last Updated') ?></b> </h4>


                <!-- Digital Clock -->
                <div class="text-end text-move" style="margin-bottom: 20px">
                    <strong class="fs-5" id="day"></strong> <strong>/</strong>
                    <strong class="fs-5" id="month"></strong> -
                    <strong class="fs-5" id="day_num"></strong> <strong>/</strong>
                    <strong class="fs-5" id="year"></strong> <strong class="fs-5">~</strong>
                    <strong class="fs-5" id="hrs"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="min"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="sec"></strong> <strong class="fs-5" id="time"></strong>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="border border-all gap-3 p-4 shadow " style="border-radius: 20px; background: none">
                            <select class="custom-select w-100 p-2" id="selectSeller">
                                <?php
                                $qry = $con->query("SELECT * FROM staff WHERE PositionID =90");
                                while ($seller = $qry->fetch_assoc()) {
                                    $match = $seller['StaffID'];
                                ?>
                                    <option value="<?= $seller['StaffID'] ?>">
                                        <?= $seller['FirstName'] . $seller['LastName'] ?></option>
                                <?php } ?>
                            </select>

                            <table class="table table-hover mt-5 pt-5" id="dataTable">
                                <thead>
                                    <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                        <td class="fs-5 text-left"><?= __('Name') ?> </td>
                                        <td class="fs-5"><?= __('Qty') ?> </td>
                                        <td class="fs-5"><?= __('Price') ?> </td>
                                        <td class="fs-5"><?= __('Amount') ?> </td>
                                    </tr>
                                </thead>

                                <tbody style="line-height: 50px;">
                                    <?php
                                    $select = $con->query("SELECT O.InvoiceID, O.InvoiceDate, O.Seller FROM invoice O ORDER BY O.InvoiceID DESC");
                                    if (mysqli_num_rows($select) > 0) {
                                        while ($row = $select->fetch_assoc()) {
                                            $match = $row['InvoiceID'];
                                    ?>
                                            <?php
                                            $pro_detail = $con->query("SELECT  OD.ProductID, OD.Price, OD.Amount, OD.Price, OD.TotalCash, P.ProductID, P.ProductName FROM invoice_detail OD
                                         INNER JOIN product P ON OD.ProductID = P.ProductID WHERE OD.InvoiceID = $match");
                                            while ($detail = $pro_detail->fetch_assoc()) {

                                            ?>
                                                <tr>
                                                    <td><?= $detail['ProductName'] ?></td>
                                                    <td><?= $detail['Amount'] ?></td>
                                                    <td>$ <?= number_format($detail['Price'], 2) ?></td>
                                                    <td> $ <?= number_format($detail['TotalCash'], 2) ?></td>
                                                </tr>

                                            <?php } ?>

                                    <?php }
                                    } ?>

                                </tbody>
                            </table>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<!-- <script>
    $(document).ready(function() {
        $('#selectSeller').on('change', function() {
            var selectSeller = $(this).val();
            $.ajax({
                url: 'API/FilterInvoice.php',
                method: 'POST',
                data: {
                    selectSeller: selectSeller
                },
                beforeSend: function() {
                    $('#dataTable').html('Working ...');
                },
                success: function(data) {
                    $('#dataTable').html(data);
                }
            })
        })

    })
</script> -->