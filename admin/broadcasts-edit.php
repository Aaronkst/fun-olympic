<?php

$err = false;
$errMsg = "";

include '../db.php';

if (isset($_POST['save'])) {
  $name = mysqli_escape_string($con, $_POST['name']);
  $img = mysqli_escape_string($con, $_POST['img']);
  if (isset($_GET['id'])) {
    $id = mysqli_escape_string($con, $_GET['id']);
    $insertQuery = "UPDATE `broadcasts` SET `name`='$name',`img`='$img' WHERE id=$id";
  } else {
    $insertQuery = "INSERT INTO `broadcasts` (`name`,`img`) VALUES '$name','$img'";
  }
  echo $insertQuery;
  $save = mysqli_query($con, $insertQuery);
  echo $save;

  if ($save) {
    header("Location: broadcasts.php");
  } else {
    $err = true;
    $errMsg = mysqli_error($con);
  }
}

if (isset($_GET['id'])) {
  $id = mysqli_escape_string($con, $_GET['id']);
  $bcQuery = "SELECT * FROM `broadcasts` WHERE id=$id";
  $relt = mysqli_query($con, $bcQuery);
  $data = $relt->fetch_assoc();
  $bc_name = $data['name'];
  $bc_img = $data['img'];
}

include '../chunks/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php generateHeaders("Save Broadcast"); ?>

<body class="container-fluid">
  <?php generateAdminNav(); ?>
  <p class="display-4 text-center m-5">Broadcast</p>
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
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" <?php if (isset($data)) echo "value='$bc_name'"; ?> required>
        </div>
        <div class="form-group m-3">
          <label for="img">Image</label>
          <input type="text" class="form-control" id="img" name="img" placeholder="Image" <?php if (isset($data)) echo "value='$bc_img'"; ?> required>
        </div>
        <div class="form-group m-3">
          <button type="submit" name="save" class="btn btn-primary d-block w-100" id="submitBtn">Save</button>
        </div>
        <div class="form-group m-3">
          <button type="reset" class="btn btn-secondary d-block w-100" id="cancel">Cancel</button>
        </div>
      </form>
    </div>
  </section>
</body>

<script>
  document.querySelector("#cancel").addEventListener("click", () => window.history.back());
</script>

</html>