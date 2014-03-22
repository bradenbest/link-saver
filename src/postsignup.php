<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<?php
session_start();
include("connect.php");

if(isset($_POST['name'])){
  $name = $_POST['name'];
  $pass = $_POST['pass'];
  $pass2 = $_POST['pass2'];
  $email = $_POST['email'];
  $data = '{"Config":{"lastSave":"Thu May 09 2013 13:14:28 GMT-0600 (MDT)","perPage":10},"Link":{"links":0},"Paradigm":{"key":"Link","list":{"Link":"Link"}}}';
  $error = false;

  $d3 = mysql_query("SELECT * FROM users WHERE name='$name'");
  $d4 = mysql_fetch_assoc($d3);

  if($d4){
    $_SESSION['msg'] = "User '$name' already exists! Think it's a name squatter? You can send a complaint to <u>bradentbest@gmail.com</u> with the subject \"NAME SQUATTER\", and a body containing your desired username along with optional details/comments. When I get the email I will respond ASAP, then I will investigate. After that, I'll notify you via email of what I did.";
    $error = true;
  }
  if($pass != $pass2){
    $_SESSION['msg'] = "The passwords do not match";
    $error = true;
  }
  if(!preg_match("/.*@.*\..*/",$email)){
    $_SESSION['msg'] = "The email you provided is invalid";
    $error = true;
  }
  if($name == "" || $pass == "" || $email == ""){
    $_SESSION['msg'] = "Form incomplete";
    $error = true;
  }
  if($error){
    header("Location:signup.php");
    die();
  }else{
    $pass = md5($pass);
    $d3 = mysql_query("INSERT INTO `users`(`name`, `pass`, `email`, `data`) VALUES ('$name','$pass','$email','$data')");
    $_SESSION['msg'] = "Congratulations! You have signed up! An email has been sent to you. Please verify your account now. If you wait too long, you will lose the account and have to sign up again.";
    $randomstr = randstr();
    mysql_query("INSERT INTO `temp`(`key`,`name`) VALUES ('$randomstr','$name')");
    $link = "http://bradenbest.com/ls/?key=$randomstr";

    $to = $email;
    $subject = "Account Verification";
    $message = "Hello, we have received a signup form using your email address.\n\nAccording to the form, your user name is $name and your email is $email.\n\nIf this is correct, click the following link to complete the signup process:\n\n$link\n\nIf not, please ignore this email, we will eventually delete the account, and won't bother you again.\n\nThanks.";
    $headers = 'From: Link Saver <noreply@bradenbest.com>';
    $mailed = mail($to, $subject, $message, $headers);
  }
}else{
  header("Location:./");
  die();
}

if($mailed){
  header("Location:./");
  die();
}else{
  mysql_query("DELETE FROM `temp` WHERE `key`='$randomstr'");
  $_SESSION['tname'] = $name;
  $_SESSION['tpass'] = $pass;
  $_SESSION['tmail'] = $email;
  $_SESSION['tdata'] = $data;
  unset($_SESSION['msg']);
  echo "<p>Email failed to send. Fill out this captcha to complete the signup process.</p>";
  $rands = randstr();
  $_SESSION['cap'] = $rands;
}
function randstr(){
  $str = "";
  $chr = "0123456789abcdefghijklmnopqrstuvwxyz";
  $len = 10;
  for($i = 0; $i < $len; $i ++){
    $str .= $chr[rand(0,strlen($chr) - 1)];
  }
  return $str;
}
?>
<form action="postcap.php" method="post">
  <canvas id="canvas"></canvas><br>
  <input name="cap" /><br>
  <input type="submit" /><br>
</form>
<script>
(function(){
var ctx = canvas.getContext('2d');
canvas.width = 200;
canvas.height = 40;
ctx.textAlign = 'center';
ctx.textBaseline = 'middle';
ctx.font = '24px arial';
ctx.fillText('<?php echo $rands;?>',100,20);
})();
</script>
