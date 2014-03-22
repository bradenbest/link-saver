<?php
session_start();
include("connect.php");

$name = $_SESSION['name'];
$data = $_POST['data'];
$_SESSION['data'] = $data;
$data2 = str_replace("'","\\'",$data);
$d3 = mysql_query("UPDATE `users` SET `data`='$data2' WHERE name = '$name'");
header("Location:logout.php");
die();
?>
