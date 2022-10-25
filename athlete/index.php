<?php

session_start();

$err = false;
$errMsg = "";

if (!isset($_SESSION['athlete'])) {
  header("Location: index.php");
} else {
  include '../chunks/header.php';
  include '../db.php';

  $id = mysqli_escape_string($con, $_SESSION['athlete']);
  if (isset($_POST['checkIn'])) {
    $venue = mysqli_escape_string($con, $_POST['venue']);
    $timestamp = date('Y-m-d H:i:s');

    $logQuery = "INSERT INTO `log` (`user`, `venue`, `time`, `type`) VALUES ($id, '$venue', '$timestamp', 'athlete')";
    $create = mysqli_query($con, $logQuery);
    if (!$create) echo mysqli_error($con);
    else $success = true;
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Venue Check In"); ?>

  <body class="container-fluid">
    <?php generateNav(); ?>
    <section class="row">
      <div class="col-sm-4 offset-sm-4 p-3">
        <form method="POST">
          <div class="form-group mx-3 mb-1">
            <?php if (isset($success) && $success) {
            ?>
              <div class="alert alert-success alert-dismissible p-2" role="alert">
                Successfully Checked In!
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group m-3">
            <label for="venue">Venue</label>
            <input type="text" class="form-control" id="venue" name="venue" placeholder="Enter Venue" required>
          </div>
          <div class="form-group m-3">
            <button type="submit" name="checkIn" class="btn btn-primary d-block w-100">Check In</button>
          </div>
        </form>
      </div>
    </section>
  </body>

  </html>
<?php
}
?>