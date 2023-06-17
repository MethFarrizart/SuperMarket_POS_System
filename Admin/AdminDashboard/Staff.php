<?php
include('../../Connection/Connect.php');
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
    .page {
        width: 21cm;
        min-height: 100% !important;
        padding: 0.5cm;
        margin: 80px auto;
        border: 1px #d3d3d3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
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

            <div class="page">
                <div class="d-flex justify-content-between" style="margin-top: 10px;">
                    <input type="text" class="form-control search w-50" placeholder="Search..." style="border-radius: 50px;">
                    <select class="custom-select mt-1" style="width: 150px; height: 50px; border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 10px;">
                        <option selected disabled>Status</option>
                        <option value=" "></option>
                    </select>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="">
                            <div class="d-flex flex-column gap-4 ">
                                <h3 class="p-4 pb-1 mb-1" style="text-decoration: overline;"> Staff Detail</h3>
                                <?php
                                $select = $con->query("SELECT s.StaffID, s.PositionID, p.PositionID, p.PositionName, s.FirstName, s.LastName, s.Gender, s.DOB, s.Address, s.Contact, s.Email, s.WorkOn FROM staff s 
                                INNER JOIN position p ON s.PositionID = p.PositionID");
                                while ($row = $select->fetch_assoc()) {
                                ?>
                                    <div class="d-flex justify-content-between p-4">
                                        <div class="d-flex justify-content-between gap-5">
                                            <div class="d-flex flex-column gap-4">
                                                <h6> StaffID : </h6>
                                                <h6> Full Name : </h6>
                                                <h6> Gender : </h6>
                                                <h6> Date of Birth : </h6>
                                                <h6> Position :</h6>
                                                <h6> Address :</h6>
                                                <h6> Contact :</h6>
                                                <h6> Email : </h6>
                                                <h6> Work On : </h6>
                                            </div>

                                            <div class="d-flex flex-column gap-4">
                                                <h6> <?= $row['StaffID'] ?> </h6>
                                                <h6> <?= $row['FirstName'] . ' ' . $row['LastName'] ?> </h6>
                                                <h6> <?= $row['Gender'] ?> </h6>
                                                <h6> <?= $row['DOB'] ?> </h6>
                                                <h6> <?= $row['PositionName'] ?> </h6>
                                                <h6> <?= $row['Address'] ?> </h6>
                                                <h6> <?= $row['Contact'] ?> </h6>
                                                <h6> <?= $row['Email'] ?> </h6>
                                                <h6> <?= $row['WorkOn'] ?> </h6>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <img src="" width="190px" height="230px">
                                            <button type="button" class="btn p-3 fs-5" style="width: 190px; background:linear-gradient(rgb(10, 107, 10), rgb(138, 138, 13)); color: yellow;"><i class="fa-solid fa-pen-to-square"></i> Edit </button>
                                            <button type="button" class="btn p-3 fs-5" style="width: 190px; background:linear-gradient(to right,red, rgb(175, 175, 22) ); color: yellow;"><i class="fa-sharp fa-solid fa-trash"></i> Delete </button>
                                        </div>
                                    </div>
                                    <hr>
                                <?php } ?>
                            </div>
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
                                <input type="text" name="pro_name" class="form-control">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Average Salary:</label>
                                <input type="number" name="pro_sal" class="form-control">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Bonus:</label>
                                <input type="number" name="pos_bonus" class="form-control">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Image:</label>
                                <input type="file" name="pos_img" class="form-control">
                            </div>

                            <div class="col-12">
                                <label for="" class="control-label">Description:</label>
                                <textarea name="pos_descr" class="form-control" rows="10"></textarea>
                            </div>

                        </div>

                        <div class="modal-footer mt-5">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Leave</button>
                            <button type="button" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
<script src="../../Action.js"></script>