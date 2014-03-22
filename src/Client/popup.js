function Close(target){
  target.parentNode.removeChild(target);
}
function Popup(url,h){
  var win = document.createElement('div');
  var frame = document.createElement('iframe');
  frame.style.width = '100%';
  frame.style.minHeight = (h||400) + 'px';
  frame.src = './Client/Form/'+url;
  var cBtn = document.createElement('button');
  cBtn.style.width = '100%';
  cBtn.innerHTML = 'Close Window';
  cBtn.onclick = function(){
    Close(win);
  }
  win.appendChild(cBtn);
  win.appendChild(document.createElement('br'));
  win.appendChild(frame);
  document.querySelector.apply(document,['.frame']).appendChild(win);
}
function HPopup(txt,h){//HTML Popup; takes html code as argument
  var win = document.createElement('div');
  var frame = document.createElement('iframe');
  frame.style.width = '100%';
  frame.style.minHeight = (h||400) + 'px';
  frame.src = 'data:text/html;,'+txt;
  var cBtn = document.createElement('button');
  cBtn.style.width = '100%';
  cBtn.innerHTML = 'Close Window';
  cBtn.onclick = function(){
    Close(win);
  }
  win.appendChild(cBtn);
  win.appendChild(document.createElement('br'));
  win.appendChild(frame);
  document.querySelector.apply(document,['.frame']).appendChild(win);
}
