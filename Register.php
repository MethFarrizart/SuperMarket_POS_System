<?php
session_start();
include('./Connection/connect.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style scoped>
    .form-control,
    .form-select {
        border-bottom: 1px solid white;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        background: none;
        border-radius: 0;
    }

    input[type="text"]::placeholder,
    input[type="tel"]::placeholder,
    input[type="email"]::placeholder,
    input[type="password"]::placeholder {
        font-weight: bold;
    }

    .border {
        background-color: rgba(255, 255, 255, 0.395);
        border-radius: 25px;
        box-shadow: 0 0 5px 5px aqua, 0 0 10px 10px blue;
    }

    .img1 img {
        width: 200px;
        height: 120px;
        z-index: 999;
        transform: rotateZ(-10deg);
    }
</style>


<?php
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $pos = $_POST['pos'];
    $work = $_POST['work'];

    $photo = addslashes($_FILES['photo']['tmp_name']);
    $photo = file_get_contents($photo);
    $photo = base64_encode($photo);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $validate_account = "SELECT * FROM staff WHERE `UserName` = '$username' AND `Password` = '$password'";
    $check_account = $con->query($validate_account);

    if (mysqli_num_rows($check_account) > 0) {
        echo
        '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="top: 0; width: 100%; position: absolute; border-radius: 0;">
                    These Username and Password have been used by another user!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else {
        $ins_emp = "INSERT INTO `staff`(`FirstName`, `LastName`, `Gender`, `PositionID`, `DOB`, `Address`, `Contact`, `Email`, `Photo`, `UserName`, `Password`, `WorkOn`) 
                    VALUES('$fname', '$lname', '$gender', '$pos', '$dob', '$address', '$phone', '$email', '$photo', '$username', '$password', '$work') ";

        $con->query($ins_emp);
        // $result = $con->query($ins_emp);
        // if ($result === true) {
        //     $session_caught = "SELECT * FROM `staff`";
        //     $caught_result = $con->query($session_caught);

        //     if (mysqli_num_rows($caught_result) > 0) {
        //         while ($row = $caught_result->fetch_assoc()) {
        //             $_SESSION['FirstName']  = $row['FirstName'];
        //             $_SESSION['LastName']   = $row['LastName'];
        //             $_SESSION['Photo']      = $row['Photo'];

        //             if ($row['PositionID'] == 89) {
        //                 header('location: ./Admin/AdminDashboard/Dashboard.php ');
        //             } else if ($row['PositionID'] == 90) {
        //                 header('location: ./Seller/accountant.php ');
        //             }
        //         }
        //     }
        // } else {
        //     echo 'failed to insert!!';
        // }
    }
}

?>


<body style="background-image: url('https://64.media.tumblr.com/2e39f0f97a0cc682b2ce7e9db30e9a64/f145147b69889cf3-db/s540x810/1f2e498d7ce3682cfc58a7c9e79fb8808c8e00b5.gif'); background-repeat: no-repeat; background-size:cover;">
    <div class="container d-flex justify-content-center" style="margin-top: 1rem;">
        <div class="img1">
            <img class="d-flex" src="./Images/registerlogo.png" alt="">
        </div>
    </div>
    <div class="container d-flex justify-content-center" style="margin-top: -20px;">
        <div class="border pt-4 px-5 pb-5 d-flex justify-content-center">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="d-flex flex-row gap-4 pt-4">
                    <input type="text" class="form-control" placeholder="Your First Name" name="fname" required>
                    <input type="text" class="form-control" placeholder="Your Last Name" name="lname" required>
                </div>

                <div class="d-flex flex-row gap-5 pt-4">
                    <div class="form-floating">
                        <input type="date" class="form-control mt-3" id="float1" placeholder="Date Of Birth" name="dob" required>
                        <label for="float1"> Date Of Birth</label>
                    </div>

                    <div style="font-weight: bold;">
                        <label for="" class="text-white"> Gender: </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="M" id="flexRadioDefault1" checked required>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="F" id="flexRadioDefault2" required>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Female
                            </label>
                        </div>
                    </div>
                </div>

                <div class="gap-5 pt-4">
                    <label style="font-weight: bold;" class="control-label text-white">Position</label>
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="pos" required>
                        <?php
                        $query = "SELECT * FROM `position`";
                        $result = $con->query($query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <option style="transition: 0.5s ease;" class="bg-primary text-white font-weight-bold" value="<?php echo $row['PositionID'] ?>" selected><?php echo $row['PositionName'] ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>

                <div class="d-flex flex-row gap-4 pt-4">
                    <input type="text" class="form-control" placeholder="Current Address" name="address">
                </div>

                <div class="d-flex flex-row gap-4 pt-4">
                    <input type="tel" class="form-control" placeholder="Self's Phone" name="phone" required>
                </div>

                <div class="d-flex flex-row gap-4 pt-4">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                </div>

                <div class="gap-5 pt-4">
                    <label style="font-weight: bold;" class="control-label text-white">Work On</label>
                    <div class="d-flex flex-row gap-4 pt-2">
                        <input type="date" class="form-control" name="work">
                    </div>
                </div>


                <div class="d-flex flex-row gap-4 pt-4">
                    <div style="color: white; font-weight: bold; padding-top: 5px;" required> Photo</div>
                    <input type="file" class="form-control" name="photo">
                </div>
                <hr class="mt-5 font-weight-bold">


                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#Signup">Next</button>
                <div class="modal fade" style="    background-color: rgba(0, 0, 0, 0.885);" id="Signup" tabindex="-1" aria-labelledby="SignupLabel" aria-hidden="true">
                    <div class="modal-dialog modal-content" style="background: none;">
                        <div class="container d-flex justify-content-center" style="margin-top: 7rem;">
                            <img style="border-radius: 50%; width: 120px; height: 150px; z-index: 999; " src="Images/signuplogo.png" alt="">
                        </div>
                        <div class="container d-flex justify-content-center" style="margin-top: -50px;">
                            <div class="border pt-5 px-5 " style=" height: 25rem;  background-color: rgb(67, 67, 102) !important;">
                                <form action="" method="post">
                                    <h6 class="text-white text-center"> Please Sign Up At The Following </h6>
                                    <div class="input-group mt-5">
                                        <span class="input-group-text" style="background: none; border: none;"><i class="fa-solid fa-user" style="font-size: 30px; padding-right: 20px;"></i></span>
                                        <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username" name="username">
                                    </div>

                                    <div class="input-group pt-5">
                                        <span class="input-group-text" style="background: none; border: none;"><i class="fa-solid fa-lock" style="font-size: 30px;padding-right: 20px;"></i></span>
                                        <input type="password" class="form-control" id="floatingInputGroup2" placeholder="Password" name="password">
                                    </div>

                                    <div class="mt-5">
                                        <a href="./admin/admindashboard.php">
                                            <button style="background-color: rgb(31, 173, 31);" type="submit" name="submit" class="mt-3 text-white btn w-100"> Submit </button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>