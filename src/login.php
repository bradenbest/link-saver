<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<?php
session_start();

if(isset($_SESSION['id'])){
  header('Location:./');
  die();
}

echo "<!DOCTYPE html>";

if(isset($_SESSION['msg'])){
  echo "<p style='color:red; font-weight:bold'>${_SESSION['msg']}</p>";
  unset($_SESSION['msg']);
}
?>
<form action="postlogin.php" method="post">
  <p><input name="name" placeholder="User Name"/></p>
  <p><input name="pass" placeholder="Password" type="password" /></p>
  <p><input type="submit" value="Log In"/></p>
  <p><a href="forgot.php">Forgot your password?</a></p>
</form>
