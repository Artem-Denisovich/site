<?
echo <<<DATA
<br>
<table cellpadding=4 cellspacing=0 border=0 width=95% align=center class="tab">
<tr class="forumline">
<td class="tab_down" valign=middle align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$msg_title</b></span></td>
</tr>
<tr class="normal">
<td valign=middle>
<ul><li><b>$msg_text</b><li>$lang[Err_access] <a href="help.php">$lang[Help_file]</a>?</ul>
$reasons<br><br><center>$return</a></center></td></tr></table>$meta
DATA;
?>