<?
echo <<<DATA
<br>
<table cellpadding=0 cellspacing=0 border=0 width=95% align=center>
<tr>
<td>
<table cellpadding=3 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 valign=middle align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="big"><b>$lang[PM_welcome] $membername</b></span></td>
</tr>
<tr>
<td valign=middle align=center><a href="messenger.php?action=inbox"><img src="./templates/Original/im/$exbb[default_lang]/inboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=outbox"><img src="./templates/Original/im/$exbb[default_lang]/outboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=new"><img src="./templates/Original/im/$exbb[default_lang]/newpm.gif" border=0></a></td>
</tr>
<tr class="normal">
<td align=center>
<p>
$lang[New_pms] <b>$totalmessages</b> $lang[New_in]<p>
$lang[Unread_pm] <b>$unread</b> $lang[Unread_pms]
<p>
<span class="dats">
<blockquote><b>$lang[Notice]</b> $lang[PM_notice]</blockquote></span>
</td>
</tr>
</table>
</td>
</tr>
</table>
DATA;
?>