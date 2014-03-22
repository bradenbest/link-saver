<?php
session_start();
include("connect.php");

if(isset($_POST['cap']) && isset($_SESSION['cap'])){
  $cap = $_POST['cap'];
  $cap2 = $_SESSION['cap'];
  if($cap == $cap2){
    //verify user
    $d3 = mysql_query("UPDATE users SET `verified`=1 WHERE name='${_SESSION['tname']}'");
    $_SESSION['msg'] = "Successfully signed up!";
  }else{
    //delete user
    $_SESSION['msg'] = "Incorrect input. Account deleted. Contact the administrator at bradentbest@gmail.com";
    $d3 = mysql_query("DELETE FROM users WHERE name='${_SESSION['tname']}'");
  }
}
header("Location:./");
die();
?>
