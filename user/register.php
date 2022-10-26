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

<body class="d-flex flex-column bg-dark align-items-center justify-content-center" style="width: 100vw; height:100vh;">
  <p class="display-5 text-white text-center mb-5">Register</p>
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
        <label for="name" class="d-block text-center mb-2"><b>Name</b></label>
        <input type="text" class="form-control rounded-pill text-center" id="name" name="name" placeholder="Enter name" required>
      </div>
      <div class="form-group m-3">
        <label for="email" class="d-block text-center mb-2"><b>Email</b></label>
        <input type="email" class="form-control rounded-pill text-center" id="email" name="email" placeholder="Enter email" required>
      </div>
      <div class="form-group m-3">
        <label for="password" class="d-block text-center mb-2"><b>Password</b></label>
        <input type="password" class="form-control rounded-pill text-center mb-3" id="password" name="password" placeholder="Enter password" required>
        <input type="password" class="form-control rounded-pill text-center" id="password2" placeholder="Re-enter password" required>
      </div>
      <div class="alert alert-danger alert-dismissible p-2" style="display:none;" id="pwdAlert" role="alert">
        Passwords do not match
      </div>
      <div class="form-group m-3 text-end">
        <button type="submit" name="register" value="register" class="btn btn-dark w-25 rounded-pill" id="submitBtn" disabled>Register</button>
        <a href="login.php" class="btn btn-outline-dark w-25 rounded-pill">Cancel</a>
      </div>
    </form>
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