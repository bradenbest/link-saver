<?php
session_start();
include('connect.php');
if(isset($_POST['name'])){
  $d3 = mysql_query("SELECT * FROM users WHERE `name`='${_POST['name']}'");
  $d4 = mysql_fetch_assoc($d3);
  if($d4 && $_POST['name'] != $_SESSION['name']){
    header("Location:save.php");
    die();
  }
  $d3 = mysql_query("SELECT * FROM users WHERE `name`!='${_SESSION['name']}' AND `email`='${_POST['email']}'");
  $d4 = mysql_fetch_assoc($d3);
  if($d4 || $_POST['name'] == '' || $_POST['pass'] == '' || $_POST['email'] == ''){
    header("Location:save.php");
    die();
  }
  $oldname = $_SESSION['name'];
  $oldpass = $_SESSION['pass'];
  $oldemail = $_SESSION['email'];
  $newname = $_POST['name'];
  $newpass = md5($_POST['pass']);
  $newemail = $_POST['email'];
  mysql_query("UPDATE users SET `name`='$newname', `pass`='$newpass', `email`='$newemail' WHERE `name`='$oldname' AND `pass`='$oldpass' AND  `email`='$oldemail'");
  header("Location:logout.php");
  die();
}else{
  header("Location:./");
  die();
}
?>
