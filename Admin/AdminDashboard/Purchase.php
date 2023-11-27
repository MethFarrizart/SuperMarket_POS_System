<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
</head>

<style>
    #loading-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        display: none;
        /* Initially hide the loading container */
    }
</style>

<body>
    <!-- Category -->
    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>

            <div class="container-fluid">
                <div class="row" style="margin-top: 120px;">
                    <div class="col-12">
                        <div class="col-4">
                            <input type="text" class="form-control p-3 search" placeholder="Search..." id="search_purchase" style="border-radius:15px;">
                        </div>
                        <div class="bg-white mt-3 p-4 shadow border" style="border-radius: 20px;">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold fs-5">
                                    <?= __('Purchase List') ?>
                                </p>
                                <p class="fw-bold fs-5 mx-5 px-5">
                                    <?= __('Filter') ?> &nbsp; <i class="fa-solid fa-filter"></i>
                                </p>
                            </div>

                            <div class="d-flex gap-2 justify-content-between">
                                <div class="d-flex gap-2">
                                    <button onclick="purchase_detail()" type="button" class="btn p-3 btn-1 text-white"><?= __('Add Purchase') ?></button> &nbsp;
                                </div>
                            </div>

                            <table class="table table-hover mt-3">
                                <thead>
                                    <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                        <td class="text-center"><?= __('Action') ?> </td>
                                        <td><?= __("PurchaseID") ?></td>
                                        <td><?= __("Purchase Date") ?></td>
                                        <td><?= __("Supplier") ?></td>
                                        <td><?= __("Seller") ?></td>
                                        <td><?= __("Before Discount") ?></td>
                                        <td><?= __("Discount") ?></td>
                                        <td><?= __("Grand Total") ?></td>
                                        <td><?= __("Status") ?></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading to next page -->
        <div id="loading-container"></div>

    </div>


</body>
<script src="../../Action.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>

<script>
    function purchase_detail() {
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
        document.body.style.opacity = 0.4;
        document.body.style.transition = 'opacity 0.3s ease';
        // document.body.style.backgroundColor = 'rgba(0, 0, 0, 0.687)';
        let spinner = new Spinner(options).spin();
        document.getElementById('loading-container').appendChild(spinner.el);


        // Simulate an asynchronous task (e.g., AJAX request)
        setTimeout(function() {
            // Stop the spinner and hide the loading container when the task is complete
            spinner.stop();
            document.getElementById('loading-container').style.display = 'none';
            document.body.style.zIndex = '2000000000';
            document.body.style.background = 'none';
            window.location.href = "PurchaseDetail.php";
        }, 2000);
    };
</script>

</html>