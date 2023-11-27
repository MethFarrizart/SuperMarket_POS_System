<?php
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


<body>


    <div class="overflow-hidden d-flex">
        <?php
        include('../../Components/Sidebar.php');
        ?>
        <div class="main-content">
            <?php
            include('../../Components/Navbar.php');
            ?>

            <div class="container-fluid" style="margin-top: 130px;">
                <h4 style="3px solid blue" class="title"><b><?= __('Report Last Updated') ?></b> </h4>


                <!-- Digital Clock -->
                <div class="text-end text-move" style="margin-bottom: 20px">
                    <strong class="fs-5" id="day"></strong> <strong>/</strong>
                    <strong class="fs-5" id="month"></strong> -
                    <strong class="fs-5" id="day_num"></strong> <strong>/</strong>
                    <strong class="fs-5" id="year"></strong> <strong class="fs-5">~</strong>
                    <strong class="fs-5" id="hrs"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="min"></strong> <strong class="fs-5">:</strong>
                    <strong class="fs-5" id="sec"></strong> <strong class="fs-5" id="time"></strong>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="border border-all gap-3 p-4 shadow " style="border-radius: 20px; background: none">

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script src="../../../Mart_POS_System/Action.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>