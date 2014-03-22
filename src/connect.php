<?php
include("config.php");

$d1 = mysqli_connect($SQL_host,$SQL_user,$SQL_pass,$SQL_table) or die('Could not connect to MySQL Database');

if(preg_match('/connect.php/',$_SERVER['REQUEST_URI'])){
  header('location:./');
  die();
}
?>
