<?php

function generateHeaders($name)
{
  echo '
  <head>
  <title>FunOlympic | ' . $name . '</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="../assets/js/bootstrap.min.js" defer></script>
  <script src="../assets/js/jquery-3.1.1.min.js"></script>
  </head>';

  return true;
}

function generateNav()
{
  echo '
  <nav class="row bg-primary text-white">
    <div class="d-flex align-items-center py-4">
      <p class="mb-0 h5" style="flex:1;">FunOlympic</p>
      <div>
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </nav>';

  return true;
}

function generateAdminNav()
{
  echo '
  <nav class="row bg-primary text-white">
    <div class="d-flex align-items-center py-4">
      <p class="mb-0 h5" style="flex:1;">FunOlympic</p>
      <div>
        <a href="index.php" class="btn btn-primary">Home</a>
        <a href="users.php" class="btn btn-primary">Users</a>
        <a href="broadcasts.php" class="btn btn-primary">Broadcasts</a>
        <a href="athletes.php" class="btn btn-primary">Athletes</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </nav>';

  return true;
}
