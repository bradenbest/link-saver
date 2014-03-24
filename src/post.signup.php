<?php
session_start();
include('connect.php');

if(isset($_POST['name']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['email'])){
  $name = $_POST['name'];
  $pass = $_POST['pass'];
  $pass2 = $_POST['pass2'];
  $email = $_POST['email'];
  if($pass == $pass2){
    $pass = hash('sha512',$pass);
    $q = $db->query("SELECT * FROM users WHERE name='$name'");
    $a = $q->fetch_array();
    if(!$a){
      $db->query("INSERT INTO users(name,pass) VALUES('$name','$pass')");
      $db->query("INSERT INTO accounts(email) VALUES('$email')");
      header('location: ./');
    }else{
      $_SESSION['msg'] = "Username Taken";
       header('location: signup.php');
    }
  }else{
    $_SESSION['msg'] = "Passwords do not match";
    header('location: signup.php');
  }
}else{
  $_SESSION['msg'] = "Form incomplete";
  header('location: singup.php');
}
?>
