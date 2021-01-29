<?
echo <<<DATA
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down"" align=center colspan=4 height="29" background="./templates/Original/im/tab_bg1.gif"><span class="big"><b>$lang[PM_inbox] $membername</b></span></td>
</tr>
<tr>
<td valign=middle align=center colspan=4 class="tab_down"><a href="messenger.php?action=inbox"><img src="./templates/Original/im/$exbb[default_lang]/inboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=outbox"><img src="./templates/Original/im/$exbb[default_lang]/outboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=new"><img src="./templates/Original/im/$exbb[default_lang]/newpm.gif" border=0></a></td>
</tr>
<tr class="forumline">
<td class="tab_right_down" align=center valign=middle height="29" background="./templates/Original/im/tab_bg1.gif"><span class="normal"><b>$lang[PM_from]</b></span></td>
<td class="tab_right_down" align=center valign=middle background="./templates/Original/im/tab_bg1.gif"><span class="normal"><b>$lang[PM_title]</b></span></td>
<td class="tab_right_down" align=center valign=middle background="./templates/Original/im/tab_bg1.gif"><span class="normal"><b>$lang[Date]</b></span></td>
<td class="tab_down" align=center valign=middle background="./templates/Original/im/tab_bg1.gif"><span class="normal"><b>$lang[PM_readed]</b></span></td>
</tr>
$inbox_data
<tr class="normal">
<td align=center valign=middle colspan=4 height="22" background="./templates/Original/im/tab_bg.gif">| <a href="messenger.php?action=deleteall&where=inbox">$lang[PM_del_all]</a> |</td>
</tr>
</table>
</td>
</tr>
</table>
DATA;
?>