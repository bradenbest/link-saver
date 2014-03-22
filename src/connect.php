<?php
$_host = "localhost";    // localhost is recommended
$_user = "";             // SQL user name
$_pass = "";             // SQL password
$_db_name = "";          // name of database

$d1 = mysql_connect($_host, $_user, $_pass)    or die("Could not connect! Try again later.");
$d2 = mysql_select_db($_db_name, $d1)           or die("Unable to access database! Try again later.");

if(preg_match("/connect.php/",$_SERVER['REQUEST_URI'])){
  //include requests won't trigger this, but direct access will
  header("Location:./");
  die("Illegal access");
}
?>
