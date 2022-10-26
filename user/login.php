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

  <body class="d-flex flex-column bg-dark align-items-center justify-content-center" style="width: 100vw; height:100vh;">
    <p class="display-5 text-white text-center mb-5">Login</p>
    <section class="col-sm-4 bg-white rounded">
      <form method="POST" class="p-5">
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
          <label for="email" class="d-block text-center mb-2"><b>Email</b></label>
          <input type="email" class="form-control rounded-pill text-center" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group m-3">
          <label for="password" class="d-block text-center mb-2"><b>Password</b></label>
          <input type="password" class="form-control rounded-pill text-center" id="password" name="password" placeholder="Enter password" required>
        </div>
        <div class="form-group m-3 text-end">
          <button type="submit" name="login" value="login" class="btn btn-dark w-25 rounded-pill">Login</button>
          <a href="register.php" class="btn btn-outline-dark w-25 rounded-pill">Register</a>
        </div>
      </form>
    </section>
  </body>

  </html>
<?php
}
