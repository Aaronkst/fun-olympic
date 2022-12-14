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
      <div class="col-sm-12 py-3">
        <div class="col-8 offset-2">
          <!-- <video class="block w-100 mb-3">
            <source src="https://youtu.be/FNt2LSLGV6w">
          </video> -->
          <iframe width="1250" height="703" src="https://www.youtube.com/embed/FNt2LSLGV6w" title="Brazil ● Road to the World Cup 2022" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          <p class="h3"><?= $data['name'] ?></p>
        </div>
      </div>
    </section>
  </body>

  </html>
<?php
}
?>