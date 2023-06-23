<?php
if (isset($_GET['PosID'])) {
    $id = $_GET['PosID'];
    $result = $con->query("DELETE FROM position WHERE PositionID = '$id'");

    if ($result === true) {

?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Successfully Deleted!'
            })
        </script>

<?php }
} ?>

<td><?= '<img src="data:image;base64,' . base64_encode($pos_row['Image']) . ' " width=50px; height=50px;>'; ?> </td>





<!-- Select category to display data -->
<?php
$all = $con->query("SELECT * FROM Category");
while ($row = $all->fetch_assoc()) {
?>
    <p> Category: <?= $row['CategoryName'] ?></p>
    <?php
    $cate = $row['CategoryID'];
    $querys = $con->query("SELECT * FROM product WHERE CategoryID = $cate");
    while ($rows = $querys->fetch_assoc()) {
    ?>
        <small><?= $rows['ProductName'] ?> </small>
    <?php } ?>

<?php } ?>










<?php
$current_date = strtotime(date("Y-m-d"));
$expired_date = strtotime($pro_row['Expired_On']);
if ($current_date >= $expired_date) {
?>
    <?php
    $status = "SELECT StatusName FROM status WHERE StatusID = 4";
    $result = $con->query($status);
    while ($status_row = $result->fetch_assoc()) {
    ?>
        <td><?= $status_row['StatusName'] ?></td>
    <?php } ?>

<?php } else { ?>
    <?php
    if ($pro_row['Qty'] == 0) {
    ?>
        <!-- The Status will be sold out -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 3";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>
        <?php } ?>

    <?php } else if ($pro_row['Qty'] <= 5) { ?>
        <!-- The Status will be almost sold out -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 2";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>

        <?php } ?>

    <?php } else if ($pro_row['Qty'] > 0) { ?>
        <!-- The Status will be available -->
        <?php
        $status = "SELECT StatusName FROM status WHERE StatusID = 1";
        $result = $con->query($status);
        while ($status_row = $result->fetch_assoc()) {
        ?>
            <td><?= $status_row['StatusName'] ?></td>

        <?php } ?>
    <?php } ?>
<?php } ?>






























<!-- Chartjs -->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Name', 'Qty'],

            <?php
            $select = $con->query("SELECT * FROM product");
            while ($row = $select->fetch_assoc()) {
                echo "['" . $row['ProductName'] . "', " . $row['Qty'] . "],";
            }
            ?>

        ]);

        var options = {
            title: 'My Daily Activities',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>






<select class="custom-select w-100 p-2" name="pro_status">
    <?php
    $qry = $con->query("SELECT * FROM status ORDER BY StatusID ");
    while ($cate = $qry->fetch_assoc()) {
    ?>
        <option value="<?php echo $cate['StatusID'] ?>"><?php echo $cate['StatusName'] ?></option>
    <?php } ?>
</select>