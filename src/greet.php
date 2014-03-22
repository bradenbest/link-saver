<style>
*{
  margin:0;
  padding:0;
}
div.greeter{
  font:48px "Courier New";
  position:absolute;
  left:0;
  top:45%;
  width:100%;
  text-align:center;
}
div.login{
  position:absolute;
  left:0;
  bottom:0;
  width:100%;
  padding:10px 0;
  background:#eef;
  text-align:center;
}
a{
  text-decoration:none;
  color:#000;
  padding:30px;
}
a:hover{
  text-decoration:underline;
}
a:first-child{
  border-right:1px solid #555;
}
a:last-child{
  border-left:1px solid #ccc;
}
span.fake-link{
  cursor:pointer;
  color:#00f;
}
span.fake-link:hover{
  text-decoration:underline;
}
<?=file_get_contents('Client/form.css')?>
</style>
<?php include("config.php");?>
<script>
var helpPage = '<center>You can sign up to create an account<hr><b>OR</b><hr>You can log in as Anonymous, or the Shared Account.<br><br><b>Anonymous</b><br>Username: nothing<br>Password: nothing<br><br>To log in as Anonymous, enter absolutely nothing into the login form, and try to log in. A normal, registered account will use a technology called localStorage to store the data on your computer, this allows easy manipulation of links, after every action or change to the data, it sends that data over to the server to save it. This user, however uses <i>only</i> localStorage to store links. The cloud aspect is out of the equation for this special case.<br><br>'+

'<b>Note to Technically involved users</b>: if you want to delete the data stored in localStorage, find a way to access your browser\'s javascript console, then, while on this domain, open a console and type "localStorage.removeItem(\'Link Saver\');". That command will, as the name suggests, delete the "Link Saver" entry from localStorage, effectively purging the links stored client-side. Don\'t do this on a registered account! Being the guy who wrote this app, I can tell you that it will detect the change to the data, and take one of two courses of action: A) It overwrites your data on the server with nothingness. B) It drops out of the save with an error. Depending on the browser, and undefined localStorage item will show up as undefined (causes scenario B), or an empty string (causes scenario A). So don\'t do it while logged on to a registered account; you might regret it. Note that scenario A will also cause you to be completely unable to load the app, as it will drop out with an error trying to parse an empty string. If you are unable to access the app, and the JS console is showing an error of that nature, drop me an email at <?=$WEBMASTER_EMAIL?>, and I will fix it for you.'+

'<br><br><b>Shared Account</b><br>Username: "share"<br>Password: nothing<br><br>The shared user is like anonymous, except the links are all stored on the server under a special user named "Share". This is the wikipedia sandbox of this site -- anyone can edit it.</center>';
</script>
<div class="greeter">
  <a href="signup.php">Sign Up</a><a href="login.php">Log In</a>
</div>
<div class="login">
  <form>
    <input id="name" name="name" placeholder="Username">
    <input id="pass" name="pass" type="password" placeholder="Password">
    <input type="Submit" value="Log In">
    <span class="fake-link" onclick="open('data:text/html;,' + helpPage,'','')">Don't have an account?</span>
  </form>
</div>
<script src="http://code.jquery.com/jquery-2.0.1.min.js"></script>
<script>
var form = document.forms[0];
JQ = window.jQuery ? 1 : 0;
form.onsubmit = function(){
  if(JQ){
    $.ajax({
      url:"ajaxlogin.php",
      type:"POST",
      data:{
        "name":form[0].value,
        "pass":form[1].value
      }
    }).done(function(response){
      $('.greeter, .login').fadeOut(100);
      if(response != 'Anonymous'){
      	setTimeout(function(){location.href = 'load.php'},150); 
      }else{
      	setTimeout(function(){location.reload()},150);
      }
    });
  }
  return false;
}
</script>
