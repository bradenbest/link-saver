<link href="Client/Form/form.css" rel="stylesheet" type="text/css">
<style>
input[type=submit]{
  width:250px;
}
</style>
<?php
session_start();
if(!isset($_SESSION['id'])){
  header("Location:./");
  die();
}
?>
<form action="postaccount.php" method="post">
  <span id="output" style="color:red"></span><br>
  <input name="name" placeholder="Change Username" value="<?php echo $_SESSION['name'];?>"/><br>
  <input name="pass" type="password" placeholder="Change Password" /><br>
  <input name="email" placeholder="Change Email" value="<?php echo $_SESSION['email']?>" /><br>
  <input type="Submit" />
</form>
<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script>
if(window.$){console.log("jQuery loaded.");}
var form = document.forms[0];
form[0].onkeyup = form[1].onkeyup = form[2].onkeyup = function(){
  $.ajax({
    type: "POST",
    url: "ajaxaccount.php",
    data: {
      name:form[0].value,
      pass:form[1].value,
      email:form[2].value
    },
  }).done(function(response){
    output.innerText = response;
  });
}
</script>
