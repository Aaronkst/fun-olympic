<?php

session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
} else {
  $err = false;
  $errMsg = "";

  include '../chunks/header.php';
  include '../db.php';

  $query = "SELECT * FROM `broadcasts` WHERE `status`=1";
  $relt = mysqli_query($con, $query);
  if (!$relt) {
    $err = true;
    $errMsg = mysqli_error($con);
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Home"); ?>

  <body class="container-fluid">
    <?php generateNav(); ?>
    <p class="display-4 text-center m-5">FunOlympic Games</p>
    <section class="row">
      <div class="col-sm-8 offset-sm-2">
        <?php
        if ($err) echo '<p class="text-center text-danger">' . $errMsg . '</p>';
        else {
        ?>
          <div class="d-flex flex-wrap justify-content-center">
            <?php
            foreach ($relt as $data) {
            ?>
              <div class="w-25 m-2 bg-white shadow rounded">
                <img class="block w-100 mb-2 rounded-top" height="150" src="../assets/img/<?= $data['img'] ?>" alt="placeholder" />
                <p class="m-3"><?= $data['name'] ?></p>
                <a href="broadcast.php?id=<?= $data['id'] ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm d-block btn-primary m-3">Watch Now &rarr;</a>
              </div>
            <?php
            }
            ?>
          </div>
        <?php } ?>
      </div>
    </section>
  </body>

  </html>

<?php
}
?>