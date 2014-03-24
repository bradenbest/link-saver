<?php
session_start();
include('connect.php');
?>
<!DOCTYPE html>
<?php
if(!isset($_SESSION['id'])){
  include('greeter.php');
}else{
  include('main.php');
}

if(isset($_SESSION['msg'])){
  $msg = $_SESSION['msg'];
  echo "<script>alert('$msg')</script>";
  unset($_SESSION['msg']);
}
?>
