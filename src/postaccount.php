<?php
session_start();
include('connect.php');
if(isset($_POST['name'])){
  $d3 = mysqli_query($d1,"SELECT * FROM user WHERE `name`='${_POST['name']}'");
  $d4 = mysqli_fetch_array($d3);
  if($d4 && $_POST['name'] != $_SESSION['name']){
    header("location:logout.php");
    die();
  }
  $d3 = mysqli_query($d1,"SELECT * FROM user WHERE `name`!='${_SESSION['name']}' AND `email`='${_POST['email']}'");
  $d4 = mysqli_fetch_array($d3);
  if($d4 || $_POST['name'] == '' || $_POST['pass'] == '' || $_POST['email'] == ''){
    header("Location:logout.php");
    die();
  }
  $oldname = $_SESSION['name'];
  $oldemail = $_SESSION['email'];
  $newname = $_POST['name'];
  $newpass = hash('sha512',$_POST['pass']);
  $newemail = $_POST['email'];
  $d3 = mysqli_query($d1,"UPDATE user SET `name`='$newname', `pass`='$newpass', `email`='$newemail' WHERE `name`='$oldname' AND `email`='$oldemail'");
  header("Location:logout.php");
  die();
}else{
  header("Location:./");
  die();
}
?>
