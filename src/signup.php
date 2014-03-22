<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<?php
session_start();
echo "<!DOCTYPE html>";
if(isset($_SESSION['msg'])){
  echo "<p style='color:red; font-weight:bold'>${_SESSION['msg']}</p>";
  unset($_SESSION['msg']);
}
if(isset($_SESSION['id'])){
  header("Location:./");
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
if(window.$){console.log("jQuery Loaded.");}
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
    if(response !== ''){
      console.log("[SERVER] :: "+response);
      var ln = "------------";
      for(var i=0;i<response.length;i++){ln+="-"}
      console.log(ln+'\n');
    }
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
