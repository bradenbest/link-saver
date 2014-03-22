<?php
session_start();
if(isset($_SESSION['id'])){
  if($_SESSION['id'] == 0){
    $username = 'Anonymous';
  }else{
    $username = $_SESSION['name'];
  }
}else{
  $username = '[NOT LOGGED IN]';
}
?>
<style>
*{
    margin:0;
    padding:0;
}
textarea,body,html{
    width:100%;
    height:100%;
}
textarea{
    background:#000;
    border:none;
    outline:none;
    font:14px courier new;
    color:#fff;
    padding:5px;
}
</style>
<title><?=$username?> @ Link Saver ~ $ </title>
<textarea id="t"><?=$username?> @ Link Saver ~ $ </textarea>
<script src="http://code.jquery.com/jquery-2.0.1.min.js"></script>
<script>
var storage = JSON.parse(localStorage['Link Saver']),
    paradigm = storage[storage.Paradigm.key],
    username = '<?=$username?>',
    greeting = username + ' @ Link Saver ~ $ ',
    key = [],
    // flags
    flag_noerror = 0;
if(username == '[NOT LOGGED IN]'){
  alert('You are not logged in. Using this app will do nothing.');
}
var console = {
  log:function(val){
    t.value += '\n'+val;
    setTimeout(function(){t.scrollTop += t.value.length;},10);
  }
};
function isbash(val){
  return val.match(/^(rm|ls|grep|ls -al|mkdir|cd|rm -rf|pwd|shutdown|open|quit|exit)/);
};
function bash(val){
  var params;
  if(val.match(/^rm -rf/)){ // paradigm remove
    params = /rf (.*)/.exec(val);
    dev.paradigm.remove(params[1]);
  }else if(val.match(/^ls -al/)){ // global list
    dev.global.list();
  }else if(val.match(/^open/)){ // link open
    params = /open ([0-9]*) ?([0-9]*)?/.exec(val);
    if(params[2]){
      dev.link.open(params[1],params[2]);
    }else{
      dev.link.open(params[1]);
    }
  }else if(val.match(/^rm/)){ // link delete
    params = /rm ([0-9]*) ?([0-9]*)?/.exec(val);
    if(params[2]){
      dev.link.delete(params[1],params[2]);
    }else{
      dev.link.delete(params[1]);
    }
  }else if(val.match(/^ls/)){ // link list
    dev.link.list();
  }else if(val.match(/^grep/)){ // global search
    params = /grep (.*)/.exec(val);
    dev.global.search(params[1]);
  }else if(val.match(/^cd/)){ // paradigm select
    params = /cd (.*)/.exec(val);
    dev.paradigm.select(params[1]);
  }else if(val.match(/^pwd/)){ // paradigm which
    dev.paradigm.which();
  }else if(val.match(/^mkdir/)){ // paradigm add
    params = /mkdir (.*)/.exec(val);
    dev.paradigm.add(params[1]);
  }else if(val.match(/^(shutdown|quit|exit)/)){ // account logout
    dev.account.logout();
  }
  flag_noerror = 1;
};
function eval2(val){
  var i,j;
  if(val == 'DevTool'){
    for(i in dev){
      console.log(i + '{');
      for(j in dev[i]){
        console.log('  ' + j);
      }
      console.log('}')
    }
    return false;
  }
  if(isbash(val)){
    bash(val);
  }
  if(val.match(/^dev\./) && !val.match(/;/)){//start anchor, use it
    if(val.match(/\(/) && val.match(/\)/)){
      eval(val);
    }else{
      console.log(eval(val));
    }
  }else if(!val.match(/^dev\./) && !flag_noerror){
    console.log('The only acceptable commands are those within the dev object. E.g. dev.link.list()');
  }else if(val.match(/;.{2}/)){
    console.log('I\'m sorry, Dave. I cannot allow you to do that (a.k.a. stop trying to XSS my site)');
  }else if(val.match(/;/)){
    console.log('Sorry, I blocked semi-colons in one of many measures to prevent XSS attacks.')
  }
  if(flag_noerror){
    flag_noerror = 0;
  }
};
function save(){
  localStorage['Link Saver'] = JSON.stringify(storage);
  console.log('Saved');
}
function Star(id){
  paradigm[id].starred = true;
  save();
}
function Unstar(id){
  delete paradigm[id].starred;
  save();
}

function DevTool(){
  function Export(){
    this.converter = function(min,max){
      if(min){
        if(max){
          var out = '';
          for(var i = min-1; i < max; i ++){
            out += paradigm[i].link + '[' + paradigm[i].title + ']\n';
          }
          console.log(out);
        }else{
          console.log(paradigm[min-1].link + '[' + paradigm[min-1].title + ']\n');
        }
      }else{
        var out = '';
        for(var i = 0; i < paradigm.length; i ++){
          out += paradigm[i].link + '[' + paradigm[i].title + ']\n';
        }
        console.log(out);
      }
    }
    this.json = function(){
      console.log(JSON.stringify(storage));
    }
  }
  function Link(){
    this.open = function(min,max){
      if(max){
        for(var i = min-1; i < max; i++){
          open(paradigm[i].link);
        }
      }else{
        open(paradigm[min-1].link);
      }
    }
    this.info = function(min,max){
      var out = '';
      if(max){
        for(var i = min-1; i < max; i++){
          out += '#'+ (i+1) + '{\n  Link:  ' + paradigm[i].link + '\n  Title: ' + paradigm[i].title + '\n';
          if(paradigm[i].starred){
            out += '  Starred: True\n}\n\n';
          }else{
            out += '}\n\n';
          }
        }
        console.log(out);
      }else{
        out += '#'+ min + '{\n  Link:  ' + paradigm[min-1].link + '\n  Title: ' + paradigm[min-1].title + '\n';
        if(paradigm[min-1].starred){
          out += '  Starred: True\n}';
        }
        console.log(out);
      }
    }
    this.add = function(link,title){
      paradigm.push({link:link,title:title});
      save();
    }
    this.edit = function(n,link,title){
      paradigm[n-1].link = link;
      paradigm[n-1].title = title;
      save();
    }
    this.delete = function(min,max){
      if(max){
        paradigm.splice(min-1,max-min+1);
        save();
      }else{
        paradigm.splice(min-1,1);
      }
      save();
    }
    this.star = function(min,max){
      if(max){
        for(var i = min-1; i < max; i++){
          Star(i);
        }
      }else{
        Star(min-1);
      }
    }
    this.unstar = function(min,max){
      if(max){
        for(var i = min-1; i < max; i++){
          Unstar(i);
        }
      }else{
        Unstar(min-1);
      }
    }
    this.test = function(min,max){
      if(max){
        console.log('Targeted: range { #'+(min)+' ('+paradigm[min-1].title+') - #'+(max) + ' ('+paradigm[max-1].title+') }');
      }else{
        console.log('Targeted: #'+(min)+' ('+paradigm[min-1].title+')');
      }
    }
    this.list = function(){
      var out = '';
      for(var i = 0; i < paradigm.length; i++){
        out += '#'+(i+1)+'{\n  Link:  '+paradigm[i].link+'\n  Title: '+paradigm[i].title+'\n';
        if(paradigm[i].starred){
          out += '  Starred: True\n}\n\n';
        }else{
          out += '}\n\n';
        }
      }
      console.log(out);
    }
    this.search = function(term){
      var i;
      console.log('Scope: in Paradigm "'+storage.Paradigm.key+'"\nTerm: '+term);
      for(i = 0; i < paradigm.length; i++){
        if(paradigm[i].title.match(term)){
          console.log('[In Title] :: #' + (i+1) + '{\n  Link:  '+paradigm[i].link+'\n  Title: '+paradigm[i].title+'\n}\n');
        }else if(paradigm[i].link.match(term)){
          console.log('[In URL] :: #' + (i+1) + '{\n  Link:  '+paradigm[i].link+'\n  Title: '+paradigm[i].title+'\n}\n');
        }
      }
    }
  }
  function Global(){
    this.search = function(term){
      var list = storage.Paradigm.list,i,j;
      console.log('Scope: Global\nTerm: '+term);
      for(i = 0; i < list.length; i ++){
        if(JSON.stringify(storage[list[i]]).match(term)){
          console.log('In Paradigm ' + list[i] + '{');
          for(j = 0; j < storage[list[i]].length; j ++){
            if(storage[list[i]][j].title.match(term)){
              console.log('  [In Title] :: #'+(j+1)+'{\n    Link:  '+storage[list[i]][j].link+'\n    Title: '+storage[list[i]][j].title+'\n  }');
            }else if(storage[list[i]][j].link.match(term)){
              console.log('  [ In URL ] :: #'+(j+1)+'{\n    Link:  '+storage[list[i]][j].link+'\n    Title: '+storage[list[i]][j].title+'\n  }');
            }
          }
          console.log('}');
        }
      }
    }
    this.list = function(){
      var list = storage.Paradigm.list,i,j;
      for(i = 0; i < list.length; i++){
        console.log('In Paradigm '+list[i]+'{');
        for(j = 0; j < storage[list[i]].length; j++){
          console.log('  #'+(j+1)+'{\n    Link:  '+storage[list[i]][j].link+'\n    Title: '+storage[list[i]][j].title+'\n  }');
        }
        console.log('}');
      }
    }
  }
  function Paradigm(){
    this.add = function(p){
      storage.Paradigm.list.push(p);
      storage[p] = [];
      save();
    }
    this.select = function(p){
      storage.Paradigm.key = storage.Paradigm.list[p];
      save();
      paradigm = storage[storage.Paradigm.key];
    }
    this.remove = function(p){
      if(storage.Paradigm.list[p] == storage.Paradigm.key){
        storage.Paradigm.key = storage.Paradigm.list[0];
      }
      delete storage[storage.Paradigm.list[p]];
      storage.Paradigm.list.splice(p,1);
      save();
      paradigm = storage[storage.Paradigm.key];
    }
    this.test = function(p){
      console.log('Targeted: #'+p+' ('+storage.Paradigm.list[p]+')');
    }
    this.list = function(){
      for(var i in storage.Paradigm.list){
        console.log('#'+i+': ' + storage.Paradigm.list[i] + '\n');
      }
    }
    this.which = function(){
      console.log('Current Paradigm: '+storage.Paradigm.key);
    }
  }
  function Account(){
    this.logout = function(){
      console.log('Logging out . . .');
      $.ajax({
        url:'../logout.php'
      }).done(function(){
        location.href = '../';
      });
    }
    this.username = function(){
      $.ajax({
        url:'../echo.username.php'
      }).done(function(response){
        console.log(response);
      })
    }
    this.help = function(_open){
      if(!_open){
        $.ajax({
          url:'../Client/Help.html'
        }).done(function(response){
          var helpPage = document.createElement('div'), 
              buffer = document.createElement('div'), 
              out = '';
          helpPage.innerHTML = response.replace(/help_images/g, '../Client/help_images');
          buffer.innerHTML = helpPage.innerHTML.replace(/\<br\>/gi, '\n');
          for(var i = 0; i < buffer.children.length; i++){
            if(buffer.children[i].tagName){
              if(buffer.children[i].tagName.match(/style/gi)){
                buffer.removeChild(buffer.children[i]);
              }
            }
          }
          out = buffer.innerText;
          console.log(out);
        });
      }else{
        open('../Client/Help.html');
      }
    }
  }
  this.export = new Export();
  this.link = new Link();
  this.global = new Global();
  this.paradigm = new Paradigm();
  this.account = new Account();
}
var devtool,dt,dev;
devtool = dt = dev = new DevTool();
function parse(val){
  try{
    eval2(val);
  }catch(e){
    console.log(e);
  }
  t.value += '\n' + greeting;
}
t.onkeydown = function(e){
  key[e.keyCode] = 1;
};
t.onkeyup = function(e){
  key[e.keyCode] = 0;
  if(e.keyCode == 13){
      var val = /Link Saver \~ \$ (.*)\n?$/
      val = val.exec(t.value)[1];
      parse(val);
  }
};
(function loop(){ // check for keys
  if(key[17] && key[0x44]){
    dev.account.logout();
  }
  setTimeout(loop,1000/12);
})();
(function loop(){ // maintain first line
  if(!t.value.match(/Link Saver \~ \$ /)){
      t.value = greeting;
  }
  setTimeout(loop,1000/4);
})();
</script>
