<!DOCTYPE html>
<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<?php
session_start();
include('connect.php');
if(isset($_SESSION['id'])){
  if($_SESSION['isadmin'] == 1){ // if logged in user is admin
    echo "<p>Admin Priviledges Verified. Hello, ${_SESSION['name']}</p>";
  }else{ // if logged in user is not admin
    $_SESSION['msg'] = "Priviledges insufficient";
    header("Location:logout.php");
    die();
  }
}else{ // if anonymous (not logged in at all)
  $_SESSION['msg'] = "Priviledges insufficient";
  header("Location:login.php");
  die();
}
?>

<p>Use this form to send an SQL query</p>
<form action="postadmin.php" method="post">
  <input name="query" style="width:98%;" id="q" />
  <input type="submit" style="width:98%;"/><br>
  <input type="button" id="b1" value="Add User" />
  <input type="button" id="b2" value="Delete User" />
  <input type="button" id="b3" value="Change Admin rights" />
  <input type="button" id="b4" value="Purge Unverified Users" />
</form>

<script>
b1.onclick = function(){q.value = "INSERT INTO `users`(`id`, `isadmin`, `verified`, `name`, `pass`, `email`, `data`) VALUES ([id],[isadmin],[verified],[name],[pass],[email],'{}')"; return false;};
b2.onclick = function(){q.value = "DELETE FROM users WHERE name='[user name]'";return false;};
b3.onclick = function(){q.value = "UPDATE users SET `isadmin`=1 WHERE name='[user name]'";return false;};
b4.onclick = function(){q.value = "DELETE FROM users WHERE `verified`=0";return false;};
</script>

<?php
if(isset($_SESSION['msg'])){
  echo "<p>${_SESSION['msg']}</p>";
  unset($_SESSION['msg']);
}

$d3 = mysql_query("SELECT * FROM users");
$d4 = mysql_fetch_assoc($d3);

$cprops = "display:inline-block; width:120px; padding:10px; border-bottom:1px solid; border-right:1px solid; background:#ccc; overflow:hidden";
$ct = "<span style=\"$cprops border-left:1px solid; border-top:1px solid; width:825px; \">"; // column title
$c0 = "<span style=\"$cprops border-left:1px solid;\">"; // column 0 (first column)
$ca = "<span style=\"$cprops \">"; // column open (point a)
$cb = "</span>"; // column close (point b)
echo $ct . "User list:" . $cb . "<br>";
echo $c0 . "id" . $cb . $ca . "name" . $cb . $ca . "admin" . $cb . $ca . "verified" . $cb . $ca . "email" . $cb . $ca . "password" . $cb . "<br>";
echo $c0 . $d4['id'] . $cb . $ca . $d4['name'] . $cb . $ca . ($d4['isadmin']?"Yes":"No") . $cb . $ca . ($d4['verified']?"Yes":"No") . $cb . $ca . $d4['email'] . $cb . $ca . ($d4['isadmin']?"*****":$d4['pass']) . $cb . "<br>";

while($d4 = mysql_fetch_assoc($d3)){
  echo $c0 . $d4['id'] . $cb . $ca . $d4['name'] . $cb . $ca . ($d4['isadmin']?"Yes":"No") . $cb . $ca . ($d4['verified']?"Yes":"No") . $cb . $ca . $d4['email'] . $cb . $ca . ($d4['isadmin']?"*****":$d4['pass']) . $cb . "<br>";
}
?>
