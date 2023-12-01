<?php
include('../../Translate/lang_sidebar.php');
include('../../Connection/connect.php');
session_start();
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
    <link rel="stylesheet" href="../../Components/design.css?v=<?php echo time() ?>">

    <!-- link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    .glow-txt {
        animation: txt 6s ease infinite;
        color: white;
        text-shadow: 0 0 10px aqua;
    }

    .fa-angle-up {
        display: none;
    }

    @keyframes txt {
        0% {
            text-shadow: 0 0 15px aqua, 0 0 20px aqua;
        }
    }
</style>


<body>
    <div class="d-flex flex-column sidebar overflow-y-scroll overflow-x-hidden">
        <div class="container">
            <div align=center class="d-flex flex-column">
                <div class=" mt-2">
                    <img class="w-75 h-75" src="../../Images/songbird2.png" alt="">
                </div>
                <div class="h5 glow-txt"><?= func('Phoenix Super-Fresh') ?></div>
            </div>
        </div>

        <!-- <div class="pt-4" align="center">
            <img src="../../Images/admin.png" class="w-50" alt="">
        </div> -->

        <div class="d-flex mt-5 flex-column gap-3 link">
            <!-- General information link -->
            <a href="../../Admin/AdminDashboard/Dashboard.php" class="active crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn4.iconfinder.com/data/icons/essentials-74/24/046_-_House-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Dashboard') ?>
                    </div>
                </div>
            </a>


            <!--Inventory Sub link -->
            <a class="toggleIcon" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/containers/256/palet02.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Inventory') ?> &nbsp;&nbsp; <i class="fa-solid fa-angle-down"></i> <i class="fa-solid fa-angle-up"></i>
                    </div>
                </div>
            </a>

            <div class="collapse multi-collapse" id="multiCollapseExample2">
                <div class="card-body d-flex flex-column gap-2">

                    <!-- Product link -->
                    <a href="../../Admin/AdminDashboard/Inventory.php" class="crosspageLink">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/Aristocracy_WebDesignTuts/48/Download_Crate.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Product List') ?>
                            </div>
                        </div>
                    </a>

                    <!--Category link -->
                    <a href="../../Admin/AdminDashboard/Category.php" class="crosspageLink">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn2.iconfinder.com/data/icons/e-commerce-534/64/Category-256.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Category') ?>
                            </div>
                        </div>
                    </a>

                    <!--Unit link -->
                    <a href="../../Admin/AdminDashboard/Unit.php" class="crosspageLink">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn4.iconfinder.com/data/icons/app-menu-1/1001/Services-256.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Unit') ?>
                            </div>
                        </div>
                    </a>

                    <!--Brand link -->
                    <a href="../../Admin/AdminDashboard/Brand.php" class="crosspageLink">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/branding-flat/512/cmyk-256.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Brand') ?>
                            </div>
                        </div>
                    </a>

                    <!--Stock link -->
                    <a href="../../Admin/AdminDashboard/Stock.php" class="crosspageLink">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn1.iconfinder.com/data/icons/fs-icons-ubuntu-by-franksouza-/256/stock_search.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Stock Control') ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>



            <!--Report link -->
            <a href="../../Admin/AdminDashboard/Report.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/logistics-and-delivery-services/52/4-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Report') ?>
                    </div>
                </div>
            </a>



            <!--Customer link -->
            <a href="../../Admin/AdminDashboard/Customer.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn1.iconfinder.com/data/icons/march-8th-women-s-day-astute/512/Support-512.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Customer') ?>
                    </div>
                </div>
            </a>


            <!--Supplier link -->
            <a href="../../Admin/AdminDashboard/Supplier.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/supply-chain-dualine-flat/64/Supplier-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Supplier') ?>
                    </div>
                </div>
            </a>

            <!--purchase link -->
            <a href="../../Admin/AdminDashboard/Purchase.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn1.iconfinder.com/data/icons/filled-outline-hobbies-1/64/hobby-shopping-bag-purchase-mall-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Purchase') ?>
                    </div>
                </div>
            </a>


            <!--Staff link -->
            <a href="../../Admin/AdminDashboard/Staff.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/human-resources-flat-3/48/107-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Staff') ?>
                    </div>
                </div>
            </a>

            <!--Position link -->
            <a href="../../Admin/AdminDashboard/Position.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn0.iconfinder.com/data/icons/job-seeker/256/folder_job_seeker_employee_unemployee_work-256.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Position') ?>
                    </div>
                </div>
            </a>


            <!-- Setting link -->
            <!-- <a class="toggleIcon2" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="https://cdn3.iconfinder.com/data/icons/macosxstyle/macosxstyle_png/128/Setting.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Setting') ?> &nbsp;&nbsp; <i class="fa-solid fa-angle-down"></i><i class="fa-solid fa-angle-up"></i>
                    </div>
                </div>
            </a> -->

            <!-- <div class="collapse multi-collapse" id="collapseSetting">
                <div class="card-body d-flex flex-column gap-2">

                    <a href="../../Admin/AdminDashboard/Currency.php">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn2.iconfinder.com/data/icons/flat-pack-1/64/Money-256.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Currency') ?>
                            </div>
                        </div>
                    </a>

                    <a href="../../Admin/AdminDashboard/PrefixCode.php">
                        <div class="d-flex ps-5 pb-2 gap-4">
                            <img style="height: 40px;" class="mt-2" src="https://cdn1.iconfinder.com/data/icons/essentials-pack/96/code_coding_html_css_programming-256.png" alt="">
                            <div class="h5 pt-3 text-white">
                                <?= func('Prefix Code') ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div> -->


            <!-- log out the program -->
            <a href="../../index.php" class="crosspageLink">
                <div class="d-flex ps-4 pb-2 gap-4">
                    <img style="height: 40px;" class="mt-2" src="../../Images/logout.png" alt="">
                    <div class="h5 pt-3 text-white">
                        <?= func('Log Out') ?>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Reload animation to the next page -->
    <div id="loading-container"></div>


</body>

</html>

<!-- link bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>

<script src="../Action.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    let crossPageReload = document.querySelectorAll('.crosspageLink');
    for (let i = 0; i < crossPageReload.length; i++) {
        crossPageReload[i].addEventListener('click', () => {
            let options = {
                lines: 15, // The number of lines to draw
                length: 40, // The length of each line
                width: 15, // The line thickness
                radius: 45, // The radius of the inner circle
                scale: 1, // Scales overall size of the spinner
                corners: 1, // Corner roundness (0..1)
                speed: 0.5, // Rounds per second
                rotate: 0, // The rotation offset
                animation: 'spinner-line-fade-quick', // The CSS animation name for the lines
                direction: 1, // 1: clockwise, -1: counterclockwise
                color: 'blue', // CSS color or array of colors
                fadeColor: 'transparent', // CSS color or array of colors
                top: '50%', // Top position relative to parent
                left: '50%', // Left position relative to parent
                shadow: '0 0 1px transparent', // Box-shadow for the lines
                zIndex: 2000000000, // The z-index (defaults to 2e9)
                className: 'spinner', // The CSS class to assign to the spinner
                position: 'absolute', // Element positioning
            }

            // Show the loading container and start the spinner
            document.getElementById('loading-container').style.display = 'flex';
            document.body.style.transition = 'opacity 0.5s ease';
            let spinner = new Spinner(options).spin();
            document.getElementById('loading-container').appendChild(spinner.el);


            // Simulate an asynchronous task (e.g., AJAX request)
            setTimeout(function() {
                // Stop the spinner and hide the loading container when the task is complete
                spinner.stop();
                document.getElementById('loading-container').style.display = 'none';
                document.body.style.background = 'none';
            }, 2000);
        })
    }
</script>

<script>
    $(document).ready(function() {
        $('.toggleIcon, .toggleIcon2').click(function() {
            if ($(this).find('fa-angle-down') == true) {
                $(this).find('.fa-angle-up').show()
            }
            $(this).find('.fa-angle-down, .fa-angle-up').toggle()

        })
    })
</script>