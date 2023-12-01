<?php
sleep(2);
include('../../Connection/Connect.php');
require('../../Translate/lang.php');

// Add Position
if (isset($_POST['add_pos'])) {
    $pos_name   = $_POST['pos_name'];
    $pos_sal    = $_POST['pos_sal'];
    $pos_descr  = $_POST['pos_descr'];
    $pos_bonus  = $_POST['pos_bonus'];

    $pos_img = $_FILES['pos_img']['name'];
    $tmp_img = $_FILES['pos_img']['tmp_name'];
    $path_img = "../../Images/";
    move_uploaded_file($tmp_img, $path_img . $pos_img);

    $ins_pos = "INSERT INTO `position`(`PositionName`, `Avg_Salary`, `Bonus`, `Image`, `Description`) 
                    VALUES('$pos_name', '$pos_sal', '$pos_bonus', '$pos_img', '$pos_descr')";

    $con->query($ins_pos);
}

?>

<!-- Update Position -->
<?php
if (isset($_POST['upd_pos'])) {
    $check_id       = $_POST['check_id'];
    $upd_pos_name   = $_POST['upd_pos_name'];
    $upd_pos_sal    = $_POST['upd_pos_sal'];
    $upd_pos_descr  = $_POST['upd_pos_descr'];
    $upd_pos_bonus  = $_POST['upd_pos_bonus'];

    if ($_FILES['upd_pos_img']['name'] != "") {
        $upd_pos_img = $_FILES['upd_pos_img']['name'];
        $upd_tmp = $_FILES['upd_pos_img']['tmp_name'];
        move_uploaded_file($upd_tmp, "../../Images/" . $upd_pos_img);
    } else {
        $upd_pos_img = $_POST['old_img'];
    }

    $upd_pos = "UPDATE `position` SET 
            `PositionName`='$upd_pos_name',
            `Avg_Salary`='$upd_pos_sal',
            `Bonus`='$upd_pos_bonus',
            `Image`='$upd_pos_img',
            `Description`='$upd_pos_descr' WHERE PositionID = $check_id";

    $con->query($upd_pos);
?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_update fade show p-4 pt-3" role="alert" style="background-color:green; border-radius: 0; z-index: 9999999999999999">
        <h5 class="pt-3 text-white"><?= __('This position on ID =') ?> <?php echo $check_id ?><?= ' ' . __('has updated') ?> </h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>


<!-- delete Position -->
<?php
if (isset($_GET['delete'])) {
    $id = $_GET['del_id'];

    $del = "DELETE FROM `position` WHERE PositionID = $id";
    $con->query($del);
    include_once('Position.php');

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; top: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"><?= __('This position on ID =') ?> <?php echo $id ?><?= ' ' . __('has deleted') ?> </h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php }

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="Css/Inventory.css">
</head>

<style>
    .alert_delete,
    .alert_update {
        top: 0;
        width: 100%;
        height: 9vh;
        position: absolute;
        z-index: 999999999;
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

            <div class="container-fluid">
                <div class="row" style="margin-top: 140px;">
                    <div class="col-12">
                        <div class="bg-white p-4 shadow border" style="border-radius: 20px;">
                            <h3 style="font-weight: bold; ">
                                <?= __('Position') ?>
                            </h3>

                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn p-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#position"><?= __('Add Position') ?></button>
                            </div>

                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: rgb(13, 77, 141); line-height: 50px;">
                                        <td><?= __('PositionID') ?> </td>
                                        <td><?= __('Position Name') ?> </td>
                                        <td><?= __('Average Salary') ?> </td>
                                        <td><?= __('Bonus') ?> </td>
                                        <td><?= __('Image') ?> </td>
                                        <td><?= __('Action') ?> </td>
                                    </tr>
                                </thead>

                                <?php
                                $pos_qry = $con->query("SELECT * FROM position");
                                while ($pos_row = $pos_qry->fetch_assoc()) {
                                ?>
                                    <tbody>
                                        <tr class="text-center h6" style="line-height: 50px;">
                                            <td><?= $pos_row['PositionID'] ?></td>
                                            <td><?= $pos_row['PositionName']  ?></td>
                                            <td><?= '$' . number_format($pos_row['Avg_Salary'], 2) ?></td>
                                            <td><?= '$' . number_format($pos_row['Bonus'], 2)   ?></td>
                                            <td><img src="../../Images/<?= $pos_row['Image'] ?>" width="70px" height="70px" alt=""></td>
                                            <td align="center" class="pt-1 gap-3 ">

                                                <!-- Update -->
                                                <a class="fs-5" href="#editpos-<?= $pos_row['PositionID'] ?>" data-bs-toggle="offcanvas" aria-controls="editpos">
                                                    <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                                                </a>

                                                <!-- Delete -->
                                                <a class="fs-5" href="#deletePos-<?= $pos_row['PositionID'] ?>" data-bs-toggle="offcanvas" aria-controls="deletePos">
                                                    <i class="fa-sharp fa-solid fa-trash mx-3" style="color: red;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Delete Position -->
                                    <div class="offcanvas offcanvas-top w-25 h-50" tabindex="-1" id="deletePos-<?= $pos_row['PositionID'] ?>" aria-labelledby="deleteLabel">
                                        <div class="offcanvas-header pt-3" style="background-color:crimson">
                                            <h3 class="offcanvas-title text-warning" id="deleteLabel"><?= __('Are You Sure ?') ?> </h3>
                                            <div class="rotate-img">
                                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                            </div>
                                        </div>
                                        <div class="offcanvas-body">
                                            <form action="" method="get">
                                                <p class="mt-5 text-center"><?= __('Do you want to delete this Position as') ?> <?= '"' . $pos_row['PositionName'] . '" ?' ?></p>

                                                <div class="col-12">
                                                    <input type="hidden" class="form-control" name="del_id" value="<?= $pos_row['PositionID'] ?>" readonly>
                                                </div>

                                                <div class="modal-footer mt-5 gap-2 d-flex">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><?= __('Leave') ?></button>
                                                    <button type="submit" class="btn btn-outline-danger" name="delete"><?= __('Delete') ?></button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>


                                    <!-- Update Position -->
                                    <div class="offcanvas offcanvas-end w-25" style="color: white; background:linear-gradient(rgb(8, 234, 234), dodgerblue, rgb(13, 13, 183));" tabindex="-1" id="editpos-<?= $pos_row['PositionID'] ?>" aria-labelledby="editLabel">
                                        <div class="offcanvas-header">
                                            <h3 class="offcanvas-title" id="editLabel"><?= __('Update Position') ?></h3>
                                            <div class="rotate-img">
                                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                            </div>
                                        </div>
                                        <div class="offcanvas-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row gap-4">
                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('PositionID') ?>:</label>
                                                        <input type="text" name="check_id" value="<?= $pos_row['PositionID'] ?>" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('Position Name') ?>:</label>
                                                        <input type="text" name="upd_pos_name" value="<?= $pos_row['PositionName'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('Average Salary') ?>:</label>
                                                        <input type="number" name="upd_pos_sal" value="<?= $pos_row['Avg_Salary'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('Bonus') ?>:</label>
                                                        <input type="number" name="upd_pos_bonus" value="<?= $pos_row['Bonus'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('Image') ?>:</label>
                                                        <input type="file" name="upd_pos_img" class="form-control"> <br>
                                                        <input type="hidden" name="old_img" value="<?php echo $pos_row['Image'] ?>">
                                                        <img src="../../Images/<?php echo $pos_row['Image'] ?>" width="50px" height="50px" alt="">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label"><?= __('Description') ?>:</label>
                                                        <textarea name="upd_pos_descr" class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer mt-5 gap-2">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><?= __('Leave') ?></button>
                                                    <button type="submit" name="upd_pos" class="btn btn-success"><?= __('Update') ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- modal add position-->
    <div class="modal fade" style="background-color: rgba(0, 0, 0, 0.685);" id="position" tabindex="-1" aria-labelledby="addproLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="addproLabel"><?= __('Position Control') ?></h1>
                    <div class="rotate-img">
                        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="40px" height="40px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                    </div>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row gap-4">
                            <div class="col-12">
                                <label for="" class="control-label"><?= __('Position Name') ?>:</label>
                                <input type="text" name="pos_name" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label"><?= __('Average Salary') ?>:</label>
                                <input type="number" name="pos_sal" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label"><?= __('Bonus') ?>:</label>
                                <input type="number" name="pos_bonus" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label"><?= __('Image') ?>:</label>
                                <input type="file" name="pos_img" class="form-control" onchange="previewIns()"> <br>
                                <img width="100px" height="100px" id="frame">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label"><?= __('Description') ?>:</label>
                                <textarea name="pos_descr" class="form-control" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer mt-5">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= __('Leave') ?></button>
                            <button type="submit" name="add_pos" class="btn btn-success"><?= __('Add') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../../Action.js"></script>
    <script>
        function previewIns() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>



</body>



</html>