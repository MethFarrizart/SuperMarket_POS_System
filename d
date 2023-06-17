<?php
if (isset($_GET['PosID'])) {
    $id = $_GET['PosID'];
    $result = $con->query("DELETE FROM position WHERE PositionID = '$id'");

    if ($result === true) {

?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Successfully Deleted!'
            })
        </script>

<?php }
} ?>

<td><?= '<img src="data:image;base64,' . base64_encode($pos_row['Image']) . ' " width=50px; height=50px;>'; ?> </td>





<!-- Select category to display data -->
<?php
$all = $con->query("SELECT * FROM Category");
while ($row = $all->fetch_assoc()) {
?>
    <p> Category: <?= $row['CategoryName'] ?></p>
    <?php
    $cate = $row['CategoryID'];
    $querys = $con->query("SELECT * FROM product WHERE CategoryID = $cate");
    while ($rows = $querys->fetch_assoc()) {
    ?>
        <small><?= $rows['ProductName'] ?> </small>
    <?php } ?>

<?php } ?>










<?php
$current_date = strtotime(date("Y-m-d"));
$expired_date = strtotime($pro_row['Expired_On']);
if ($current_date >= $expired_date) {
?>
    <?php
    $status = "SELECT StatusName FROM status WHERE StatusID = 4";
    $result = $con->query($status);
    while ($status_row = $result->fetch_assoc()) {
    ?>
        <td><?= $status_row['StatusName'] ?></td>
    <?php } ?>

<?php } else { ?>
    <?php
    if ($pro_row['Qty'] == 0) {
    ?>
        <!-- The Status will be sold out -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 3";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>
        <?php } ?>

    <?php } else if ($pro_row['Qty'] <= 5) { ?>
        <!-- The Status will be almost sold out -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 2";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>

        <?php } ?>

    <?php } else if ($pro_row['Qty'] > 0) { ?>
        <!-- The Status will be available -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 1";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>

        <?php } ?>
    <?php } ?>
<?php } ?>













<?php
$pro_qry = $con->query("SELECT c.CategoryName, s.StatusName, p.ProductID, p.ProductName, p.Qty, p.Price, p.Import_On, p.Expired_On, p.StatusID, p.Image FROM product p
                                                            INNER JOIN category c ON c.CategoryID = p.CategoryID 
                                                            -- INNER JOIN status s ON s.StatusID = p.StatusID
                                                            ORDER BY p.ProductID DESC");
while ($pro_row = $pro_qry->fetch_assoc()) {
?>
    <tbody>
        <tr class="text-center h6" style="line-height: 50px;">
            <td><?= $pro_row['ProductID'] ?> </td>
            <td><?= $pro_row['ProductName'] ?> </td>
            <td><?= $pro_row['CategoryName'] ?> </td>
            <td><?= $pro_row['Qty'] ?> </td>
            <td><?= $pro_row['Price'] ?> </td>
            <td><?= $pro_row['Import_On'] ?> </td>
            <td><?= $pro_row['Expired_On'] ?> </td>
            <td><img src="../../Images/<?php echo $pro_row['Image'] ?>" width="50px" height="50px" alt=""></td>
            <!-- <td><?= $pro_row['StatusID'] ?></td> -->

            <?php
            $check_status = $pro_row['StatusID'];
            $result = $con->query("SELECT * FROM status WHERE StatusID = $check_status");
            ?>



            <td align="center" class="pt-1">
                <button type="button" class="btn text-white px-4 p-2" style="background-color: #1D9A29;" data-bs-toggle="offcanvas" data-bs-target="#editpro-" aria-controls="editpro">
                    <i class="fa-solid fa-pen-to-square" style="color: yellow;"></i>
                    Edit
                </button>

                <button type="button" class="btn text-white px-4 p-2 " style="background-color: red;" data-bs-toggle="offcanvas" data-bs-target="#deletepro-" aria-controls="deletepro">
                    <i class="fa-sharp fa-solid fa-trash" style="color: yellow;"></i>
                    Delete
                </button>
            </td>
        </tr>
    </tbody>
<?php } ?>





























// $upd_prostatus = $_POST['upd_prostatus'];












<!-- <select class="custom-select w-100 p-2" name="pro_status">
                                <?php
                                $qry = $con->query("SELECT * FROM status WHERE StatusID = 1");
                                while ($cate = $qry->fetch_assoc()) {
                                ?>
                                        <option selected value="<?php echo $cate['StatusID'] ?>"><?php echo $cate['StatusName'] ?></option>
                                    <?php } ?>
                                </select> -->









<?php
$qry = $con->query("SELECT * FROM status WHERE StatusID = 1");
while ($status = $qry->fetch_assoc()) {
    echo $status['StatusName'];
?>

<?php } ?>





<!-- Delete Product -->
<div class="offcanvas offcanvas-top w-100" tabindex="-1" id="deletepro-<?= $pro_row['ProductID'] ?>" aria-labelledby="deleteLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="deleteLabel">Delete Product</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
    </div>
    <div class="offcanvas-body bg-warning">
        <form action="" method="get">
            <h3> Are You Sure?</h3>

            <div class="col-12">
                <input type="text" class="form-control" name="del_proid" value="<?= $pro_row['ProductID'] ?>" readonly>
            </div>

            <div class="modal-footer mt-5">
                <button type="submit" class="btn btn-danger" name="delete_pro">Delete</button>
            </div>
        </form>
    </div>
</div>


<!-- Update Product -->
<div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editpro-<?= $pro_row['ProductID'] ?>" aria-labelledby="editLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="editLabel">Update Product</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
    </div>
    <div class="offcanvas-body bg-primary">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row gap-4">
                <div class="col-12">
                    <label class="control-label">Product_ID: </label>
                    <input type="text" name="check_proid" value=" <?= $pro_row['ProductID'] ?>" class="form-control" readonly>
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Product Name: </label>
                    <input type="text" name="upd_proname" value="<?= $pro_row['ProductName'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Category Type: </label>
                    <select class="custom-select w-100 p-2" name="upd_procate">
                        <?php
                        $qry = $con->query("SELECT * FROM category ORDER BY CategoryID");
                        while ($cate = $qry->fetch_assoc()) {
                        ?>
                            <option selected value="<?php echo $cate['CategoryID'] ?>"><?php echo $cate['CategoryName'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Quantity: </label>
                    <input type="text" name="upd_qty" value="<?= $pro_row['Qty'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">UnitPrice: </label>
                    <input type="text" name="upd_price" value="<?= $pro_row['Price'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Import On: </label>
                    <input type="datetime-local" name="upd_date" value="<?= $pro_row['Import_On'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Expired On: </label>
                    <input type="date" name="upd_expired" value="<?= $pro_row['Expired_On'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Status Type:</label>
                    <input type="text" name="upd_prostatus" value="<?= $pro_row['StatusID'] ?>" class="form-control">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Image: </label>
                    <input type="file" name="upd_proimg" value="<?= $pro_row['Image'] ?>" class="form-control"> <br>
                    <img src="../../Images/<?php echo $pro_row['Image'] ?>" width="100px" height="100px" alt="">
                </div>

                <div class="col-12">
                    <label for="" class="control-label">Description: </label>
                    <textarea name="upd_prodescr" class="form-control" rows="10"></textarea>
                </div>

            </div>

            <div class="modal-footer mt-5 gap-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Leave</button>
                <button type="submit" name="upd_pro" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>















if ($i > $page) {
// echo "<a href='Inventory.php?page=" . ($page + 1) . "' class='btn btn-primary'> Next </a>";
// }


<nav aria-label="...">
    <ul class="pagination">
        <?php
        $select_all = $con->query("SELECT * FROM product");

        $total_record = mysqli_num_rows($select_all);
        $total_pages = ceil($total_record / $record_per_page);

        if ($page > 1) {

        ?>
            <li class="page-item">
                <a class="page-link" href="Inventory.php?page=<?= $i = 1 ?>" tabindex="-1">Previous</a>
            </li>

        <?php }
        for ($i = 1; $i <= $total_pages; $i++) { ?>

            <li class="page-item">
                <a class="page-link" href="Inventory.php?page=<?= $i ?>"></a>
            </li>

        <?php } ?>
    </ul>
</nav>