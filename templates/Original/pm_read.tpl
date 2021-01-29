<?
echo <<<DATA
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" align=center valign=middle height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[PM_inbox] $membername</b></span></td>
</tr>
<tr>
<td class="tab_down" valign=middle align=center><a href="messenger.php?action=inbox"><img src="./templates/Original/im/$exbb[default_lang]/inboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=outbox"><img src="./templates/Original/im/$exbb[default_lang]/outboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=new"><img src="./templates/Original/im/$exbb[default_lang]/newpm.gif" border=0></a></td>
</tr>
<tr class="dats">
<td class="tab_down" valign=middle align=center background="./templates/Original/im/bg.gif">
$lang[Message_from] <b>$from</b> $lang[PM_to_you] <b>$date</b></td>
</tr>
<tr class="normal">
<td class="tab_down" valign=top align=left><b>$lang[Message_title]: $messagetitle</b><p>$post</td>
</tr>
<tr> 
<td align="left" class="small" height="22" background="./templates/Original/im/tab_bg.gif">| <a href="messenger.php?action=delete&where=inbox&msg=$vars[msg]" class=dats>$lang[Delete]</a> | <a href="messenger.php?action=reply1&msg=$vars[msg]" class=dats>$lang[Reply]</a> |</td>
</tr>
</table>
</td>
</tr>
</table>
DATA;
?>