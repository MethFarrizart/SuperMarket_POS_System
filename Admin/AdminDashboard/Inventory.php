<?php
include('../../Connection/Connect.php');


// add Product
if (isset($_POST['add_pro'])) {
    $pro_name       = $_POST['pro_name'];
    $pro_cate       = $_POST['pro_cate'];
    $pro_qty        = $_POST['pro_qty'];
    $pro_price      = $_POST['pro_price'];
    $pro_date       = date("Y-m-d H:i:s A");
    $pro_expired    = $_POST['pro_expired'];
    $pro_descr      = $_POST['pro_descr'];

    $pro_status     = $_POST['pro_status'];
    $pro_img        = $_FILES['pro_img']['name'];
    $tmp_img        = $_FILES['pro_img']['tmp_name'];
    $path_img       = "../../Images/";
    move_uploaded_file($tmp_img, $path_img . $pro_img);

    // Check product name when insert the name
    $validate_name = $con->query("SELECT * FROM product WHERE ProductName = '$pro_name'");
    if (mysqli_num_rows($validate_name) > 0) {
        echo '<div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
                <h5 class="pt-3 text-white"> This Product has in table</h5>
                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
            </div>';
    } else {
        $ins_pro = "INSERT INTO `product`
        (`ProductName`, `CategoryID`, `Qty`, `Price`, `Image`, `Import_On`, `Expired_On`, `StatusID`, `Description`) 
        VALUES ('$pro_name', '$pro_cate', '$pro_qty', '$pro_price', '$pro_img', '$pro_date', '$pro_expired', '$pro_status', '$pro_descr') ";

        $con->query($ins_pro);
    }
}
?>

<?php
// Delete product
if (isset($_GET['delete_pro'])) {
    $id = $_GET['del_proid'];

    $del_pro = "DELETE FROM `product` WHERE ProductID = $id";
    $con->query($del_pro);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> This Product <?php echo $id ?> has deleted</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>


<?php
// Update product
if (isset($_POST['upd_pro'])) {
    $check_proid = $_POST['check_proid'];
    $upd_proname = $_POST['upd_proname'];
    $upd_procate = $_POST['upd_procate'];
    $upd_qty = $_POST['upd_qty'];
    $upd_price = $_POST['upd_price'];
    $upd_expired = $_POST['upd_expired'];
    $upd_prostatus = $_POST['upd_prostatus'];
    $upd_prodescr = $_POST['upd_prodescr'];


    $upd_proimg    = isset($_FILES['upd_proimg']['name']) ? $_FILES['upd_proimg']['name'] : '';
    $upd_tmpimg    = $_FILES['upd_proimg']['tmp_name'];
    $path_imgs     = "../../Images/";
    move_uploaded_file($upd_tmpimg, $path_imgs . $upd_proimg);

    $upd_product = " UPDATE `product` SET 
                            `ProductName`='$upd_proname',
                            `CategoryID`='$upd_procate',
                            `Qty`='$upd_qty',
                            `Price`='$upd_price',
                            `Image`='$upd_proimg',
                            `Expired_On`='$upd_expired',
                            `StatusID`='$upd_prostatus',
                            `Description`='$upd_prodescr'
                            WHERE `ProductID` = '$check_proid' ";

    $con->query($upd_product);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:green; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> This Product on ID = <?php echo $check_proid ?> has updated</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>


<?php
// add Category
if (isset($_POST['add_cate'])) {
    $cate_name  = $_POST['cate_name'];
    $cate_descr = $_POST['cate_descr'];

    $ins_cate = "INSERT INTO `category`(`CategoryName`, `Description`) VALUES ('$cate_name', '$cate_descr')";
    $con->query($ins_cate);
}

// Delete Category
if (isset($_GET['delete_cate'])) {
    $id = $_GET['del_cateid'];

    $del_cate = "DELETE FROM `category` WHERE CategoryID = $id";
    $con->query($del_cate);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%">
        <h5 class="pt-3 text-white"> This Category on ID = <?php echo $id ?> has deleted</h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php }

// Update Category
if (isset($_POST['upd_cate'])) {
    $check_cateid = $_POST['check_cateid'];
    $upd_catename = $_POST['upd_catename'];

    $upd_cate = "UPDATE `Category` SET `CategoryName` = '$upd_catename' WHERE CategoryID = $check_cateid";
    $con->query($upd_cate);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="Css/Inventory.css">
</head>
<style>
    #slide2 {
        display: none;
    }

    #slide3 {
        display: none;
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
                <div class="d-flex justify-content-end gap-2" style="margin-top: 120px;">
                    <button class="btn p-3 btn1" style=" background:linear-gradient(to right, rgb(54, 54, 175), dodgerblue); color: white;">
                        Product List
                    </button>

                    <button class="btn btn-primary p-3 btn2" style=" background:linear-gradient(to right, rgb(54, 54, 175), dodgerblue); color: white;">
                        Category List
                    </button>

                    <button class="btn btn-primary p-3 btn3" style=" background:linear-gradient(to right, rgb(54, 54, 175), dodgerblue); color: white;">
                        Stock Control
                    </button>
                </div>

                <!-- Product -->
                <?php
                include('./Function/Product.php');
                ?>

                <!-- Category -->
                <?php
                include('./Function/Category.php');
                ?>

                <!-- Stock Control -->
                <?php
                include('./Function/Stock.php');
                ?>
            </div>
        </div>
    </div>


</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>


<script>
    $(document).ready(function() {
        // Check Expire Date
        $('.expired').change(function() {
            var new_date = new Date();
            var get_date = new Date($(this).val());
            var get = $('.qty').val();

            if (new_date >= get_date) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 4");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            } else {

                // Available
                if (get > 5) {
                    <?php
                    $select = $con->query("SELECT * FROM Status WHERE StatusID = 1");
                    while ($row = $select->fetch_assoc()) {
                        $statusid = $row['StatusID'];
                        $statusName = $row['StatusName'];
                    }
                    ?>
                    $('.statusID').val("<?php echo $statusid ?>");
                    $('.statusName').val("<?php echo $statusName ?>");
                }

                // Almost 
                else if (get >= 1 && get <= 5) {
                    <?php
                    $select = $con->query("SELECT * FROM Status WHERE StatusID = 2");
                    while ($row = $select->fetch_assoc()) {
                        $statusid = $row['StatusID'];
                        $statusName = $row['StatusName'];
                    }
                    ?>
                    $('.statusID').val("<?php echo $statusid ?>");
                    $('.statusName').val("<?php echo $statusName ?>");
                }

                // Sold Out
                else if (get == 0 || get == null) {
                    <?php
                    $select = $con->query("SELECT * FROM Status WHERE StatusID = 3");
                    while ($row = $select->fetch_assoc()) {
                        $statusid = $row['StatusID'];
                        $statusName = $row['StatusName'];
                    }
                    ?>
                    $('.statusID').val("<?php echo $statusid ?>");
                    $('.statusName').val("<?php echo $statusName ?>");
                }
            }
        })


        // Check status
        // Use keyup function
        $('.qty').keyup(function() {
            var get = $(this).val();

            // Available
            if (get > 5) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 1");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }

            // Almost 
            else if (get >= 1 && get <= 5) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 2");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }

            // Sold Out
            else if (get == 0 || get == null) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 3");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }
        })



        // Use change function
        $('.qty').change(function() {
            var get = $(this).val();

            // Available
            if (get > 5) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 1");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }

            // Almost 
            else if (get >= 1 && get <= 5) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 2");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }

            // Sold Out
            else if (get == 0 || get == null) {
                <?php
                $select = $con->query("SELECT * FROM Status WHERE StatusID = 3");
                while ($row = $select->fetch_assoc()) {
                    $statusid = $row['StatusID'];
                    $statusName = $row['StatusName'];
                }
                ?>
                $('.statusID').val("<?php echo $statusid ?>");
                $('.statusName').val("<?php echo $statusName ?>");
            }
        })



        // Change function
        $('.btn1').click(function() {
            $('.slide1').slideDown();
            $('#slide2').css('display', 'none')
            $('#slide3').css('display', 'none')
        })

        $('.btn2').click(function() {
            $('#slide2').slideDown(400)
            $('.slide1').css('display', 'none')
            $('#slide3').css('display', 'none')
        })

        $('.btn3').click(function() {
            $('#slide3').slideDown(400)
            $('.slide1').css('display', 'none')
            $('#slide2').css('display', 'none')
        })


        // Search Product by Ajax
        $('#search_pro').on('keyup', function() {
            var search_pro = $(this).val();
            $.ajax({
                url: "Data/SearchProduct.php",
                method: "POST",
                data: {
                    search_pro: search_pro
                },
                beforeSend: function() {
                    $('#dataTable').html('Working ...');
                },
                success: function(data) {
                    $('#dataTable').html(data);
                }
            })
        })


        // Filter Product by Category
        $('#filter_cate').on('change', function() {
            var filter_cate = $(this).val();
            $.ajax({
                url: "Data/FilterCategory.php",
                method: "POST",
                data: {
                    filter_cate: filter_cate
                },
                beforeSend: function() {
                    $('#dataTable').html('Working ...');
                },
                success: function(data) {
                    $('#dataTable').html(data);
                }
            })
        })

        // Filter Product by Status
        $('#filter_status').on('change', function() {
            var filter_status = $(this).val();
            $.ajax({
                url: "Data/FilterStatus.php",
                method: "POST",
                data: {
                    filter_status: filter_status
                },
                beforeSend: function() {
                    $('#dataTable').html('Working ...');
                },
                success: function(data) {
                    $('#dataTable').html(data);
                }
            })
        })

    })
</script>