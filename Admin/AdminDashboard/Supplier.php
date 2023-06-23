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

<body>
    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>
            <P>Csvefe</P>

        </div>
    </div>





    <!-- offcanvas stock -->
    <div class="offcanvas offcanvas-start w-100" tabindex="-1" id="stock" aria-labelledby="stockLabel" style="transition: 0.8s ease;">
        <div class="offcanvas-header">
            <img data-bs-dismiss="offcanvas" aria-label="Close" src="../../Images/gobackicon.png" style="cursor: grab;" width="80px" height="80px">
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-4" style="border-radius: 20px;">
                        <h2 class="text-center"> Stock Control </h2>
                        <div class="mt-5 pt-3 w-100" id="columnchart2" style="width: 740px; height: 400px; margin-top: -10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>