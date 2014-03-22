<?php
$d1 = mysql_connect("localhost", 'braden', '54334556o')or die("Could not connect! Try again later.");
$d2 = mysql_select_db('Link Saver 1-2-0',$d1)or die("Unable to access database! Try again later.");

if(preg_match("/connect.php/",$_SERVER['REQUEST_URI'])){
  //include requests won't trigger this, but direct access will
  header("Location:./");
  die("Not allowed to access this page directly");
}
?>
