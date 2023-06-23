<div class="p-3 header sticky-xl-top">
  <div class="click fs-4 text-white fw-bold h2 pt-4" href="#" style="cursor:grab"><i class="fas fa-align-right"></i></div>

  <div class="d-flex rounded-img">
    <div class="rounded-img">
      <?php echo "<img src='data:image;base64,$_SESSION[Photo]' width: 50px; height: 50px>"; ?>
    </div>
    <h4 class="text-white pt-3 ps-4"><?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] ?></h4>
  </div>
  <!-- <div class="click fs-4 text-white fw-bold h2 pt-3" href="#" style="cursor:grab"><i class="fas fa-align-right"></i></div> -->
</div>