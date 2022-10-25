<?php

session_start();

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
} else {
  include '../chunks/header.php';
  include '../db.php';

  $userCountQuery = "SELECT COUNT(id) as count FROM users";
  $bcCountQuery = "SELECT COUNT(id) as count FROM broadcasts";
  $topBcQuery = "SELECT COUNT(user) as views, broadcasts.name FROM `log`, `broadcasts` WHERE log.broadcast = broadcasts.id GROUP BY log.broadcast ORDER BY views DESC LIMIT 0,5";

  $userCount = mysqli_query($con, $userCountQuery);
  $bcCount = mysqli_query($con, $bcCountQuery);
  $topBc = mysqli_query($con, $topBcQuery);

  $userData = $userCount->fetch_assoc();
  $bcData = $bcCount->fetch_assoc();
  $topBcData = $topBc->fetch_assoc();
?>
  <!DOCTYPE html>
  <html lang="en">

  <?php generateHeaders("Dashboard"); ?>

  <body class="container-fluid">
    <?php generateAdminNav(); ?>
    <div class="container">
      <section class="row">
        <div class="col-sm-3 p-4">
          <div class="bg-white rounded shadow p-2">
            <p class="h5">Users</p>
            <p class="h4 text-primary text-end">
              <?= $userData['count'] ?>
            </p>
          </div>
        </div>
        <div class="col-sm-3 p-4">
          <div class="bg-white rounded shadow p-2">
            <p class="h5">Broadcasts</p>
            <p class="h4 text-primary text-end">
              <?= $bcData['count'] ?>
            </p>
          </div>
        </div>
        <div class="col-sm-6 p-4">
          <div class="bg-white rounded shadow d-flex p-2">
            <div style="flex:1;" class="d-flex flex-column mx-2">
              <p class="h5">Top Broadcast</p>
              <p class="h5 text-primary text-end mt-auto">
                <?= $topBcData['name'] ?>
              </p>
            </div>
            <div style="flex:1;" class="d-flex flex-column mx-2">
              <p class="h5">Views</p>
              <p class="h4 text-primary text-end mt-auto">
                <?= $topBcData['views'] ?>
              </p>
            </div>
          </div>
        </div>
      </section>
      <section class="row">
        <div class="col-12 p-4">
          <a href="broadcasts.php" class="block h3">Broadcasts &rarr;</a>
          <div class="rounded bg-white shadow mt-4">
            <table class="table table-striped table-hover">
              <thead class="bg-dark text-white">
                <tr>
                  <th>Broadcast</th>
                  <th>Views</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($topBc as $data) {
                ?>
                  <tr>
                    <td><?= $data['name'] ?></td>
                    <td><?= $data['views'] ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>

  </body>

  </html>

<?php
}
?>