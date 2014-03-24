<?php
session_start();
include('connect.php');

$id = $_SESSION['id'];
$q = $db->query("SELECT * FROM links WHERE uid='$id'");
$a = $q->fetch_array();
if($a){
  $q = $db->query("SELECT * FROM links WHERE uid='$id'");
  $c = 0;
  while($i = $q->fetch_array()){
    $link = $i['link'];
    $title = $i['title'];
    $lid = $i['lid'];
    $c++;
    echo "<li><span title='$lid'>$lid</span><a target='_blank' href='$link'>$title</a></li>";
  }
}else{
  echo "<li>No Links</li>";
}
?>
