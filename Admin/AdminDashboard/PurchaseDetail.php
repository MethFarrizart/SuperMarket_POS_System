<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>

<?php
if (isset($_SESSION['cart'])) {
    $item = array(
        'pro_selection' => $_POST['pro_selection'],
    );
    $_SESSION['cart'][] = $item_array;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Phoenix Super-Fresh</title>
    <link rel="shortcut icon" type="image" href="https://media.istockphoto.com/id/1275763595/vector/blue-flame-bird.jpg?s=612x612&w=0&k=20&c=R7Y3DJnYFIQM8TfOfM3smZpdEl4Ks3ku4mzEFqSDKVU=">
    <link rel="stylesheet" href="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.css">
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
                        <div class="d-flex justify-content-between">
                            <div class="fw-bold fs-5"> <?= __('Purchase Management') ?> /
                                <a class="text-decoration-none" onclick="purchase()" href="Purchase.php"><?= __('Purchase') ?></a>
                            </div>
                            <button type="submit" class="btn btn-1 text-white"><?= __("Save") ?></button>
                        </div>

                        <div class="bg-white  mt-3 p-4 shadow border" style="border-radius: 20px;">
                            <div class="row">
                                <div class="col-4">
                                    <small><?= __('Supplier Name') ?>:</small><br>
                                    <div style="width: 100%">
                                        <div id="supplier_selection"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small><?= __('Status') ?>:</small> <br>
                                    <div style="width: 100%">
                                        <div id="status_selection"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <small><?= __('Purchase Date') ?>:</small>
                                    <input type="date" id="pro_expired" name="pro_expired" class="form-control expired">
                                </div>


                            </div>
                            <div class="col-12 mt-4">
                                <small><?= __('Product Name') ?>:</small> <br>
                                <div style="width: 100%">
                                    <div id="product_selection"> </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="mt-4 text-white text-start h5" style="background: linear-gradient(rgb(13, 77, 141), rgb(33, 150, 188)); line-height: 30px;">
                                            <th><?= __("Action") ?></th>
                                            <th><?= __("Product Name") ?></th>
                                            <th><?= __("Qty") ?></th>
                                            <th><?= __("Price") ?></th>
                                            <th><?= __("Discount") ?></th>
                                            <th><?= __("Sub Total") ?></th>
                                        </tr>
                                    </thead>

                                    <tbody id="selectedProductsTableBody">
                                        <tr>
                                            <?php
                                            foreach ($_SESSION['cart'] as $value) {
                                            ?>
                                                <td><?= $value['pro_selection'] ?></td>
                                            <?php } ?>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12 mt-5">
                                <small><?= __('Description') ?>: </small>
                                <textarea name="" class="form-control" rows="10"></textarea>
                            </div>
                            <div class="text-end mt-5">
                                <h6><?= __("Total Price") ?>: </h6>
                                <h6><?= __("Total Discount") ?>: </h6>
                                <h6><?= __("Grand Total") ?>: </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-container"></div>


</body>
<script src="../../Action.js"></script>
<script src="../../../Mart_POS_System/plugin/virtualSelection/virtual-select.min.js"></script>
<script>
    VirtualSelect.init({
        ele: '#supplier_selection',
        search: true,
        maxWidth: '100%',
        placeholder: ' Select Supplier',
        selectAllOnlyVisible: true,

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


    VirtualSelect.init({
        ele: '#status_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Status',
        selectAllOnlyVisible: true,

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


    VirtualSelect.init({
        ele: '#product_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Product',
        name: 'pro_selection',

        options: [
            <?php
            $result = $con->query("SELECT * FROM product");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['ProductName'] ?>',
                    value: <?= $row['ProductID'] ?>
                },
            <?php } ?>
        ],
    });


    // Push Product to table to sell
    // let selectedProducts = [];
    // let queryItem = document.querySelector('#product_selection')
    // queryItem.addEventListener('change', function() {
    //     let selectedValue = this.value;
    //     queryItem.options.find(item => {
    //         if (item.value === selectedValue) {
    //             selectedProducts.push(item.label)
    //         }
    //     })
    //     updateTable()
    // })


    // Update Product selection
    // function updateTable() {
    //     let tableBody = document.getElementById("selectedProductsTableBody");

    //     // Clear existing rows in the table
    //     tableBody.innerHTML = "";

    //     // Add rows for each selected product
    //     for (let i = 0; i < selectedProducts.length; i++) {
    //         let newRow = tableBody.insertRow(tableBody.rows.length);
    //         let cell = newRow.insertCell(0);
    //         cell.innerHTML = '<a onclick="removeProduct(' + i + ')"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>';
    //         cell = newRow.insertCell(1);
    //         cell.innerHTML = selectedProducts[i];
    //         cell = newRow.insertCell(2);
    //         cell.innerHTML = '<input type="number" id="input1" class="sumTotal" >'
    //         cell = newRow.insertCell(3);
    //         cell.innerHTML = '<input type="number" id="input2" class="sumTotal">'
    //         cell = newRow.insertCell(4);
    //         cell.innerHTML = ''
    //         cell = newRow.insertCell(5);
    //         cell.innerHTML = '<p>Total Sum: <span id="totalSum">0</span></p>'
    //     }
    // }

    // Remove product selection
    function removeProduct(index) {
        selectedProducts.splice(index, 1);
        updateTable();
    }

    // const inputValue = document.querySelectorAll('.sumTotal');
    // const subTotal = document.getElementById('totalSum');

    // inputValue.forEach(inputItem => {
    //     inputItem.addEventListener('keyup', calculateTotalSum);
    // });

    // function calculateTotalSum() {
    //     let totalSum = 0

    //     inputValue.forEach(inputItem => {
    //         totalSum += parseFloat(inputItem.value) || 0;
    //     });
    //     subTotal.textContent = totalSum.toFixed(2);
    //     console.log(subTotal)
    // }
</script>


<script>
    function purchase() {
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
        let spinner = new Spinner(options).spin();
        document.getElementById('loading-container').appendChild(spinner.el);


        // Simulate an asynchronous task (e.g., AJAX request)
        setTimeout(function() {
            // Stop the spinner and hide the loading container when the task is complete
            spinner.stop();
            document.getElementById('loading-container').style.display = 'none';
            document.body.style.background = 'none';
            window.location.href = "Purchase.php";
        }, 2000);
    };
</script>


</html>