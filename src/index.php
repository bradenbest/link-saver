<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<link rel="icon" type="image/png" href="http://bradenbest.com/ls/favicon.ico" id="favicon" />
<?php
session_start();
include("connect.php");

echo "<!DOCTYPE html>";
echo "<title>Link Saver</title>";
echo "<style>body{background:#ccc;}</style>";
if(isset($_GET['key'])){ // check for verification key from signup
  $d3 = mysql_query("SELECT * FROM temp WHERE `key`='${_GET['key']}'");
  $d4 = mysql_fetch_assoc($d3);
  if($d4){
    echo "<p style='color:green; font-weight:bold'>Your account has been verified. Thank you for signing up!</p>";
    mysql_query("UPDATE users SET `verified`=1 WHERE `name`='${d4['name']}'");
    mysql_query("DELETE FROM temp WHERE `key`='${_GET['key']}'");
  }
}

if(isset($_GET['pkey']) && isset($_SESSION['pkey'])){ // check for verification key from password reset
  if($_GET['pkey'] == $_SESSION['pkey']){
    $newpass = $_SESSION['pkey'];
    $email = $_SESSION['email'];
    $d3 = mysql_query("UPDATE users SET `pass`='$newpass' WHERE `email`='$email'");
    unset($_SESSION['email']);
    unset($_SESSION['pkey']);
    if($d3){
      echo "<p>Your password has been updated.</p>";
    }else{
      echo "<p>A fatal error ocurred changing your password. Please fill out the form again.</p>";
    }
  }
}

if(isset($_SESSION['msg'])){ // check for message from signup process
  echo "<p style='color:green; font-weight:bold'>${_SESSION['msg']}</p>";
  unset($_SESSION['msg']);
}

$logged_in = isset($_SESSION['id']);

if($logged_in){ // user is logged in
  if($_SESSION['verified'] == 1){ // user is verified
    if(!isset($_SESSION['active'])){ // check for lockout that prevents loading the data a second time
      echo "\n<script>localStorage.removeItem('Link Saver');</script>";
      if($_SESSION['data'][0] == '"'){
        echo "\n<script>var storage = " . substr($_SESSION['data'],1,-1) . "</script>";
      }else{
        echo "\n<script>var storage = " . $_SESSION['data'] . "</script>";
      }
      echo "\n<script>localStorage['Link Saver'] = JSON.stringify(storage);</script>";
      $_SESSION['active'] = 1; // set aforementioned lockout
    }
    echo file_get_contents('Index.html');
    echo "<div style=\"position:fixed; bottom:5px; left:10px;\">";
    echo "Logged in as ${_SESSION['name']}";
    $foot = "class=\"php_footer_insert\"";
    if($_SESSION['isadmin']){
      echo " | <a $foot href=\"admin.php\">Admin Tools</a>";
    }
    echo " | <a $foot href=\"save.php\">Save and Log Out</a> | <a $foot href=\"logout.php\">Log Out</a>";
    echo "</div>";
    echo "<span class='notification'></span>";
    echo "<script src='http://code.jquery.com/jquery-2.0.0.min.js'></script>";
    echo "<script>var loggedIn = true;</script>";
  }else{ // user is not verified
    echo "<p>Hey, ${_SESSION['name']}! [<a href='logout.php'>Log Out</a>]</p>";
    echo "<p>You must verify your account to use this app. Check your email for a message.</p>";
    echo "<p>If you can't verify your account, you can send an email to bradentbest@gmail.com requesting verification, and I'll get you all set up as soon as I can.</p>";
  }
}else{ // user is not logged in
  echo "<div id=\"greeter\">";
  echo "<div style=\"position:absolute;left:0;top:45%;text-align:center;width:100%;font-size:32px;\"><a href='signup.php'>Sign Up</a> or <a href='login.php'>Log In</a></div>";
  echo "<div style=\"position:absolute;left:0;bottom:0;margin-bottom:-10px;width:100%;background:#aaa;text-align:center;\"><form><input placeholder=\"username\" name=\"name\" /><input placeholder=\"password\" type=\"password\" name=\"pass\"/><input type=\"Submit\" value=\"Log In\"></form></div>";
  echo "<script src='http://code.jquery.com/jquery-2.0.0.min.js'></script>";
  echo "<script>var form = document.forms[0];form.onsubmit = function(){\$.ajax({type:'POST',url:'ajaxlogin.php',data:{name:form[0].value,pass:form[1].value}}).done(function(response){if(response !== 'failed'){\$('#greeter').fadeOut(180);setTimeout(function(){location.reload()},200);}else{alert('Bad Login');}});return false;}</script>";
  echo "</div>";
  echo "<div class=\"header_notice\">This is an old version. The latest version can be found <a href=\"http://bradenbest.com/ls\">Here</a>. All accounts have been moved over there, so to use this version, you'll have to create another account.</div>";
  echo "<style>.header_notice{position:absolute;padding:10px 0;text-align:center;left:0;top:0;background:#fff;border-bottom:1px solid #aaa;width:100%;box-shadow:#aaa 0 1px;font:16px \"Courier New\";}</style>";
}
?>
<script>
function renderFavicon(){
  var fCanvas = document.createElement('canvas');
  fCanvas.width = 16;
  fCanvas.height = 16;
  fctx = fCanvas.getContext('2d');
  fctx.font = 'bold 14px Monospace';
  fctx.textAlign = 'center';
  fctx.textBaseline = 'middle';
  fctx.fillText('LS',8,8);
  var fImg = fCanvas.toDataURL();
  favicon.href = fImg; 
};
renderFavicon();

function g(s){ // javascript "$_GET"
  try{
    return RegExp('[?&]'+s+'=([^?&]*)').exec(location.href)[1];
  }catch(e){
    return false;
  }
}
function autosaveOff(){location.href="?autosave=0"} // option to disable autosave

if(window.loggedIn && window.jQuery && g('autosave') !== '0'){ // check for logged in, jQuery, and autosave not disabled
  console.log('Autosave: on');
  console.log('To turn it off, type autosaveOff()');
  (function loop(){ // autosave
    $('.notification').fadeIn(100);
    $('.notification').html ("Saving . . .");
    $.ajax({
      type:"POST",
      url:"ajaxsave.php",
      data:{
        "data":JSON.stringify(storage)
      }
    }).done(function(response){
      response = JSON.parse(response);
      console.log('[SERVER'+(response.type=='failure'?' ERROR':'')+'] :: '+response.msg);
      var ln = "------------";
      for(var i=0;i<response.msg.length;i++){ln+="-"}
      console.log(ln+'\n');
      $('.notification').html(response.msg);
      $('.notification').fadeOut(10000);
    });
    setTimeout(loop,1000*60); // repeat every minute
  })();
}else{
  if(window.loggedIn){
    if(g('autosave') === '0'){
      console.log('Autosave: off');
    }
    if(!window.jQuery){
      console.log('jQuery Failed to load.');
    }
  }
}
</script>
<style>
a.php_footer_insert{
  color:#000;
}
a.php_footer_insert:hover{
  color:#fff;
}
span.notification{
    background:#5c5;
    padding:8px 0;
    display:inline-block;
    width:200px;
    text-align:center;
    position:fixed;
    left:10px;
    bottom:30px;
}
</style>
