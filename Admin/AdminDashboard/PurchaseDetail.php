<?php
include('../../Connection/Connect.php');
require('../../Translate/lang.php');
?>


<?php

if (isset($_POST['save'])) {

    // Get form data
    $status = $_POST["status"];
    $supplier = $_POST["supplier"];
    $purchaseDate = $_POST["purchaseDate"];

    // Insert purchase information into the 'purchase' table
    $ins_purchase = $con->query("INSERT INTO purchase (PurchaseDate, SupplierID, StatusID) VALUES ('$purchaseDate','$supplier', '$status')");

    // Insert new puchase_id
    $purchase_id = $con->insert_id;

    $selectedProducts = json_decode($_POST['queryProducts'], true);

    // print_r( $selectedProducts);

    if ($purchase_id) {
        foreach ($selectedProducts as $item) {
            $purchasePrice = $item['purchasePrice'];
            $qty   = $item['qty'];
            $discount = $item['discount'];
            $productID = $item['productID'];
            $beforeDiscount = $item['beforeDiscount'];
            $afterDiscount = $item['afterDiscount'];
            $subTotal = $item['subTotal'];
            $grandTotal = $item['grandTotal'];

            $isPaidOrNot = isset($_POST['isPaidOrNot']) ? 8 : 9; //8 => Paid, 9 => Not Paid


            // Insert purchase_detail information into the 'purchase_detail' table
            // if ($isPaidOrNot == 8) {
            //     $ins_purchase_detail = $con->query("INSERT INTO purchase_detail (PurchaseID, ProductID, Qty, Price, BeforeDiscount, Discount, AfterDiscount, SubTotal) 
            //     VALUES ('$purchase_id', '$productID', '$qty', '$purchasePrice', '$beforeDiscount', '$discount', '$afterDiscount', '$subTotal')");
            //     // Update product quantity
            //     $con->query("UPDATE product SET Qty = Qty + '$qty' WHERE ProductID = '$productID'");
            // } else if ($isPaidOrNot == 9) {
            //     $ins_purchase_detail = $con->query("INSERT INTO purchase_detail (PurchaseID, BeforeDiscount, Discount, AfterDiscount, SubTotal) 
            //     VALUES ('$purchase_id', '$beforeDiscount', '$discount', '$afterDiscount', '$subTotal')");
            // }

            $ins_purchase_detail = $con->query("INSERT INTO purchase_detail (PurchaseID, ProductID, Qty, Price, BeforeDiscount, Discount, AfterDiscount, SubTotal) 
            VALUES ('$purchase_id', '$productID', '$qty', '$purchasePrice', '$beforeDiscount', '$discount', '$afterDiscount', '$subTotal')");
            // Update product quantity
            $con->query("UPDATE product SET Qty = Qty + '$qty' WHERE ProductID = '$productID'");
        }

        $con->query("INSERT INTO purchasepayment (PurchaseID, Grand_total, PaymentStatus) VALUES ('$purchase_id', '$grandTotal', '$isPaidOrNot')");

        header('location: Purchase.php');
        exit();
    }
}

// Update Purchase
if (isset($_POST['updatePurchase'])) {
    $id = $_POST['updatePurchaseID'];
    $status = $_POST["status"];
    $supplier = $_POST["supplier"];
    $purchaseDate = $_POST["purchaseDate"];
    $isPaidOrNot = isset($_POST['isPaidOrNot']) ? 8 : 9; //8 => Paid, 9 => Not Paid

    // Using prepared statement to prevent SQL injection
    $stmt = $con->prepare("UPDATE purchase SET PurchaseDate = ?, SupplierID = ?, StatusID = ? WHERE PurchaseID = ?");
    $stmts = $con->prepare("UPDATE purchasepayment SET PaymentStatus = ? WHERE PurchaseID = ?");

    // s Stand for String, i Stand for Integer
    $stmts->bind_param("ii", $isPaidOrNot, $id);
    $stmt->bind_param("sssi", $purchaseDate, $supplier, $status, $id);

    // Execute the statement
    $stmt->execute();
    $stmts->execute();

    header('location: Purchase.php');
    exit();
}

// Get Query Param
if (isset($_GET['EditPurchase'])) {
    $editPurchaseID = $_GET['EditPurchase'];

    $purchaseQuery = $con->query("SELECT purchase_detail.ProductID, purchase_detail.Price AS purchasePrice, purchase_detail.PurchaseID, purchase_detail.ProductID, 
    purchase_detail.Qty AS oldQty, purchase_detail.BeforeDiscount, purchase_detail.AfterDiscount, purchase_detail.Discount,
    purchase_detail.SubTotal, product.*, purchase.*, purchasePayment.* FROM purchase_detail
    INNER JOIN product ON purchase_detail.ProductID = product.ProductID  
    INNER JOIN purchase ON purchase.PurchaseID = purchase_detail.PurchaseID
    INNER JOIN purchasePayment ON purchasePayment.PurchaseID = purchase_detail.PurchaseID
    WHERE purchase_detail.PurchaseID = $editPurchaseID");

    $beforeDiscount = 0;
    $afterDiscount = 0;

    $productIDValue = array();
    $productNameValue = array();
    $qty = array();
    $purchasePrice = array();
    $discount =  array();
    $eachBeforeDiscount = array();
    $eachAfterDiscount = array();
    $eachSubTotal = array();


    while ($purchaseDetail = $purchaseQuery->fetch_assoc()) {
        $productNameValue[] = $purchaseDetail['ProductName'];
        $productIDValue[] = $purchaseDetail['ProductID'];
        $qty[] = $purchaseDetail['oldQty'];
        $purchasePrice[] = $purchaseDetail['purchasePrice'];
        $discount[] = $purchaseDetail['Discount'];
        $eachBeforeDiscount[] = $purchaseDetail['BeforeDiscount'];
        $eachAfterDiscount[] = $purchaseDetail['AfterDiscount'];
        $eachSubTotal[] = $purchaseDetail['SubTotal'];

        $statusID = $purchaseDetail['StatusID'];
        $supplierID = $purchaseDetail['SupplierID'];
        $purchase_date = $purchaseDetail['PurchaseDate'];

        $beforeDiscount += $purchaseDetail['BeforeDiscount'];
        $afterDiscount += $purchaseDetail['AfterDiscount'];
        $grand_total = $purchaseDetail['Grand_total'];
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

    input {
        border: 0
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

                        <form action="" method="post">
                            <div class="row">
                                <div class="col-6 fw-bold fs-5">
                                    <?= isset($_GET['EditPurchase']) ?  __('Update Purchase Management') . ' ' : __('Purchase Management') . ' ' ?>/
                                    <a class="text-decoration-none" onclick="purchase()" href="Purchase.php"><?= __('Purchase') ?></a>
                                </div>

                                <div class="col-3 form-check ml-5 pl-5">
                                    <?php
                                    $paymentStatus = isset($_GET['PaymentStatus']) ? $_GET['PaymentStatus'] : 9;
                                    ?>

                                    <input class="form-check-input p-2" style="border: 1px solid black;" value="8" type="checkbox" name="isPaidOrNot" id="flexCheckDefault" <?php echo $paymentStatus == 8 ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-dark" for="flexCheckDefault" id="paymentStatusLabel">
                                        <?= $paymentStatus == 8 ? __("Paid") : __("Not Paid") ?>
                                    </label>
                                    </label>
                                </div>
                            </div>

                            <script>
                                // Change label to "Paid" or Not "Not Paid"
                                let changeLabel = document.getElementById('paymentStatusLabel')
                                let checkBox = document.getElementById('flexCheckDefault')
                                checkBox.addEventListener('change', () => {
                                    changeLabel.innerHTML = checkBox.checked ? '<?= __("Paid") ?>' : '<?= __("Not Paid") ?>';
                                })
                            </script>


                            <div class="d-flex justify-content-between">

                                <?php
                                if (isset($_GET['EditPurchase'])) {
                                ?>
                                    <div class="mt-4"> <?= __("PurchaseID") . ': PUR' . $_GET['EditPurchase'] ?></div>
                                    <button type="submit" style="width: 100px; height: 40px" name="updatePurchase" class="btn btn-1 text-white"><?= __("Update") ?></button>

                                <?php } else { ?>
                                    <div></div>
                                    <button type="submit" name="save" class="btn btn-1 text-white"><?= __("Save") ?></button>

                                <?php } ?>
                            </div>

                            <div>
                                <!-- Update PurchaseID -->
                                <?php
                                if (isset($_GET['EditPurchase'])) {
                                    $id = $_GET['EditPurchase'];
                                ?>
                                    <input class="form-control" type="hidden" name="updatePurchaseID" value="<?= $id ?>">

                                <?php } ?>
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
                                        <input type="datetime" id="purchaseDate" name="purchaseDate" class="form-control required">
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
                                                <th class="text-end"><?= __("After Discount") ?></th>
                                                <th class="text-end"><?= __("Sub Total") . ' (' .  __("With Tax") . ' 10%' . ')' ?></th>
                                            </tr>
                                        </thead>

                                        <!-- <tbody>
                                            <?php
                                            foreach ($productNameValue as $index => $item) {
                                            ?>
                                                <tr>
                                                    <td><a onclick="removeProduct"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a></td>
                                                    <td><?= $item ?></td>
                                                    <td><?= $qty[$index] ?></td>
                                                    <td><?= '$ ' . number_format($price[$index], 2) ?></td>
                                                    <td><?= $discount[$index] . ' %' ?></td>
                                                    <td><?= '$ ' . number_format($eachBeforeDiscount[$index], 2) ?></td>
                                                    <td><?= '$ ' . number_format($eachAfterDiscount[$index], 2) ?></td>
                                                    <td><?= '$ ' . number_format($eachSubTotal[$index], 2) ?></td>

                                                </tr>

                                            <?php } ?>

                                        </tbody> -->

                                        <tbody id="queryProductByParams">

                                        </tbody>

                                        <tbody id="selectedProductsTableBody">

                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-end mt-5">
                                    <h6><?= __("Total Before Discount") ?>: $ <span id="clearTotalBeforeDiscount" onkeyup="calculateSum()" class="totalBeforeDiscount"> <?= isset($beforeDiscount) ? number_format($beforeDiscount, 2)  : '';  ?> </span> </h6>
                                    <h6><?= __("Total After Discount") ?>: $ <span id="clearTotalAfterDiscount" onkeyup="calculateSum()" class="totalAfterDiscount"> <?= isset($afterDiscount) ? number_format($afterDiscount, 2)  : '';  ?> </span> </h6>
                                    <h6><?= __("Grand Total") ?>: $ <span onkeyup="calculateSum()" id="clearGrandTotal" class="grandTotal"> <?= isset($grand_total) ? number_format($grand_total, 2)  : '';  ?> </span> </h6>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    // Wait for the document to be ready
    document.addEventListener("DOMContentLoaded", function() {

        // Set the input value to the current date
        document.getElementById("purchaseDate").value = moment().format("YYYY-MM-DD HH:mm:ss A");

        <?php
        if (isset($purchase_date)) {
            $id = $purchase_date;
        ?>
            document.getElementById("purchaseDate").value = moment('<?= $id ?>').format("YYYY-MM-DD HH:mm:ss A");

        <?php } ?>
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
        selectedValue: <?php echo isset($statusID) ? $statusID : 6; ?>,

        options: [
            <?php
            $result = $con->query("SELECT * FROM status WHERE statusID IN(6, 7, 10)");
            while ($row = $result->fetch_assoc()) {
                if ($row['StatusID'] == 6) {
                    $row['StatusName'] = 'រង់ចាំ';
                } else if ($row['StatusID'] == 7) {
                    $row['StatusName'] = 'បានបញ្ចប់';
                } else if ($row['StatusID'] == 10) {
                    $row['StatusName'] = 'កម្មង់';
                }
            ?> {
                    label: '<?= $row['StatusName'] ?>',
                    value: <?= $row['StatusID'] ?>
                },

            <?php } ?>
        ],
    });

    // Supplier comboBox
    VirtualSelect.init({
        ele: '#supplier_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Supplier',
        selectAllOnlyVisible: true,
        name: 'supplier',
        required: true,
        selectedValue: <?php echo isset($supplierID) ? $supplierID : 2; ?>,

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

    // product comboBox
    VirtualSelect.init({
        ele: '#product_selection',
        search: true,
        maxWidth: '100%',
        placeholder: 'Select Product',
        name: 'pro_selection',
        selectAllOnlyVisible: true,

        name: "productName",

        options: [
            <?php
            $result = $con->query("SELECT * FROM product");
            while ($row = $result->fetch_assoc()) {
                $id =  $row['ProductName'];
                $pu_price = $row['PurchasePrice'];
            ?> {
                    label: '<?= $id ?>',
                    value: <?= $row['ProductID'] ?>,
                    customData: <?= $pu_price ?>
                },
            <?php } ?>
        ],
    });


    // Assuming you've echoed the JSON-encoded PHP arrays into JavaScript variables
    <?php
    if (
        isset($productNameValue) && isset($productIDValue) && isset($qty) && isset($purchasePrice)
        && isset($discount) && isset($eachBeforeDiscount) && isset($eachAfterDiscount) && isset($eachSubTotal)
    ) {
    ?>
        let productNameValue = <?php echo json_encode($productNameValue) ?>;
        let productIDValue = <?php echo json_encode($productIDValue) ?>;
        let qty = <?php echo json_encode($qty); ?>;
        let purchasePrice = <?php echo json_encode($purchasePrice); ?>;
        let discount = <?php echo json_encode($discount); ?>;
        let eachBeforeDiscount = <?php echo json_encode($eachBeforeDiscount); ?>;
        let eachAfterDiscount = <?php echo json_encode($eachAfterDiscount); ?>;
        let eachSubTotal = <?php echo json_encode($eachSubTotal); ?>;

        let queryProduct = [];
        // Old Product input
        for (let i = 0; i < productNameValue.length; i++) {
            let product = {
                productName: productNameValue[i],
                productID: productIDValue[i],
                qty: qty[i],
                purchasePrice: purchasePrice[i],
                discount: discount[i],
                beforeDiscount: eachBeforeDiscount[i],
                afterDiscount: eachAfterDiscount[i],
                subTotal: eachSubTotal[i]
            };
            queryProduct.push(product);
            console.log(queryProduct);
        }

    <?php } ?>


    // Push Product to table to sell
    let selectedProducts = [];
    let selectedProductID = [];
    let purchasePriceSelected = [];

    // New Product input
    let queryItem = document.querySelector('#product_selection')
    queryItem.addEventListener('change', function() {

        let selectedValue = this.value;
        queryItem.options.forEach(item => {
            if (item.value === selectedValue) {
                selectedProducts.push(item.label);
                selectedProductID.push(item.value);
                purchasePriceSelected.push(item.customData);
            }
        })

        updateTable();
    })


    function displayOldProductQuery() {
        let tableBody = document.getElementById('queryProductByParams');

        // Clear existing rows in the table
        tableBody.innerHTML = '';

        // Iterate over the array and create rows in the table
        for (let i = 0; i < queryProduct.length; i++) {
            let oldRow = tableBody.insertRow(tableBody.rows.length);

            // Assuming the product has properties like productName and productID
            let cell = oldRow.insertCell(0);

            // Trash Bin delete
            cell.innerHTML = `
                <div class="pt-1">
                    <a onclick="removeProduct(${i})"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>
                <div>
                `;

            // Product
            cell = oldRow.insertCell(1);
            cell.innerHTML =
                `<div class="pt-2"> ${queryProduct[i].productName} </div>` +
                `<input name="productID" data-index="${i}" type="hidden" value="${queryProduct[i].productID}">`;

            // Qty
            cell = oldRow.insertCell(2);
            cell.innerHTML = `
            <div class="d-flex gap-3">
                <input name="qtyValue" data-index="${i}" 
                    onkeyup="calculateSum(${i})"  
                    value="${queryProduct[i].qty}" 
                    style="border-radius: 25px" type="number" 
                    class="qtyValue shadow p-1 text-center h-100">
            </div>
            `;

            // Purchase Price
            cell = oldRow.insertCell(3);
            cell.innerHTML = `
            <input name="purchasePrice" data-index="${i}" 
                type="text" 
                onkeyup="calculateSum(${i})"  
                value="${queryProduct[i].purchasePrice}" 
                style="border-radius: 25px;" 
                class="purchasePrice text-white shadow p-1 text-center h-100">
            $`;


            // Discount
            cell = oldRow.insertCell(4);
            cell.innerHTML = `<input name="discountValue" data-index="${i}"  
                type="number" 
                value="${queryProduct[i].discount}" 
                onkeyup="calculateSum(${i})" 
                style="border-radius: 25px" 
                class="discountValue shadow p-1 text-center h-100"> 
            %`;


            // Before Discount
            cell = oldRow.insertCell(5);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="beforeDiscount_${i}"> ${queryProduct[i].beforeDiscount} </span>
            </div>
           `;

            // After Discount
            cell = oldRow.insertCell(6);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="afterDiscount_${i}"> ${queryProduct[i].afterDiscount} </span>
            </div>
           `;

            // SubTotal Amount
            cell = oldRow.insertCell(7);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="totalSum_${i}"> ${queryProduct[i].subTotal} </span>
            </div>
            `;

            calculateSum()

        }
    }

    displayOldProductQuery()


    // function displayOldProductQuery() {
    //     let tableBody = document.getElementById('queryProductByParams');

    //     // Clear existing rows in the table
    //     tableBody.innerHTML = '';

    //     // Iterate over the array and create rows in the table
    //     for (let i = 0; i < queryProduct.length; i++) {
    //         let oldRow = tableBody.insertRow(tableBody.rows.length);

    //         // Assuming the product has properties like productName and productID
    //         let cell = oldRow.insertCell(0);

    //         // Trash Bin delete
    //         cell.innerHTML = `
    //             <div class="pt-1">
    //                 <a onclick="removeProduct(${i})"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>
    //             <div>
    //             `;

    //         // Product
    //         cell = oldRow.insertCell(1);
    //         cell.innerHTML =
    //             `<div class="pt-2"> ${queryProduct[i].productName} </div>` +
    //             `<input name="productID" data-index="${i}" type="hidden" value="${queryProduct[i].productID}">`;

    //         // Qty
    //         cell = oldRow.insertCell(2);
    //         cell.innerHTML = `
    //         <div class="d-flex gap-3">
    //             <input name="qtyValue" data-index="${i}" 
    //                 onkeyup="calculateSum(${i})"  
    //                 value="${queryProduct[i].qty}" 
    //                 style="border-radius: 25px" type="number" 
    //                 class="qtyValue shadow p-1 text-center h-100">
    //         </div>
    //         `;

    //         // Purchase Price
    //         cell = oldRow.insertCell(3);
    //         cell.innerHTML = `
    //         <input name="purchasePrice" data-index="${i}" 
    //             type="text" 
    //             onkeyup="calculateSum(${i})"  
    //             value="${queryProduct[i].purchasePrice}" readonly 
    //             style="border-radius: 25px; background-color: grey" 
    //             class="purchasePrice text-white shadow p-1 text-center h-100">
    //         $`;


    //         // Discount
    //         cell = oldRow.insertCell(4);
    //         cell.innerHTML = `<input name="discountValue" data-index="${i}"  
    //             type="number" 
    //             value="${queryProduct[i].discount}" 
    //             onkeyup="calculateSum(${i})" 
    //             style="border-radius: 25px" 
    //             class="discountValue shadow p-1 text-center h-100"> 
    //         %`;


    //         // Before Discount
    //         cell = oldRow.insertCell(5);
    //         cell.innerHTML = `
    //         <div class="pt-2 text-end">
    //             $ <span class="beforeDiscount_${i}"> ${queryProduct[i].beforeDiscount} </span>
    //         </div>
    //        `;

    //         // After Discount
    //         cell = oldRow.insertCell(6);
    //         cell.innerHTML = `
    //         <div class="pt-2 text-end">
    //             $ <span class="afterDiscount_${i}"> ${queryProduct[i].afterDiscount} </span>
    //         </div>
    //        `;

    //         // SubTotal Amount
    //         cell = oldRow.insertCell(7);
    //         cell.innerHTML = `
    //         <div class="pt-2 text-end">
    //             $ <span class="totalSum_${i}"> ${queryProduct[i].subTotal} </span>
    //         </div>
    //         `;

    //         calculateSum()

    //     }
    // }


    function updateTable() {

        let tableBody = document.getElementById("selectedProductsTableBody");

        // Store the input values before clearing the table
        let inputValues = [];

        inputValues = selectedProducts.map((product, i) => {

            let qtyInput = document.querySelector(`input[name="qtyValue"][data-index="${i}"]`);
            let priceInput = document.querySelector(`input[name="purchasePrice"][data-index="${i}"]`);
            let discountInput = document.querySelector(`input[name="discountValue"][data-index="${i}"]`);

            const qty = qtyInput ? parseInt(qtyInput.value) || 0 : 0;
            const price = priceInput ? parseFloat(priceInput.value) || 0 : 0;
            const discount = discountInput ? parseInt(discountInput.value) || 0 : 0;
            let beforeDiscountInput = qty * price

            let afterDiscountInput = qty * price * discount / 100;
            let subTotalInput = (qty * price) - afterDiscountInput;
            let subTotalWithTax = (subTotalInput + (subTotalInput * 10 / 100))


            // Calculate grandTotal and update the inputValues array
            let grandTotalInput = 0;
            grandTotalInput += parseFloat(subTotalWithTax) || 0;

            let afterDiscountValue = 0
            afterDiscountValue += parseFloat(subTotalInput) || 0;


            return {
                productID: selectedProductID[i],
                qty: qtyInput ? qtyInput.value : '',
                purchasePrice: purchasePriceSelected[i],
                discount: discountInput ? discountInput.value : '',
                beforeDiscount: beforeDiscountInput.toFixed(3),
                afterDiscount: afterDiscountValue.toFixed(3),
                subTotal: subTotalWithTax.toFixed(3),
                grandTotal: grandTotalInput.toFixed(3)
            };
        });

        // Clear existing rows
        tableBody.innerHTML = '';

        // Add rows for each selected product
        for (let i = 0; i < selectedProducts.length; i++) {
            let newRow = tableBody.insertRow(tableBody.rows.length);
            let cell = newRow.insertCell(0);

            // Trash Bin delete
            cell.innerHTML = `
            <div class="pt-2">
                <a onclick="removeProduct(${i})"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>
            <div>
            `;

            // Product Name
            cell = newRow.insertCell(1);
            cell.innerHTML =
                `<div class="pt-2"> ${selectedProducts[i]} </div>` +
                `<input name="productID" data-index="${i}" type="hidden" value="${selectedProductID[i]}">`;

            // Qty
            cell = newRow.insertCell(2);
            cell.innerHTML = `
            <input name="qtyValue" data-index="${i}" 
                    onkeyup="calculateSum(${i})"  
                    value="${inputValues[i].qty}" 
                    style="border-radius: 25px" type="number" 
                    class="qtyValue shadow p-1 text-center h-100"> <div class="input-group-prepend">
            `;

            // Purchase Price
            cell = newRow.insertCell(3);
            cell.innerHTML = `
            <input name="purchasePrice" data-index="${i}" 
                type="text" 
                onkeyup="calculateSum(${i})"  
                value="${purchasePriceSelected[i].toFixed(3)}" 
                style="border-radius: 25px;" 
                class="purchasePrice shadow p-1 text-center h-100">
            $`;

            // Discount
            cell = newRow.insertCell(4);
            cell.innerHTML = `<input name="discountValue" data-index="${i}"  
                type="number" 
                value="${inputValues[i].discount}" 
                onkeyup="calculateSum(${i})" 
                style="border-radius: 25px" 
                class="discountValue shadow p-1 text-center h-100"> 
            %`;


            // Before Discount
            cell = newRow.insertCell(5);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="beforeDiscount_${i}"> 0 </span>
            </div>
           `;

            // After Discount
            cell = newRow.insertCell(6);
            cell.innerHTML = `
            <div class="pt-2 text-end">
                $ <span class="afterDiscount_${i}"> 0 </span>
            </div>
           `;

            // SubTotal Amount
            cell = newRow.insertCell(7);
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

        document.querySelectorAll('.purchasePrice').forEach(function(priceInput, index) {
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
                    purchasePrice: purchasePriceSelected[index],
                    qty: '',
                    price: '',
                    discount: '',
                    beforeDiscount: '',
                    afterDiscount: '',
                    subTotal: '',
                    grandTotal: ''
                };
            }
            inputValues[index][key] = value;

            const qty = parseInt(document.querySelector(`input[name="qtyValue"][data-index="${index}"]`).value) || 0;
            const price = parseFloat(document.querySelector(`input[name="purchasePrice"][data-index="${index}"]`).value) || 0;
            const discount = parseInt(document.querySelector(`input[name="discountValue"][data-index="${index}"]`).value) || 0;

            let beforeDiscount = qty * price
            inputValues[index]['beforeDiscount'] = beforeDiscount.toFixed(3)

            let afterDiscount = qty * price * discount / 100;
            let subTotal = (qty * price) - afterDiscount;
            let subTotalWithTax = subTotal + (subTotal * 10 / 100)

            inputValues[index]['afterDiscount'] = subTotal.toFixed(3);
            inputValues[index]['subTotal'] = subTotalWithTax.toFixed(3);


            // Calculate grandTotal and update the inputValues array
            let grandTotal = 0;
            for (let i = 0; i < inputValues.length; i++) {
                grandTotal += parseFloat(inputValues[i]['subTotal']) || 0;
            }
            inputValues[index]['grandTotal'] = grandTotal.toFixed(3);

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
        let grandTotal = 0;
        let totalBeforeDiscount = 0;
        let totalAfterDiscount = 0;
        for (let i = 0; i < tableBody.rows.length; i++) {
            const qtyInput = document.querySelector(`input[name="qtyValue"][data-index="${i}"]`);
            const priceInput = document.querySelector(`input[name="purchasePrice"][data-index="${i}"]`);
            const discountInput = document.querySelector(`input[name="discountValue"][data-index="${i}"]`);

            const qty = parseInt(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseInt(discountInput.value) || 0;

            // Before Discount
            const beforeDiscount = qty * price
            totalBeforeDiscount += beforeDiscount
            document.getElementsByClassName(`beforeDiscount_${i}`)[0].innerHTML = beforeDiscount.toFixed(3)
            document.querySelector('.totalBeforeDiscount').innerHTML = totalBeforeDiscount.toFixed(3)

            // After Discount
            let afterDiscount = qty * price * discount / 100;
            let subTotal = (qty * price) - afterDiscount;
            totalAfterDiscount += subTotal
            document.getElementsByClassName(`afterDiscount_${i}`)[0].innerHTML = subTotal.toFixed(3)
            document.querySelector('.totalAfterDiscount').innerHTML = totalAfterDiscount.toFixed(3)


            // After calculate subTotal, we will calculate with tax = 10%
            let subTotalWithTax = subTotal + (subTotal * 10 / 100)
            document.getElementsByClassName(`totalSum_${i}`)[0].innerHTML = subTotalWithTax.toFixed(3);

            grandTotal += subTotalWithTax
            document.querySelector('.grandTotal').innerHTML = grandTotal.toFixed(3);
        }
    }


    // Remove product selection
    function removeProduct(index) {
        selectedProducts.splice(index, 1);
        selectedProductID.splice(index, 1);
        purchasePriceSelected.splice(index, 1);

        // Clear the HTML content of elements
        let clearTotalBeforeDiscount = document.getElementById('clearTotalBeforeDiscount');
        let clearTotalAfterDiscount = document.getElementById('clearTotalAfterDiscount');
        let clearGrandTotal = document.getElementById('clearGrandTotal');

        if (clearTotalBeforeDiscount && clearTotalAfterDiscount && clearGrandTotal) {
            clearTotalBeforeDiscount.innerText = '$0.00';
            clearTotalAfterDiscount.innerText = '$0.00';
            clearGrandTotal.innerText = '$0.00';
        }

        <?php
        if (
            isset($productNameValue) && isset($productIDValue) && isset($qty) && isset($purchasePrice)
            && isset($discount) && isset($eachBeforeDiscount) && isset($eachAfterDiscount) && isset($eachSubTotal)
        ) {
        ?>
            queryProduct.splice(index, 1);
            displayOldProductQuery();
        <?php } ?>


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