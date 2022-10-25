<?php

$err = false;
$errMsg = "";

if (isset($_POST['register'])) {
  include '../db.php';
  $name = mysqli_escape_string($con, $_POST['name']);
  $email = mysqli_escape_string($con, $_POST['email']);
  $password = mysqli_escape_string($con, $_POST['password']);
  $insertQuery = "INSERT INTO `users` (name, email, password) VALUES ('$name','$email','$password')";
  $relt = mysqli_query($con, $insertQuery);

  if ($relt) {
    session_start();
    $userQuery = "SELECT id FROM `users` WHERE email='$email'";
    $relt = mysqli_query($con, $userQuery);
    $row = $relt->fetch_assoc();
    $_SESSION['id'] = $row['id'];
    header("Location: index.php");
  } else {
    $err = true;
    $errMsg = mysqli_error($con);
  }
}
include '../chunks/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php generateHeaders("Register"); ?>

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
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="form-group m-3">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group m-3">
          <label for="password">Password</label>
          <input type="password" class="form-control mb-3" id="password" name="password" placeholder="Enter password" required>
          <input type="password" class="form-control" id="password2" placeholder="Re-enter password" required>
        </div>
        <div class="alert alert-danger alert-dismissible p-2" style="display:none;" id="pwdAlert" role="alert">
          Passwords do not match
        </div>
        <div class="form-group m-3">
          <button type="submit" name="register" value="register" class="btn btn-primary d-block w-100" id="submitBtn" disabled>Submit</button>
        </div>
      </form>
    </div>
  </section>
</body>

<script>
  const password = document.querySelector('#password');
  const password2 = document.querySelector('#password2');
  password2.addEventListener("change", (e) => {
    let checkPass = passwordValidator();
    if (!checkPass) document.querySelector("#pwdAlert").style.display = "block";
    else {
      document.querySelector("#pwdAlert").style.display = "none";
      document.querySelector("#submitBtn").disabled = false;
    }
  })
  const passwordValidator = () => {
    if (password.value && password2.value && password.value === password2.value) return true;
    else return false;
  }
</script>

</html>