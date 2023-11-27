<?php
include('../../Connection/Connect.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>



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

            <div class="container" style="margin-top: 120px;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td> ID </td>
                            <td> UserName </td>
                            <td> Product Name </td>
                            <td> Price </td>
                        </tr>
                    </thead>

                    <?php
                    $select = $con->query("SELECT b.ID, b.name, s.ID, s.UserID, s.ProductName, s.Price FROM Special s INNER JOIN bookprice b ON s.UserID = b.ID");
                    while ($row = $select->fetch_assoc()) {


                    ?>
                        <tbody>
                            <tr>
                                <td> <?= $row['ID'] ?> </td>
                                <td> <?= $row['name'] ?> </td>
                                <td> <?= $row['ProductName'] ?> </td>
                                <td> <?= $row['Price'] ?> </td>
                            </tr>
                        </tbody>

                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="../../../Mart_POS_System/Action.js"></script>