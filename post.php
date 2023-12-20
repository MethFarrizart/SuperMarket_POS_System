<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        function updateTable() {
            let tableBody = document.getElementById("selectedProductsTableBody");

            let inputValues = [];
            for (let i = 0; i < selectedProducts.length; i++) {
                let qtyInput = document.querySelector(`input[name="qtyValue"][data-index="${i}"]`);
                let priceInput = document.querySelector(`input[name="priceValue"][data-index="${i}"]`);
                let discountInput = document.querySelector(`input[name="discountValue"][data-index="${i}"]`);

                inputValues.push({
                    qty: qtyInput ? qtyInput.value : '',
                    price: priceInput ? priceInput.value : '',
                    discount: discountInput ? discountInput.value : '',
                });
            }

            // Clear existing rows
            tableBody.innerHTML = '';

            // Add rows for each selected product
            for (let i = 0; i < selectedProducts.length; i++) {

                let newRow = tableBody.insertRow(tableBody.rows.length);
                let cell = newRow.insertCell(0);
                cell.innerHTML = `<a onclick="removeProduct(${i})"><img src="../../Images/trash.png" width="20px" height="20px" style="cursor: grab;"></a>`;
                cell = newRow.insertCell(1);
                cell.innerHTML = selectedProducts[i];

                cell = newRow.insertCell(2);
                cell.innerHTML =
                    ` <div class="d-flex gap-3">
                            <input name="qtyValue" data-index="${i}" style="border-radius: 25px" type="number" class="qty text-center" onkeyup="calculateSum(${i})" value="${inputValues[i].qty}">
                        </div> `;

                // Unit Price
                cell = newRow.insertCell(3);
                cell.innerHTML = ` <input name="priceValue" data-index="${i}" style="border-radius: 25px" type="number" class="shadow p-1 price text-center h-100" onkeyup="calculateSum(${i})" value="${inputValues[i].price}">`;

                // Discount
                cell = newRow.insertCell(4);
                cell.innerHTML = `<input name="discountValue" data-index="${i}" style="border-radius: 25px" type="number" class="shadow p-1 discount text-center h-100" onkeyup="calculateSum(${i})" value="${inputValues[i].discount}"> %`;

                // SubTotal Amount
                cell = newRow.insertCell(5);
                cell.innerHTML = `<p data-index="${i}" class="text-end totalSum_${i}"> 0 $</p>`;

                selectedProducts.push({
                    priceValue: document.querySelector(`input[name="priceValue"][data-index="${i}"]`).value,
                    qtyValue: document.querySelector(`input[name="qtyValue"][data-index="${i}"]`).value,
                    discountValue: document.querySelector(`input[name="discountValue"][data-index="${i}"]`).value,
                    productName: selectProductIndex[i]
                });
            }

            document.getElementById("selectedProductsInput").value = JSON.stringify(selectedProducts);
        }
    </script>
</body>

</html>