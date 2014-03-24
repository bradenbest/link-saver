<?php
session_start();
include('connect.php');

if(isset($_POST['id'])){
  $uid = $_SESSION['id'];
  $lid = $_POST['id'];
  $db->query("DELETE FROM links WHERE lid='$lid' AND uid='$uid'");
}
?>
