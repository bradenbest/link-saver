var windowPopup = function(url,w,h){
  var height = h||250, width = w||300;
  window.open('./Link_Saver/Forms/'+url,'','width='+width+',height='+height+',top=100,left=0,location=no,menubar=no,status=no,titlebar=no,toolbar=no');
};

var Popup = function(url,w,h){
  var height = h || 250, 
      width = w || 300,
      win,
      frm,
      cBtn;
  win = document.createElement('div');

  frm = document.createElement('iframe');
  frm.style.width = width + 'px';
  frm.style.height = height + 'px';
  frm.src = './Link_Saver/Forms/'+url;

  cBtn = document.createElement('input');
  cBtn.type = 'button';
  cBtn.style.width = '300px';
  cBtn.style.position = 'relative';
  cBtn.style.left = '-10px';
  cBtn.value = 'Close Window';
  cBtn.onclick = function(){
    Close(win)
  };

  win.appendChild(cBtn);
  win.appendChild(document.createElement('br'));
  win.appendChild(frm);

  frame.appendChild(win);
};

function Close(target){
  target.parentNode.removeChild(target);
};
//Provides functionality to open windows
