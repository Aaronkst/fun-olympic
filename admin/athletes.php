<?php

session_start();

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
} else {
  include '../chunks/header.php';
  include '../db.php';

  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $status = $_POST['status'] == 1 ? 0 : 1;
    $updateQuery = "UPDATE `athletes` SET `status`=$status WHERE id=$id";
    $update = mysqli_query($con, $updateQuery);
    if (!$update) echo mysqli_error($con);
  }

  $start = 0;

  if (isset($_GET['page'])) $start = $_GET['page'] * 10;

  $userQuery = "SELECT * FROM athletes";

  if (isset($_POST['search'])) {
    $userQuery = $userQuery . " WHERE ";
    if ($_POST['id'] !== "") {
      $id = mysqli_escape_string($con, $_POST['id']);
      $userQuery = $userQuery . "id=$id";
    }
    if ($_POST['name'] !== "") {
      if ($_POST['id'] == "") {
        $name = mysqli_escape_string($con, $_POST['name']);
        $userQuery = $userQuery . "name='$name'";
      } else {
        $name = mysqli_escape_string($con, $_POST['name']);
        $userQuery = $userQuery . " AND name='$name'";
      }
    }
    if ($_POST['username'] !== "") {
      if ($_POST['id'] == "" && $_POST['name'] == "") {
        $username = mysqli_escape_string($con, $_POST['username']);
        $userQuery = $userQuery . "username='$username'";
      } else {
        $username = mysqli_escape_string($con, $_POST['username']);
        $userQuery = $userQuery . " AND username='$username'";
      }
    }
  }

  $userQuery = $userQuery . " LIMIT $start, 9";

  $relt = mysqli_query($con, $userQuery);
  $count = mysqli_num_rows($relt);
?>
  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Users"); ?>

  <body class="container-fluid bg-secondary">
    <?php generateAdminNav(); ?>
    <div class="container">
      <section class="row">
        <form method="POST" class="col-12 p-4  bg-white rounded shadow mt-4">
          <div class="text-end px-3">
            <a href="athletesEdit.php" class="btn btn-success">Create New &plus;</a>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group m-3">
                <label for="id">User Id</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="ID">
              </div>
            </div>
            <div class="col">
              <div class="form-group m-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
              </div>
            </div>
            <div class="col">
              <div class="form-group m-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="text-end px-3">
                <button class="btn btn-dark mx-3" type="submit" name="search">Search</button>
                <button class="btn btn-secondary" type="reset" id="reset">Reset</button>
              </div>
            </div>
          </div>
        </form>
      </section>
      <section class="row">
        <div class="col-12 p-4 rounded bg-white shadow mt-4">
          <p class="text-end">Total: <?= $count ?></p>
          <div>
            <table class="table table-striped table-hover">
              <thead class="bg-dark text-white sticky-top">
                <tr>
                  <th>#</th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = $start;
                foreach ($relt as $data) {
                  $i++;
                ?>
                  <tr>
                    <td><?= $i ?></td>
                    <td><?= $data['id'] ?></td>
                    <td><?= $data['name'] ?></td>
                    <td><?= $data['username'] ?></td>
                    <td>
                      <form method="POST" class="d-inline mr-3">
                        <input type="text" name="id" value="<?= $data['id'] ?>" hidden>
                        <input type="text" name="status" value="<?= $data['status'] ?>" hidden>
                        <button type="submit" name="update" class="btn btn-<?php echo $data['status'] == 1 ? "danger" : "dark"; ?> btn-sm">
                          <?php echo $data['status'] == 1 ? "Disable" : "Enable"; ?>
                        </button>
                      </form>
                      <a target="_blank" rel="noopener noreferrer" class="btn btn-warning btn-sm" href="athletesLogs.php?id=<?= $data['id'] ?>">View Activity</a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <div class="p-3">
              <div class="d-flex">
                <?php
                for ($x = 0; $x < $count / 10; $x++) {
                ?>
                  <a class="btn rounded-circle btn-dark px-3" <?php if ($x * 10 !== $start) echo 'href="athletes.php?page=' . $x + 1 . '"'; ?>><small><?= $x + 1 ?></small></a>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

  </body>

  <script>
    const id = document.querySelector("#id");
    const name = document.querySelector("#name");
    const username = document.querySelector("#username");

    document.querySelector("#reset").addEventListener("change", () => {
      id.value = "";
      name.value = "";
      username.value = "";
    })
  </script>

  </html>

<?php
}
?>