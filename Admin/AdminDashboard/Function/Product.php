<div class="slide1">
    <div class="col-4 d-flex gap-5 justify-content-between">
        <input type="text" class="form-control p-3 search" placeholder="Search..." id="search_pro" style="border-radius:15px;">
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="bg-white p-4 shadow border" style="border-radius: 20px;">
                <div class="d-flex justify-content-between">
                    <p style="font-weight: bold;" class="fs-5">
                        Product List
                    </p>
                    <p style="font-weight: bold;" class="fs-5 mx-5 px-5">
                        Filter &nbsp; <i class="fa-solid fa-filter"></i>
                    </p>
                </div>


                <div class="d-flex gap-2 justify-content-between">
                    <button type="button" class="btn p-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#addpro">Add Product</button>
                    <div class="d-flex gap-2">
                        <!-- Category Filter -->
                        <div class="input-group mb-3">
                            <select class="custom-select px-3" id="filter_cate">
                                <?php
                                $qry = $con->query("SELECT * FROM category");
                                while ($cate = $qry->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $cate['CategoryID'] ?>"><?php echo $cate['CategoryName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="input-group mb-3">
                            <select class="custom-select px-3" id="filter_status" size="">
                                <?php
                                $qry = $con->query("SELECT * FROM status");
                                while ($status = $qry->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $status['StatusID'] ?>"><?php echo $status['StatusName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>


                <!-- Query all Products into dataTable -->
                <table class="table table-hover mt-3" id="dataTable">
                    <thead>
                        <tr class="mt-4 text-white text-center h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 50px;">
                            <td> ProductID </td>
                            <td> Product Name</td>
                            <td> Type </td>
                            <td> Quantity </td>
                            <td> Unit Price </td>
                            <td> Import On</td>
                            <td> Expired On</td>
                            <td> Image </td>
                            <td> Status </td>
                            <td> Action </td>
                        </tr>
                    </thead>

                    <?php

                    // Reload data by page
                    $record_per_page = 5;

                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }
                    $start_page = ($page - 1) * 5;
                    $pro_qry = $con->query("SELECT c.CategoryName, s.StatusID, s.StatusName, p.ProductID, p.ProductName, p.Qty, p.Price, p.Import_On, p.Expired_On, p.StatusID, p.Image FROM product p
                                            INNER JOIN category c ON c.CategoryID = p.CategoryID 
                                            INNER JOIN status s ON s.StatusID = p.StatusID 
                                            ORDER BY p.ProductID DESC 
                                            LIMIT $start_page, $record_per_page");
                    while ($pro_row = $pro_qry->fetch_assoc()) {
                        $import_date = date_create($pro_row['Import_On']);
                        $expire_date = date_create($pro_row['Expired_On']);
                    ?>
                        <tbody>
                            <tr class="text-center h6" style="line-height: 50px;">
                                <td><?= $pro_row['ProductID'] ?> </td>
                                <td><?= $pro_row['ProductName'] ?> </td>
                                <td><?= $pro_row['CategoryName'] ?> </td>
                                <td><?= $pro_row['Qty'] ?> </td>
                                <td><?= '$' . number_format($pro_row['Price'], 2)  ?> </td>
                                <td><?= date_format($import_date, "D-M-d-Y ~ H:i:s A");  ?> </td>
                                <td><?= date_format($expire_date, "Y-M-d");  ?> </td>
                                <td><img src="../../Images/<?php echo $pro_row['Image'] ?>" width="50px" height="50px" alt=""></td>

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


                                <td align="center" class="pt-1">
                                    <button type="button" class="btn text-white px-4 p-2" style="background-color: #1D9A29;" data-bs-toggle="offcanvas" data-bs-target="#editpro-<?= $pro_row['ProductID'] ?>" aria-controls="editpro">
                                        <i class="fa-solid fa-pen-to-square" style="color: yellow;"></i>
                                        Edit
                                    </button>

                                    <button type="button" class="btn text-white px-4 p-2 " style="background-color: red;" data-bs-toggle="modal" data-bs-target="#deletepro-<?= $pro_row['ProductID'] ?>" aria-controls="deletepro">
                                        <i class="fa-sharp fa-solid fa-trash" style="color: yellow;"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>


                        <!-- Delete Product -->
                        <div class="modal fade" id="deletepro-<?= $pro_row['ProductID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:crimson">
                                        <h3 class="modal-title text-warning" id="exampleModalLabel">Are You Sure?</h3>
                                        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="get">
                                            <p class="mt-5 text-center"> Do you want to delete this product as <?= '"' . $pro_row['ProductName'] . '" ?' ?></p>

                                            <div class="col-12">
                                                <input type="hidden" class="form-control" name="del_proid" value="<?= $pro_row['ProductID'] ?>" readonly>
                                            </div>

                                            <div class="modal-footer mt-5">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Leave</button>
                                                <button type="submit" name="delete_pro" class="btn btn-outline-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Update Product -->
                        <div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editpro-<?= $pro_row['ProductID'] ?>" aria-labelledby="editLabel" style="color: white; background:linear-gradient(rgb(8, 234, 234), dodgerblue, rgb(13, 13, 183));">
                            <div class="offcanvas-header">
                                <h3 class="offcanvas-title text-white" id="editLabel">Update Product</h3>
                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                            </div>
                            <div class="offcanvas-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row gap-4">
                                        <div class="col-12">
                                            <input type="hidden" name="check_proid" value=" <?= $pro_row['ProductID'] ?>" class="form-control" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Product Name: </label>
                                            <input type="text" name="upd_proname" value="<?= $pro_row['ProductName'] ?>" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Category Type: </label>
                                            <select class="custom-select w-100 p-2" name="upd_procate" required>
                                                <?php
                                                $qry = $con->query("SELECT * FROM category ORDER BY CategoryID");
                                                while ($cate = $qry->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $cate['CategoryID'] ?>"><?php echo $cate['CategoryName'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Quantity: </label>
                                            <input type="number" min="0" name="upd_qty" value="<?= $pro_row['Qty'] ?>" class="form-control qty">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">UnitPrice: </label>
                                            <input type="number" name="upd_price" value="<?= $pro_row['Price'] ?>" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Import On: </label>
                                            <input type="datetime-local" name="upd_date" value="<?= $pro_row['Import_On'] ?>" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Expired On: </label>
                                            <input type="date" name="upd_expired" value="<?= $pro_row['Expired_On'] ?>" class="form-control expired">
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="control-label">Status Type:</label>
                                            <input type="hidden" name="upd_prostatus" value="<?= $pro_row['StatusID'] ?>" class="form-control statusID" readonly>
                                            <input type="text" value="<?= $pro_row['StatusName'] ?>" class="form-control statusName" readonly>
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
                    <?php } ?>
                </table>

                <div class="d-flex justify-content-between">

                    <!-- Show the record row by clicking page -->
                    <div class="d-flex gap-2 mt-5">
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
                    <div class="mt-5" style="color: grey">
                        Last Seen:
                        <?php
                        $date1 = date_create('2023-06-14'); //old
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
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-white" id="addproLabel">Product Control</h1>
                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row gap-4">
                        <div class="col-12">
                            <label for="" class="control-label">Product Name:</label>
                            <input type="text" name="pro_name" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Category Type:</label>
                            <select class="custom-select w-100 p-2" name="pro_cate">
                                <?php
                                $qry = $con->query("SELECT * FROM category ORDER BY CategoryID");
                                while ($cate = $qry->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $cate['CategoryID'] ?>"><?php echo $cate['CategoryName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Quantity:</label>
                            <input type="number" min="0" name="pro_qty" class="form-control qty">
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Unit Price:</label>
                            <input type="number" name="pro_price" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Purchased On:</label>
                            <input type="datetime-local" name="pro_date" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Expired On:</label>
                            <input type="date" name="pro_expired" class="form-control" id="expired">
                        </div>


                        <div class="col-12">
                            <label for="" class="control-label">Status Type:</label>
                            <input type="hidden" name="pro_status" class="form-control statusID" readonly>
                            <input type="text" class="form-control statusName" readonly>
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Description:</label>
                            <textarea name="pro_descr" class="form-control" rows="10"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="" class="control-label">Image:</label>
                            <input type="file" name="pro_img" class="form-control" onchange="preview()"> <br>
                            <img src="" width="100px" height="100px" id="frame">
                        </div>
                    </div>

                    <div class="modal-footer mt-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Leave</button>
                        <button type="submit" name="add_pro" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>