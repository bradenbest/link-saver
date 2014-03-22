<!DOCTYPE html>
<title>Link Saver</title>
<?php
// go to under construction page
session_start();
if(!isset($_SESSION['developer'])){// Use set.php to enable developer access, use construction.php to edit the message, should the reason for the maintenance change
  //include('construction.php');
  //die();
}
include('connect.php');
include('config.php');
$logged_in = isset($_SESSION['id']);
if(isset($_GET['key'])){ // check for verification key from signup
  $d3 = mysqli_query($d1,"SELECT * FROM temp WHERE `key`='${_GET['key']}'");
  $d4 = mysqli_fetch_array($d3);
  if($d4){
    echo "<p style='color:green; font-weight:bold'>Your account has been verified. Thank you for signing up!</p>";
    mysqli_query($d1,"UPDATE user SET `verified`=1 WHERE `name`='${d4['name']}'");
    mysqli_query($d1,"DELETE FROM temp WHERE `key`='${_GET['key']}'");
  }
}

if(isset($_GET['pkey']) && isset($_SESSION['pkey'])){ // check for verification key from password reset
  if($_GET['pkey'] == $_SESSION['pkey']){
    $newpass = $_SESSION['pkey'];
    $email = $_SESSION['email'];
    $d3 = mysqli_query($d1,"UPDATE user SET `pass`='$newpass' WHERE `email`='$email'");
    unset($_SESSION['email']);
    unset($_SESSION['pkey']);
    if($d3){
      echo "<p>Your password has been updated.</p>";
    }else{
      echo "<p>A fatal error ocurred changing your password. Please fill out the form again.</p>";
    }
  }
}

if(isset($_SESSION['msg'])){
  echo "<script>alert(" . $_SESSION['msg'] . ")</script>";
}
if($logged_in){
  if((isset($_SESSION['verified']) && $_SESSION['verified'] == 1) || $_SESSION['id'] === 0){
    if($_SESSION['id'] === 0){
      $uname = "Anonymous";
      echo "<script>var anonymous = true;</script>";
	}elseif($_SESSION['id'] === -1 || $_SESSION['name'] == "share"){
      $uname = "Shared Account";
	  echo "<script>var shared = true;</script>";
	}else{
      $uname = $_SESSION['name'];
	}
	echo "<p style='position:fixed;left:0;bottom:0;z-index:23;padding:15px;font:16px \"Courier New\"'>Logged in as " . $uname . "</p>";
    include('main.php');
  }else{
    $_message = "Someone named " . $_SESSION['name'] . " tried to log in.\r\n\r\nGo verify them, Braden!\r\n\r\n-Link Saver";
    $_headers = 'From: Link Saver <no-reply@link-saver-bot>';

    mail($WEBMASTER_EMAIL, 'An unverified user tried to log in! Go verify their account!', $_message, $_headers);
    echo "<s>You must verify your account. <a href='logout.php'>Log Out</a> first.</s>";
    echo "<br><br>Whoops, that's probably a false positive.<br>An email alert has been sent to Braden. He'll verify you when he gets to his email.<br>For now, we'll just let you in.<br><br>Refreshing. . .";
    echo "<script>location.reload();</script>";
    $_SESSION['verified'] = 1;
  }
}else{
  include('greet.php');
}
?>
