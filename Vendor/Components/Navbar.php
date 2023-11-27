<div class="p-3 header sticky-xl-top d-flex justify-content-between">


    <div class="d-flex gap-3 pt-2">
        <div class="click fs-4 text-white fw-bold h2 pt-4" style="cursor:grab"><i class="fas fa-align-right"></i></div>
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" style="width: 150px;" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        Language
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-between" style="margin-top: -30px;">
                            <a class="text-dark text-decoration-none" href="Order.php?lang=en">English</a>
                            <a class="text-dark text-decoration-none" href="Order.php?lang=kh">Khmer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex text-white fw-bold pt-4" type="button" style="cursor:grab" data-bs-toggle="offcanvas" data-bs-target="#order" aria-controls="order">
            <i class="fa-solid fa-cart-plus fs-4"></i>
            <div align=center style="font-size: 20px; border-radius: 50%; width: 30px; height: 30px; margin: -20px -10px; background-color: rgb(40, 242, 40);" class="text-white">
                <?php
                if (isset($_SESSION['cart'])) {
                    $count = count(($_SESSION['cart']));
                    echo $count;
                } else {
                    echo "0";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="d-flex rounded-img">
        <div class="rounded-img">
            <?php echo "<img src='data:image;base64,$_SESSION[Photo]' width: 50px; height: 50px>"; ?>
        </div>
        <h4 class="text-white pt-3 ps-4"><?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] ?></h4>
    </div>
</div>