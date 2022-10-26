<?php

session_start();

$err = false;
$errMsg = "";

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
  header("Location: index.php");
} else {
  include '../chunks/header.php';
  include '../db.php';

  $id = mysqli_escape_string($con, $_GET['id']);
  $user = mysqli_escape_string($con, $_SESSION['id']);
  $timestamp = date('Y-m-d H:i:s');

  $logQuery = "INSERT INTO `log` (`user`, `broadcast`, `time`, `type`) VALUES ($user, $id, '$timestamp', 'user')";
  $create = mysqli_query($con, $logQuery);
  if (!$create) echo mysqli_error($con);

  $broadcastQuery = "SELECT * FROM `broadcasts` WHERE id='$id'";
  $relt = mysqli_query($con, $broadcastQuery);
  if (!$relt) {
    $err = true;
    $errMsg = mysqli_error($con);
  } else {
    if (mysqli_num_rows($relt) === 0) {
      $err = true;
      $errMsg = "Broadcast not found";
    } else {
      $data = $relt->fetch_assoc();
    }
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders($data['name']); ?>

  <body class="container-fluid">
    <?php generateNav(); ?>
    <section class="row">
      <div class="col-10 p-0">
        <img src="../assets/img/<?= $data['img'] ?>" class="block w-100 mb-3" />
      </div>
      <div class="col-2 p-0">
        <p class="h5 text-white bg-dark p-4"><?= $data['name'] ?></p>
        <div class="p-4">
          <p>Athletes</p>
          <ul>
            <li>Athlete 1</li>
            <li>Athlete 2</li>
            <li>Athlete 3</li>
            <li>Athlete 4</li>
            <li>Athlete 5</li>
          </ul>
        </div>
      </div>
    </section>
  </body>

  </html>
<?php
}
?>