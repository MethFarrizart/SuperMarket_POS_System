<?php
include('../Connection/Connect.php');
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $del_brand = "DELETE FROM `brand` WHERE BrandID = '$id'";

    $con->query($del_brand);
}
