var mouse = {x:0, y:0};
var cmenu = document.querySelector.apply(document,['.cmenu']);
cmenu.innerHTML = '';
cmenu.style.display = 'none';
function killMenu(){
  cmenu.style.display = 'none';
}
function createMenu(content){
  cmenu.innerHTML = '';
  for(var i = 0; i < content.length; i++){
    var item = document.createElement('li');
    item.innerHTML = content[i][0];
    item.onmousedown = content[i][1];
    cmenu.appendChild(item);
  }
  cmenu.style.display = 'block';
  cmenu.style.left = (mouse.x - 5) + 'px';
  cmenu.style.top = (mouse.y - 5) + 'px';
  cmenu.focus();
}
onmousedown = window.onblur = killMenu;
onmousemove = function(e){
  mouse.x = e.clientX || e.pageX || e.offsetX;
  mouse.y = e.clientY || e.pageY || e.offsetY;
}
