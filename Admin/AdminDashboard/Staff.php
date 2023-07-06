<?php
include('../../Connection/Connect.php');


// Update Staff
if (isset($_POST['upd_staff'])) {
    $check_staffid = $_POST['check_staffid'];
    $upd_firstName = $_POST['upd_firstName'];
    $upd_lastName = $_POST['upd_lastName'];
    $upd_gender = $_POST['upd_gender'];
    $upd_dob = $_POST['upd_dob'];
    $upd_adr = $_POST['upd_adr'];
    $upd_email = $_POST['upd_email'];
    $upd_contact = $_POST['upd_contact'];
    $upd_position = $_POST['upd_position'];

    $upd_staffimg = addslashes($_FILES['upd_staffimg']['tmp_name']);
    $upd_staffimg = file_get_contents($upd_staffimg);
    $upd_staffimg = base64_encode($upd_staffimg);


    $con->query("UPDATE `staff` SET
                `FirstName`='$upd_firstName',
                `LastName`='$upd_lastName',
                `Gender`='$upd_gender',
                `DOB`='$upd_dob',
                `PositionID`='$upd_position',
                `Address`='$upd_adr',
                `Contact`='$upd_contact',
                `Email`='$upd_email',
                `Photo`='$upd_staffimg'
                WHERE staffID = '$check_staffid'");

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:green; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> This staff on ID = <?php echo $check_staffid ?> has updated</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>
<?php } ?>


<!-- Delete Staff -->
<?php
if (isset($_GET['delete'])) {
    $del_staffid = $_GET['del_staffid'];

    $del = "DELETE FROM `staff` WHERE StaffID = $del_staffid";
    $con->query($del);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; top: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> This staff on ID = <?php echo $del_staffid ?> has deleted</h5>
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
                <!-- <div class="d-flex justify-content-between" style="margin-top: 10px;">
                    <input type="text" class="form-control search w-50" placeholder="Search..." style="border-radius: 50px;">
                    <select class="custom-select mt-1" style="width: 150px; height: 50px; border: none; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 10px;">
                        <option selected disabled>Status</option>
                        <option value=" "></option>
                    </select>
                </div> -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="">
                            <div class="d-flex flex-column gap-4 ">
                                <h3 class="p-4 pb-1 mb-1" style="text-decoration: overline;"> Staff Detail</h3>
                                <?php
                                $select = $con->query("SELECT s.StaffID, s.PositionID, p.PositionID, s.Photo, p.PositionName, s.FirstName, s.LastName, s.Gender, s.DOB, s.Address, s.Contact, s.Email, s.WorkOn FROM staff s 
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
                                            <?php echo '<img src="data:image;base64,' . $row['Photo'] . ' " width=190px; height=230px;>'; ?>

                                            <!-- Update Staff -->
                                            <button data-bs-toggle="offcanvas" data-bs-target="#editStaff-<?= $row['StaffID'] ?>" aria-controls="editstaff" type="button" class="btn p-3 fs-5" style="width: 190px; background:linear-gradient(rgb(10, 107, 10), rgb(138, 138, 13)); color: yellow;">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>

                                            <!-- Delete Staff-->
                                            <button data-bs-toggle="modal" data-bs-target="#deleteStaff-<?= $row['StaffID'] ?>" type="button" class="btn p-3 fs-5" style="width: 190px; background:linear-gradient(to right,red, rgb(175, 175, 22) ); color: yellow;">
                                                <i class="fa-sharp fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Delete Staff -->
                                    <div class="modal fade" id="deleteStaff-<?= $row['StaffID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:crimson">
                                                    <h3 class="modal-title text-warning" id="exampleModalLabel">Are You Sure?</h3>
                                                    <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="modal" aria-label="Close" style="cursor: grab;">
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="get">
                                                        <p class="mt-5 text-center"> Do you want to delete this staff as <?= '"' . $row['FirstName'] . ' ' . $row['LastName'] . '"' ?></p>

                                                        <div class="col-12">
                                                            <input type="hidden" class="form-control" name="del_staffid" value="<?= $row['StaffID'] ?>" readonly>
                                                        </div>

                                                        <div class="modal-footer mt-5">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Leave</button>
                                                            <button type="submit" name="delete" class="btn btn-outline-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Staff -->
                                    <div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editStaff-<?= $row['StaffID'] ?>" aria-labelledby="editLabel" style="color: white; background:linear-gradient(rgb(8, 234, 234), dodgerblue, rgb(13, 13, 183));">
                                        <div class="offcanvas-header">
                                            <h3 class="offcanvas-title text-white" id="editLabel">Update Staff</h3>
                                            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                                        </div>

                                        <div class="offcanvas-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="row gap-4">
                                                    <div class="col-12">
                                                        <input type="hidden" name="check_staffid" value=" <?= $row['StaffID'] ?>" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">First Name: </label>
                                                        <input type="text" name="upd_firstName" value=" <?= $row['FirstName'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Last Name: </label>
                                                        <input type="text" name="upd_lastName" value=" <?= $row['LastName'] ?>" class="form-control">
                                                    </div>

                                                    <div style="font-weight: bold;">
                                                        <label for="" class="text-white"> Gender: </label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="upd_gender" value="M" id="flexRadioDefault1" checked required>
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                Male
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="upd_gender" value="F" id="flexRadioDefault2" required>
                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                Female
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Date of Birth: </label>
                                                        <input type="date" name="upd_dob" value="<?= $row['DOB'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Position: </label>
                                                        <select class="custom-select w-100 p-2" name="upd_position">
                                                            <?php
                                                            $qry = $con->query("SELECT * FROM position ORDER BY PositionID");
                                                            while ($cate = $qry->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $cate['PositionID'] ?>"><?php echo $cate['PositionName'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Address: </label>
                                                        <input type="text" name="upd_adr" value="<?= $row['Address'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Contact: </label>
                                                        <input type="text" name="upd_contact" value="<?= $row['Contact'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Email: </label>
                                                        <input type="text" name="upd_email" value="<?= $row['Email'] ?>" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="control-label">Work On: </label>
                                                        <input type="datetime" value="<?= $row['WorkOn'] ?>" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="control-label">Photo: </label>
                                                        <input type="file" name="upd_staffimg" class="form-control"> <br>
                                                        <?php echo '<img src="data:image;base64,' . $row['Photo'] . ' " width=100px; height=100px;>'; ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer mt-5 pt-3" style="border-top: 1px solid white;">
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Leave</button>
                                                        <button type="submit" name="upd_staff" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                <?php } ?>
                                <!-- </div> -->
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