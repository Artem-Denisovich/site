<?
include('./templates/Original/form_code.tpl');

$datashow = <<<DATA
$java
<script language="Javascript" src="templates/Original/codes.js"></script>
<table cellpadding=0 cellspacing=0 border=0 width=$exbb[tablewidth] align=center>
<form name=postform action="announcements.php" method=post>
<input type=hidden name="action" value="$do">
$hidden
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="catname">
<td class="tab_down" valign=middle colspan=2 height="29" background="./templates/Original/im/tab_bg1.gif"><b>$lang[Ann_add]</b></td></tr>
<tr class="dats">
<td valign=top width=30%><b>$lang[Ann_title]</b></td>
<td valign=middle><input class="tab" type=text name="title" size=60 maxlength=255 value="$title"></td></tr>
<tr class="dats">
<td valign=top width=30%><b>$lang[Announ]</b><br>$lang[Ann_enter]<p>$lang[Ann_smiles]</td>
<td valign="top">
  <table width="450" border="0" cellspacing="0" cellpadding="2">
     $form_code
	 <tr>
        <td colspan="9"><textarea name="inpost" style="width:600px" cols="60" rows="15" wrap="virtual" tabindex=1 class="tab" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">$post</textarea><br>$smilesmap</td>
     </tr>
  </table>
</td>
</table>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="dats">
<td class="postclr1" height="22" background="./templates/Original/im/tab_bg.gif" valign=middle colspan=2 align=center>
<input class=tab type=Submit value=$lang[Sent] name=Submit onClick="return clckcntr();"> &nbsp; <input class=tab type="reset" name="$lang[Clear]">
</td></tr>
</table></td></tr></form></table>
DATA;
?>