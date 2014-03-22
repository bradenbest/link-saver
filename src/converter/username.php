<?php
  session_start();
  if(isset($_SESSION['id'])){
    if($_SESSION['id'] == 0){
      $username = "Anonymous";
    }else{
      $username = $_SESSION['name'];
    }
    echo "Successfully exported to Link Saver under user $username";
  }else{
    echo "Successfully exported to Link Saver under user Anonymous. Not Logged in.";
  }
?>
