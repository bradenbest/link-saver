<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="main.css">
<form action="post.login.php" method="post">
  <input name="name" placeholder="User name"><br>
  <input name="pass" placeholder="Password" type="password"><br>
  <input type="submit" value="Log In"><br>
</form>
