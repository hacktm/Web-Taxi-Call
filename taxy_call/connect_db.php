<?php session_start();

$con = mysqli_connect("localhost","price_compare","price_compare","price_compare");
if (!$con)
  {
    die('Could not connect: ' . mysqli_error());
  }


?>