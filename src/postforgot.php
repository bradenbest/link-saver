<?php
session_start();
if(isset($_POST['email'])){
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $mpass = md5($pass);
  $link = "http://bradenbest.com/ls?pkey=" . $mpass;
  $_SESSION['pkey'] = $mpass;
  $_SESSION['email'] = $email;
  $to = $email;
  $subject = "Confirm Password Change";
  $message = "Hello, we have received a request to change your password because someone clicked the \"Forgot Password\" link\n\n" . 
    "Your new password will be $pass. To confirm, go to the following link:\n\n" . 
    "$link";
  $headers = "From: Link Saver <noreply@bradenbest.com>";

  mail($to, $subject, $message, $headers);
  $_SESSION['msg'] = "An email has been sent to you, please click the link to confirm the password change.";
  header("Location:./");
  die();
}else{
  header("Location:./");
  die();
}
?>
