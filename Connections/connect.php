<?php 
/*
  connect.php
  a simple script to open a MySQL connection
*/

include("config.php");

$con = mysqli_connect($host, $user, $pass, $db) or die("Some error occurred during connection " . mysqli_error($con));

?>
