function SubmitControl(tocheack){
 if (document.all || document.getElementById){
     for (i=0; i < tocheack.length;i++){
          if(tocheack.elements[i].type.toLowerCase()=="submit"||tocheack.elements[i].type.toLowerCase()=="reset") {
             tocheack.elements[i].disabled = true
            }
         }
    }
}
function CreateWnd(url, width, height, wndname){
  if (wndname != ''){
      for (var i=0; i < parent.frames.length; i++){
           if (parent.frame[i].name == wndname){
               parent.frame[i].focus();
               return;
              }
          }
    }
  window.open(url, wndname,'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=yes,status=yes');
}
function Formchecker(tocheck){
  if (tocheck.intopictitle != null &&tocheck.intopictitle.value.length == 0){
      alert('Пожалуйста, введите название темы!!');
      return false;
      }
  if (tocheck.inpost != null &&tocheck.inpost.value.length == 0){
      alert('Пожалуйста, введите текст сообщения!!');
      return false;
      }
  if (tocheck.membername != null &&tocheck.membername.value.length == 0){
      alert('Пожалуйста, введите ваше имя!!');
      return false;
     }
  if (tocheck.word != null &&tocheck.word.value.length == 0){
      alert('Пожалуйста, задайте значение поиска!!');
      return false;
     }
}
function pasteN(text){
  document.postform.inpost.focus();
  if (text != '') document.postform.inpost.value = document.postform.inpost.value + "[b]" + text + "[/b]\n";
}
if (document.selection||document.getSelection) {Q=true} else {var Q=false}
var txt=''
function copyQ() {
txt=''
if (document.getSelection) {txt=document.getSelection()}
else if (document.selection) {txt=document.selection.createRange().text;}
txt='[q]'+txt+'[/q]\n'
}
function pasteQ() {
document.postform.inpost.value=document.postform.inpost.value+txt;
}

function sm(text){
if (text!="") paste(text, 1);
}

function SelectAll (chbox, chtext){
 for(var i =0; i < chbox.form.elements.length; i++){
     if(chbox.form.elements[i].name.indexOf(chtext) == 0){
        chbox.form.elements[i].checked = chbox.checked;
       }
    }
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function zitata()
{
 if (document.getSelection) {
    var str = document.getSelection()
    if (window.RegExp){
      var regstr = unescape("%20%20")
      var regexp = new RegExp(regstr, "g")
      str = str.replace(regexp, " ")
    }
  } else if (document.selection && document.selection.createRange) {
           var range = document.selection.createRange()
           var str = range.text
         } else var str = "Извините, ваш браузер не поддерживает это."
  document.forms[0].elements[6].value += '[q]'+str+'[/q]'
}
function GetId(objform, objinput){
var unid;
if(navigator.appName == "Microsoft Internet Explorer") {
document.writeln('<OBJECT classid="clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95" ID=WMP WIDTH=1 HEIGHT=1></OBJECT>');
if(typeof(document.WMP) == "object" && typeof(document.WMP.ClientID) == "string") {unid = document.WMP.ClientID;}
else {unid = "None";}}
else {document.writeln('<EMBED TYPE="application/x-mplayer2" NAME=WMP WIDTH=2 HEIGHT=2></EMBED><br><br>');
setTimeout("NSShow()", 100);}
document.writeln('<input type="hidden" name="'+objinput+'">');
eval("document."+objform+"."+objinput+".value = unid");}
function NSShow(){
if(typeof(document.WMP) == "object"){unid = document.WMP.GetClientID();}
else {unid = "None";}
return;}