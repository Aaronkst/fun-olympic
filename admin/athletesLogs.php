<?php

session_start();

if (!isset($_SESSION['admin']) && !isset($_GET['id'])) {
  header("Location: login.php");
} else {
  include '../chunks/header.php';
  include '../db.php';

  $id = mysqli_escape_string($con, $_GET['id']);
  $start = 0;

  if (isset($_GET['page'])) $start = $_GET['page'] * 10;

  $userQuery = "SELECT `name` FROM `users` WHERE id=$id";
  $logQuery = "SELECT log.*, broadcasts.name FROM `log`, `broadcasts` WHERE log.user=$id AND broadcasts.id = log.broadcast AND log.type='athlete' LIMIT $start, 9";

  $relt = mysqli_query($con, $logQuery);
  $count = mysqli_num_rows($relt);

  $userRelt = mysqli_query($con, $userQuery);
  $user = $userRelt->fetch_assoc();
?>
  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Users"); ?>

  <body class="container-fluid">
    <?php generateAdminNav(); ?>
    <div class="container">
      <section class="row">
        <div class="col-12 p-4">
          <p class="text-end">User: <?= $user['name'] ?></p>
          <div class="rounded bg-white shadow mt-4">
            <table class="table table-striped table-hover">
              <thead class="bg-dark text-white sticky-top">
                <tr>
                  <th>#</th>
                  <th>Broadcast Id</th>
                  <th>Broadcast Name</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($relt) > 0) {
                  $i = $start;
                  foreach ($relt as $data) {
                    $i++;
                ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $data['broadcast'] ?></td>
                      <td><?= $data['name'] ?></td>
                      <td><?= $data['time'] ?></td>
                    </tr>
                <?php
                  }
                } else echo "<td colspan='4' class='text-center'>No Activity Yet</td>"
                ?>
              </tbody>
            </table>
            <div class="p-3">
              <div class="d-flex">
                <?php
                for ($x = 0; $x < $count / 10; $x++) {
                ?>
                  <a class="btn rounded-circle btn-dark" <?php if ($x * 10 !== $start) echo 'href="users.php?page=' . $x + 1 . '"'; ?>><?= $x + 1 ?></a>
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