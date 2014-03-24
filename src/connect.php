<?php
$host = "localhost";
$user = "";
$pass = "";
$database = "";

@$db = new mysqli($host,$user,$pass,$database); // Let ME report errors
if($db->connect_errno){
  printf("An Error occurred trying to connect to the database<br>Server returned <b>%s</b><br>Please try again later.", $db->connect_error);
  die();
}
?>
