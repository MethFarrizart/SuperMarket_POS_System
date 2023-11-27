<?php
include('../../../Connection/Connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand_name = $_POST['brand_name'];
    $brand_descr = $_POST['brand_descr'];

    $ins_brand = "INSERT INTO `brand`(`BrandName`, `Description`) VALUES ('$brand_name', '$brand_descr')";

    $output =  $con->query($ins_brand);
}
