<?php
sleep(1);
include('../../../Connection/Connect.php');
include('../../../Translate/language.php');

if (isset($_POST['search_pro'])) {
    $search = $_POST['search_pro'];
    $query = "SELECT c.CategoryName, s.StatusName, s.StatusID, p.ProductID, p.ProductName, p.Qty, p.Price, p.Import_On, p.Expired_On, p.StatusID, p.Image FROM product p
            INNER JOIN category c ON c.CategoryID = p.CategoryID 
            INNER JOIN status s ON s.StatusID = p.StatusID
            WHERE ProductName LIKE '%$search%' ORDER BY p.ProductID DESC ";
    $search_result = $con->query($query);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <table class="table table-hover mt-3">
            <thead>
                <tr class="mt-4 text-white text-center h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 50px;">
                    <td class="text-center"><?= __('Action') ?> </td>
                    <td><?= __('ProductID') ?> </td>
                    <td><?= __('Image') ?> </td>
                    <td><?= __('Product Name') ?> </td>
                    <td><?= __('Type') ?> </td>
                    <td><?= __('Quantity') ?> </td>
                    <td><?= __('Unit Price') ?> </td>
                    <td class="text-center"><?= __('Import On') ?> </td>
                    <td><?= __('Expired On') ?> </td>
                    <td><?= __('Status') ?> </td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($search_result) > 0) {
                    while ($pro_row = $search_result->fetch_assoc()) {
                        $import_date = date_create($pro_row['Import_On']);
                        $expire_date = date_create($pro_row['Expired_On']);
                ?>
            <tbody>
                <tr class="text-center h6" style="line-height: 50px;">
                    <td><?= $pro_row['ProductID'] ?> </td>
                    <td><?= $pro_row['ProductName'] ?> </td>
                    <td><?= $pro_row['CategoryName'] ?> </td>
                    <td><?= $pro_row['Qty'] ?> </td>
                    <td><?= '$' . number_format($pro_row['Price'], 2) ?> </td>
                    <td><?= date_format($import_date, "Y-M-d ~ H:i:s");  ?> </td>
                    <td><?= date_format($expire_date, "Y-M-d");  ?> </td>
                    <td><img src="../../Images/<?php echo $pro_row['Image'] ?>" width="50px" height="50px" alt=""></td>

                    <?php
                        $get_status     = $pro_row['StatusID'];
                        $get_proid      = $pro_row['ProductID'];
                        $current_date =  date("Y-m-d");
                        $expired_date = $pro_row['Expired_On'];
                        if ($current_date >= $expired_date) {
                    ?>
                        <?php
                            $new_status = $con->query("UPDATE `product` SET `StatusID` = 4 WHERE `ProductID` = $get_proid");
                            if ($new_status === true) {
                        ?>
                            <td><?= $pro_row['StatusName'] ?> <div class="spinner-grow spinner-grow-sm bg-danger"></div>
                            </td>
                        <?php } ?>

                    <?php } else { ?>

                        <?php
                            if ($pro_row['Qty'] == 0) {
                        ?>
                            <!-- The Status will be sold out -->
                            <?php
                                $new_status = $con->query("UPDATE `product` SET `StatusID` = 3 WHERE `ProductID` = $get_proid");
                                if ($new_status === true) {
                            ?>
                                <td class="text-danger"><?= $pro_row['StatusName'] ?></td>
                            <?php } ?>

                        <?php } else if ($pro_row['Qty'] <= 5) { ?>

                            <!-- The Status will be almost sold out -->
                            <?php
                                $new_status = $con->query("UPDATE `product` SET `StatusID` = 2 WHERE `ProductID` = $get_proid");
                                if ($new_status === true) {
                            ?>
                                <td class="text-warning"><?= $pro_row['StatusName'] ?></td>
                            <?php } ?>

                        <?php } else if ($pro_row['Qty'] > 0) { ?>

                            <!-- The Status will be available -->
                            <?php
                                $new_status = $con->query("UPDATE `product` SET `StatusID` = 1 WHERE `ProductID` = $get_proid");
                                if ($new_status === true) {
                            ?>
                                <td class="text-success"><?= $pro_row['StatusName'] ?></td>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </tbody>

        <?php } ?>

    <?php } else { ?>
        <h2 class="text-center pt-4"> Nothing </h2>
    <?php } ?>
    </tbody>


        </table>
    </body>

    </html>

<?php } else {
    header('./Admin/AdminDashboard/Inventory.php');
} ?>