<?php
include('../../Connection/Connect.php');

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
<style>
    .glow-txt {
        animation: txt 6s ease infinite;
        color: white;
        text-shadow: 0 0 10px aqua;
    }

    @keyframes txt {
        0% {
            text-shadow: 0 0 15px aqua, 0 0 20px aqua;
        }
    }
</style>


<body>
    <div class="d-flex flex-column sidebar">
        <div class="container">
            <div align=center class="d-flex flex-column">
                <img class="w-100" src="../../Images/phoenix.png" alt="">
                <div class="h4 glow-txt" style="margin-top: -50px;">Phoenix Super-Fresh</div>
            </div>
        </div>

        <div class="pt-3" align="center">
            <img src="../../Images/cashier.png" class="w-50" alt="">
        </div>

        <div class="d-flex mt-5 flex-column gap-3 link">

            <!-- Dashboard Order Product link -->
            <a href="../Sellers/Order.php" class="active">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn4.iconfinder.com/data/icons/essentials-74/24/046_-_House-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Dashboard
                    </div>
                </div>
            </a>

            <!--Invoice link -->
            <a href="../Sellers/Invoice.php">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn1.iconfinder.com/data/icons/provincial-electricity-authority-2/64/bill_invoice_payment_receipt_billing-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        Invoice Report
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