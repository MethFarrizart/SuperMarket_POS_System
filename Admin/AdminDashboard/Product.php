<?php
include_once('../../../Mart_POS_System/Translate/lang.php');
?>


<div>
    <!-- Digital Clock -->
    <div class="text-end">
        <strong class="fs-5" id="day"></strong> <strong>/</strong>
        <strong class="fs-5" id="month"></strong> -
        <strong class="fs-5" id="day_num"></strong> <strong>/</strong>
        <strong class="fs-5" id="year"></strong> <strong class="fs-5">~</strong>
        <strong class="fs-5" id="hrs"></strong> <strong class="fs-5">:</strong>
        <strong class="fs-5" id="min"></strong> <strong class="fs-5">:</strong>
        <strong class="fs-5" id="sec"></strong> <strong class="fs-5" id="time"></strong>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="bg-white p-4 shadow border" style="border-radius: 20px;">
                <div class="d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <img style="height: 30px;" src="https://cdn0.iconfinder.com/data/icons/Aristocracy_WebDesignTuts/48/Download_Crate.png" alt="">
                        <p style="font-weight: bold;" class="fs-5">
                            <?= __('Product List') ?>
                        </p>
                    </div>

                    <div>
                        <button type="button" class="btn p-2 px-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#addpro"><?= __('Add Product') ?></button>
                        <button type="button" onclick="refreshPage()" class="btn p-2 px-3 btn-1 text-white"><?= __('Refresh') ?></button> &nbsp;
                    </div>
                </div>
                <hr>


                <div class="mt-3 d-flex justify-content-between">
                    <div>
                        <!-- <button type="button" class="btn p-2 px-3 btn-1 text-white">10</button> -->
                    </div>

                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <input type="text" class="form-control search" style="border-radius:15px;" placeholder="Search..." id="search_pro">
                        </div>

                        <div>
                            <a data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                <i class="h3 fa-solid fa-filter"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <!-- filter -->
                <div class="mt-3 collapse multi-collapse" id="collapseFilter">
                    <div class="card card-body">
                        <div class="row">
                            <!-- Category Filter -->
                            <div class="col-3">
                                <label for="" class="control-label text-dark"> <?= __("Category") ?> : </label>
                                <div id="filter_cate"></div>
                            </div>
                            <!-- Status Filter -->
                            <div class="col-3">
                                <label for="" class="control-label text-dark"> <?= __("Status") ?> : </label>
                                <div id="filter_status"></div>
                            </div>
                            <!-- Brand Filter -->
                            <div class="col-3">
                                <label for="" class="control-label text-dark"> <?= __("Brand") ?> : </label>
                                <div id="filter_brand"></div>
                            </div>
                            <!-- Supplier Filter -->
                            <div class="col-3">
                                <label for="" class="control-label text-dark"> <?= __("Supplier") ?> : </label>
                                <div id="filter_supplier"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Query all Products into dataTable -->
                <table id="dataTable" class="table table-hover mt-3">
                    <thead>
                        <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                            <td class="text-center"><?= __('Action') ?> </td>
                            <td><?= __('ProductID') ?> </td>
                            <td><?= __('Image') ?> </td>
                            <td><?= __('Product Name') ?> </td>
                            <td><?= __('Type') ?> </td>
                            <td><?= __('Brand') ?> </td>
                            <td><?= __('Supplier') ?> </td>
                            <td><?= __('Quantity') ?> </td>
                            <td><?= __('Purchase Price') ?> </td>
                            <td><?= __('Sell Price') ?> </td>
                            <td class="text-center"><?= __('Import On') ?> </td>
                            <td><?= __('Expired On') ?> </td>
                            <td><?= __('Status') ?> </td>
                        </tr>
                    </thead>

                    <?php
                    // Reload data by pagination
                    $record_per_page = 10;

                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }
                    $start_page = ($page - 1) * 10;
                    $pro_qry = $con->query("SELECT u.UnitID, u.UnitName, c.CategoryName, b.BrandID, b.BrandName, s.StatusID, s.StatusName, sup.SupplierID, sup.SupplierName, p.* FROM product p
                                            INNER JOIN category c ON c.CategoryID = p.CategoryID 
                                            INNER JOIN status s ON s.StatusID = p.StatusID 
                                            LEFT JOIN unit u ON u.UnitID = p.UnitID
                                            LEFT JOIN brand b ON b.BrandID = p.BrandID 
                                            LEFT JOIN Supplier Sup ON Sup.SupplierID = p.SupplierID 
                                            -- GROUP BY p.ProductID
                                            ORDER BY p.ProductID DESC 
                                            LIMIT $start_page, $record_per_page");
                    while ($pro_row = $pro_qry->fetch_assoc()) {
                        $import_date = date_create($pro_row['Import_On']);
                        $expire_date = date_create($pro_row['Expired_On']);
                        $pro_id = $pro_row['ProductID'];

                        // $updateQty = $con->query("SELECT SUM(pu.Qty) AS TotalQty, p.* FROM purchase_detail pu 
                        //                     INNER JOIN product p ON pu.ProductID = p.productID  WHERE p.ProductID = $pro_id
                        //                     ");
                        // $rowSellPrice = $updateQty->fetch_assoc();

                        // $totalQty = $rowSellPrice['TotalQty'];

                        // $updateTotalQty = $con->query("UPDATE Product SET Qty = $totalQty WHERE ProductID = $pro_id");

                        $cate_match = $pro_row['CategoryID'];
                        $brand_match = $pro_row['BrandID'];
                        $supplier_match = $pro_row['SupplierID'];
                    ?>
                        <tbody>
                            <tr class="text-center h6" style="line-height: 30px;">
                                <td>
                                    <div class="d-flex flex-column">
                                        <button style="background-color: dodgerblue; border-radius: 25px" align="center" class="show-details-btn btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <!-- <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="modal" data-bs-target="#viewpro-<?= $pro_row['ProductID'] ?>" aria-controls="viewpro">
                                                <i style="color: purple;" class="fa fa-eye" aria-hidden="true"></i> &nbsp;
                                                <?= __('View') ?>
                                            </button> -->
                                            <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="offcanvas" data-bs-target="#editpro-<?= $pro_row['ProductID'] ?>" aria-controls="editpro">
                                                <i style="color: green;" class="fa-solid fa-pen-to-square"></i> &nbsp;
                                                <?= __('Edit') ?>
                                            </button>

                                            <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="modal" data-bs-target="#deletepro-<?= $pro_row['ProductID'] ?>" aria-controls="deletepro">
                                                <i style="color: red;" class="fa-sharp fa-solid fa-trash"></i> &nbsp;
                                                <?= __('Delete') ?>
                                            </button>
                                        </div>


                                        <!-- <button align="center" style="margin-top: -3px;" class="show-details-btn btn btn-secondary fs-6" data-details-id="<?= $pro_row['ProductID'] ?>" type="button">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>

                                        <div id="<?= $pro_row['ProductID'] ?>" class="details">

                                            <div class="d-flex flex-column w-100 gap-2">
                                                <button type="button" class="btn text-white p-2 w-100 watchBg" data-bs-toggle="modal" data-bs-target="#viewpro-<?= $pro_row['ProductID'] ?>" aria-controls="viewpro">
                                                    <i class="fa fa-eye" aria-hidden="true" style="color: yellow"></i>
                                                    <?= __('View') ?>
                                                </button>
                                                <button type="button" class="btn text-white p-2 w-100" style="background-color: #1D9A29;" data-bs-toggle="offcanvas" data-bs-target="#editpro-<?= $pro_row['ProductID'] ?>" aria-controls="editpro">
                                                    <i class="fa-solid fa-pen-to-square" style="color: yellow;"></i>
                                                    <?= __('Edit') ?>
                                                </button>

                                                <button type="button" class="btn text-white p-2 w-100 " style="background-color: red;" data-bs-toggle="modal" data-bs-target="#deletepro-<?= $pro_row['ProductID'] ?>" aria-controls="deletepro">
                                                    <i class="fa-sharp fa-solid fa-trash" style="color: yellow;"></i>
                                                    <?= __('Delete') ?>
                                                </button>
                                            </div>

                                        </div> -->
                                    </div>
                                </td>

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


                                <td> <?= $pro_row['Qty'] . ' ' . $pro_row['UnitName']; ?> </td>


                                <td><?= '$ ' . number_format($pro_row['PurchasePrice'], 2)  ?> </td>
                                <td><?= '$ ' . number_format($pro_row['Price'], 2)  ?> </td>
                                <td><?= date_format($import_date, "D-M-d-Y ~ H:i:s A");  ?> </td>
                                <td>
                                    <?=
                                    date_format($expire_date, "Y-M-d") == '-0001-Nov-30' ? 'None Expired' : date_format($expire_date, "Y-M-d")
                                    ?>
                                </td>

                                <!-- Get status through quantity and date -->
                                <?php
                                $get_status     = $pro_row['StatusID'];
                                $get_proid      = $pro_row['ProductID'];
                                $current_date   =  date("Y-m-d");
                                $expired_date   = $pro_row['Expired_On'];

                                if ($current_date >= $expired_date) {
                                ?>
                                    <?php
                                    $new_status = $con->query("UPDATE `product` SET `StatusID` = 4 WHERE `ProductID` = $get_proid");
                                    if ($new_status === true) {
                                    ?>
                                        <td><?= $pro_row['StatusName'] ?> <div class=" spinner-grow spinner-grow-sm bg-danger"></div>
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
                                            <td class="h5"><span class="text-bg-danger badge rounded-pill"><?= $pro_row['StatusName'] ?></span> </td>
                                        <?php } ?>

                                    <?php } else if ($pro_row['Qty'] <= 5) { ?>

                                        <!-- The Status will be almost sold out -->
                                        <?php
                                        $new_status = $con->query("UPDATE `product` SET `StatusID` = 2 WHERE `ProductID` = $get_proid");
                                        if ($new_status === true) {
                                        ?>
                                            <td class="h5"><span class="text-white bg-warning badge rounded-pill"><?= $pro_row['StatusName'] ?></span> </td>
                                        <?php } ?>

                                    <?php } else if ($pro_row['Qty'] > 0 || empty($pro_row['Expired_On'])) { ?>

                                        <!-- The Status will be available -->
                                        <?php
                                        $new_status = $con->query("UPDATE `product` SET `StatusID` = 1 WHERE `ProductID` = $get_proid");
                                        if ($new_status === true || date_format($expire_date, "Y-M-d") == '-0001-Nov-30') {
                                        ?>
                                            <td class="h5"><span class="text-bg-success badge rounded-pill"><?= $pro_row['StatusName'] ?></span> </td>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                        </tbody>

                        <!-- Delete Product -->
                        <div class="modal fade" id="deletepro-<?= $pro_row['ProductID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:crimson">
                                        <h3 class="modal-title text-warning" id="exampleModalLabel">
                                            <?= __('Are You Sure ?') ?></h3>
                                        <div class="rotate-img">
                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <p class="mt-5 text-center"><?= __('Do you want to delete this product as') ?>
                                                <?= '"' . $pro_row['ProductName'] . '" ?' ?></p>

                                            <div class="col-12">
                                                <input type="hidden" class="form-control" name="del_proid" value="<?= $pro_row['ProductID'] ?>" readonly>
                                            </div>

                                            <div class="modal-footer mt-5">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= __('Leave') ?></button>
                                                <button type="submit" name="delete_pro" class="btn btn-outline-danger"><?= __('Delete') ?></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Update Product -->
                        <div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editpro-<?= $pro_row['ProductID'] ?>" aria-labelledby="editLabel" style="color: white; background:linear-gradient(rgb(8, 234, 234), dodgerblue, rgb(13, 13, 183));">
                            <div class="offcanvas-header">
                                <h3 class="offcanvas-title text-white" id="editLabel"><?= __('Update Product') ?></h3>
                                <div class="rotate-img">
                                    <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                </div>
                            </div>
                            <div class="offcanvas-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row gap-4">
                                        <div class="col-12">
                                            <input type="hidden" name="check_proid" value=" <?= $pro_row['ProductID'] ?>" class="form-control" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Product Name') ?>: </label>
                                            <input type="text" name="upd_proname" value="<?= $pro_row['ProductName'] ?>" class="form-control">
                                        </div>

                                        <div class="col-6">
                                            <label for="" class="control-label"><?= __('Category') ?>: </label>
                                            <select class="custom-select w-100 p-2" name="upd_procate">
                                                <?php
                                                $qry = $con->query("SELECT * FROM Category");
                                                while ($cate = $qry->fetch_assoc()) {
                                                ?>
                                                    <?php
                                                    if ($cate['CategoryID'] == $cate_match) {
                                                    ?>
                                                        <option selected value="<?= $cate['CategoryID'] ?>">
                                                            <?= $cate['CategoryName'] ?></option>

                                                    <?php } else { ?>
                                                        <option value="<?= $cate['CategoryID'] ?>"><?= $cate['CategoryName'] ?>
                                                        </option>

                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-6">
                                            <label for="" class="control-label"><?= __('Brand') ?>: </label>
                                            <select class="custom-select w-100 p-2" name="upd_probrand">
                                                <?php
                                                $qry = $con->query("SELECT * FROM brand");
                                                while ($brand = $qry->fetch_assoc()) {
                                                ?>
                                                    <?php
                                                    if ($brand['BrandID'] == $brand_match) {
                                                    ?>
                                                        <option selected value="<?= $brand['BrandID'] ?>">
                                                            <?= $brand['BrandName'] ?></option>

                                                    <?php } else { ?>
                                                        <option value="<?= $brand['BrandID'] ?>"><?= $brand['BrandName'] ?>
                                                        </option>

                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-6">
                                            <label for="" class="control-label"><?= __('Supplier') ?>: </label>
                                            <select class="custom-select w-100 p-2" name="upd_proSupplier">
                                                <?php
                                                $qry = $con->query("SELECT * FROM supplier");
                                                while ($supplier = $qry->fetch_assoc()) {
                                                ?>
                                                    <?php
                                                    if ($supplier['SupplierID'] == $supplier_match) {
                                                    ?>
                                                        <option value="<?= $supplier['SupplierID'] ?>">
                                                            <?= $supplier['SupplierName'] ?></option>

                                                    <?php } else { ?>
                                                        <option value="<?= $supplier['SupplierID'] ?>"><?= $supplier['SupplierName'] ?>
                                                        </option>

                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Quantity') ?>: </label>
                                            <input type="number" value="<?= $pro_row['Qty'] ?>" class="form-control qty" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Purchase Price') ?>: </label>
                                            <input type="text" name="upd_purchasePrice" value="<?= $pro_row['PurchasePrice'] ?>" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Sell Price') ?>: </label>
                                            <input type="text" name="upd_price" value="<?= $pro_row['Price'] ?>" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Import On') ?>: </label>
                                            <input type="datetime" value="<?= $pro_row['Import_On'] ?>" class="form-control" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Expired On') ?>: </label>
                                            <input type="date" name="upd_expired" value="<?= $pro_row['Expired_On'] ?>" class="form-control expired">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Status Type') ?>:</label>
                                            <input type="hidden" name="upd_prostatus" value="<?= $pro_row['StatusID'] ?>" class="form-control statusID" readonly>
                                            <input type="text" value="<?= $pro_row['StatusName'] ?>" class="form-control statusName" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Image') ?>: </label>
                                            <input type="hidden" name="old_img" value="<?php echo $pro_row['Image'] ?>">
                                            <input type="file" name="upd_proimg" class="form-control"> <br>
                                            <img src="../../Images/<?php echo $pro_row['Image'] ?>" width="100px" height="100px" alt="">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label"><?= __('Description') ?>: </label>
                                            <textarea name="upd_prodescr" class="form-control" rows="10"></textarea>
                                        </div>

                                    </div>

                                    <div class="modal-footer mt-5 gap-2">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><?= __('Leave') ?></button>
                                        <button type="submit" name="upd_pro" class="btn btn-success"><?= __('Update') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </table>

                <div class="d-flex justify-content-between">

                    <!-- Show the record row by clicking page -->
                    <div class="d-flex gap-2 mt-3">
                        <?php
                        $select_all = $con->query("SELECT * FROM product");

                        $total_record = mysqli_num_rows($select_all);
                        $total_pages = ceil($total_record / $record_per_page);

                        // Release button Previous with left-angle icon
                        if ($page > 1) {
                            echo "<a href='Inventory.php?page=" . ($page - 1) . "' class='btn btn-outline-success px-3'> <i class='fa-solid fa-angles-left'></i> </a>";
                        }

                        // Release the possible nth page to record data
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='Inventory.php?page= " . $i . "' class='btn btn-outline-success px-4'> $i </a>";
                        }

                        // Release button Next with right-angle icon
                        if ($i > ($page + 1)) {
                            echo "<a href='Inventory.php?page=" . ($page + 1) . "' class='btn btn-outline-success'> <i class='fa-solid fa-angles-right'></i> </a>";
                        }
                        ?>
                    </div>

                    <!-- Show Last Seen -->
                    <div class="mt-3" style="color: grey">
                        Last Seen:
                        <?php
                        $date1 = date_create('2023-06-15'); //old
                        $date2 = date_create(date('Y-m-d')); //new
                        $diff = date_diff($date1, $date2);

                        echo  $show = $diff->format("%a") . ' ' . 'days ago';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal add product -->
<div class="modal fade" style="background-color: rgba(0, 0, 0, 0.685);" id="addpro" tabindex="-1" aria-labelledby="addproLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-xl" role="document">
        <div class="modal-content content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-white" id="addproLabel"><?= __('Product Control') ?></h1>
                <div class="rotate-img">
                    <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                </div>
            </div>
            <div class="modal-body">
                <form id="addProduct" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Product Name') ?>:</label>
                            <input type="text" name="pro_name" id="pro_name" class="form-control" required>
                        </div>

                        <!-- Category -->
                        <div class="col-4">
                            <label for="" class="control-label"> <?= __("Category") ?>: </label>
                            <div id="insert_category"></div>
                        </div>

                        <!-- Brand -->
                        <div class="col-4">
                            <label for="" class="control-label"> <?= __("Brand") ?>: </label>
                            <div id="insert_brand"></div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Supplier -->
                        <div class="col-4">
                            <label for="" class="control-label"> <?= __("Supplier") ?>: </label>
                            <div id="insert_supplier"></div>
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Purchase Price') ?>: </label>
                            <input type="text" name="pro_purchasePrice" class="form-control" required>
                        </div>

                        <!-- Sell Price -->
                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Sell Price') ?>:</label>
                            <input type="text" name="pro_price" id="price" class="form-control" required>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <!-- Unit Name -->
                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Unit Name') ?>:</label>
                            <div id="insert_unit"></div>
                        </div>

                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Expired On') ?>:</label>
                            <input type="date" id="pro_expired" name="pro_expired" class="form-control expired">
                        </div>


                        <!-- Status -->
                        <div class="col-4">
                            <label for="" class="control-label"><?= __('Status Type') ?>:</label>
                            <input type="hidden" id="pro_status" name="pro_status" class="form-control statusID" readonly>
                            <input type="text" class="form-control statusName" readonly>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <!-- Description -->
                        <div class="col-12">
                            <label for="" class="control-label"><?= __('Description') ?>:</label>
                            <textarea id="pro_descr" name="pro_descr" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="col-12 mt-5">
                            <label for="" class="control-label"><?= __('Image') ?>:</label>
                            <input type="file" id="pro_img" name="pro_img" class="form-control" onchange="preview()"> <br>
                            <img src="" width="100px" height="100px" id="frame">
                        </div>
                    </div>


                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= __('Leave') ?></button>
                        <button type="submit" name="add_pro" class="btn btn-success"><?= __('Add') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>