<?php
sleep(2);
include('../../Connection/Connect.php');
require('../../../Mart_POS_System/Translate/lang.php');


// add Product
if (isset($_POST['add_pro'])) {
    $pro_name       = $_POST['pro_name'];
    $pro_cate       = $_POST['pro_cate'];
    $pro_qty        = $_POST['pro_qty'];
    $pro_price      = $_POST['pro_price'];
    $pro_date       = date("Y-m-d H:i:s A");
    $pro_expired    = $_POST['pro_expired'];
    $pro_descr      = $_POST['pro_descr'];
    $pro_brand      = $_POST['pro_brand'];

    $pro_status     = $_POST['pro_status'];
    $pro_img        = $_FILES['pro_img']['name'];
    $tmp_img        = $_FILES['pro_img']['tmp_name'];
    $path_img       = "../../Images/";
    move_uploaded_file($tmp_img, $path_img . $pro_img);

    // Check product name when insert the name
    $validate_name = $con->query("SELECT * FROM product WHERE ProductName = '$pro_name'");
    if (mysqli_num_rows($validate_name) > 0) {

?>
        <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
            <h5 class="pt-3 text-white"><?= __("This Product has in table") ?> </h5>
            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
        </div>
    <?php } else { ?>

        <?php
        $ins_pro = "INSERT INTO `product`
                (`ProductName`, `CategoryID`, `BrandID`, `Qty`, `Price`, `Image`, `Import_On`, `Expired_On`, `StatusID`, `Description`) 
                VALUES ('$pro_name', '$pro_cate', '$pro_brand', '$pro_qty', '$pro_price', '$pro_img', '$pro_date', '$pro_expired', '$pro_status', '$pro_descr') ";

        $con->query($ins_pro);
        ?>

        <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:green; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
            <h5 class="pt-3 text-white"> <?= __("This Product Name =") ?> <?php echo $pro_name ?> <?= __("is added") ?> </h5>
            <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
        </div>
<?php }
} ?>

<?php
// Delete product
if (isset($_POST['delete_pro'])) {
    $id = $_POST['del_proid'];

    $del_pro = "DELETE FROM `product` WHERE ProductID = $id";
    $con->query($del_pro);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:orange; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> <?= __("This Product on ID =") ?> <?php echo $id ?> <?= __("has deleted") ?> </h5>
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
    $upd_probrand = $_POST['upd_probrand'];
    $upd_proSupplier = $_POST['upd_proSupplier'];

    $upd_proimg    = $_FILES['upd_proimg']['name'];
    $upd_tmpimg    = $_FILES['upd_proimg']['tmp_name'];
    $path_imgs     = "../../Images/";
    move_uploaded_file($upd_tmpimg, $path_imgs . $upd_proimg);

    $upd_product = "UPDATE `product` SET 
                    `ProductName`='$upd_proname',
                    `CategoryID`='$upd_procate',
                    `BrandID`='$upd_probrand',
                    `SupplierID`='$upd_proSupplier',
                    `Qty`='$upd_qty',
                    `Price`='$upd_price',
                    `Image`='$upd_proimg',
                    `Expired_On`='$upd_expired',
                    `StatusID`='$upd_prostatus',
                    `Description`='$upd_prodescr'
                    WHERE `ProductID`='$check_proid'";


    $con->query($upd_product);

?>
    <div class="d-flex justify-content-between alert alert-dismissible alert_delete fade show p-4 pt-3" role="alert" style="background-color:green; top: 0; border-radius: 0; z-index: 999999999; position: fixed; width:100%; transition: 0.6s ease">
        <h5 class="pt-3 text-white"> <?= __("This Product on ID =") ?> <?php echo $check_proid ?> <?= __("has updated") ?> </h5>
        <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="alert" aria-label="Close" style="cursor: grab;">
    </div>

<?php } ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.css">
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

            <div class="container-fluid" style="margin-top: 120px;">
                <!-- Product -->
                <?php
                include('./Product.php');
                ?>
            </div>
        </div>
    </div>


</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.js"></script>
<script>
    // Insert Brand Combobox
    VirtualSelect.init({
        ele: '#insert_brand',
        search: true,
        placeholder: ' Select Brand',
        hideClearButton: true,
        name: 'pro_brand',
        required: true,
        maxWidth: '100%',
        // selectedValue: 10,

        options: [
            <?php
            $result = $con->query("SELECT * FROM brand");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['BrandName'] ?>',
                    value: <?= $row['BrandID'] ?>,
                },

            <?php } ?>
        ],
    });


    // Insert Supplier Combobox
    VirtualSelect.init({
        ele: '#insert_supplier',
        search: true,
        placeholder: ' Select Supplier',
        hideClearButton: true,
        name: 'pro_supplier',
        // required: true,
        maxWidth: '100%',

        options: [
            <?php
            $result = $con->query("SELECT * FROM supplier");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['SupplierName'] ?>',
                    value: <?= $row['SupplierID'] ?>,
                },

            <?php } ?>
        ],
    });


    // Insert Category Combobox
    VirtualSelect.init({
        ele: '#insert_category',
        search: true,
        placeholder: 'Select Category',
        hideClearButton: true,
        name: 'pro_cate',
        required: true,
        maxWidth: '100%',
        // selectedValue: 1,

        options: [
            <?php
            $result = $con->query("SELECT * FROM category");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['CategoryName'] ?>',
                    value: <?= $row['CategoryID'] ?>,
                },

            <?php } ?>
        ],
    });


    // Update Category Combobox
    VirtualSelect.init({
        ele: '#update_category',
        search: true,
        placeholder: 'Select Category',
        hideClearButton: true,
        name: 'upd_procate',
        maxWidth: '100%',

        options: [
            <?php
            $verify = $con->query("SELECT * FROM product");
            $matchingCategories = [];
            $nonMatchingCategories = [];

            while ($row = $verify->fetch_assoc()) {
                $cate_match = $row['CategoryID'];
                $qry = $con->query("SELECT * FROM Category");

                while ($cate = $qry->fetch_assoc()) {
                    $category = [
                        'label' => $cate['CategoryName'],
                        'value' => $cate['CategoryID'],
                    ];

                    if ($cate['CategoryID'] == $cate_match) {
                        $matchingCategories[] = $category;
                    } else {
                        $nonMatchingCategories[] = $category;
                    }
                }
            }



            // Concatenate matching and non-matching categories
            $allCategories = array_merge($matchingCategories, $nonMatchingCategories);

            foreach ($allCategories as $category) {
            ?> {
                    label: '<?= $category['label'] ?>',
                    value: '<?= $category['value'] ?>',
                },
            <?php } ?>
        ],
    });




    // filter Category Combobox
    VirtualSelect.init({
        ele: '#filter_cate',
        search: true,
        placeholder: ' Select Category',
        hideClearButton: true,
        maxWidth: '100%',

        options: [
            <?php
            $result = $con->query("SELECT * FROM category");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['CategoryName'] ?>',
                    value: <?= $row['CategoryID'] ?>
                },

            <?php } ?>
        ],
    });


    // filter Supplier Combobox
    VirtualSelect.init({
        ele: '#filter_supplier',
        search: true,
        placeholder: ' Select Supplier',
        hideClearButton: true,
        maxWidth: '100%',

        options: [
            <?php
            $result = $con->query("SELECT * FROM supplier");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['SupplierName'] ?>',
                    value: <?= $row['SupplierID'] ?>
                },

            <?php } ?>
        ],
    });


    // filter Brand Combobox
    VirtualSelect.init({
        ele: '#filter_brand',
        search: true,
        placeholder: 'Select Brand',
        hideClearButton: true,
        maxWidth: '100%',

        options: [
            <?php
            $result = $con->query("SELECT * FROM brand");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['BrandName'] ?>',
                    value: <?= $row['BrandID'] ?>
                },

            <?php } ?>
        ],
    });

    // Status Combobox
    VirtualSelect.init({
        ele: '#filter_status',
        search: true,
        placeholder: 'Select Status',
        hideClearButton: true,
        maxWidth: '100%',

        options: [
            <?php
            $result = $con->query("SELECT * FROM status");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['StatusName'] ?>',
                    value: <?= $row['StatusID'] ?>
                },

            <?php } ?>
        ],
    });
</script>



<script>
    function refreshPage() {
        setTimeout(function() {
            location.reload();
        }, 2000);
    }


    // $(document).ready(function() {
    //     $('.show-details-btn').click(function() {
    //         var detailsId = $(this).data("details-id");
    //         var details = $("#" + detailsId + ".details");

    //         $(".details").not(details).hide();
    //         details.toggle(200);
    //     });

    //     $('.toggleBtn').click(function() {
    //         if ($(this).find('.fa-plus') == true) {
    //             $(this).find('.fa-minus').show()
    //         }
    //         $(this).find('.fa-plus, .fa-minus').toggle()

    //     })
    // });

    // $(document).on('click', function(event) {
    //     if (!$(event.target).is('.show-details-btn') && !$(event.target).is('.details')) {
    //         $('.details').hide(200);
    //     }
    // });
</script>

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
                url: "API/SearchProduct.php",
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

        // Filter Product by Brand
        $('#filter_brand').on('change', function() {
            var filter_brand = $(this).val();
            $.ajax({
                url: "API/FilterBrand.php",
                method: "POST",
                data: {
                    filter_brand: filter_brand
                },
                beforeSend: function() {
                    $('#dataTable').html('Working ...');
                },
                success: function(data) {
                    $('#dataTable').html(data);
                }
            })
        })


        // Filter Product by Supplier
        $('#filter_supplier').on('change', function() {
            var filter_supplier = $(this).val();
            $.ajax({
                url: "API/FilterSupplier.php",
                method: "POST",
                data: {
                    filter_supplier: filter_supplier
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
                url: "API/FilterCategory.php",
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
                url: "API/FilterStatus.php",
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