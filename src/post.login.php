<?php
session_start();
include('connect.php');

if(isset($_POST['name']) && isset($_POST['pass'])){
  $name = $_POST['name'];
  $pass = hash('SHA512',$_POST['pass']);
  $q = $db->query("SELECT id FROM users WHERE name='$name' AND pass='$pass'");
  $a = $q->fetch_array();
  $_SESSION['id'] = $a['id'];
  header('location:./');
}else{
  $_SESSION['msg'] = "Incomplete login";
  header('location: login.php');
}
?>
