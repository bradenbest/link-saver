<?php
  session_start();
  if(isset($_SESSION['id'])){
    if($_SESSION['id'] == 0){
      $username = "Anonymous";
    }else{
      $username = $_SESSION['name'];
    }
    echo "Logged in as user $username";
  }else{
    echo "You are not logged in. Please refresh the page and log back in.";
  }
?>
