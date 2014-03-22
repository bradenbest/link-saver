<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="Client/Form/form.css">
<style>
a{
  text-decoration:none;
  color:#000;
}
a:hover{
  text-decoration:underline;
}
</style>
<form action="postlogin.php" method="post">
  <input name="name" placeholder="Username"><br>
  <input name="pass" placeholder="Password" type="password"><br>
  <input type="Submit" value="Log In"><br>
  <a href="forgot.php">Forgot your password?</a>
</form>
