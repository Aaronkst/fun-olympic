<?php

session_start();

$err = false;
$errMsg = "";

if (isset($_SESSION['id'])) {
  header("Location: index.php");
} else {
  if (isset($_POST['login'])) {
    include '../db.php';
    $email = mysqli_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $userQuery = "SELECT * FROM `users` WHERE `email`='$email' AND `status`=1";
    $relt = mysqli_query($con, $userQuery);
    if (!$relt) {
      $err = true;
      $errMsg = mysqli_error($con);
    } else {
      if (mysqli_num_rows($relt) === 0) {
        $err = true;
        $errMsg = "Invalid Email";
      } else {
        $data = $relt->fetch_assoc();
        if ($data['password'] !== $password) {
          $err = true;
          $errMsg = "Invalid Login";
        } else {
          $_SESSION['id'] = $data['id'];
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

  <style>
    body {
      background-image: url("../assets/img/bg.jpg");
    }
  </style>

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
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" aria-describedby="emailDisclaimer" required>
            <small id="emailDisclaimer" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group m-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          </div>
          <div class="form-group m-3">
            <button type="submit" name="login" value="login" class="btn btn-primary d-block w-100">Login</button>
          </div>
          <a href="register.php" class="d-block text-decoration-none text-center"><small>Register</small></a>
        </form>
      </div>
    </section>
  </body>

  </html>
<?php
}
