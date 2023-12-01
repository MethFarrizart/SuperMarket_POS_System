<?php
include('../../../Connection/Connect.php');
include('../../../Translate/language.php');

if (isset($_POST['selectSeller'])) {
    $select = $_POST['selectSeller'];
    $sql = $con->query("SELECT OD.invoiceID, OD.ProductID, OD.Price, OD.Amount, OD.TotalCash, pro.ProductName, O.*, 
                       P.SubTotal, P.GrandTotal, P.KhmerTotal FROM invoice O 
                       INNER JOIN invoice_detail OD ON OD.InvoiceID = O.InvoiceID 
                       INNER JOIN product pro ON O.ProductID = pro.ProductID
                       INNER JOIN payment P ON P.InvoiceID = O.InvoiceID
                       WHERE O.Seller = $select
                       ");
}
