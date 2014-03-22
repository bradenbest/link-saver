<?php
session_start();
include("connect.php");

if(isset($_POST['data'])){
  $name = $_SESSION['name'];
  $data = $_POST['data'];
  $_SESSION['data'] = $data;
  $data2 = str_replace("'","\\'",$data);
  $d3 = mysql_query("UPDATE `users` SET `data`='$data2' WHERE name = '$name'");
  if($d3){
    $response["msg"] = "autosaved at " . strftime("%H:%M:%S");
    $response["type"] = "success";
    echo json_encode($response);
    die();
  }else{
    $response["msg"] = "autosave failed";
    $response["type"] = "failure";
    echo json_encode($response);
    die();
  }
}else{
  header("Location:index.php");
  die();
}

?>
