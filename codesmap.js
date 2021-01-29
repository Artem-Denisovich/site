helpstat = false;
stprompt = true;
basic = false;

var head="display:''"

function doit(header){
var head=header.style
if (helpstat) {
head.display=""
}
else if (basic) {
head.display=""
}
else if (stprompt) {
head.display=""
}
else {
head.display="none"
}
}

function xspand(header){
var head=header.style
if (head.display == "none") {
head.display=""
}
else {
head.display="none"
}
}

function thelp(swtch){
	if (swtch == 1){
		basic = false;
		stprompt = false;
		helpstat = true;
	} else if (swtch == 0) {
		helpstat = false;
		stprompt = false;
		basic = true;
	} else if (swtch == 2) {
		helpstat = false;
		basic = false;
		stprompt = true;
	} else {
		helpstat = false;
		basic = false;
		stprompt = false;
	}
}

function AddText(NewCode) {
document.postform.inpost.focus(); 
document.postform.inpost.value+=NewCode;
}

function email() {
	if (helpstat) {
		alert("Тег [email] - ссылка на адрес электронной почты.\n\nПримеры:\n[email]somebody@anywhere.com[/email]\n[email=somebody@anywhere.com]почта[/email]");
	} else if (basic) {
		AddTxt="[email][/email]";
		AddText(AddTxt);
	} else { 
		txt2=prompt("Введите имя того, чей e-mail Вы хотите указать (можно оставить строку пустой)",""); 
		if (txt2!=null) {
			txt=prompt("Email address.","emailadd");      
			if (txt!=null) {
				if (txt2=="") {
					AddTxt="[email]"+txt+"[/email]";
				} else {
					AddTxt="[email="+txt+"]"+txt2+"[/email]";
				} 
				AddText(AddTxt);	        
			}
		}
	}
}

function showsize(size) {
	if (helpstat) {
		alert("Size Tag\nSets the text size.\nPossible values are 1 to 6.\n 1 being the smallest and 3 the largest.\nUSE: [size="+size+"]This is size "+size+" text[/size]");
	} else if (basic) {
		AddTxt="[size="+size+"][/size]";
		AddText(AddTxt);
	} else {                       
		txt=prompt("Text to be size "+size,"Text"); 
		if (txt!=null) {             
			AddTxt="[size="+size+"]"+txt+"[/size]";
			AddText(AddTxt);
		}        
	}
}

function bold() {
	if (helpstat) {
		alert("Тег [b] - полужирное начертание шрифта.\n\nПример: [b]полужирный[/b]");
	} else if (basic) {
		AddTxt="[b][/b]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Введите текст, который будет выделен полужирным начертанием.","Text");     
		if (txt!=null) {           
			AddTxt="[b]"+txt+"[/b]";
			AddText(AddTxt);
		}       
	}
}

function sound() {
	if (helpstat) {
		alert("Тег [sound] - вставка звука в сообщение\n\nПример:\n: [sound]Ссылка на звуковой файл в Интернет[/sound]");
	} else if (basic) {
		AddTxt="[sound][/sound]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Ссылка на звуковой файл в Интернет.","http://");     
		if (txt!=null) {           
			AddTxt="[sound]"+txt+"[/sound]";
			AddText(AddTxt);
		}       
	}
}

function italicize() {
	if (helpstat) {
		alert("Тег [i] - курсив, наклонное начертание шрифта.\n\nПример: [i]курсив[/i]");
	} else if (basic) {
		AddTxt="[i][/i]";
		AddText(AddTxt);
	} else {   
		txt=prompt("Введите текст, который будет выделен курсивом","Text");     
		if (txt!=null) {           
			AddTxt="[i]"+txt+"[/i]";
			AddText(AddTxt);
		}	        
	}
}

function quote() {
	if (helpstat){
		alert("Тег [q] применяется для цитирования чужих сообщений, цитата вставляется с небольшим отступом от края текста.\n\nПримеры: [q]цитата[/q]\n[q=author]цитата[/q]");
	} else if (basic) {
		AddTxt="\r[q]\r[/q]";
		AddText(AddTxt);
	} else {   
		txt=prompt("Введите цитату","Text");     
		if(txt!=null) {          
			AddTxt="\r[q]\r"+txt+"\r[/q]";
			AddText(AddTxt);
		}	        
	}
}

function showcolor(color) {
	if (helpstat) {
		alert("Color Tag\nSets the text color.  Any named color can be used.\nUSE: [color="+color+"]This is some "+color+" text[/color]");
	} else if (basic) {
		AddTxt="[color="+color+"][/color]";
		AddText(AddTxt);
	} else {  
     	txt=prompt("Text to be "+color,"Text");
		if(txt!=null) {
			AddTxt="[color="+color+"]"+txt+"[/color]";
			AddText(AddTxt);        
		} 
	}
}

function center() {
 	if (helpstat) {
		alert("Тег [center] - поместит ваше сообщение по центру.\n\nПример: [center]Заголовог по центру[/center]");
	} else if (basic) {
		AddTxt="[center][/center]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Текст по центру","Text");     
		if (txt!=null) {          
			AddTxt="\r[center]"+txt+"[/center]";
			AddText(AddTxt);
		}	       
	}
}

function hyperlink() {
	if (helpstat) {
		alert("Тег [url] - ссылка.\n\nПримеры:\n[url]www.anywhere.com[/url]\n[url=http://www.anywhere.com]Anywhere[/url]");
	} else if (basic) {
		AddTxt="[url][/url]";
		AddText(AddTxt);
	} else { 
		txt2=prompt("Введите текст для ссылки (можно оставить строку пустой).",""); 
		if (txt2!=null) {
			txt=prompt("Введите адрес ссылки в Интернете.","http://");      
			if (txt!=null) {
				if (txt2=="") {
					AddTxt="[url]"+txt+"[/url]";
					AddText(AddTxt);
				} else {
					AddTxt="[url="+txt+"]"+txt2+"[/url]";
					AddText(AddTxt);
				}         
			} 
		}
	}
}

function image() {
	if (helpstat){
		alert("Тег [img] - рисунок.\n\nПримеры:\n[img]http://www.ixbt.com/image.gif[/img]");
	} else if (basic) {
		AddTxt="[img][/img]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Введите адрес ссылки картинки в Интернете","http://");    
		if(txt!=null) {            
			AddTxt="\r[img]"+txt+"[/img]";
			AddText(AddTxt);
		}	
	}
}

function flash() {
	if (helpstat) {
		alert("Тег [flash] - вставка флеш ролика в сообщение.\nВам нужно точно знать размер ролика!\nПримеры:\n[flasр size=2]www.anywhere.com/flash_prikol.swf[/flash]\n[flasр size=width,height]www.anywhere.com/flash_prikol.swf[/flash]");
	} else if (basic) {
		AddTxt="[flash size=2]http://[/flash]";
		AddText(AddTxt);
	} else { 
		txt2=prompt("Size of the flash movie (1, 2, 3).","2"); 
		if (txt2!=null) {
			txt=prompt("URL for the flash movie (.swf file).","http://");      
			if (txt!=null) {
				if (txt2=="") {
					AddTxt="[flash size=2]"+txt+"[/flash]";
					AddText(AddTxt);
				} else {
					AddTxt="[flash size="+txt2+"]"+txt+"[/flash]";
					AddText(AddTxt);
				}         
			} 
		}
	}
}

function showcode() {
	if (helpstat) {
		alert("Тег [code] применяется для вывода теста как он есть - с предотвращением форматирования (автопереноса на новую строку), без интерпретации кодов форума и смайликов; вставляется с небольшим отступом от края текста\n\nПример: [code]программный код[/code]");
	} else if (basic) {
		AddTxt="\r[code]\r[/code]";
		AddText(AddTxt);
	} else {   
		txt=prompt("Введите код","");     
		if (txt!=null) {          
			AddTxt="\r[code]"+txt+"[/code]";
			AddText(AddTxt);
		}	       
	}
}

function list() {
	if (helpstat) {
		alert("Тег [list] - создаёт маркерованный/нумерованный либо алфавитный список.\n\nПример:\n[list]\n[*]строка 1\n[*]строка 2\n[*]строка 3\n[/list]");
	} else if (basic) {
		AddTxt="\r[list]\r[*]\r[*]\r[*]\r[/list]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Выберите тип списка\nВведите 'A' для алфавиного, '1' для нумерованного или оставьте поле пустым для маркированного списка.","");               
		while ((txt!="") && (txt!="A") && (txt!="a") && (txt!="1") && (txt!=null)) {
			txt=prompt("ОШИБКА!\nВозможные значения для ввода: не вводить ничего, ввести 'A' или '1'.","");               
		}
		if (txt!=null) {
			if (txt=="") {
				AddTxt="\r[list]\r\n";
			} else {
				AddTxt="\r[list="+txt+"]\r";
			} 
			txt="1";
			while ((txt!="") && (txt!=null)) {
				txt=prompt("Введите очередную строку списка (для завершения списка оставьте строку пустой)",""); 
				if (txt!="") {             
					AddTxt+="[*]"+txt+"\r"; 
				}                   
			} 
			AddTxt+="[/list]\r\n";
			AddText(AddTxt); 
		}
	}
}

function underline() {
  	if (helpstat) {
		alert("Тег [u] - подчеркнутое начертание шрифта.\n\nПример: [u]подчеркнутый[/u]");
	} else if (basic) {
		AddTxt="[u][/u]";
		AddText(AddTxt);
	} else {  
		txt=prompt("Введите текст, который будет выделен подчеркнутым начертанием.","Text");     
		if (txt!=null) {           
			AddTxt="[u]"+txt+"[/u]";
			AddText(AddTxt);
		}	        
	}
}

function showfont(font) {
 	if (helpstat){
		alert("Font Tag\nSets the font face for the enclosed text.\nUSE: [font="+font+"]The font of this text is "+font+"[/font]");
	} else if (basic) {
		AddTxt="[font="+font+"][/font]";
		AddText(AddTxt);
	} else {                  
		txt=prompt("Text to be in "+font,"Text");
		if (txt!=null) {             
			AddTxt="[font="+font+"]"+txt+"[/font]";
			AddText(AddTxt);
		}        
	}  
}
<!-- // cloak
var submitted = 0;
// -->
