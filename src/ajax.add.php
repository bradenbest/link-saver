<?php
session_start();
include('connect.php');

if(isset($_POST['link'])){
  $uid = $_SESSION['id'];
  $link = $_POST['link'];
  $title = $_POST['title'];
  $db->query("INSERT INTO links(uid,link,title) VALUES('$uid','$link','$title')");
}
?>
