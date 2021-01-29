<?
echo <<<DATA
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" valign=middle align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="big"><b>$lang[PM_outread]</b></span></td>
</tr>
<tr>
<td class="tab_down" valign=middle align=center><a href="messenger.php?action=inbox"><img src="./templates/Original/im/$exbb[default_lang]/inboxpm.jpg" border=0></a> &nbsp; <a href="messenger.php?action=outbox"><img src="./templates/Original/im/$exbb[default_lang]/outboxpm.jpg" border=0></a> &nbsp; <a href="messenger.php?action=new"><img src="./templates/Original/im/$exbb[default_lang]/newpm.jpg" border=0></a></td>
</tr>
<tr class="normal">
<td class="tab_down" align=center background="./templates/Original/im/bg.gif">$lang[Message_to] <b>$to</b> - <b>$date</b></td>
</tr>
<tr class="normal">
<td align=left><b>$lang[Message_title]: $messagetitle</b><p>$post</td>
</tr>
</table>
</td>
</tr>
</table>
DATA;
?>