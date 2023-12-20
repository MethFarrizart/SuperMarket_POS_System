<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $status = $_POST["status"];
    $supplier = $_POST["supplier"];

    // Insert purchase information into the 'purchase' table
    $ins_purchase = $con->query("INSERT INTO purchase (SupplierID, StatusID) VALUES ('$supplier', '$status')");

    // Insert new puchase_id
    $purchase_id = $con->insert_id;

    $selectedProducts = json_decode($_POST['queryProducts'], true);

    if ($purchase_id) {
        foreach ($selectedProducts as $item) {
            $price = $item['price'];
            $qty   = $item['qty'];
            $discount = $item['discount'];
            $productID = $item['productID'];
            $beforeDiscount = $item['beforeDiscount'];
            $subTotal = $item['subTotal'];
            $grandTotal = $item['grandTotal'];

            // Insert purchase_detail information into the 'purchase_detail' table
            $ins_purchase_detail = $con->query("INSERT INTO purchase_detail (PurchaseID, ProductID, Qty, Price, BeforeDiscount, Discount) 
                VALUES ('$purchase_id', '$productID', '$qty', '$price', '$beforeDiscount', '$discount')");

            $ins_purchase_payment = $con->query("INSERT INTO purchasepayment (PurchaseID, Grand_total)
VALUES ('$purchase_id', '$grandTotal')");

            $product_query = $con->query("SELECT Qty FROM Product WHERE ProductID = $productID");
            $product_row = $product_query->fetch_assoc();

            $purchase_query = $con->query("SELECT SUM(QTY) as totalQty FROM purchase_detail WHERE ProductID = '$productID'");
            $purchase_row = $purchase_query->fetch_assoc();

            $totalQty = $product_row['Qty'] + $purchase_row['totalQty'];

            $con->query("UPDATE Product SET Qty = $totalQty WHERE ProductID = $productID");
        }




        header('location: Purchase.php');
        exit();
    }
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
                        <div class="fw-bold fs-5"> <?= __('Purchase Management') ?> /
                            <a class="text-decoration-none" onclick="purchase()" href="Purchase.php"><?= __('Purchase') ?></a>
                        </div>
                        <form action="" method="post">
                            <div class="d-flex justify-content-between">
                                <div></div>
                                <button type="submit" name="save" class="btn btn-1 text-white"><?= __("Save") ?></button>

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
                                                <th class="text-end"><?= __("Before Discount") ?></th>
                                                <th class="text-end"><?= __("Sub Total") . ' (' .  __("With Tax") . ' 15%' . ')' ?></th>
                                            </tr>
                                        </thead>

                                        <tbody id="selectedProductsTableBody">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-end mt-5">
                                    <!-- <h6><?= __("Total Discount") ?>: </h6> -->
                                    <h6><?= __("Grand Total") ?>: $ <span onkeyup="calculateSum()" class="grandTotal"> </span> </h6>
                                </div>

                                <div class="col-12 mt-5">
                                    <small><?= __('Description') ?>: </small>
                                    <textarea name="" class="form-control" rows="10"></textarea>
                                </div>

                                <input type="hidden" name="queryProducts" id="selectedProductsInput">
                            </div>
                        </form>
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
    // Supplier comboBox
    VirtualSelect.init({
        ele: '#supplier_selection',
        search: true,
        maxWidth: '100%',
        placeholder: ' Select Supplier',
        selectAllOnlyVisible: true,
        name: 'supplier',
        required: true,

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


    // Status comboBox
    VirtualSelect.init({
        ele: '#status_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Status',
        selectAllOnlyVisible: true,
        name: "status",
        required: true,

        options: [
            <?php
            $result = $con->query("SELECT * FROM status WHERE statusID > 5");
            while ($row = $result->fetch_assoc()) {
            ?> {
                    label: '<?= $row['StatusName'] ?>',
                    value: <?= $row['StatusID'] ?>
                },

            <?php } ?>
        ],
    });


    // product comboBox
    VirtualSelect.init({
        ele: '#product_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Product',
        name: 'pro_selection',
        selectAllOnlyVisible: true,
        required: true,
        name: "productName",

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
    let selectedProducts = [];
    let selectedProductID = [];
    let queryItem = document.querySelector('#product_selection')
    queryItem.addEventListener('change', function() {
        let selectedValue = this.value;
        queryItem.options.forEach(item => {
            if (item.value === selectedValue) {
                selectedProducts.push(item.label)
                selectedProductID.push(item.value)
            }
        })
        updateTable()
    })


    function updateTable() {
        let tableBody = document.getElementById("selectedProductsTableBody");

        // Store the input values before clearing the table
        let inputValues = [];

        inputValues = selectedProducts.map((product, i) => {
            let qtyInput = document.querySelector(`input[name="qtyValue"][data-index="${i}"]`);
            let priceInput = document.querySelector(`input[name="priceValue"][data-index="${i}"]`);
            let discountInput = document.querySelector(`input[name="discountValue"][data-index="${i}"]`);

            const qty = qtyInput ? parseInt(qtyInput.value) || 0 : 0;
            const price = priceInput ? parseFloat(priceInput.value) || 0 : 0;
            const discount = discountInput ? parseInt(discountInput.value) || 0 : 0;
            var beforeDiscountInput = qty * price

            var afterDiscountInput = qty * price * discount / 100;
            var subTotalInput = (qty * price) - afterDiscountInput;
            var subTotalWithTax = (subTotalInput + (subTotalInput * 15 / 100))


            // Calculate grandTotal and update the inputValues array
            var grandTotalInput = 0;
            grandTotalInput += parseFloat(subTotalWithTax) || 0;


            return {
                productID: selectedProductID[i],
                qty: qtyInput ? qtyInput.value : '',
                price: priceInput ? priceInput.value : '',
                discount: discountInput ? discountInput.value : '',
                beforeDiscount: beforeDiscountInput.toFixed(2),
                subTotal: subTotalWithTax.toFixed(2),
                grandTotal: grandTotalInput.toFixed(2)
            };
        });

        // Clear existing rows
        tableBody.innerHTML = '';

        // Add rows for each selected product
        for (let i = 0; i < selectedProducts.length; i++) {
            let newRow = tableBody.insertRow(tableBody.rows.length);
            let cell = newRow.insertCell(0);
            cell.innerHTML = `
            <div class="pt-2">
                <a onclick="removeProduct(${i})"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>
            <div>
            `;
            cell = newRow.insertCell(1);
            cell.innerHTML =
                `<div class="pt-2"> ${selectedProducts[i]} </div>` +
                `<input name="productID" data-index="${i}" type="hidden" value="${selectedProductID[i]}">`;

            // Qty value="${inputValues[i].qty}"
            cell = newRow.insertCell(2);
            cell.innerHTML = `
            <div class="d-flex gap-3">
                <input name="qtyValue" data-index="${i}" onkeyup="calculateSum(${i})"  value="${inputValues[i].qty}" style="border-radius: 25px" type="number" class="qtyValue shadow p-1 text-center h-100">
            </div>
            `;

            // Unit Price
            cell = newRow.insertCell(3);
            cell.innerHTML = `
            <input name="priceValue" data-index="${i}" onkeyup="calculateSum(${i})"  value="${inputValues[i].price}" style="border-radius: 25px" type="text" class="priceValue shadow p-1 text-center h-100">
            `;

            // Discount
            cell = newRow.insertCell(4);
            cell.innerHTML = `<input name="discountValue" data-index="${i}"  value="${inputValues[i].discount}" onkeyup="calculateSum(${i})" style="border-radius: 25px" type="number" class="discountValue shadow p-1 text-center h-100"> %`;


            // Before Discount
            cell = newRow.insertCell(5);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="beforeDiscount_${i}"> 0 </span>
            </div>
           `;

            // SubTotal Amount
            cell = newRow.insertCell(6);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="totalSum_${i}"> 0 </span>
            </div>
            `;

            calculateSum()
        }

        // Update the inputValues array when the input values change
        document.querySelectorAll('.qtyValue').forEach(function(qtyInput, index) {
            qtyInput.addEventListener('input', function() {
                updateInputValue(index, 'qty', qtyInput.value);
            });
        });

        document.querySelectorAll('.priceValue').forEach(function(priceInput, index) {
            priceInput.addEventListener('input', function() {
                updateInputValue(index, 'price', priceInput.value);
            });
        });

        document.querySelectorAll('.discountValue').forEach(function(discountInput, index) {
            discountInput.addEventListener('input', function() {
                updateInputValue(index, 'discount', discountInput.value);
            });
        });


        function updateInputValue(index, key, value) {
            if (!inputValues[index]) {
                inputValues[index] = {
                    productID: selectedProductID[index],
                    qty: '',
                    price: '',
                    discount: '',
                    beforeDiscount: '',
                    subTotal: '',
                    grandTotal: ''
                };
            }
            inputValues[index][key] = value;

            const qty = parseInt(document.querySelector(`input[name="qtyValue"][data-index="${index}"]`).value) || 0;
            const price = parseFloat(document.querySelector(`input[name="priceValue"][data-index="${index}"]`).value) || 0;
            const discount = parseInt(document.querySelector(`input[name="discountValue"][data-index="${index}"]`).value) || 0;

            var beforeDiscount = qty * price
            inputValues[index]['beforeDiscount'] = beforeDiscount.toFixed(2)

            var afterDiscount = qty * price * discount / 100;
            var subTotal = (qty * price) - afterDiscount;
            var subTotalWithTax = subTotal + (subTotal * 15 / 100)
            inputValues[index]['subTotal'] = subTotalWithTax.toFixed(2);


            // Calculate grandTotal and update the inputValues array
            let grandTotal = 0;
            for (let i = 0; i < inputValues.length; i++) {
                grandTotal += parseFloat(inputValues[i]['subTotal']) || 0;
            }
            inputValues[index]['grandTotal'] = grandTotal.toFixed(2);

            updateInputValues();
        }

        function updateInputValues() {
            let variable = document.getElementById("selectedProductsInput").value = JSON.stringify(inputValues);
            console.log(variable);
        }


    }

    // Calculate subtotal
    function calculateSum(index) {
        let tableBody = document.getElementById("selectedProductsTableBody");
        var grandTotal = 0;
        for (let i = 0; i < tableBody.rows.length; i++) {
            const qtyInput = document.querySelector(`input[name="qtyValue"][data-index="${i}"]`);
            const priceInput = document.querySelector(`input[name="priceValue"][data-index="${i}"]`);
            const discountInput = document.querySelector(`input[name="discountValue"][data-index="${i}"]`);

            const qty = parseInt(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseInt(discountInput.value) || 0;

            const beforeDiscount = qty * price
            document.getElementsByClassName(`beforeDiscount_${i}`)[0].innerHTML = beforeDiscount.toFixed(2)

            var afterDiscount = qty * price * discount / 100;
            var subTotal = (qty * price) - afterDiscount;

            // After calculate subTotal, we will calculate with tax = 15%
            var subTotalWithTax = subTotal + (subTotal * 15 / 100)
            document.getElementsByClassName(`totalSum_${i}`)[0].innerHTML = subTotalWithTax.toFixed(2);

            grandTotal += subTotalWithTax
            document.querySelector('.grandTotal').innerHTML = grandTotal.toFixed(2);
        }
    }


    // Remove product selection
    function removeProduct(index) {
        selectedProducts.splice(index, 1);
        updateTable();
    }
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