<?php
session_start();
include('connect.php');
if(isset($_POST['name']) && isset($_POST['pass'])){
  $name = $_POST['name'];
  $pass = hash('sha512',$_POST['pass']);
  $response = 0;
  $d2 = mysqli_query($d1,"SELECT * FROM user WHERE name='$name' AND pass='$pass'");
  $d3 = mysqli_fetch_array($d2);
  if($d2 && $d3){
    $_SESSION['id']       = $d3['id'];
    $_SESSION['admin']    = $d3['admin'];
    $_SESSION['verified'] = $d3['verified'];
    $_SESSION['name']     = $d3['name'];
    $_SESSION['email']    = $d3['email'];
    $_SESSION['data']     = str_replace('\\','',$d3['data']);
    echo "User";
  }elseif($name === ""){ // Anonymous
    $_SESSION['id'] = 0;
    echo "Anonymous";
  }else{
    echo "Bad Login";
  }
}else{
  header('location:./');
  die();
}
?>
