<?php
session_start();
include('connect.php');

if(isset($_POST['id'])){
  $uid = $_SESSION['id'];
  $lid = $_POST['id'];
  $link = $_POST['link'];
  $title = $_POST['title'];
  $db->query("UPDATE links SET link='$link', title='$title' WHERE lid='$lid' AND uid='$uid'");
}
?>
