<?php
require('../../Translate/lang.php');
include('../../Connection/Connect.php');

?>

<?php
if (isset($_POST['add_supplier'])) {
    $SupplierName = $_POST['SupplierName'];
    $Contact = $_POST['Contact'];
    $Address = $_POST['Address'];
    $Email = $_POST['Email'];
    $supplier_descr = $_POST['supplier_descr'];

    $ins_brand = $con->query("INSERT INTO `supplier`(`SupplierName`, `Contact`, `Email`, `Address`, `Description`) VALUES ('$SupplierName', '$Contact', '$Email', '$Address', '$supplier_descr')");
}
?>

<?php
// Update supplier
if (isset($_POST['upd_supplier'])) {
    $check_SupplierID = $_POST['check_SupplierID'];
    $upd_SupplierName = $_POST['upd_SupplierName'];
    $upd_Contact = $_POST['upd_Contact'];
    $upd_Address = $_POST['upd_Address'];
    $upd_Email = $_POST['upd_Email'];

    $upd_Supplier = $con->query("UPDATE `supplier` SET 
                            `SupplierName` = '$upd_SupplierName' ,
                            `Contact` = '$upd_Contact',
                            `Email` = '$upd_Email',	
                            `Address` = '$upd_Address'
                            WHERE SupplierID = $check_SupplierID");

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:green; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> <?= __('This Supplier on ID') . ' = SUP' . $check_SupplierID  . ' ' . __("has updated") ?></h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>

<?php
// Delete Supplier
if (isset($_GET['delete_supplier'])) {
    $id = $_GET['del_SupplierId'];

    $del_supplier = "DELETE FROM `supplier` WHERE SupplierID = $id";
    $con->query($del_supplier);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%">
        <h5 class="pt-3 text-white"> <?= __('This Supplier on ID') . ' = SUP' . $id  . ' ' . __("has deleted") ?></h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="Css/Inventory.css">
</head>

<body>
    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>

            <div class="container-fluid" style="margin-top: 120px;">
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
                                    <img style="height: 30px;" src="https://cdn0.iconfinder.com/data/icons/supply-chain-dualine-flat/64/Supplier-256.png" alt="">
                                    <p style="font-weight: bold;" class="fs-5">
                                        <?= __('Supplier List') ?>
                                    </p>
                                </div>

                                <div>
                                    <button class="btn p-2 px-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#addSupplier"><?= __('Add Supplier') ?></button>
                                    <button class="btn p-2 px-3 btn-1 text-white" type="button" onclick="refreshPage()"><?= __('Refresh') ?></button> &nbsp;
                                </div>
                            </div>
                            <hr>


                            <div class="mt-3 d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn p-2 px-3 btn-1 text-white">10</button>
                                </div>

                                <div class="d-flex gap-2">
                                    <div class="w-100">
                                        <input type="text" class="form-control search" style="border-radius:15px;" placeholder="Search..." id="search_supplier">
                                    </div>
                                </div>
                            </div>


                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="mt-4 text-white h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                        <td><?= __('Action') ?></td>
                                        <td><?= __('SupplierID') ?></td>
                                        <td><?= __('Supplier Name') ?> </td>
                                        <td><?= __('Contact') ?> </td>
                                        <td><?= __('Email') ?> </td>
                                        <td><?= __('Address') ?> </td>
                                    </tr>
                                </thead>

                                <?php
                                // Reload data by pagination
                                $record_per_page = 5;

                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                $start_page = ($page - 1) * 5;


                                $qry_supplier = $con->query("SELECT * FROM supplier ORDER BY SupplierID DESC LIMIT $start_page, $record_per_page");
                                while ($supplier_row = $qry_supplier->fetch_assoc()) {
                                ?>
                                    <tbody>
                                        <tr class="h6" style="line-height: 30px;">
                                            <td class="pt-1">
                                                <button style="background-color: dodgerblue; border-radius: 25px;" class="show-details-btn btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-solid fa-gear"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="offcanvas" data-bs-target="#editSupplier-<?= $supplier_row['SupplierID'] ?>" aria-controls="editSupplier">
                                                        <i class="fa-solid fa-pen-to-square" style="color: green;"></i> &nbsp;
                                                        <?= __('Edit') ?>
                                                    </button>

                                                    <button type="button" class="dropdown-item btn p-2 w-100 text-secondary" data-bs-toggle="modal" data-bs-target="#deleteSupplier-<?= $supplier_row['SupplierID'] ?>" aria-controls="deleteSupplier">
                                                        <i style="color: red;" class="fa-sharp fa-solid fa-trash"></i> &nbsp;
                                                        <?= __('Delete') ?>
                                                    </button>
                                                </div>
                                            </td>

                                            <td><?= 'SUP' . $supplier_row['SupplierID'] ?> </td>
                                            <td><?= $supplier_row['SupplierName'] ?> </td>
                                            <td><?= $supplier_row['Contact'] ?> </td>
                                            <td><?= $supplier_row['Email'] ?> </td>
                                            <td><?= $supplier_row['Address'] ?> </td>
                                        </tr>
                                    </tbody>

                                    <!-- Delete Supplier -->
                                    <div class="modal fade" id="deleteSupplier-<?= $supplier_row['SupplierID'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:crimson">
                                                    <h3 class="modal-title text-warning" id="deleteLabel"><?= __('Are You Sure ?') ?></h3>
                                                    <div class="rotate-img">
                                                        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="get">
                                                        <p class="mt-5 text-center"><?= __('Do you want to delete this Supplier as') ?> <?= '"' . $supplier_row['SupplierName'] . '"?' ?></p>

                                                        <div class="col-12">
                                                            <input type="hidden" class="form-control" name="del_SupplierId" value="<?= $supplier_row['SupplierID'] ?>" readonly>
                                                        </div>

                                                        <div class="modal-footer mt-5">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('Leave') ?></button>
                                                            <button type="submit" name="delete_supplier" class="btn btn-outline-danger"><?= __('Delete') ?></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Update Supplier -->
                                    <div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editSupplier-<?= $supplier_row['SupplierID'] ?>" aria-labelledby="editLabel" style="background:linear-gradient(rgb(8, 234, 234), dodgerblue, rgb(13, 13, 183));">
                                        <div class="offcanvas-header">
                                            <h3 class="offcanvas-title text-white" id="editLabel"><?= __('Update Supplier') ?> </h3>
                                            <div class="rotate-img">
                                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                            </div>
                                        </div>
                                        <div class="offcanvas-body mt-3">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row gap-4">
                                                    <div class="col-12">
                                                        <label class="control-label"><?= __('Supplier_ID') ?>: </label>
                                                        <input type="text" name="check_SupplierID" value=" <?= $supplier_row['SupplierID'] ?>" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label"><?= __('Supplier Name') ?>: </label>
                                                        <input type="text" name="upd_SupplierName" value=" <?= $supplier_row['SupplierName'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label"><?= __('Contact') ?>: </label>
                                                        <input type="text" name="upd_Contact" value=" <?= $supplier_row['Contact'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label"><?= __('Email') ?>: </label>
                                                        <input type="email" name="upd_Email" value=" <?= $supplier_row['Email'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label"><?= __('Address') ?>: </label>
                                                        <input type="text" name="upd_Address" value=" <?= $supplier_row['Address'] ?>" class="form-control">
                                                    </div>

                                                </div>

                                                <div class="modal-footer mt-5 gap-2 pt-3" style="border-top: 1px solid white;">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><?= __('Leave') ?></button>
                                                    <button type="submit" name="upd_supplier" class="btn btn-success"><?= __('Update') ?></button>
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
                                    $select_all = $con->query("SELECT * FROM supplier");

                                    $total_record = mysqli_num_rows($select_all);
                                    $total_pages = ceil($total_record / $record_per_page);

                                    // Release button Previous with left-angle icon
                                    if ($page > 1) {
                                        echo "<a href='Supplier.php?page=" . ($page - 1) . "' class='btn btn-outline-success px-3'> <i class='fa-solid fa-angles-left'></i> </a>";
                                    }

                                    // Release the possible nth page to record data
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        echo "<a href='Supplier.php?page= " . $i . "' class='btn btn-outline-success px-4'> $i </a>";
                                    }

                                    // Release button Next with right-angle icon
                                    if ($i > ($page + 1)) {
                                        echo "<a href='Supplier.php?page=" . ($page + 1) . "' class='btn btn-outline-success'> <i class='fa-solid fa-angles-right'></i> </a>";
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal add Supplier -->
        <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.685);" id="addSupplier" tabindex="-1" aria-labelledby="addSupplierLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-white" id="addproLabel"><?= __('Supplier Control') ?></h1>
                        <div class="rotate-img">
                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row gap-4">
                                <div class="col-12">
                                    <label class="control-label"><?= __('Supplier Name') ?>: </label>
                                    <input type="text" name="SupplierName" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="control-label"><?= __('Contact') ?>: </label>
                                    <input type="text" name="Contact" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="control-label"><?= __('Email') ?>: </label>
                                    <input type="email" name="Email" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="control-label"><?= __('Address') ?>: </label>
                                    <input type="text" name="Address" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label for="" class="control-label"><?= __('Description') ?>:</label>
                                    <textarea name="supplier_descr" class="form-control" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer mt-5">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= __('Leave') ?></button>
                                <button type="submit" name="add_supplier" class="btn btn-success"><?= __('Add') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>


<script>

</script>