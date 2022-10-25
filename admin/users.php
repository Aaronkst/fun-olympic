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
    $updateQuery = "UPDATE `users` SET `status`=$status WHERE id=$id";
    $update = mysqli_query($con, $updateQuery);
    if (!$update) echo mysqli_error($con);
  }

  $start = 0;

  if (isset($_GET['page'])) $start = $_GET['page'] * 10;

  $userQuery = "SELECT * FROM users";

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
    if ($_POST['email'] !== "") {
      if ($_POST['id'] == "" && $_POST['name'] == "") {
        $email = mysqli_escape_string($con, $_POST['email']);
        $userQuery = $userQuery . "email='$email'";
      } else {
        $email = mysqli_escape_string($con, $_POST['email']);
        $userQuery = $userQuery . " AND email='$email'";
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

  <body class="container-fluid">
    <?php generateAdminNav(); ?>
    <div class="container">
      <section class="row">
        <form method="POST" class="col-12">
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
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="text-end px-3">
                <button class="btn btn-primary mx-3" type="submit" name="search">Search</button>
                <button class="btn btn-secondary" type="reset" id="reset">Reset</button>
              </div>
            </div>
          </div>
        </form>
      </section>
      <section class="row">
        <div class="col-12 p-4">
          <p class="text-end">Total: <?= $count ?></p>
          <div class="rounded bg-white shadow mt-4">
            <table class="table table-striped table-hover">
              <thead class="bg-dark text-white sticky-top">
                <tr>
                  <th>#</th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
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
                    <td><?= $data['email'] ?></td>
                    <td>
                      <form method="POST" class="d-inline mr-3">
                        <input type="text" name="id" value="<?= $data['id'] ?>" hidden>
                        <input type="text" name="status" value="<?= $data['status'] ?>" hidden>
                        <button type="submit" name="update" class="btn btn-<?php echo $data['status'] == 1 ? "danger" : "primary"; ?> btn-sm">
                          <?php echo $data['status'] == 1 ? "Disable" : "Enable"; ?>
                        </button>
                      </form>
                      <a target="_blank" rel="noopener noreferrer" class="btn btn-warning btn-sm" href="users-logs.php?id=<?= $data['id'] ?>">View Activity</a>
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
                  <a class="btn rounded-circle btn-primary" <?php if ($x * 10 !== $start) echo 'href="users.php?page=' . $x + 1 . '"'; ?>><?= $x + 1 ?></a>
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
    const email = document.querySelector("#email");

    document.querySelector("#reset").addEventListener("change", () => {
      id.value = "";
      name.value = "";
      email.value = "";
    })
  </script>

  </html>

<?php
}
?>