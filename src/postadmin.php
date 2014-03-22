<?php
session_start();
include("connect.php");

if(isset($_POST['query'])){
  $query = $_POST['query'];
  $d3 = mysql_query($query);
  if(preg_match("/SELECT/", $query)){
    $d4 = ". Returned result: " . var_dump(mysql_fetch_assoc($d3));
  }else{
    $d4 = ".";
  }
  $_SESSION['msg'] = "Query `$query` was sent successfully$d4 ";
}
header("Location:admin.php");
die();
?>
