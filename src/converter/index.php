<?php include("../config.php");?>

<link rel="stylesheet" type="text/css" href="css/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="main.css">
<title>Link Converter</title>
<center>
<textarea id="text" class="form-control" placeholder="Paste links here, seperated by lines"></textarea>
  <button id="convert"   class="btn btn-default">Convert</button>
  <button id="exportbtn" class="btn btn-default">Export</button>
  <button id="html" class="btn btn-default" style="display:none;">Generate HTML</button>
  <button id="json" class="btn btn-default" style="display:none;">Generate JSON</button>
  <button id="xml"  class="btn btn-default" style="display:none;">Generate XML</button>
  <button id="linksaver" class="btn btn-default" style="display:none;">Export To Link Saver</button>
  <button id="settings"  class="btn btn-default">Settings</button>
</center>
<ul class="list-group" id="out"></ul>
<script type="text/javascript">
/*Start Storage*/
var storage;
(function(){ // init
  if(localStorage['converter']){
    storage = JSON.parse(localStorage['converter']);
    if(storage.saveText || storage.useStorage){ // useStorage for backward compatability with earlier iterations of the storage object
      text.value = storage.text;
    }
    if(storage.saveMetrics){
      text.style.width = storage.metrics[0];
      text.style.height = storage.metrics[1];
    }
  }else{
    storage = {
      text:""
    };
  }
})();
(function loop(){ // loop
  storage.text = text.value;
  storage.metrics = [text.style.width, text.style.height];
  localStorage['converter'] = JSON.stringify(storage);
  setTimeout(loop,1000/4);
})();
/*End Storage*/
function parseLine(line){
  var title,link;
  if(line.match(/\[/)){
    title = /\[(.*)\]/.exec(line)[1];
    link = /(.*)\[/.exec(line)[1];
  }else{
    title = link = line;
  }
  return [link,title];
}
function getFavicon(url){
  var expr = /https?:\/\/([^\/]*)/gi.exec(url);
  if(expr[1]){
    return 'http://plus.google.com/_/favicon?domain='+expr[1];
  }else{
    return 'http://plus.google.com/_/favicon?domain=';
  }
}
function convertLinks(){
  var i, links, count = 0;
  out.innerHTML = '';
  links = text.value.split('\n');
  for(i = 0; i < links.length; i++){
    if(links[i] !== ''){
      var data = parseLine(links[i]);
      var item = document.createElement('li');
      item.className = "list-group list-group-item";
      var fav = '<img class="fav" src="'+getFavicon(data[0])+'">';
      item.innerHTML = '<span>'+(++count)+'</span> '+(storage.renderFavicons?(fav):(''))+' <a class="list" href="'+data[0]+'" target="_blank">'+data[1]+'</a>';
      out.appendChild(item);
    }
  }
}
function hideButtons(){
  exportbtn.style.display = 'block';
  html.style.display = 'none';
  json.style.display = 'none';
  xml.style.display = 'none';
  linksaver.style.display = 'none';
}
text.onkeyup = function(e){
  if(storage.autoComplete){
    if(e.keyCode == 0xDB){ // [
      var pos = text.selectionStart,
          firstHalf = text.value.substr(0,pos),
          secondHalf = text.value.substr(pos,text.value.length);
      text.value = firstHalf + ']' + secondHalf;
      text.selectionStart = text.selectionEnd = pos;
    }
  }
  if(storage.autoUpdate){
    convertLinks();
  }
  if(storage.removeWWW){
    if(text.value.match(/https?:\/\/www\./)){
      text.value = text.value.replace(/www\./g,'');
    }
  }
}
//export button reveals them
exportbtn.onclick = function(){
  html.style.display = 'block';
  json.style.display = 'block';
  xml.style.display = 'block';
  linksaver.style.display = 'block';
  exportbtn.style.display = 'none';
}
convert.onclick = convertLinks;
html.onclick = function(){
  convertLinks();
  var buffer = '<link rel="stylesheet" type="text/css" href="http://<?=$PATH_TO_INDEX?>/converter/minimal.css"><ul>'+out.innerHTML+'</ul>';
  out.innerHTML = '<center><textarea id="_txt" class="form-control">'+buffer+'</textarea><br><a target="_blank" href="data:text/html;,'+escape(buffer)+'">Permanent link</a></center>';
  _txt.focus();
  _txt.select();
  hideButtons();
}
json.onclick = function(){
  var i, links, data = [];
  out.innerHTML = '';
  links = text.value.split('\n');
  for(i = 0; i < links.length; i++){
    if(links[i] !== ''){
      var _data = parseLine(links[i]);
        data.push({link:_data[0],title:_data[1]});
    }
  }
  out.innerHTML = '<center><textarea id="tout" class="form-control">'+JSON.stringify(data)+'</textarea>'
  tout.focus();
  tout.select();
  hideButtons();
}
xml.onclick = function(){
  var i, links, data = '<'+"?xml version='1.0' encoding='us-ascii'"+'?>\n<List>\n';
  out.innerHTML = '';
  links = text.value.split('\n');
  for(i = 0; i < links.length; i ++){
    if(links[i] !== ''){
      var _data = parseLine(links[i]);
      data += '  <Link>\n    <URL>'+_data[0]+'</URL>\n    <Title>'+_data[1]+'</Title>\n  </Link>\n';
    }
  }
  data += '</List>';
  data = data.replace(/\&/g,'&amp;');
  out.innerHTML = '<center><textarea id="tout" class="form-control">'+data.replace(/\&/g,'&amp;')+'</textarea><br><a target="_blank" href="data:text/xml;,'+escape(data)+'">Permanent Link</a></center>';
  tout.focus();
  tout.select();
  hideButtons();
}
linksaver.onclick = function(){
  if(localStorage['Link Saver']){
    var _storage = JSON.parse(localStorage['Link Saver']), i, links;
    var _key = _storage.Paradigm.key;
    links = text.value.split('\n');
    for(i = 0; i < links.length; i++){
      if(links[i] !== ''){
        var data = parseLine(links[i]);
        _storage[_key].push({link:data[0],title:data[1]});
      }
    }
    var ajax = new XMLHttpRequest();
    ajax.open('POST','username.php');
    ajax.send();
    ajax.onload = function(){
      out.innerHTML = '<center>' + this.responseText + '</center>';
      localStorage['Link Saver'] = JSON.stringify(_storage);
    }
  }else{
    out.innerHTML = '<center>Failed to export because there is no data. Log in to the Link Saver and try again.</center>';
  }
  hideButtons();
}

function CheckBox(container,label,param){
  var canvas = document.createElement('canvas'),
      ctx = canvas.getContext('2d');
  container.appendChild(canvas);
  container.appendChild(document.createTextNode(label));
  canvas.width = canvas.height = 15;
  canvas.className = 'checkbox';
  (function loop(){
    ctx.fillStyle = '#ccc';
    ctx.fillRect(0,0,15,15);
    ctx.fillStyle = '#fff';
    ctx.fillRect(1,1,13,13);
    if(storage[param]){
      ctx.fillStyle = '#000';
      ctx.fillRect(2,2,11,11);
    }
    setTimeout(loop,1000/24)
  })();
  canvas.onclick = function(){
    storage[param] = !storage[param];
  }
  container.appendChild(document.createElement('br'));
}

settings.onclick = function(){
  var _settings = document.createElement('div');
  _settings.style.margin = '0 auto';
  _settings.style.width = '30%';
  out.innerHTML = '';
  out.appendChild(_settings);
  
  new CheckBox(_settings, 'Save text', 'saveText');
  new CheckBox(_settings, 'Save textbox metrics', 'saveMetrics');
  new CheckBox(_settings, 'Auto-convert while typing', 'autoUpdate');
  new CheckBox(_settings, 'Auto-complete "[" brackets','autoComplete');
  new CheckBox(_settings, 'Auto-remove WWWs','removeWWW');
  new CheckBox(_settings, 'Render favicons for links', 'renderFavicons');
}
</script>
