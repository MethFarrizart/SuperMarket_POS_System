<?php
include('../../Connection/connect.php');
session_start();
// session_destroy();
if (!$_SESSION['FirstName'] && !$_SESSION['LastName']) {
    header('location: ../../../Mart_Pos_System/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Components/design.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="d-flex flex-column sidebar">
        <div class="container">
            <div class="d-flex py-4" style="gap: 3px; border-bottom: 2px solid white;">
                <img class="h-25 pt-2" src="../../Images/image 16.png" alt="">
                <div class="h2 text-white">Metaverse University</div>
            </div>
        </div>

        <div class="pt-3" align="center">
            <img src="../../Images/admin.png" alt="">
        </div>

        <div class="d-flex mt-3 mb-5 flex-column gap-3 link">
            <!-- General information link -->
            <a href="../../Admin/AdminDashboard/Dashboard.php" class="active">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn4.iconfinder.com/data/icons/essentials-74/24/046_-_House-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Dashboard
                    </div>
                </div>
            </a>

            <!--Inventory link -->
            <a href="../../Admin/AdminDashboard/Inventory.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/containers/256/palet02.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Inventory
                    </div>
                </div>
            </a>

            <!--Report link -->
            <a href="../../Admin/AdminDashboard/Report.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/logistics-and-delivery-services/52/4-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Report
                    </div>
                </div>
            </a>


            <!--Supplier link -->
            <a href="../../Admin/AdminDashboard/Supplier.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/supply-chain-dualine-flat/64/Supplier-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Supplier
                    </div>
                </div>
            </a>


            <!--Staff link -->
            <a href="../../Admin/AdminDashboard/Staff.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/human-resources-flat-3/48/107-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Staff
                    </div>
                </div>
            </a>

            <!--Staff link -->
            <a href="../../Admin/AdminDashboard/Position.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/job-seeker/256/folder_job_seeker_employee_unemployee_work-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Position
                    </div>
                </div>
            </a>


            <!-- log out the program -->
            <a href="../../index.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="../../Images/logout.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Log Out
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>