<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="main.css">
<form action="post.signup.php" method="post">
  <input name="name" placeholder="User Name"><br>
  <input name="pass" placeholder="Password" type="password"><br>
  <input name="pass2" placeholder="Repeat Password" type="password"><br>
  <input name="email" placeholder="Email"><br>
  <input type="submit" value="Sign Up">
</form>
<?php
if(isset($_SESSION['msg'])){
  $msg = $_SESSION['msg'];
  echo "<script>alert('$msg')</script>";
  unset($_SESSION['msg']);
}
?>
