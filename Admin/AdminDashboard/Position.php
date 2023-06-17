<?php
include('../../Connection/Connect.php');


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
                    VALUES('$pos_name', '$pos_sal', '$pos_bonus', '$pos_img', '$pos_descr') ";

    $con->query($ins_pos);
}

?>

<?php
if (isset($_POST['upd_pos'])) {
    $check_id       = $_POST['check_id'];
    $upd_pos_name   = $_POST['upd_pos_name'];
    $upd_pos_sal    = $_POST['upd_pos_sal'];
    $upd_pos_descr  = $_POST['upd_pos_descr'];
    $upd_pos_bonus  = $_POST['upd_pos_bonus'];

    $upd_pos_img = $_FILES['upd_pos_img']['name'];
    $upd_tmp_img = $_FILES['upd_pos_img']['tmp_name'];
    $path_upd_img = "../../Images/" . $upd_pos_img;
    move_uploaded_file($upd_tmp_img, $path_upd_img);

    $upd_pos = "UPDATE `position` SET 
                    `PositionName`='$upd_pos_name',
                    `Avg_Salary`='$upd_pos_sal',
                    `Bonus`='$upd_pos_bonus',
                    `Image`='$upd_pos_img',
                    `Description`='$upd_pos_descr' WHERE PositionID = $check_id";

    $con->query($upd_pos);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_update fade show p-4 pt-3" role="alert" style="background-color:green; border-radius: 0;">
        <h5 class="pt-3 text-white"> This position <?php echo $upd_pos_name ?> has updated</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>



<?php
if (isset($_GET['delete'])) {
    $id = $_GET['del_id'];

    $del = "DELETE FROM `position` WHERE PositionID = $id";
    $con->query($del);
    include_once('Position.php');

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0;">
        <h5 class="pt-3 text-white"> This position <?php echo $id ?> has deleted</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php }


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Css/Inventory.css">
</head>

<style>
    .alert_delete, .alert_update{
        top: 0; 
        width: 100%; 
        height: 9vh; 
        position: absolute; 
        z-index: 3; 
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
                            <p style="font-weight: bold; text-decoration: overline" class="fs-5">
                                Position
                            </p>

                            <div class="d-flex gap-2 justify-content-end">
                                <button class="btn p-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#position">Add Position</button>
                            </div>

                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="mt-4 text-white text-center h5" style="background-color: rgb(13, 77, 141); line-height: 50px;">
                                        <td> PositionID</td>
                                        <td> Position Name</td>
                                        <td> Average Salary</td>
                                        <td> Bonus </td>
                                        <td> Image</td>
                                        <td> Action</td>
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

                                    <!-- <button type="submit" class="btn btn-danger" onclick="show_dialog()">Test</button> -->

                                    <!-- Delete Position -->
                                    <div class="offcanvas offcanvas-start w-25" tabindex="-1" id="deletePos-<?= $pos_row['PositionID'] ?>" aria-labelledby="deleteLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="deleteLabel">Delete Position</h5>
                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                        </div>
                                        <div class="offcanvas-body bg-warning">
                                            <form action="" method="get">
                                                <h3> Are You Sure?</h3>

                                                <div class="col-12">
                                                    <input type="text" class="form-control" name="del_id" value="<?= $pos_row['PositionID'] ?>" readonly>
                                                </div>

                                                <div class="modal-footer mt-5">
                                                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Update Position -->
                                    <div class="offcanvas offcanvas-start w-25" tabindex="-1" id="editpos-<?= $pos_row['PositionID'] ?>" aria-labelledby="editLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="editLabel">Update Position</h5>
                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                        </div>
                                        <div class="offcanvas-body bg-primary">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row gap-4">
                                                    <div class="col-12">
                                                        <label for="" class="control-label">PositionID:</label>
                                                        <input type="text" name="check_id" value="<?= $pos_row['PositionID'] ?>" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="" class="control-label">Position Name:</label>
                                                        <input type="text" name="upd_pos_name" value="<?= $pos_row['PositionName'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Average Salary:</label>
                                                        <input type="number" name="upd_pos_sal" value="<?= $pos_row['Avg_Salary'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Bonus:</label>
                                                        <input type="number" name="upd_pos_bonus" value="<?= $pos_row['Bonus'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Image:</label>
                                                        <input type="file" name="upd_pos_img" class="form-control"> <br>
                                                        <img src="../../Images/<?php echo $pos_row['Image'] ?>" width="50px" height="50px" alt="">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Description:</label>
                                                        <textarea name="upd_pos_descr" class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer mt-5 gap-2">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Leave</button>
                                                    <button type="submit" name="upd_pos" class="btn btn-success">Update</button>
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
                    <h1 class="modal-title fs-5 text-white" id="addproLabel">Position Control</h1>
                    <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row gap-4">
                            <div class="col-12">
                                <label for="" class="control-label">Position Name:</label>
                                <input type="text" name="pos_name" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Average Salary:</label>
                                <input type="number" name="pos_sal" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Bonus:</label>
                                <input type="number" name="pos_bonus" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Image:</label>
                                <input type="file" name="pos_img" class="form-control" onchange="previewIns()" required> <br>
                                <img width="100px" height="100px" id="frame">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Description:</label>
                                <textarea name="pos_descr" class="form-control" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer mt-5">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Leave</button>
                            <button type="submit" name="add_pos" class="btn btn-success">Add</button>
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