<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>

<body>

    <!-- Form Add Product -->
    <h2>Add Product</h2>
    <form id="productForm">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required><br>

        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" name="productPrice" required><br>

        <button type="button" onclick="addProduct()">Add Product</button>
    </form>

    <div id="result"></div>

    <h2>Filter Products</h2>
    <input type="text" id="filter" placeholder="Enter product name" oninput="getProducts()">

    <div id="productList"></div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
</body>

</html>


<script>
    function addProduct() {
        var productName = document.getElementById("productName").value;
        var productPrice = document.getElementById("productPrice").value;

        $.ajax({
            type: "POST",
            url: "insert_product.php",
            data: {
                action: "addProduct",
                productName: productName,
                productPrice: productPrice
            },
            success: function(response) {
                $("#result").html(response);
                getProducts(); // After adding a product, update the product list
            }
        });
    }

    function getProducts() {
        var filter = document.getElementById("filter").value;

        $.ajax({
            type: "POST",
            url: "insert_product.php",
            data: {
                action: "getProducts",
                filter: filter
            },
            dataType: "json",
            success: function(products) {
                var productList = "<h2>Product List</h2><ul>";
                for (var i = 0; i < products.length; i++) {
                    productList += "<li>" + products[i].name + " - $" + products[i].price + "</li>";
                }
                productList += "</ul>";
                $("#productList").html(productList);
            }
        });
    }

    // Initial load of products
    $(document).ready(function() {
        getProducts();
    });

    // Filter products on input change
    $("#filter").on("input", function() {
        getProducts();
    });
</script>





<?php
// Assuming you have a database connection
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert product
    if (isset($_POST["action"]) && $_POST["action"] == "addProduct") {
        $productName = $_POST["productName"];
        $productPrice = $_POST["productPrice"];

        $sql = "INSERT INTO products (name, price) VALUES ('$productName', $productPrice)";

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Read and filter products
    if (isset($_POST["action"]) && $_POST["action"] == "getProducts") {
        $filter = isset($_POST["filter"]) ? $_POST["filter"] : "";
        $filterCondition = $filter ? " WHERE name LIKE '%$filter%'" : "";

        $result = $conn->query("SELECT * FROM products" . $filterCondition);

        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode($products);
        } else {
            echo "No products found.";
        }
    }
}

$conn->close();
?>