<?php
session_start();
include('connect.php');
if($_SESSION['id'] !== 0){ // Make sure user is not anon
  $name = $_SESSION['name'];
  $data = $_POST['data'];
  $data = mysqli_real_escape_string($d1,$data);
  $d3 = mysqli_query($d1,"UPDATE `user` SET `data`='$data' WHERE `name`='$name'");
  if($d3){
    echo "[SERVER] :: Query Succeeded.";
  }else{
    echo "[SERVER] :: Query Failed.\n\nData: POST.data - " . $data;
  }
}
?>
