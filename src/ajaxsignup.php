<?php
session_start();
include('connect.php');
include('config.php');

if(isset($_POST['name'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $d3 = mysqli_query($d1,"SELECT * FROM user WHERE `name`='$name'");
  $d4 = mysqli_fetch_assoc($d3);
  if($d4){
    echo "This name is already taken by somebody else.\n\nIf you think it's a name squatter or spammer, please email the administrator at $WEBMASTER_EMAIL with your desired username and email and I will see what I can do.";
    die();
  }
  if(!preg_match("/.*@.*\..*/",$email)){
    echo "The email you provided is invalid";
    die();
  }
  $d3 = mysqli_query($d1, "SELECT * FROM user WHERE `email`='$email'");
  $d4 = mysqli_fetch_array($d3);
  if($d4){
    echo "This email is already in use by another user";
    die();
  }
  echo "";
  die();
}else{ // User has somehow wandered onto this page. Boot them off
  header("location:./");
  die();
}
?>
