<link href="./Link_Saver/css/Main.css" rel="stylesheet" type="text/css" />
<?php
session_start();
function randw($syllables = 4){ // random word
  // generates a random nonsense Japanese-style password using rules similar to Katakana and Hiragana
  // I figure something like "shuzhuruku" is more memorable than "ptykbnbmvn"
  function randi($s){ // random index
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
  <input name="pass" type="hidden" value="<?php echo randw();?>" />
  <input name="email" placeholder="email" name="email" /><br>
  <input type="Submit" />
</form>
