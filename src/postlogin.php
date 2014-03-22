<?php
session_start();
include("connect.php");

if(isset($_POST['name'])){
  $name = $_POST['name']; $pass = md5($_POST['pass']);

  $d3 = mysql_query("SELECT * FROM users WHERE name = '$name' AND pass = '$pass'");
  $d4 = mysql_fetch_assoc($d3);

  if($d4){ // if login matches any row, then log in by passing the row to $_SESSION
    $_SESSION['id'] = $d4['id'];
    $_SESSION['isadmin'] = $d4['isadmin'];
    $_SESSION['verified'] = $d4['verified'];
    $_SESSION['name'] = $d4['name'];
    $_SESSION['pass'] = $d4['pass'];
    $_SESSION['email'] = $d4['email'];
    $_SESSION['data'] = $d4['data'];
    header("Location:./");
    die();
  }else{ // if login does not match any row, then return to login with error message
    $_SESSION['msg'] = 'Bad Login';
    header("Location: login.php");
    die();
  }
}else{
  echo "failed";
  header("Location:./");
  die();
}
?>
