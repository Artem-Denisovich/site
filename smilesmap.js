var mode  = 2
function paste(text, flag){
if ((document.selection)&&(flag)) {
        document.postform.inpost.focus();
        document.postform.document.selection.createRange().text = text;
} else document.postform.inpost.value += text;
}

function ibsmiles(){
        document.writeln('<map name=smilies>');
        document.writeln('<area shape="rect" coords="493,3,521,17" href="javascript:sm(\':umnik:\')" alt="умник">');
        document.writeln('<area shape="rect" coords="476,3,492,17" href="javascript:sm(\':spy:\')" alt="шпион">');
        document.writeln('<area shape="rect" coords="457,3,474,17" href="javascript:sm(\':lamer:\')" alt="ламер">');
        document.writeln('<area shape="rect" coords="442,3,456,17" href="javascript:sm(\':love:\')" alt="любовь">');
        document.writeln('<area shape="rect" coords="425,6,441,16" href="javascript:sm(\':shuffle:\')" alt="смущение">');
        document.writeln('<area shape="rect" coords="407,2,423,19" href="javascript:sm(\':cry2:\')" alt="рёв в три ручья">');
        document.writeln('<area shape="rect" coords="380,0,406,17" href="javascript:sm(\':beer:\')" alt="сходка">');
        document.writeln('<area shape="rect" coords="363,2,379,17" href="javascript:sm(\':eyes:\')" alt="глаза разбежались">');
        document.writeln('<area shape="rect" coords="346,3,362,17" href="javascript:sm(\':super:\')" alt="высший восторг">');
        document.writeln('<area shape="rect" coords="330,2,344,17" href="javascript:sm(\':rotate:\')" alt="тащусь">');
        document.writeln('<area shape="rect" coords="311,3,327,17" href="javascript:sm(\':down:\')" alt="ругаю">');
        document.writeln('<area shape="rect" coords="293,3,310,17" href="javascript:sm(\':up:\')" alt="одобряю">');
        document.writeln('<area shape="rect" coords="272,3,292,17" href="javascript:sm(\':kruto:\')" alt="круто!">');
        document.writeln('<area shape="rect" coords="254,3,270,17" href="javascript:sm(\':mad:\')" alt="злость">');
        document.writeln('<area shape="rect" coords="237,3,253,17" href="javascript:sm(\':o\')" alt="смущение, стыд">');
        document.writeln('<area shape="rect" coords="220,3,236,17" href="javascript:sm(\':insane:\')" alt="не в себе">');
        document.writeln('<area shape="rect" coords="203,3,219,17" href="javascript:sm(\':rolleyes:\')" alt="закатывать глаза (с сарказмом)">');
        document.writeln('<area shape="rect" coords="188,3,202,17" href="javascript:sm(\':eek:\')" alt="жуть">');
        document.writeln('<area shape="rect" coords="169,3,185,17" href="javascript:sm(\':confused:\')" alt="замешательство">');
        document.writeln('<area shape="rect" coords="152,3,168,17" href="javascript:sm(\':helloween:\')" alt="мистика">');
        document.writeln('<area shape="rect" coords="135,3,151,17" href="javascript:sm(\':lol:\')" alt="помираю со смеху!">');
        document.writeln('<area shape="rect" coords="118,3,134,17" href="javascript:sm(\':laugh:\')" alt="смех">');
        document.writeln('<area shape="rect" coords="101,3,117,17" href="javascript:sm(\':gigi:\')" alt="гы-гы!">');
        document.writeln('<area shape="rect" coords="84,3,100,17" href="javascript:sm(\':D\')" alt="голливудская улыбка">');
        document.writeln('<area shape="rect" coords="67,3,83,17" href="javascript:sm(\':p\')" alt="подшучивать, дразнить">');
        document.writeln('<area shape="rect" coords="50,3,66,17" href="javascript:sm(\':smirk:\')" alt="ухмылка">');
        document.writeln('<area shape="rect" coords="33,3,49,17" href="javascript:sm(\';)\')" alt="подмигивание">');
        document.writeln('<area shape="rect" coords="16,3,32,17" href="javascript:sm(\':(\')" alt="недовольство, огорчение">');
        document.writeln('<area shape="rect" coords="0,3,15,17" href="javascript:sm(\':)\')" alt="улыбка">');
        document.writeln('</map>');
        document.writeln('<img src="./im/images/smiles.gif" width="526" height="20" border=0 usemap="#smilies">');
}

function ibcodes(){
        document.writeln('<map name="codes">')
        document.writeln('<area shape="rect" coords="19,0,35,18  " href="javascript:italicize()" alt="Тег [i] - курсив, наклонное начертание шрифта.\n\nПример: [i]курсив[/i]">')
        document.writeln('<area shape="rect" coords="0,0,17,18   " href="javascript:bold()" alt="Тег [b] - полужирное начертание шрифта.\n\nПример: [b]полужирный[/b]">')
        document.writeln('<area shape="rect" coords="37,0,53,18  " href="javascript:underline()" alt="Тег [u] - подчеркнутое начертание шрифта.\n\nПример: [u]подчеркнутый[/u]">')
        document.writeln('<area shape="rect" coords="56,0,74,18  " href="javascript:center()" alt="Тег [center] - поместит ваше сообщение по центру.\n\nПример: [center]Заголовог по центру[/center]">')
        document.writeln('<area shape="rect" coords="79,0,98,18  " href="javascript:hyperlink()" alt="Тег [url] - ссылка.\n\nПримеры:\n[url]www.anywhere.com[/url]\n[url=http://www.anywhere.com]Anywhere[/url]">')
        document.writeln('<area shape="rect" coords="99,0,118,18 " href="javascript:flash()" alt="Тег [flash] - вставка флеш ролика в сообщение.\nВам нужно точно знать размер ролика!\nПримеры:\n[flash size=2]www.anywhere.com/flash_prikol.swf[/flash]\n[flash size=width,height]www.anywhere.com/flash_prikol.swf[/flash]">')
        document.writeln('<area shape="rect" coords="120,0,139,18" href="javascript:email()" alt="Тег [email] - ссылка на адрес электронной почты.\n\nПримеры:\n[email]BillGates@MustDie.com[/email]\n[email=BillGates@MustDie.com]Мелкософт[/email]">')
        document.writeln('<area shape="rect" coords="140,0,158,18" href="javascript:image()" alt="Тег [img] - рисунок.\n\nПример:\n[img]http://www.ixbt.com/image.gif[/img]">')
        document.writeln('<area shape="rect" coords="159,0,178,18" href="javascript:sound()" alt="Тег [sound] - вставка звука в сообщение\n\nПример:\n: [sound]Ссылка на звуковой файл в Интернет[/sound]">')
        document.writeln('<area shape="rect" coords="180,0,197,18" href="javascript:showcode()" alt="Тег [code] применяется для вывода теста как он есть - с предотвращением форматирования (автопереноса на новую строку), без интерпретации кодов форума и смайликов; вставляется с небольшим отступом от края текста\n\nПример: [code]программный код[/code]">')
        document.writeln('<area shape="rect" coords="199,0,217,18" href="javascript:quote()" alt="Тег [q] применяется для цитирования чужих сообщений, цитата вставляется с небольшим отступом от края текста.\n\nПримеры: [q]цитата[/q]\n[q=author]цитата[/q]">')
        document.writeln('<area shape="rect" coords="219,0,236,18" href="javascript:list()" alt="Тег [list] - создаёт маркерованный/нумерованный либо алфавитный список.\n\nПример:\n[list]\n[*]строка 1\n[*]строка 2\n[*]строка 3\n[/list]">')
        document.writeln('</map>')
        document.writeln('<img border=0 src="./im/images/codesmap.gif" width="255" height="19" usemap="#codes">')

}