<?php
session_start();
include("config.php");

if(isset($_POST['email'])){
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $npass = hash('sha512',$pass);
  $link = "http://$PATH_TO_INDEX/?pkey=" . $npass;
  $_SESSION['pkey'] = $npass;
  $_SESSION['email'] = $email;
  $to = $email;
  $subject = "Confirm Password Change";
  $message = "Hello, we have received a request to change your password because someone clicked the \"Forgot Password\" link\n\n" . 
    "Your new password will be $pass. To confirm, go to the following link:\n\n" . 
    "$link";
  $headers = "From: Link Saver <noreply@link-saver>";

  mail($to, $subject, $message, $headers);
  $_SESSION['msg'] = "An email has been sent to you, please click the link to confirm the password change.";
  header("location:./");
  die();
}else{
  header("location:./");
  die();
}
?>
