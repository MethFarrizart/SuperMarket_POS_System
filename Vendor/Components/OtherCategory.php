<?php
$category = $con->query("SELECT * FROM Category WHERE CategoryID > 1");
while ($cate_row = $category->fetch_assoc()) {
    $match = $cate_row['CategoryID'];
?>

    <div class="tab-pane fade" id="list-<?= $cate_row['CategoryID'] ?>" role="tabpanel" aria-labelledby="list-<?= $cate_row['CategoryID'] ?>-list">
        <div class="pro-item">
            <?php
            $product = $con->query("SELECT * FROM product WHERE CategoryID = $match");
            if (mysqli_num_rows($product) > 0) {
                while ($row = $product->fetch_assoc()) {
                    $status = $row['StatusID'];
                    $qty = $row['Qty'];
            ?>
                    <?php
                    // Display expired product 
                    if ($status == 4) {
                    ?>
                        <div class="card shadow expired" style="width: 18rem; border-radius: 15px">
                            <div class="card-body" align=center>
                                <div class="label-price pt-1">$ <?= number_format($row['Price'], 2)  ?></div>
                                <img class="w-50" src="../../Images/<?= $row['Image'] ?>">
                                <img src="../../Images/expiredlogo.png" class="w-75 position-relative" style="z-index: 999;">
                                <h5 class="card-title pt-4"><?= $row['ProductName'] ?></h5>
                                <p class="card-text"></p>
                                <h5> <?= __('Left') ?>: <?= $row['Qty'] ?> <?= __('Items') ?> </h5>
                            </div>
                        </div>

                        <!-- Display sold out product -->
                    <?php } else if ($qty == 0) { ?>
                        <div class="card shadow " style="width: 18rem; border-radius: 15px">
                            <div class="card-body sold-out" align=center>
                                <div class="label-price pt-1">$ <?= number_format($row['Price'], 2)  ?></div>
                                <img src="../../Images/<?= $row['Image'] ?>" style="width: 200px">
                                <img src="../../Images/soldoutlogo.png" width="270" height="200" style="z-index: 3; margin-top: -200px;">
                                <h5 class="card-title pt-4"><?= $row['ProductName'] ?></h5>
                                <form action="Order.php?id=<?= $row['ProductID'] ?>" method="post" align=center>
                                    <button disabled name="submit" type="submit" class="btn btn-primary p-3" style="background:linear-gradient(to top, rgb(54, 54, 175), dodgerblue);">Add to Cart</button>
                                </form>
                            </div>
                        </div>

                        <!-- Display almost almost product -->
                    <?php } else if ($qty < 6) { ?>
                        <div class="card shadow" style="width: 18rem; border-radius: 15px">
                            <div class="card-body almost" align=center>
                                <div class="label-price pt-1">$ <?= number_format($row['Price'], 2)  ?></div>
                                <img src="../../Images/<?= $row['Image'] ?>" style="width: 200px">
                                <h5 class="card-title pt-4"><?= $row['ProductName'] ?></h5>
                                <h5> <?= __('Left') ?>: <?= $row['Qty'] ?> <?= __('Items') ?></h5>
                                <form action="Order.php?id=<?= $row['ProductID'] ?>" method="post" align=center>

                                    <input type="hidden" name="p_id" value="<?= $row['ProductID'] ?>">
                                    <input type="hidden" name="p_name" value="<?= $row['ProductName'] ?>">
                                    <input type="hidden" name="p_cate" value="<?= $row['CategoryID'] ?>">
                                    <input type="number" name="p_amount" class="form-control"> <br>
                                    <input type="hidden" name="p_originQty" value="<?= $row['Qty'] ?>">
                                    <input type="hidden" name="p_price" value="<?= $row['Price'] ?>">
                                    <input type="hidden" name="p_img" value="<?= $row['Image'] ?>">

                                    <button name="add-to-cart" type="submit" class="btn btn-primary p-3" style="background:linear-gradient(to top, rgb(54, 54, 175), dodgerblue);">Add to Cart</button>
                                </form>
                            </div>
                        </div>

                        <!-- Display available product -->
                    <?php } else if ($status == 1) { ?>
                        <div class="card shadow" style="width: 18rem; border-radius: 15px; background:linear-gradient(to top, rgb(54, 54, 175), dodgerblue);">
                            <div class="card-body text-white" align=center>
                                <div class="label-price pt-1">$ <?= number_format($row['Price'], 2)  ?></div>
                                <img src="../../Images/<?= $row['Image'] ?>" style="width: 200px">
                                <h5 class="card-title pt-4"><?= $row['ProductName'] ?></h5>
                                <h5> <?= __('Left') ?>: <?= $row['Qty'] ?> <?= __('Items') ?> </h5>
                                <form action="Order.php?id=<?= $row['ProductID'] ?>" class="cover_form" method="post" align=center>

                                    <input type="hidden" name="p_id" value="<?= $row['ProductID'] ?>">
                                    <input type="hidden" name="p_name" value="<?= $row['ProductName'] ?>">
                                    <input type="hidden" name="p_cate" value="<?= $row['CategoryID'] ?>">
                                    <input type="number" name="p_amount" class="form-control"> <br>
                                    <input type="hidden" name="p_originQty" value="<?= $row['Qty'] ?>">
                                    <input type="hidden" name="p_price" value="<?= $row['Price'] ?>" class="upd_price">
                                    <input type="hidden" name="p_img" value="<?= $row['Image'] ?>">

                                    <button name="add-to-cart" onclick="verify()" type="submit" class="btn btn-primary p-3" style="background:linear-gradient(to top, rgb(54, 54, 175), dodgerblue);">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                <?php }
            } else { ?>
                <div style="height: 58vh">
                    <div class="loadingio-spinner-spinner-qn1vzcvkchk d-flex justify-content-center" style="width: 400%; height: 18vh">
                        <div class="ldio-clilj3a1frv">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <h4 class="pb-4 mt-5 pt-5" align=center><i><?= __('No Product has been added') ?> !</i> </h4>
                        </div>

                    </div>

                </div>

            <?php } ?>
        </div>
    </div>

<?php } ?>