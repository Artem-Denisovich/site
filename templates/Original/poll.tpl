<?
$poll_html = <<<POLL
<form method="POST" action="post.php">
<input type=hidden name="action" value="poll">
<input type=hidden name="forum" value="$vars[forum]">
<input type=hidden name="topic" value="$vars[topic]">
<tr><a name='poll'>
<td colspan="2">
<table cellspacing="0" width="100%" cellpadding="4" border="0" align="center">
$moderlinks
<tr><td colspan="2" align="center"><b>$poll_title</b></td></tr>
<tr><td align="center">
<table cellspacing="0" cellpadding="2" border="0">
$pollch
</table>
</td></tr>
<tr>
<td colspan="2" align="center">$do</td></tr>
</table>
</td>
</tr>
</form>
POLL;
?>