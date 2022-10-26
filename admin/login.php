<?php

session_start();

$err = false;
$errMsg = "";

if (isset($_SESSION['admin'])) {
  header("Location: index.php");
} else {
  if (isset($_POST['login'])) {
    include '../db.php';
    $username = mysqli_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $userQuery = "SELECT * FROM `admin` WHERE username='$username'";
    $relt = mysqli_query($con, $userQuery);
    if (!$relt) {
      $err = true;
      $errMsg = mysqli_error($con);
    } else {
      if (mysqli_num_rows($relt) === 0) {
        $err = true;
        $errMsg = "Invalid User";
      } else {
        $row = $relt->fetch_assoc();
        if ($row['password'] !== $password) {
          $err = true;
          $errMsg = "Invalid Login";
        } else {
          $_SESSION['admin'] = $row['id'];
          header("Location: index.php");
        }
      }
    }
  }
  include '../chunks/header.php';
?>

  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Admin"); ?>

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
          <label for="username" class="d-block text-center mb-2"><b>Username</b></label>
          <input type="username" class="form-control rounded-pill text-center" id="username" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group m-3">
          <label for="password" class="d-block text-center mb-2"><b>Password</b></label>
          <input type="password" class="form-control rounded-pill text-center" id="password" name="password" placeholder="Enter password" required>
        </div>
        <div class="form-group m-3 text-end">
          <button type="submit" name="login" value="login" class="btn btn-dark w-25 rounded-pill">Login</button>
        </div>
      </form>
    </section>
  </body>

  </html>
<?php
}
