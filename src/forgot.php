<link href="Client/Form/form.css" rel="stylesheet" type="text/css" />
<style>
input[type=submit]{
  width:250px;
}
</style>
<?php
session_start();
function randw($syllables = 4){ // RANDom Word
  function randi($s){ // RANDom Index
    return $s[rand(0,sizeof($s)-1)];
  }
  $cs = array('b','d','f','g','h','j','k','m','n','p','r','s','sh','t','z','zh');
  // consonent set without c,l,q,x,v,w
  $vs = array('a','e','i','o','u');
  // vowel set without y
  $str = "";
  for($i = 0; $i < $syllables; $i++){
    $str .= randi($cs) . randi($vs);
  }
  return $str;
}
?>
<form action="postforgot.php" method="post">
  <input name="pass" type="hidden" value="<?=randw()?>">
  <input name="email" placeholder="email"><br>
  <input type="Submit">
</form>
