<!DOCTYPE html>
<link href="Client/Form/form.css" type="text/css" rel="stylesheet" />
<?php
session_start();
if(isset($_SESSION['id'])){
  header("location:./");
  die();
}
?>

<form action="postsignup.php" method="post">
  <span id="output" style="color:red"></span><br>
  <input name="name" placeholder="User Name" /><br>
  <input name="pass" placeholder="Password" type="password" /><br>
  <input name="pass2" placeholder="Repeat Password" type="password" /><br>
  <input name="email" placeholder="Email address" /><br>
  <input type="submit" value="Sign Up"/>
</form>

<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script>
var form = document.forms[0];
form[0].onkeyup = form[3].onkeyup = function(){
  $.ajax({
    type: "POST",
    url: "ajaxsignup.php",
    data: {
      name:form[0].value,
      email:form[3].value
    },
  }).done(function(response){
    output.innerText = response;
  });
}
form[2].onblur = function(){
  if(form[1].value !== form[2].value){
    output.innerText = 'Passwords do not match';
  }else{
    output.innerText = '';
  }
}
</script>
