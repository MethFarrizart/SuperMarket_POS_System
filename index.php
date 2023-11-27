<?php
session_start();
include('./Connection/Connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<style scoped>
    .form-control {
        border-bottom: 1px solid white;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        background: none;
        border-radius: 0;
    }

    input[type="text"]::placeholder,
    input[type="password"]::placeholder {
        font-weight: bold;
    }

    .border {
        background-color: rgba(255, 255, 255, 0.395);
        border-radius: 25px;
        box-shadow: 0 0 5px 5px aqua, 0 0 10px 10px blue;
    }
</style>




<body style="background-image: url('https://64.media.tumblr.com/2e39f0f97a0cc682b2ce7e9db30e9a64/f145147b69889cf3-db/s540x810/1f2e498d7ce3682cfc58a7c9e79fb8808c8e00b5.gif'); background-repeat: no-repeat; background-size:cover;">
    <div class="container d-flex justify-content-center" style="margin-top: 6rem;">
        <img style=" width: 190px; height: 200px; z-index: 999;" src="Images/loginlogo.png" alt="">
    </div>
    <div class="container d-flex justify-content-center" style="margin-top: -70px;">
        <div class="border pt-5 px-5 pb-5 " style=" height: 30rem;">
            <form action="" method="post">


                <div class="input-group mb-3">
                    <span class="input-group-text" style="background: none; border: none;"><i class="fa-solid fa-user" style="font-size: 30px; padding-right: 20px;"></i></span>
                    <input type="text" class="form-control" id="floatingInputGroup1" placeholder="Username" name="username">
                </div>

                <div class="input-group pt-5">
                    <span class="input-group-text" style="background: none; border: none;"><i class="fa-solid fa-lock" style="font-size: 30px;padding-right: 20px;"></i></span>
                    <input type="password" class="form-control" id="floatingInputGroup2" placeholder="Password" name="password">
                </div>

                <div class="d-flex justify-content-between mt-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-white" for="flexCheckDefault">
                            Remeber Me
                        </label>
                    </div>
                    <small><a href="#" style="text-decoration: none; color: white;"> Forgot Password?</a></small>
                </div>


                <div class="d-flex justify-content-around">
                    <button class="mt-3 btn w-100" name="submit" onclick="return preventBack()" style="background-color: rgb(26, 192, 26); font-weight: bold; color: white; border-radius: 25px;"> Log In</button>
                </div>

                <div class="mt-5">
                    <small class="text-white"> If not yet registered, please &nbsp; <a href="Register.php" style="text-decoration: none; color: aqua; font-weight: bold;"> Register Now</a></small>
                </div>
            </form>
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</html>

<?php

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $pw = $_POST['password'];

    if (empty($uname) || empty($pw)) {
        echo '<div class="d-flex justify-content-between alert alert-dismissible  fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; top: 0; position: fixed; width:100%; transition: 0.6s ease">
                <h5 class="pt-3 text-white"> Missing UserName or password </h5>
                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
            </div>';
    } else {
        $validate = "SELECT * FROM `staff` WHERE UserName = '$uname' AND Password = '$pw'";
        $result = $con->query($validate);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['FirstName'] = $row['FirstName'];
                    $_SESSION['LastName'] = $row['LastName'];
                    $_SESSION['Photo'] = $row['Photo'];
                    $_SESSION['StaffID'] = $row['StaffID'];
                    $_SESSION['PositionID'] = $row['PositionID'];


                    if ($row['PositionID'] == 89) {
                        header('location: ./Admin/AdminDashboard/Dashboard.php');
                    } else if ($row['PositionID'] == 90) {
                        header('location: ./Vendor/Sellers/Order.php');
                    }
                }
            } else {
                echo '<div class="d-flex justify-content-between alert alert-dismissible  fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; top: 0; position: fixed; width:100%; transition: 0.6s ease">
                        <h5 class="pt-3 text-white"> Not Correct UserName or Password </h5>
                        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
                    </div>';
            }
        }
    }
}
?>

<script src="../../../Mart_POS_System/Action.js"></script>