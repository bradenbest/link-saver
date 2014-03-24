<link rel="stylesheet" type="text/css" href="main.css">
<ul id="menu">
  <li id="addlink">Add Link</li>
  <li id="editlink">Edit Link</li>
  <li id="deletelink">Delete Link</li>
  <li onclick="location.href='logout.php'">Log Out</li>
</ul>
<ul id="links"></ul>
<?php
include('connect.php');

$id = $_SESSION['id'];
$q = $db->query("SELECT * FROM users WHERE id='$id'");
$a = $q->fetch_array();
$name = $a['name'];
?>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script>
var id = <?=$id?>,
    name = '<?=$name?>';

function load(){
  $.ajax({
    type:'post',
    url:'ajax.load.php'
  }).done(function(msg){
    if(msg){
      links.innerHTML = msg;
    }
  });
}

function add(link,title){
  $.ajax({
    type:'post',
    url:'ajax.add.php',
    data:{
      link:link,
      title:title
    }
  }).done(function(){
    load();
  });
}

function edit(id,link,title){
  $.ajax({
    type:'post',
    url:'ajax.edit.php',
    data:{
      id:id,
      link:link,
      title:title
    }
  }).done(function(){
    load();
  });
}

function remove(id){
  $.ajax({
    type:'post',
    url:'ajax.remove.php',
    data:{
      id:id
    }
  }).done(function(){
    load();
  });
}

load();

function Box(e,content){
  var box = document.createElement('div'),
      tag;
  document.body.appendChild(box);
  box.className = "form_box";
  box.style.left = (e.clientX || e.pageX)+'px';
  box.style.top = (e.clientY || e.pageY)+'px';
  box.onmouseout = function(e){
    var e = event.toElement || event.relatedTarget;
    if(e.parentNode == this || e == this) {
      return false;
    }
    box.parentNode.removeChild(box);
  }
  if(content){
    for(var i = 0; i < content.length; i++){
      tag = document.createElement(content[i].tname);
      for(var j in content[i]){
        if(content[i].hasOwnProperty(j)){
          tag[j] = content[i][j];
        }
      }
      box.appendChild(tag);
      box.innerHTML += "<br>";
    }
  }
  return box;
}

addlink.onclick = function(e){
  Box(e,[
    {tname:"input", id:"_link", placeholder:"http://google.com"},
    {tname:"input", id:"_title", placeholder:"Google"},
    {tname:"input", id:"_sub", type:"submit", value:"Add Link"}
  ]);
  _sub.onclick = function(){
    add(_link.value,_title.value);
  }
}
editlink.onclick = function(e){
  Box(e,[
    {tname:"input", id:"_id", placeholder:"Link id (hover mouse over link number)"},
    {tname:"input", id:"_link", placeholder:"e.g. http://google.com"},
    {tname:"input", id:"_title", placeholder:"e.g. Google"},
    {tname:"input", id:"_sub", type:"submit", value:"Update Link"}
  ]);
  _sub.onclick = function(){
    edit(_id.value,_link.value,_title.value);
  }
}
deletelink.onclick = function(e){
  Box(e,[
    {tname:"input", id:"_id", placeholder:"Link id (hover mouse over link number)"},
    {tname:"input", id:"_sub", type:"submit", value:"Delete Link"}
  ]);
  _sub.onclick = function(){
    remove(_id.value);
  }
}
</script>
