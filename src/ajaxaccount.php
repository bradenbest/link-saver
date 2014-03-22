<?php
//asynchronous postaccount
session_start();
include('connect.php');
if(isset($_POST['name'])){
  if($_POST['name'] == ''){
    echo "Username field cannot be empty";
    die();
  }
  $d3 = mysqli_query($d1,"SELECT * FROM user WHERE `name`='${_POST['name']}'");
  $d4 = mysqli_fetch_array($d3);
  if($d4 && $_POST['name'] != $_SESSION['name']){
    echo "User already exists!";
    die();
  }
}
if(isset($_POST['pass'])){
  if($_POST['pass'] == ''){
    echo "Password field cannot be empty";
    die();
  }
}

if(isset($_POST['email'])){
  if($_POST['email'] == ''){
    echo "Email field cannot be empty";
    die();
  }
  $d3 = mysqli_query($d1,"SELECT * FROM user WHERE `name`!='${_SESSION['name']}' AND `email`='${_POST['email']}'");
  $d4 = mysqli_fetch_assoc($d3);
  if($d4){
    echo "Someone else already has this email!";
    die();
  }
}else{//User trying to access page directly
  header("location:./");
  die();
}
?>
