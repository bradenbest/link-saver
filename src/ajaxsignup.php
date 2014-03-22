<?php
session_start();
include("connect.php");
if(isset($_POST['name'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $d3 = mysql_query("SELECT * FROM users WHERE `name`='$name'");
  $d4 = mysql_fetch_assoc($d3);
  if($d4){
    echo "This name is already taken by somebody else.\n\nIf you think it's a name squatter or spammer, please email the administrator at bradentbest@gmail.com with your desired username and email and I will see what I can do.";
    die();
  }
  if(!preg_match("/.*@.*\..*/",$email)){
    echo "The email you provided is invalid";
    die();
  }
  $d3 = mysql_query("SELECT * FROM users WHERE `email`='$email'");
  $d4 = mysql_fetch_assoc($d3);
  if($d4){
    echo "This email is already in use by another user";
    die();
  }
  echo "";
   die();
}else{ // User has somehow wandered onto this page. Boot them off
  header("Location:./");
  die();
}
?>
