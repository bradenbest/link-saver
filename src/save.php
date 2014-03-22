<link href="Link_Saver/css/Main.css" type="text/css" rel="stylesheet" />
<?php
session_start();
echo "<!DOCTYPE html>";
?>

<form action="postsave.php" method="post" id="form">
  <input name="data" id="d"/><br>
  <input type="submit"/>
  <p>If nothing happens within a few seconds, click the submit button</p>
</form>
<script>
lserr = false;
try{
  console.log(JSON.parse(localStorage['Link Saver']).Config.lastSave);
}catch(e){
  lserr = true;
}
if(localStorage['Link Saver'] && localStorage['Link Saver'] != "undefined" && localStorage['Link Saver'] != "\"undefined\"" && localStorage['Link Saver'] != undefined && !lserr){
  d.value = JSON.stringify(localStorage['Link Saver']);
}else{ // if localstorage doesnt have valid data
  var tempstorage = {
    Config:{
      lastSave:(new Date()).toString(),
      perPage:10
    },
    Link:{
      links:0
    },
    Paradigm:{
      key:'Link',
      list:{
        'Link':'Link'
      }
    }
  };
  d.value = JSON.stringify(tempstorage);
}
form.submit();
</script>
