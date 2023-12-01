<?php
sleep(1);
include('../../../Connection/Connect.php');
include('../../../Translate/language.php');

if (isset($_POST['filter_status'])) {
    $filter_status = $_POST['filter_status'];
    $query = "SELECT c.CategoryName, b.BrandID, b.BrandName, s.StatusName, s.StatusID, sup.SupplierID, sup.SupplierName, p.* FROM product p
            INNER JOIN category c ON c.CategoryID = p.CategoryID 
            INNER JOIN status s ON s.StatusID = p.StatusID
            LEFT JOIN brand b ON b.BrandID = p.BrandID 
            LEFT JOIN Supplier Sup ON Sup.SupplierID = p.SupplierID 
            WHERE p.StatusID = $filter_status ORDER BY p.ProductID DESC ";
} else {
    $query = "SELECT * FROM product";
}

$filter_status_result = $con->query($query);
// if (mysqli_num_rows($filter_status_result) > 0) {
?>
<table class="table table-hover mt-3">
    <thead>
        <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
            <td><?= __('ProductID') ?> </td>
            <td><?= __('Image') ?> </td>
            <td><?= __('Product Name') ?> </td>
            <td><?= __('Type') ?> </td>
            <td><?= __('Brand') ?> </td>
            <td><?= __('Supplier') ?> </td>
            <td><?= __('Quantity') ?> </td>
            <td><?= __('Unit Price') ?> </td>
            <td class="text-center"><?= __('Import On') ?> </td>
            <td><?= __('Expired On') ?> </td>
            <td><?= __('Status') ?> </td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($filter_status_result) > 0) {
            while ($pro_row = $filter_status_result->fetch_assoc()) {
                $import_date = date_create($pro_row['Import_On']);
                $expire_date = date_create($pro_row['Expired_On']);
        ?>
    <tbody>
        <tr class="text-center h6" style="line-height: 30px;">
            <td class="text-start"><?= 'PHO' .  $pro_row['ProductID'] ?> </td>
            <td>
                <?php
                if ($pro_row['Image'] != null) {

                ?>
                    <img src="../../Images/<?php echo $pro_row['Image'] ?>" width="30px" height="30px" alt="">

                <?php } else { ?>
                    <img width="30px" height="30px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Blue_question_mark_icon.svg/1200px-Blue_question_mark_icon.svg.png" alt="">

                <?php } ?>

            </td>
            <td class="text-start"> <?= $pro_row['ProductName'] ?> </td>
            <td class="text-start"><?= $pro_row['CategoryName'] ?> </td>
            <td class="text-start"> <?= $pro_row['BrandName'] ?> </td>
            <td class="text-start"> <?= $pro_row['SupplierName'] ?> </td>
            <td><?= $pro_row['Qty'] ?> </td>
            <td><?= '$ ' . number_format($pro_row['Price'], 2)  ?> </td>
            <td><?= date_format($import_date, "D-M-d-Y ~ H:i:s A");  ?> </td>
            <td>
                <?=
                date_format($expire_date, "Y-M-d") == '-0001-Nov-30' ? 'None Expired' : date_format($expire_date, "Y-M-d")
                ?>
            </td>

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
    <h2 class="text-center pt-4"> <?= __('Nothing') ?> </h2>
<?php } ?>
</tbody>


</table>