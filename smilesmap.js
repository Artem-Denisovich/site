var mode  = 2
function paste(text, flag){
if ((document.selection)&&(flag)) {
        document.postform.inpost.focus();
        document.postform.document.selection.createRange().text = text;
} else document.postform.inpost.value += text;
}

function ibsmiles(){
        document.writeln('<map name=smilies>');
        document.writeln('<area shape="rect" coords="493,3,521,17" href="javascript:sm(\':umnik:\')" alt="�����">');
        document.writeln('<area shape="rect" coords="476,3,492,17" href="javascript:sm(\':spy:\')" alt="�����">');
        document.writeln('<area shape="rect" coords="457,3,474,17" href="javascript:sm(\':lamer:\')" alt="�����">');
        document.writeln('<area shape="rect" coords="442,3,456,17" href="javascript:sm(\':love:\')" alt="������">');
        document.writeln('<area shape="rect" coords="425,6,441,16" href="javascript:sm(\':shuffle:\')" alt="��������">');
        document.writeln('<area shape="rect" coords="407,2,423,19" href="javascript:sm(\':cry2:\')" alt="�� � ��� �����">');
        document.writeln('<area shape="rect" coords="380,0,406,17" href="javascript:sm(\':beer:\')" alt="������">');
        document.writeln('<area shape="rect" coords="363,2,379,17" href="javascript:sm(\':eyes:\')" alt="����� �����������">');
        document.writeln('<area shape="rect" coords="346,3,362,17" href="javascript:sm(\':super:\')" alt="������ �������">');
        document.writeln('<area shape="rect" coords="330,2,344,17" href="javascript:sm(\':rotate:\')" alt="������">');
        document.writeln('<area shape="rect" coords="311,3,327,17" href="javascript:sm(\':down:\')" alt="�����">');
        document.writeln('<area shape="rect" coords="293,3,310,17" href="javascript:sm(\':up:\')" alt="�������">');
        document.writeln('<area shape="rect" coords="272,3,292,17" href="javascript:sm(\':kruto:\')" alt="�����!">');
        document.writeln('<area shape="rect" coords="254,3,270,17" href="javascript:sm(\':mad:\')" alt="������">');
        document.writeln('<area shape="rect" coords="237,3,253,17" href="javascript:sm(\':o\')" alt="��������, ����">');
        document.writeln('<area shape="rect" coords="220,3,236,17" href="javascript:sm(\':insane:\')" alt="�� � ����">');
        document.writeln('<area shape="rect" coords="203,3,219,17" href="javascript:sm(\':rolleyes:\')" alt="���������� ����� (� ���������)">');
        document.writeln('<area shape="rect" coords="188,3,202,17" href="javascript:sm(\':eek:\')" alt="����">');
        document.writeln('<area shape="rect" coords="169,3,185,17" href="javascript:sm(\':confused:\')" alt="��������������">');
        document.writeln('<area shape="rect" coords="152,3,168,17" href="javascript:sm(\':helloween:\')" alt="�������">');
        document.writeln('<area shape="rect" coords="135,3,151,17" href="javascript:sm(\':lol:\')" alt="������� �� �����!">');
        document.writeln('<area shape="rect" coords="118,3,134,17" href="javascript:sm(\':laugh:\')" alt="����">');
        document.writeln('<area shape="rect" coords="101,3,117,17" href="javascript:sm(\':gigi:\')" alt="��-��!">');
        document.writeln('<area shape="rect" coords="84,3,100,17" href="javascript:sm(\':D\')" alt="������������ ������">');
        document.writeln('<area shape="rect" coords="67,3,83,17" href="javascript:sm(\':p\')" alt="�����������, ��������">');
        document.writeln('<area shape="rect" coords="50,3,66,17" href="javascript:sm(\':smirk:\')" alt="�������">');
        document.writeln('<area shape="rect" coords="33,3,49,17" href="javascript:sm(\';)\')" alt="������������">');
        document.writeln('<area shape="rect" coords="16,3,32,17" href="javascript:sm(\':(\')" alt="������������, ���������">');
        document.writeln('<area shape="rect" coords="0,3,15,17" href="javascript:sm(\':)\')" alt="������">');
        document.writeln('</map>');
        document.writeln('<img src="./im/images/smiles.gif" width="526" height="20" border=0 usemap="#smilies">');
}

function ibcodes(){
        document.writeln('<map name="codes">')
        document.writeln('<area shape="rect" coords="19,0,35,18  " href="javascript:italicize()" alt="��� [i] - ������, ��������� ���������� ������.\n\n������: [i]������[/i]">')
        document.writeln('<area shape="rect" coords="0,0,17,18   " href="javascript:bold()" alt="��� [b] - ���������� ���������� ������.\n\n������: [b]����������[/b]">')
        document.writeln('<area shape="rect" coords="37,0,53,18  " href="javascript:underline()" alt="��� [u] - ������������ ���������� ������.\n\n������: [u]������������[/u]">')
        document.writeln('<area shape="rect" coords="56,0,74,18  " href="javascript:center()" alt="��� [center] - �������� ���� ��������� �� ������.\n\n������: [center]��������� �� ������[/center]">')
        document.writeln('<area shape="rect" coords="79,0,98,18  " href="javascript:hyperlink()" alt="��� [url] - ������.\n\n�������:\n[url]www.anywhere.com[/url]\n[url=http://www.anywhere.com]Anywhere[/url]">')
        document.writeln('<area shape="rect" coords="99,0,118,18 " href="javascript:flash()" alt="��� [flash] - ������� ���� ������ � ���������.\n��� ����� ����� ����� ������ ������!\n�������:\n[flash size=2]www.anywhere.com/flash_prikol.swf[/flash]\n[flash size=width,height]www.anywhere.com/flash_prikol.swf[/flash]">')
        document.writeln('<area shape="rect" coords="120,0,139,18" href="javascript:email()" alt="��� [email] - ������ �� ����� ����������� �����.\n\n�������:\n[email]BillGates@MustDie.com[/email]\n[email=BillGates@MustDie.com]���������[/email]">')
        document.writeln('<area shape="rect" coords="140,0,158,18" href="javascript:image()" alt="��� [img] - �������.\n\n������:\n[img]http://www.ixbt.com/image.gif[/img]">')
        document.writeln('<area shape="rect" coords="159,0,178,18" href="javascript:sound()" alt="��� [sound] - ������� ����� � ���������\n\n������:\n: [sound]������ �� �������� ���� � ��������[/sound]">')
        document.writeln('<area shape="rect" coords="180,0,197,18" href="javascript:showcode()" alt="��� [code] ����������� ��� ������ ����� ��� �� ���� - � ��������������� �������������� (������������ �� ����� ������), ��� ������������� ����� ������ � ���������; ����������� � ��������� �������� �� ���� ������\n\n������: [code]����������� ���[/code]">')
        document.writeln('<area shape="rect" coords="199,0,217,18" href="javascript:quote()" alt="��� [q] ����������� ��� ����������� ����� ���������, ������ ����������� � ��������� �������� �� ���� ������.\n\n�������: [q]������[/q]\n[q=author]������[/q]">')
        document.writeln('<area shape="rect" coords="219,0,236,18" href="javascript:list()" alt="��� [list] - ������ �������������/������������ ���� ���������� ������.\n\n������:\n[list]\n[*]������ 1\n[*]������ 2\n[*]������ 3\n[/list]">')
        document.writeln('</map>')
        document.writeln('<img border=0 src="./im/images/codesmap.gif" width="255" height="19" usemap="#codes">')

}