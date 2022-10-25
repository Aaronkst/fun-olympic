<?php

$con = mysqli_connect("localhost", "root", "", "pj");

if (!$con) {
  die('Connection Failed' . mysqli_connect_error());
}
