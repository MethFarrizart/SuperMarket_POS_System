<?php
include('../../../Connection/Connect.php');
include('../../../Translate/language.php');

if (isset($_POST['search_proStock'])) {
    $search_proStock = $_POST['search_proStock'];
    $search = $con->query("SELECT DISTINCT OD.ProductID, P.ProductID, P.ProductName, P.Image, P.Qty, SUM(Amount) AS Count FROM invoice_detail OD
        INNER JOIN product P ON P.ProductID = OD.ProductID WHERE P.ProductName LIKE '%$search_proStock%' GROUP BY OD.ProductID ");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
</head>

<body>
    <table class="table table-hover mt-5">
        <thead>
            <tr class=" mt-4 text-white text-center h5" style="background: linear-gradient( rgb(13, 73, 141), rgb(33, 150, 188)); line-height: 30px;">
                <td><?= __('ProductID') ?></td>
                <td><?= __('Product Name') ?></td>
                <td><?= __('Stock-Out') ?></td>
                <td><?= __('Balance') ?></td>
                <td><?= __('Stability') ?></td>
                <td><?= __('Image') ?></td>
            </tr>
        </thead>

        <tbody>
            <?php
            if (mysqli_num_rows($search) > 0) {
                while ($stock_row = $search->fetch_assoc()) {

            ?>
        <tbody class="text-center h6" style="line-height: 30px;">
            <tr>
                <td><?= $stock_row['ProductID'] ?></td>
                <td><?= $stock_row['ProductName'] ?></td>
                <td><?= $stock_row['Count'] ?></td>
                <td><?= $stock_row['Qty'] ?></td>
                <td><?= $stock_row['Qty'] + $stock_row['Count'] ?></td>
                <td><img src="../../Images/<?= $stock_row['Image'] ?>" width="30px" height="30px" alt=""> </td>
            </tr>
        </tbody>

    <?php } ?>

<?php } else { ?>
    <h2 class="text-center pt-4"> <?= __('Nothing') ?> </h2>
<?php } ?>

</tbody>

    </table>
</body>

</html>