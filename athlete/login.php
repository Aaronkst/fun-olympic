<?php

session_start();

$err = false;
$errMsg = "";

if (isset($_SESSION['athlete'])) {
  header("Location: index.php");
} else {
  if (isset($_POST['login'])) {
    include '../db.php';
    $username = mysqli_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $userQuery = "SELECT * FROM `athletes` WHERE `username`='$username' AND `status`=1";
    $relt = mysqli_query($con, $userQuery);
    if (!$relt) {
      $err = true;
      $errMsg = mysqli_error($con);
    } else {
      if (mysqli_num_rows($relt) === 0) {
        $err = true;
        $errMsg = "Invalid Username";
      } else {
        $data = $relt->fetch_assoc();
        if ($data['password'] !== $password) {
          $err = true;
          $errMsg = "Invalid Login";
        } else {
          $_SESSION['athlete'] = $data['id'];
          header("Location: index.php");
        }
      }
    }
  }
  include '../chunks/header.php';
?>

  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Login"); ?>

  <body class="container-fluid">
    <p class="display-4 text-center m-5">FunOlympic Games</p>
    <section class="row">
      <div class="col-sm-4 offset-sm-4 bg-white">
        <form method="POST" class="p-3">
          <div class="form-group mx-3 mb-1">
            <?php if ($err) {
            ?>
              <div class="alert alert-danger alert-dismissible p-2" role="alert">
                <?= $errMsg ?>
              </div>
            <?php
            }
            ?>
          </div>
          <div class="form-group m-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" aria-describedby="usernameDisclaimer" required>
          </div>
          <div class="form-group m-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          </div>
          <div class="form-group m-3">
            <button type="submit" name="login" value="login" class="btn btn-primary d-block w-100">Login</button>
          </div>
        </form>
      </div>
    </section>
  </body>

  </html>
<?php
}
